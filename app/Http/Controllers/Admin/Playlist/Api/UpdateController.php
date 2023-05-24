<?php

namespace App\Http\Controllers\Admin\Playlist\Api;

use App\Http\Controllers\Admin\Playlist\BaseController;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdateController extends BaseController
{
    public function __invoke(Request $request, Playlist $playlist)
    {
        $data = $request->all();

        if (count($data) == 1)
            $playlist->update($data);
        else
            $this->service->update($data, $playlist);

        return response([]);
    }
}
