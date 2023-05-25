<?php

namespace App\Http\Requests\Admin\Track;

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
            'lyrics' => ['nullable', 'string'],
            'artists' => ['nullable'],
            'genres' => ['nullable'],
            'album' => ['nullable', 'numeric'],
            'artwork_url' => ['nullable', 'image'],
            'audio_url' => ['nullable', 'url'],
            'status' => ['nullable'],
            'is_national' => ['nullable'],
            'track_number' => ['nullable', 'numeric'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'audio_url.required' => 'Заполните поле',
            'audio_url.url' => 'Введите правельный адресс ссылки',
            'artwork_url.image' => 'Выберите изображеие',
        ];
    }
}