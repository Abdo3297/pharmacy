<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class updateOrderRequest extends customRequest
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
            'items' => ['required', 'array'],
            'items.*.product_id' => ['required', Rule::exists('products', 'id')],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
