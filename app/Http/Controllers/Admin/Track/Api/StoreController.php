<?php

namespace App\Http\Controllers\Admin\Track\Api;

use App\Http\Controllers\Admin\Track\BaseController;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    public function __invoke(Request $request)
    {
        $data = $request->all();

        $this->service->store($data);

        return response([]);
    }
}