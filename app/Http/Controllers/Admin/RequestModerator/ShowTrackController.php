<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TrackResource;
use App\Models\User;
use OwenIt\Auditing\Models\Audit;

class ShowTrackController extends Controller
{
    public function __invoke()
    {
        $moderator = 3;

        $audits = Audit::where('auditable_type', 'like', '%Track%')->get();

        foreach ($audits as $key => $audit) {
            $user = User::where('id', $audit->user_id)->get();
            if ($user[0]->role !== $moderator) unset($audits[$key]);
        }

        return new TrackResource($audits);
    }
}