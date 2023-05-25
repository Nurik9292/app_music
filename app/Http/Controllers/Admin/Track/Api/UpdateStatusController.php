<?php

namespace App\Http\Controllers\Admin\Track\Api;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;

class UpdateStatusController extends Controller
{
    public function __invoke(Request $request, Track $track)
    {
        $data = $request->only('status');

        $track->update($data);

        return response([]);
    }
}