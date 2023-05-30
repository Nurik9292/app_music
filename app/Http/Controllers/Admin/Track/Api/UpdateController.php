<?php

namespace App\Http\Controllers\Admin\Track\Api;

use App\Http\Controllers\Admin\Track\BaseController;
use App\Http\Requests\Admin\Track\UpdateRequest;
use App\Models\RequestTrack;
use App\Models\Track;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Track $track)
    {
        $data = $request->validated();

        if (count($requestTrack = RequestTrack::where('track_id', $track->id)->get()) > 0) {
            $requestTrack[0]->update(['response' => 'одобрено']);
        }

        $this->service->updata($data, $track);

        return response([]);
    }
}
