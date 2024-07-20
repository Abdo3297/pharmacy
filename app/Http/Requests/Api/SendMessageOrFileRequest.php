<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

class SendMessageOrFileRequest extends customRequest
{
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
            'sender_id' => ['required', Rule::exists('users', 'id')],
            'receiver_id' => ['required', Rule::exists('users', 'id')],
            'message' => ['nullable', 'string'],
            'file' => ['nullable', 'array'],
            'file.*' => ['file'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'sender_id' => auth()->user()->id,
        ]);
    }
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if (is_null($this->message) && !$this->hasFile('file')) {
                $validator->errors()->add('message', 'Either message or file is required.');
                $validator->errors()->add('file', 'Either message or file is required.');
            } elseif (!is_null($this->message) && $this->hasFile('file')) {
                $validator->errors()->add('message', 'Only one of message or file should be provided, not both.');
                $validator->errors()->add('file', 'Only one of message or file should be provided, not both.');
            }
        });
    }
}