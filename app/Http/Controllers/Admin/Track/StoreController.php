<?php

namespace App\Http\Controllers\Admin\Track;

use App\Http\Requests\Admin\Track\StoreRequest;
use App\Models\ArtistTrack;
use App\Models\GenreTrack;
use App\Models\Track;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return redirect()->route('track.index');
    }
}