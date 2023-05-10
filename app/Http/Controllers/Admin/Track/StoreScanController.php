<?php

namespace App\Http\Controllers\Admin\Track;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StoreScanController extends BaseController
{
    public function __invoke(Request $request)
    {
        $data = $request->validate(['path' => ['required'], 'local' => ['required']]);

        $this->service->startScanDir($data['path'], $data['local']);

        if ($data['local'] == 'tm')
            $file = File::where('local', 'tm')->get();

        $file[0]->update(['path' => $data['path'], 'local' => $data['local'], 'scanTime' =>  Carbon::parse(now())->format('Y-m:d H:i')]);

        return redirect()->route('track.index');
    }
}