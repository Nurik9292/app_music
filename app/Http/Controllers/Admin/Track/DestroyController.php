<?php

namespace App\Http\Controllers\Admin\Track;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Support\Facades\Storage;

class DestroyController extends Controller
{
    public function __invoke(Track $track)
    {
        Storage::disk('public')->delete([$track->audio_url, $track->thumb_url]);

        $track->artists()->detach();
        $track->genres()->detach();
        $track->album()->detach();

        $track->delete();

        return redirect()->back();
    }
}