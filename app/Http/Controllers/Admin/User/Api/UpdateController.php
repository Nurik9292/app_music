<?php

namespace App\Http\Controllers\Admin\User\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\Api\UpdateRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, User $user)
    {
        $data = $request->validated();

        foreach ($user->getRoles() as $key => $role)
            if ($data['role'] == $role) $data['role'] = $key;


        $user->update($data);

        return new UserResource($user);
    }
}