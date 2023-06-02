<?php

namespace App\Http\Controllers\Admin\Album\Api;

use App\Http\Controllers\Admin\Album\BaseController;
use App\Http\Requests\Admin\Album\StoreRequest;
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
