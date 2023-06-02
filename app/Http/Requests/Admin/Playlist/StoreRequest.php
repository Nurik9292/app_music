<?php

namespace App\Http\Requests\Admin\Playlist;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title_tm' => ['required', 'string'],
            'title_ru' => ['required', 'string'],
            'status' => ['nullable'],
            'artwork_url' => ['required'],
            'tracks' => ['required'],
            'genres' => ['required'],
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
            'title_tm.required' => 'Заполните поле',
            'title_ru.required' => 'Заполните поле',
            'tracks.required' => 'Выберите трек',
            'genres.required' => 'Выберите жанр',
            'artwork_url.required' => 'Выберите изображение',
            'artwork_url.image' => 'Файл должен быть изображение',
        ];
    }
}
