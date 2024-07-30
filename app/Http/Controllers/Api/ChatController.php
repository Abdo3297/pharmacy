<?php

namespace App\Http\Controllers\Api;

use ZipArchive;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Events\SendMessageEvent;
use App\Events\DeleteMessageEvent;
use App\Events\UpdateMessageEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\ChatResource;
use JaOcero\FilaChat\Models\FilaChatMessage;
use App\Http\Requests\Api\SendMessageRequest;
use JaOcero\FilaChat\Events\FilaChatMessageEvent;
use JaOcero\FilaChat\Models\FilaChatConversation;
use App\Http\Requests\Api\SendMessageOrFileRequest;
use App\Http\Requests\Api\UpdateMessageOrFileRequest;
use JaOcero\FilaChat\Events\FilaChatMessageReadEvent;

class ChatController extends Controller
{
    public function loadChat()
    {
        $user = auth()->user();
        if ($user->is_admin) {
            return ResponseHelper::finalResponse(
                "You can't chat with yourself",
                null,
                true,
                Response::HTTP_OK
            );
        }
        $receiver = User::where('is_admin', 1)->first();
        $conversation = FilaChatConversation::where(function ($query) use ($user, $receiver) {
            $query->where(function ($q) use ($user, $receiver) {
                $q->where('senderable_id', $user->id)
                    ->where('receiverable_id', $receiver->id);
            })->orWhere(function ($q) use ($user, $receiver) {
                $q->where('senderable_id', $receiver->id)
                    ->where('receiverable_id', $user->id);
            });
        })->first();
        if (!$conversation) {
            return ResponseHelper::finalResponse(
                'No conversation found',
                null,
                true,
                Response::HTTP_OK
            );
        }
        $chats = FilaChatMessage::
            where('filachat_conversation_id', $conversation->id)
            ->orderBy('created_at', 'asc')
            ->get();
        return ResponseHelper::finalResponse(
            'Data fetched successfully',
            ChatResource::collection($chats),
            true,
            Response::HTTP_OK
        );
    }
    public function sendMessage(SendMessageRequest $request)
    {
        $sender = auth()->user();
        $receiver = User::where('is_admin', 1)->first();

        $filachat_conversation = FilaChatConversation::where(function ($query) use ($sender, $receiver) {
            $query->where('senderable_id', $sender->id)
                ->orWhere('senderable_id', $receiver->id);
        })->where(function ($query) use ($sender, $receiver) {
            $query->where('receiverable_id', $sender->id)
                ->orWhere('receiverable_id', $receiver->id);
        })->first();

        if (!$filachat_conversation) {
            $filachat_conversation = FilaChatConversation::create([
                'senderable_id' => $sender->id,
                'senderable_type' => $sender::class,
                'receiverable_id' => $receiver->id,
                'receiverable_type' => $receiver::class,
            ]);
        }

        $newMessage = FilaChatMessage::query()->create([
            'filachat_conversation_id' => $filachat_conversation->id,
            'message' => $request->message ?? null,
            'attachments' => count($request->storedAttachments) > 0 ? $request->storedAttachments : null,
            'original_attachment_file_names' => count($request->originalAttachmentFileNames) > 0 ? $request->originalAttachmentFileNames : null,
            'senderable_id' => $sender->id,
            'senderable_type' => $sender::class,
            'receiverable_id' => $receiver->id,
            'receiverable_type' => $receiver::class,
        ]);

        broadcast(
            new FilaChatMessageEvent(
                $filachat_conversation->id,
                $newMessage->id,
                $receiver->id,
                $sender->id,
            )
        );

        return ResponseHelper::finalResponse(
            'message created successfully',
            ChatResource::make($newMessage),
            true,
            Response::HTTP_CREATED
        );
    }
    public function downloadFile($id)
    {
        $message = FilaChatMessage::find($id);
        if (!$message) {
            return ResponseHelper::finalResponse(
                'Message not found',
                null,
                true,
                Response::HTTP_NOT_FOUND
            );
        }
        $storedAttachments = $message->attachments;
        $originalAttachmentFileNames = $message->original_attachment_file_names;
        if ($message->attachments == Null) {
            return ResponseHelper::finalResponse(
                'No Files For This Message',
                null,
                true,
                Response::HTTP_NOT_FOUND
            );
        }
        $userId = auth()->user()->id;
        if ($message->senderable_id !== $userId && $message->receiverable_id !== $userId) {
            return ResponseHelper::finalResponse(
                'Not authorized to download this file',
                null,
                true,
                Response::HTTP_FORBIDDEN
            );
        }
        if (count($storedAttachments) > 1) {
            $archive = new ZipArchive();
            $archiveFileName = 'files' . '.zip';
            $archiveFilePath = storage_path('app/public/' . $archiveFileName);

            if ($archive->open($archiveFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                return ResponseHelper::finalResponse(
                    'Could not create archive file',
                    null,
                    true,
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
            foreach ($storedAttachments as $attachmentPath) {
                if (Storage::disk(config('filachat.disk'))->exists($attachmentPath)) {
                    $originalFileName = $originalAttachmentFileNames[$attachmentPath];
                    $archive->addFile(Storage::disk(config('filachat.disk'))->path($attachmentPath), $originalFileName);
                }
            }
            $archive->close();
            return response()->download($archiveFilePath)->deleteFileAfterSend(true);
        } elseif (count($storedAttachments) === 1) {
            $requestedFilePath = $storedAttachments[0];
            $requestedFileName = $originalAttachmentFileNames[$requestedFilePath];
            if (Storage::disk(config('filachat.disk'))->exists($requestedFilePath)) {
                return Storage::disk(config('filachat.disk'))->download($requestedFilePath, $requestedFileName);
            }
            return ResponseHelper::finalResponse(
                'File Not Found',
                null,
                true,
                Response::HTTP_NOT_FOUND
            );
        }
    }
    public function markAsRead()
    {
        $receiver = auth()->user();
        $filachat_conversation = FilaChatConversation::where(function ($query) use ($receiver) {
            $query->where('senderable_id', $receiver->id)
                ->orWhere('receiverable_id', $receiver->id);
        })->first();
        if (!$filachat_conversation) {
            return ResponseHelper::finalResponse(
                'Not authorized',
                null,
                true,
                Response::HTTP_FORBIDDEN
            );
        }
        $messages = FilaChatMessage::
            where('filachat_conversation_id', $filachat_conversation->id)
            ->whereNull('last_read_at')
            ->get();
        if ($messages->isEmpty()) {
            return ResponseHelper::finalResponse(
                'No unread messages found',
                null,
                true,
                Response::HTTP_NOT_FOUND
            );
        }
        foreach ($messages as $message) {
            if ($message->receiverable_id === auth()->user()->id) {
                $message->update([
                    'last_read_at' => now(),
                ]);
            }
        }
        broadcast(new FilaChatMessageReadEvent($filachat_conversation->id));
        return ResponseHelper::finalResponse(
            'All unread messages marked as read successfully',
            null,
            true,
            Response::HTTP_OK
        );
    }
}
