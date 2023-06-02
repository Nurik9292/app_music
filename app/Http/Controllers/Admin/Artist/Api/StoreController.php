<?php

namespace App\Http\Controllers\Admin\Artist\Api;

use App\Http\Controllers\Admin\Artist\BaseController;
use App\Http\Requests\Admin\Artist\StoreRequest;
use OwenIt\Auditing\Models\Audit;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        $audit = Audit::latest()->first();

        $audit->update(['user_type' => 'App\Model\User', $data['user_id']]);

        return response([]);
    }
}
