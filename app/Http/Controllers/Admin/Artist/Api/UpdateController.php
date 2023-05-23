<?php

namespace App\Http\Controllers\Admin\Artist\Api;

use App\Http\Controllers\Admin\Artist\BaseController;
use App\Models\Artist;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    public function __invoke(Request $request, Artist $artist)
    {
        $data = $request->all();

        if (count($data) == 1)
            $artist->update($data);
        else
            $this->service->update($data, $artist);

        return response([]);
    }
}
