<?php

namespace App\Http\Controllers\Admin\Playlist;

use App\Http\Requests\Admin\Playlist\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return redirect()->route('playlist.index');
    }
}
