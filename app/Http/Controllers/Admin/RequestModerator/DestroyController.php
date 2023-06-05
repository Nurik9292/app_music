<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use OwenIt\Auditing\Models\Audit;

class DestroyController extends Controller
{
    public function __invoke(Audit $audit)
    {
        $audit->delete();

        return response([]);
    }
}
