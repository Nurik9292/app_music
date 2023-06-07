<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use OwenIt\Auditing\Models\Audit;

class DestroyController extends BaseController
{
    public function __invoke(Audit $audit)
    {

        if (preg_match('/(Artist)/', $audit->auditable_type))
            $this->service->delete($audit);

        if (preg_match('/(Track)/', $audit->auditable_type))
            $this->service->delete($audit);



        $audit->delete();

        return response([]);
    }
}