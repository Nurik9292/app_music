<?php

namespace App\Http\Resources\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = new User();
        $role = '';

        foreach ($user->getRoles() as $key => $rol)
            if ($this->role == $key) $role = $rol;


        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $role,
        ];
    }
}
