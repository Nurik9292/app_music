<?php

namespace App\Http\Controllers\Admin\Album\Api;

use App\Http\Controllers\Admin\Album\BaseController;
use App\Http\Requests\Admin\Album\UpdateRequest;
use App\Models\Album;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Album $album)
    {
        $data = $request->validated();

        $this->service->update($data, $album);

        return response([]);
    }
}