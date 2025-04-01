<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Traits\ValidationErrorHandler;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    use ValidationErrorHandler;


    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:60',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'phone' => 'required|regex:/^\+380\d{9}$/|unique:users,phone',
            'position_id' => 'required|exists:positions,id',
            'photo' => 'nullable|image|mimes:jpeg,jpg|max:5120',
        ];
    }
}

