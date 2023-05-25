<?php

namespace App\Http\Controllers\Admin\Track\Api;

use App\Http\Controllers\Admin\Track\BaseController;
use App\Http\Requests\Admin\Track\UpdateRequest;
use App\Models\Track;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Track $track)
    {
        $data = $request->validated();

        if (count($data) == 1)
            $track->update($data);
        else
            $this->service->updata($data, $track);

        return response([]);
    }
}