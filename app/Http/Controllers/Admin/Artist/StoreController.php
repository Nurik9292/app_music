<?php

namespace App\Http\Controllers\Admin\Artist;

use App\Http\Requests\Admin\Artist\StoreRequest;
use App\Models\Artist;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return redirect()->route('artist.index');
    }
}