<?php

namespace App\Http\Controllers\Api;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Events\SendMessageEvent;
use App\Events\DeleteMessageEvent;
use App\Events\UpdateMessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ChatResource;
use App\Http\Requests\Api\SendMessageOrFileRequest;
use App\Http\Requests\Api\UpdateMessageOrFileRequest;

class ChatController extends Controller
{
    public function loadChat()
    {
        $user = User::whereId(auth()->user()->id)->first();
        if ($user->is_admin) {
            return ResponseHelper::finalResponse(
                "You can't chat with yourself",
                null,
                true,
                Response::HTTP_OK
            );
        }
        $chats = Chat::with('media')
            ->where(function ($query) use ($user) {
                $query->where(function ($q) use ($user) {
                    $q->where('sender_id', $user->id)->whereHas('receiver', function ($q) {
                        $q->where('is_admin', true);
                    });
                })->orWhere(function ($q) use ($user) {
                    $q->where('receiver_id', $user->id)->whereHas('sender', function ($q) {
                        $q->where('is_admin', true);
                    });
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();
        return ResponseHelper::finalResponse(
            'Data fetched successfully',
            ChatResource::collection($chats),
            true,
            Response::HTTP_OK
        );
    }
    public function sendMessageOrFiles(SendMessageOrFileRequest $request)
    {
        $data = $request->validated();
        if ($data['sender_id'] == $data['receiver_id']) {
            return ResponseHelper::finalResponse(
                'Sender ID must not be the same as Receiver ID.',
                null,
                true,
                Response::HTTP_OK
            );
        }
        $senderIsAdmin = User::where('id', $data['sender_id'])->value('is_admin');
        $receiverIsAdmin = User::where('id', $data['receiver_id'])->value('is_admin');
        if (!$senderIsAdmin && !$receiverIsAdmin) {
            return ResponseHelper::finalResponse(
                'Either Sender or Receiver must be an admin.',
                null,
                true,
                Response::HTTP_OK
            );
        }
        if ($senderIsAdmin && $receiverIsAdmin) {
            return ResponseHelper::finalResponse(
                'Both Sender and Receiver cannot be admins.',
                null,
                true,
                Response::HTTP_OK
            );
        }
        $chat = Chat::create($data);
        if ($request->hasFile('file')) {
            $chat->addMultipleMediaFromRequest(['file'])->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('chat');
            });
        }
        $chat->load('media');
        event(new SendMessageEvent($chat->message, $chat->getMedia('chat')->map(function ($media) {
            return $media->getUrl();
        })->toArray()));
        return ResponseHelper::finalResponse(
            'message sent successfully',
            ChatResource::make($chat),
            true,
            Response::HTTP_CREATED
        );
    }
    public function updateMessage(UpdateMessageOrFileRequest $request, $id)
    {
        $data = $request->validated();
        $user = auth()->user();
        if ($user->is_admin) {
            return ResponseHelper::finalResponse('Not allowed', null, false, Response::HTTP_FORBIDDEN);
        }
        $chat = Chat::where('id', $id)
            ->where('sender_id', $user->id)
            ->first();
        if (!$chat) {
            return ResponseHelper::finalResponse('Chat not found or you are not authorized to edit this message.', null, true, Response::HTTP_OK);
        }
        if ($chat->message == NULL) {
            return ResponseHelper::finalResponse('You can\'t update in file', null, true, Response::HTTP_OK);
        }
        $chat->update($data);
        event(new UpdateMessageEvent($chat->id, $chat->message));
        return ResponseHelper::finalResponse(
            'Message updated successfully',
            ChatResource::make($chat),
            true,
            Response::HTTP_OK
        );
    }
    public function deleteMessageOrFiles($id)
    {
        $user = auth()->user();
        if ($user->is_admin) {
            return ResponseHelper::finalResponse(
                'not allowed',
                null,
                false,
                Response::HTTP_FORBIDDEN
            );
        }
        $chat = Chat::where(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->orWhere('receiver_id', $user->id);
        })->where(function ($query) {
            $query->whereHas('sender', function ($query) {
                $query->where('is_admin', true);
            })->orWhereHas('receiver', function ($query) {
                $query->where('is_admin', true);
            });
        })->find($id);
        if ($chat) {
            $chat->delete();
            event(new DeleteMessageEvent($chat->id));
            return ResponseHelper::finalResponse(
                'data deleted successfully',
                null,
                true,
                Response::HTTP_OK
            );
        }
        return ResponseHelper::finalResponse(
            'data not found',
            null,
            true,
            Response::HTTP_OK
        );
    }
}
