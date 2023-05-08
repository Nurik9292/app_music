<?php

namespace App\Http\Requests\Admin\Artist;

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
            'name' => ['nullable', 'string'],
            'bio_tk' => ['nullable', 'string'],
            'bio_ru' => ['nullable', 'string'],
            'artwork_url' => ['nullable', 'image'],
            'country_id' => ['nullable', 'numeric'],
            'status' => ['nullable']
        ];
    }
}
