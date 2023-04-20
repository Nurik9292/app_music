<?php

namespace App\Http\Controllers\Admin\Artist;

use App\Http\Requests\Admin\Artist\UpdateRequest;
use App\Models\Artist;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $requeset, Artist $artist)
    {
        $data = $requeset->validated();

        if ($data['artwork_url'])
            $data = $this->service->resize($data, $artist);

        $artist->update($data);

        return redirect()->route('artist.index');
    }
}