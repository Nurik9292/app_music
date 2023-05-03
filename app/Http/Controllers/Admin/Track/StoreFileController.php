<?php

namespace App\Http\Controllers\Admin\Track;

use App\Http\Controllers\Controller;
use App\Imports\TrackImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class StoreFileController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate(['file' => ['required']]);
        $file_name = basename($data['file']);

        $path_file = Storage::putFileAs("public/excel", $data['file'], $file_name . ".xlsx");

        ini_set('memory_limot', '-1');
        Excel::import(new TrackImport, storage_path("app/" . $path_file));

        return redirect()->back();
    }
}