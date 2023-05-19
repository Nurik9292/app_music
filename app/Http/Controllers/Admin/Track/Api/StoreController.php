<?php

namespace App\Http\Controllers\Admin\Track\Api;

use App\Http\Controllers\Admin\Track\BaseController;
use App\Http\Requests\Admin\Album\StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StoreController extends BaseController
{
    public function __invoke(Request $request)
    {
        $data = $request->all();

        $this->service->store($data);

        return response([]);
    }
}
