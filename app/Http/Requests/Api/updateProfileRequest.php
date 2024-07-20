<?php

namespace App\Http\Requests\Api;

use App\Enums\UserGender;
use Illuminate\Validation\Rule;
use Propaganistas\LaravelPhone\Rules\Phone;

class updateProfileRequest extends customRequest
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
            'name' => ['sometimes', 'string'],
            'phone' => ['sometimes', (new Phone), Rule::unique('users')->ignore(auth()->user()->id)],
            'phone_country' => ['required_with:phone'],
            'gender' => ['sometimes', 'string', 'in:' . implode(',', array_map(fn ($case) => $case->value, UserGender::cases()))],
            'birth' => ['sometimes', 'date'],
            'image' => ['sometimes', 'image', 'mimes:png,jpg,jpeg,webp,svg']
        ];
    }
}
