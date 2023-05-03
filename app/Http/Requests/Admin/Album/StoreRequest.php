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
            'description' => ['required', 'string'],
            'release_date' => ['required', 'date'],
            'added_date' => ['required', 'date'],
            'artists' => ['required'],
            'artwork_url' => ['required', 'image'],
            'type' => ['required', 'numeric'],
            'status' => ['nullable'],
            'is_national' => ['nullable'],
        ];
    }
}