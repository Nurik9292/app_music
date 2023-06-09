<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use OwenIt\Auditing\Models\Audit;

class RestoreController extends BaseController
{
    public function __invoke(Audit $audit)
    {

        if ($audit->event == 'deleted') {
            $this->service->create($audit);
        }

        if ($audit->event == 'created') {
            $this->service->delete($audit);
        }

        if ($audit->event == 'updated') {
            $this->service->returnOldData($audit);
        }

        // Audit::latest()->first()->delete();

        return response([]);
    }
}