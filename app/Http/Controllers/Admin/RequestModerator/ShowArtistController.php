<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ArtistResource;
use App\Models\User;
use OwenIt\Auditing\Models\Audit;

class ShowArtistController extends Controller
{
    public function __invoke()
    {
        $moderator = 3;

        $audits = Audit::where('auditable_type', 'like', '%Artist%')->get();

        foreach ($audits as $key => $audit) {
            $user = User::where('id', $audit->user_id)->get();
            if ($user[0]->role !== $moderator) unset($audits[$key]);
        }

        return new ArtistResource($audits);
    }
}
