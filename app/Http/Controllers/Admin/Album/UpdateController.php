<?php

namespace App\Http\Controllers\Admin\Album;

use App\Models\Album;
use App\Http\Requests\Admin\Album\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Album $album)
    {
        $data = $request->validated();

        $this->service->update($data, $album);

        return redirect()->route('album.index');
    }
}
