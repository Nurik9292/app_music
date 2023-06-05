<?php

namespace App\Http\Controllers\Admin\Genre\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Genre\StoreRequest;
use App\Models\Genre;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Models\Audit;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $userId = $data['user_id'];
        unset($data['user_id']);

        Genre::create($data);

        // $audit = Audit::latest()->first();
        // $audit->update(['user_type' => 'App\Model\User', $data['user_id']]);

        return response([]);
    }
}