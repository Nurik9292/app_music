<?php

namespace App\Http\Requests\Admin\Track;

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
            'title' => ['required', 'string'],
            'lyrics' => ['required', 'string'],
            'artists' => ['required'],
            'genres' => ['required'],
            'album' => ['required', 'numeric'],
            'thumb_url' => ['required', 'image'],
            'audio_url' => ['required', 'string'],
            // 'audio_url' => ['required', 'file', 'mimes:mp3,mpeg'],
            'status' => ['nullable'],
            'is_national' => ['nullable'],
            'track_number' => ['nullable', 'numeric'],
        ];
    }
}