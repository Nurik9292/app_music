<?php

namespace App\Http\Controllers\Admin\Genre\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Genre\StoreRequest;
use App\Models\Genre;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        Log::debug($data);

        Genre::create($data);

        return response([]);
    }
}