<?php

namespace App\Http\Requests\Api;

use App\Helpers\ResponseHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class customRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*')) {
            $response = ResponseHelper::finalResponse('Validation Errors', $validator->errors(), false, 422);
            throw new ValidationException($validator, $response);
        }
    }
}
