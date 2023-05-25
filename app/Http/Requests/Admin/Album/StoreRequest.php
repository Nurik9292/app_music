<?php

namespace App\Http\Requests\Admin\Album;

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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'release_date' => ['required'],
            'added_date' => ['required'],
            'artists' => ['required'],
            'artwork_url' => ['required', 'image'],
            'type' => ['required'],
            'status' => ['nullable'],
            'is_national' => ['nullable'],
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
            'title.required' => 'Заполните поле',
            'type.required' => 'Выберите тип альбома',
            'artists.required' => 'Выберите артиста',
            'artwork_url.required' => 'Выберите изображение',
            'artwork_url.image' => 'Файл должен быть изображение',
            'release_date.required' => 'Заполните поле',
            'added_date.required' => 'Заполните поле',
            'release_date.date' => 'Поле длжно быть заполнено датой',
            'added_date.date' => 'Поле длжно быть заполнено датой',
        ];
    }
}