<?php

namespace App\Http\Controllers\Admin\Album\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;

class UpdateStatusController extends Controller
{
    public function __invoke(Request $request, Album $album)
    {
        $data = $request->only('status');

        $album->update($data);

        return response([]);
    }
}