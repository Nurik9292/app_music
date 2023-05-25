<?php

namespace App\Http\Controllers\Admin\Artist\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;

class UpdateStatusController extends Controller
{
    public function __invoke(Request $request, Artist $artist)
    {
        $data = $request->only('status');

        $artist->update($data);

        return response([]);
    }
}