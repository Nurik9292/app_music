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
            // 'title' => ['nullable', 'string'],
            'lyrics' => ['nullable', 'string'],
            'artists' => ['nullable'],
            'genres' => ['nullable'],
            'album' => ['nullable', 'numeric'],
            'thumb_url' => ['nullable', 'image'],
            'audio_url' => ['nullable', 'string'],
            // 'audio_url' => ['nullable', 'file', 'mimes:mp3,mpeg'],
            'status' => ['nullable'],
            'is_national' => ['nullable'],
            'track_number' => ['nullable', 'numeric'],
        ];
    }
}