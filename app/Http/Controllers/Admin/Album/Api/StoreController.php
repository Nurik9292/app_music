<?php

namespace App\Http\Controllers\Admin\Album\Api;

use App\Http\Controllers\Admin\Album\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StoreController extends BaseController
{
    public function __invoke(Request $request)
    {
        $data = $request->all();

        Log::debug($data);

        $this->service->store($data);

        return response([]);
    }
}