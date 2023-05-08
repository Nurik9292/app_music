<?php

namespace App\Http\Controllers\Admin\Playlist;

use App\Models\Playlist;
use App\Http\Requests\Admin\Playlist\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Playlist $playlist)
    {
        $data = $request->validated();

        $this->service->update($data, $playlist);

        return redirect()->route('playlist.index');
    }
}
