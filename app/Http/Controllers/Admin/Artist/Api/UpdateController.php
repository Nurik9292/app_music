<?php

namespace App\Http\Controllers\Admin\Artist\Api;

use App\Http\Controllers\Admin\Artist\BaseController;
use App\Http\Requests\Admin\Artist\UpdateRequest;
use App\Models\Artist;
use App\Models\User;
use OwenIt\Auditing\Models\Audit;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Artist $artist)
    {
        $data = $request->validated();

        $user = User::where('id', $data['user_id'])->get();
        if ($user[0]->role === $user[0]->MODERATOR) {
            $data['status'] = false;
        }

        $this->service->update($data, $artist);

        $audit = Audit::latest()->first();

        $audit->update(['user_type' => 'App\Model\User', 'user_id' =>  $user[0]->id]);

        return response([]);
    }
}