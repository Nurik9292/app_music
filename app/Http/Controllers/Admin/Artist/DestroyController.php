<?php

namespace App\Http\Controllers\Admin\Artist;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Support\Facades\Storage;

class DestroyController extends Controller
{
    public function __invoke(Artist $artist)
    {

        Storage::disk('public')->delete([$artist->artwork_url, $artist->thumb_url]);

        $artist->delete();

        return redirect()->back();
    }
}