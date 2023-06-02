<?php

namespace App\Http\Controllers\Admin\Playlist\Api;

use App\Http\Controllers\Admin\Playlist\BaseController;
use App\Http\Requests\Admin\Playlist\StoreRequest;
use OwenIt\Auditing\Models\Audit;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        dd($request->validated());
        $data = $request->validated();

        $this->service->store($data);

        $audit = Audit::latest()->first();

        $audit->update(['user_type' => 'App\Model\User', $data['user_id']]);

        return response([]);
    }
}
