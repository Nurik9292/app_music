<?php

namespace App\Http\Controllers\Admin\Playlist;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Support\Facades\Storage;

class DestroyController extends Controller
{
    public function __invoke(Playlist $playlist)
    {
        Storage::disk('public')->delete([$playlist->artwork_url, $playlist->thumb_url]);

        $playlist->tracks()->detach();
        $playlist->genres()->detach();

        $playlist->delete();

        return redirect()->back();
    }
}
