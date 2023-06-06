<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use OwenIt\Auditing\Models\Audit;

class AllowController extends Controller
{
    public function __invoke(Audit $audit)
    {
        if ($audit->event == 'updated') {
            $artist_name = $audit->new_values['name'];
            $artist = Artist::where('name', $artist_name)->get()[0];
        } else {
            $artist_id = $audit->new_values['id'];
            $artist = Artist::where('id', $artist_id)->get()[0];
        }

        $artist->update(['status' => true]);

        $audit->delete();

        return response([]);
    }
}