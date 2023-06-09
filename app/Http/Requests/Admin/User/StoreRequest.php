<?php

namespace App\Http\Requests\Admin\User;

use Faker\Guesser\Name;
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
            'email' => ['required', 'string', 'unique:system_users', 'min:6'],
            'password' => ['required', 'string', 'min:6', 'max:20'],
            'role' => ['required', 'numeric']
        ];
    }
}
