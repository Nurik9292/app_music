<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ArtistResource;
use OwenIt\Auditing\Models\Audit;

class ShowArtistController extends Controller
{
    public function __invoke()
    {
        $audits = Audit::where('auditable_type', 'like', '%Artist%')->get();

        return new ArtistResource($audits);
    }
}
