<?php

namespace App\Http\Controllers\Admin\Album;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Support\Facades\Storage;

class DestroyController extends Controller
{
    public function __invoke(Album $album)
    {
        Storage::disk('public')->delete([$album->artwork_url, $album->thumb_url]);

        // $album->tracks()->detach();

        $album->delete();

        return redirect()->back();
    }
}