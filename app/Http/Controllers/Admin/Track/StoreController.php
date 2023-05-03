<?php

namespace App\Http\Controllers\Admin\Track;

use App\Http\Requests\Admin\Track\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return redirect()->route('track.index');
    }
}