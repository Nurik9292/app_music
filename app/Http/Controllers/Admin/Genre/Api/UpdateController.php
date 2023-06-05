<?php

namespace App\Http\Controllers\Admin\Genre\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Genre\Api\UpdateRequest;
use App\Models\Genre;
use OwenIt\Auditing\Models\Audit;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Genre $genre)
    {
        $data = $request->validated();

        $userId = $data['user_id'];
        unset($data['user_id']);

        $genre->update($data);

        // $audit = Audit::latest()->first();
        // $audit->update(['user_type' => 'App\Model\User', $data['user_id']]);

        return response([]);
    }
}