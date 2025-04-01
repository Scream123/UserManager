<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Traits\ValidationErrorHandler;
use Illuminate\Foundation\Http\FormRequest;

class ShowUserRequest extends FormRequest
{
    use ValidationErrorHandler;

    public function authorize()
    {
        return true;
    }
    public function validationData()
    {
        return array_merge($this->request->all(), [
            'id' => $this->route('id'),
        ]);
    }
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'User ID is required.',
            'id.integer' => 'The user ID must be an integer.',
            'id.exists' => 'The user with the requested ID does not exist.',
        ];
    }
}
