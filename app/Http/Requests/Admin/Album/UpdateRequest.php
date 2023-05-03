<?php

namespace App\Http\Requests\Admin\Album;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'release_date' => ['nullable', 'date'],
            'added_date' => ['nullable', 'date'],
            'artists' => ['required'],
            'artwork_url' => ['nullable', 'image'],
            'type' => ['nullable', 'numeric'],
            'status' => ['nullable'],
            'is_national' => ['nullable'],
        ];
    }
}