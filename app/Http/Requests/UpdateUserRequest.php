<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
            'name' => ['string', 'max:55'],
            'email' => [ 'email', 'unique:users,email,'.$this->id],
            'phone' => ['string', 'unique:users,phone,'.$this->id],
            'old_password' => ['string','check_old_password'],
            'password' => [
                Password::min(8)
                    ->letters()
                    ->symbols(),
                'confirmed'
            ],
        ];
    }
}
