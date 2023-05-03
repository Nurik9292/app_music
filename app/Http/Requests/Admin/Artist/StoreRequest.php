<?php

namespace App\Http\Requests\Admin\Artist;

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
            'name' => ['required', 'string'],
            'bio_tk' => ['required', 'string'],
            'bio_ru' => ['required', 'string'],
            'artwork_url' => ['required', 'image'],
            'country_id' => ['required', 'numeric'],
            'status' => ['nullable']
        ];
    }
}