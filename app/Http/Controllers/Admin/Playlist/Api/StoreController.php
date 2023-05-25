<?php

namespace App\Http\Controllers\Admin\Playlist\Api;

use App\Http\Controllers\Admin\Playlist\BaseController;
use App\Http\Requests\Admin\Playlist\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return response([]);
    }
}