<?php

namespace App\Http\Controllers\Admin\Album\Api;

use App\Http\Controllers\Admin\Album\BaseController;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdateController extends BaseController
{
    public function __invoke(Request $request, Album $album)
    {
        $data = $request->all();

        if (count($data) == 1)
            $album->update($data);
        else
            $this->service->update($data, $album);

        return response([]);
    }
}
