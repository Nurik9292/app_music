<?php

namespace App\Http\Controllers\Admin\Playlist\Api;

use App\Http\Controllers\Admin\Playlist\BaseController;
use App\Http\Requests\Admin\Playlist\UpdateRequest;
use App\Models\Playlist;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Playlist $playlist)
    {
        $data = $request->all();

        $this->service->update($data, $playlist);

        return response([]);
    }
}