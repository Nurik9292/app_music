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
            'name' => ['required', 'string'],
            'bio_tk' => ['nullable', 'string'],
            'bio_ru' => ['nullable', 'string'],
            'artwork_url' => ['nullable', 'image'],
            'country_id' => ['required', 'numeric'],
            'status' => ['nullable'],
            'user_id' => ['nullable']

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
            'name.required' => 'Заполните поле',
            'artists.required' => 'Выберите артиста',
            'artwork_url.required' => 'Выберите изображение',
            'artwork_url.image' => 'Файл должен быть изображение',
            'country_id.required' => 'Выберите страну артиста'
        ];
    }
}
