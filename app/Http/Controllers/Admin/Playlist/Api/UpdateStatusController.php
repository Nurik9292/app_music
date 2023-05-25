<?php

namespace App\Http\Controllers\Admin\Playlist\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Http\Request;

class UpdateStatusController extends Controller
{
    public function __invoke(Request $request, Playlist $playlist)
    {
        $data = $request->only('status');

        $playlist->update($data);

        return response([]);
    }
}