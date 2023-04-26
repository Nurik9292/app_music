<?php

namespace App\Http\Controllers\Admin\Playlist;

use App\Http\Requests\Admin\Playlist\UpdateRequest;
use App\Models\Playlist;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Playlist $playlist)
    {
        $data = $request->validated();

        $this->service->update($data, $playlist);

        return redirect()->route('playlist.index');
    }
}
