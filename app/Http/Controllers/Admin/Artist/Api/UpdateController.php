<?php

namespace App\Http\Controllers\Admin\Artist\Api;

use App\Http\Controllers\Admin\Artist\BaseController;
use App\Http\Requests\Admin\Artist\UpdateRequest;
use App\Models\Artist;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Artist $artist)
    {
        $data = $request->validated();

        $this->service->update($data, $artist);

        return response([]);
    }
}