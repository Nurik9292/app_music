<?php

namespace App\Http\Controllers\Admin\Playlist\Api;

use App\Http\Controllers\Admin\Playlist\BaseController;
use App\Http\Requests\Admin\Playlist\UpdateRequest;
use App\Models\Playlist;
use OwenIt\Auditing\Models\Audit;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Playlist $playlist)
    {
        $data = $request->all();

        $userId = $data['user_id'];
        unset($data['user_id']);

        $this->service->update($data, $playlist);

        $audit = Audit::latest()->first();

        // $audit->update(['user_type' => 'App\Model\User', $data['user_id']]);

        return response([]);
    }
}