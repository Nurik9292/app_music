<?php

namespace App\Http\Requests\Admin\Block\Overview\Api;

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
            'status' => ['nullable', 'boolean'],
            'name' => ['required', 'string'],
            // 'type' => ['required'],
            // 'albums' => ['required_if:type,new_album'],
            // 'playlists' => ['required_if:type,new_playlist,updated_playlist'],
            'order_number' => ['required', 'numeric'],
        ];
    }
}