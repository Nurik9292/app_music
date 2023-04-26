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
            'artwork_url' => ['required', 'image'],
            'tracks' => ['required'],
            'genres' => ['required'],
        ];
    }
}
