<?php

namespace App\Http\Controllers\Admin\Track;

use App\Http\Controllers\Controller;
use App\Models\File;

class ResetScanController extends Controller
{
    public function __invoke()
    {
        $files = File::all();

        foreach ($files as $file) {
            $file->update(['scanTime' => 0,]);
        }

        return redirect()->back();
    }
}