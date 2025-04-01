<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Traits\ValidationErrorHandler;
use Illuminate\Foundation\Http\FormRequest;

class ListUserRequest extends FormRequest
{
    use ValidationErrorHandler;

    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'count' => 'nullable|integer',
            'page' => 'nullable|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'count.integer' => 'The count must be an integer.',
            'page.integer' => 'The page must be an integer.',
            'page.min' => 'The page must be at least 1.',
        ];
    }
}
