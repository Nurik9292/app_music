<?php

namespace App\Http\Controllers\Admin\Album;

use App\Http\Requests\Admin\Album\StoreRequest;
use Illuminate\Support\Facades\Log;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return redirect()->route("album.index");
    }
}
