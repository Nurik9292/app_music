<?php

namespace App\Http\Controllers\Admin\Track\Api;

use App\Http\Controllers\Admin\Track\BaseController;
use App\Models\Track;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdateController extends BaseController
{
    public function __invoke(Request $request, Track $track)
    {
        $data = $request->all();

        if (count($data) == 1)
            $track->update($data);
        else
            $this->service->updata($data, $track);

        return response([]);
    }
}
