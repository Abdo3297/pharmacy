<?php

namespace App\Http\Requests\Api;

use App\Enums\UserGender;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Propaganistas\LaravelPhone\Rules\Phone;

class registerRequest extends customRequest
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:'.User::class],
            'phone' => ['required', (new Phone), 'unique:'.User::class],
            'phone_country' => ['required_with:phone'],
            'gender' => ['required', 'string', 'in:'.implode(',', array_map(fn ($case) => $case->value, UserGender::cases()))],
            'birth' => ['required', 'date'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        return array_merge($validated, [
            'is_admin' => false,
            // 'phone' => \libphonenumber\PhoneNumberUtil::getInstance()->getCountryCodeForRegion($this->phone_country) . $this->phone,
        ]);
    }
}
