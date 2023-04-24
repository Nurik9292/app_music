<?php

namespace App\Http\Controllers\Admin\Track;

use App\Http\Requests\Admin\Track\UpdateRequest;
use App\Models\Track;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Track $track)
    {
        $data = $request->validated();

        $this->service->updata($data, $track);

        return redirect()->route('track.index');
    }
}