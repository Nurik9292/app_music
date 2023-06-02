<?php

namespace App\Http\Controllers\Admin\Album\Api;

use App\Http\Controllers\Admin\Album\BaseController;
use App\Http\Requests\Admin\Album\UpdateRequest;
use App\Models\Album;
use OwenIt\Auditing\Models\Audit;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Album $album)
    {
        $data = $request->validated();

        $this->service->update($data, $album);

        $audit = Audit::latest()->first();

        $audit->update(['user_type' => 'App\Model\User', $data['user_id']]);

        return response([]);
    }
}
