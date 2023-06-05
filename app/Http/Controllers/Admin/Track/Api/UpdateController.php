<?php

namespace App\Http\Controllers\Admin\Track\Api;

use App\Http\Controllers\Admin\Track\BaseController;
use App\Http\Requests\Admin\Track\UpdateRequest;
use App\Models\RequestTrack;
use App\Models\Track;
use OwenIt\Auditing\Models\Audit;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Track $track)
    {
        $data = $request->validated();

        $userId = $data['user_id'];
        unset($data['user_id']);

        $this->service->updata($data, $track);

        // $audit = Audit::latest()->first();

        // $audit->update(['user_type' => 'App\Model\User', $data['user_id']]);


        return response([]);
    }
}