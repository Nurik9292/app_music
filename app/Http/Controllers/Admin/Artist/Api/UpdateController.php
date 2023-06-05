<?php

namespace App\Http\Controllers\Admin\Artist\Api;

use App\Http\Controllers\Admin\Artist\BaseController;
use App\Http\Requests\Admin\Artist\UpdateRequest;
use App\Models\Artist;
use OwenIt\Auditing\Models\Audit;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Artist $artist)
    {
        $data = $request->validated();

        $userId = $data['user_id'];
        unset($data['user_id']);

        $this->service->update($data, $artist);

        // $audit = Audit::latest()->first();

        // $audit->update(['user_type' => 'App\Model\User', $data['user_id']]);

        return response([]);
    }
}