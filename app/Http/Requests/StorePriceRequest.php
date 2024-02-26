<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePriceRequest extends FormRequest
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
            'from' => ['required', 'string'],
            'to' => ['required', 'string'],
            'sonata_price' => ['required', 'integer'],
            'gms_price' => ['required', 'integer'],
            'h1_price' => ['required', 'integer'],
            'ford_price' => ['required', 'integer'],
            'lexus_price' => ['required', 'integer'],
            'mercedes_price' => ['required', 'integer'],
        ];
    }
}
