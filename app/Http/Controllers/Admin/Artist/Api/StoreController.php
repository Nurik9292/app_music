<?php

namespace App\Http\Controllers\Admin\Artist\Api;

use App\Http\Controllers\Admin\Artist\BaseController;
use App\Http\Requests\Admin\Artist\StoreRequest;
use App\Models\User;
use OwenIt\Auditing\Models\Audit;

class StoreController extends BaseController
{

    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $user = User::where('id', $data['user_id'])->get();
        if ($user[0]->role === $user[0]->MODERATOR) {
            $data['status'] = false;
        }

        $userId = $data['user_id'];
        unset($data['user_id']);

        $this->service->store($data);

        $audit = Audit::latest()->first();
        $audit->update(['user_type' => 'App\Model\User',  'user_id' =>  $userId]);

        return response([]);
    }
}