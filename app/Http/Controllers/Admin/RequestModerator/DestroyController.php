<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Models\ArtistAudit;
use OwenIt\Auditing\Models\Audit;

class DestroyController extends Controller
{
    public function __invoke(Audit $audit)
    {

        if (count($auditArtist = ArtistAudit::where('audit_id', $audit->id)->get()) > 0)
            $auditArtist->delete();
        $audit->delete();

        return response([]);
    }
}