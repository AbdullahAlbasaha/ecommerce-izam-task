<?php

namespace App\Http\Requests;

use App\Traits\HelperTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    use HelperTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            $this->response_has_errors($validator->errors(),'Register Failed',422);
        }
        parent::failedValidation($validator);
    }
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|unique:users',
            'name' => 'required|string',
            'password' => 'required|string|confirmed',
        ];
    }
}
