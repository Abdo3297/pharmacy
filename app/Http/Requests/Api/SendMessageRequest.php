<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Str;

class SendMessageRequest extends customRequest
{
    public $storedAttachments = [];

    public $originalAttachmentFileNames = [];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message' => ['nullable', 'string'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file'],
        ];
    }

    /**
     * Ensure either message or attachments (or both) are present.
     */
    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if (! $this->filled('message') && ! $this->hasFile('attachments')) {
                $validator->errors()->add('message', 'Either message or attachments must be provided.');
                $validator->errors()->add('attachments', 'Either message or attachments must be provided.');
            }
        });
    }

    /**
     * Handle the attachment processing and store them.
     */
    protected function prepareForValidation()
    {
        // Ensure attachments are always treated as an array
        $attachments = $this->has('attachments') && is_array($this->attachments) ? $this->attachments : ($this->attachments ? [$this->attachments] : []);
        $this->storedAttachments = [];
        $this->originalAttachmentFileNames = [];

        foreach ($attachments as $attachment) {
            // Generate a random file name
            $randomFileName = Str::random(26).'.'.$attachment->getClientOriginalExtension();
            // Store the file in the 'attachments' directory on the specified disk
            $path = $attachment->storeAs('attachments', $randomFileName, config('filachat.disk'));
            // Add the stored file path to the storedAttachments array
            $this->storedAttachments[] = $path;
            // Map the original file name to the stored file path
            $this->originalAttachmentFileNames[$path] = $attachment->getClientOriginalName();
        }
    }
}
