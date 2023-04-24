<?php

namespace App\Http\Controllers\Admin\Artist;

use App\Http\Requests\Admin\Artist\UpdateRequest;
use App\Models\Artist;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $requeset, Artist $artist)
    {
        $data = $requeset->validated();

        $this->service->update($data, $artist);

        return redirect()->route('artist.index');
    }
}