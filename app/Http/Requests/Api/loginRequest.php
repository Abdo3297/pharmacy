<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;

class loginRequest extends customRequest
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
            'email' => [
                'nullable',
                'email',
                'string',
            ],
            'phone' => [
                'nullable',
                'string',
            ],
            'password' => ['required', 'string'],
        ];
    }

    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if (! $this->filled('email') && ! $this->hasFile('phone')) {
                $validator->errors()->add('email', 'Either email or phone must be provided.');
                $validator->errors()->add('phone', 'Either email or phone must be provided.');
            }
            if ($this->filled('email') && $this->filled('phone')) {
                $validator->errors()->add('email', 'only one of email or phone must be provided.');
                $validator->errors()->add('phone', 'only one of email or phone must be provided.');
            }
        });
    }
}
