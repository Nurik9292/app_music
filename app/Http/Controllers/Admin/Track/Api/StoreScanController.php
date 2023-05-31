<?php

namespace App\Http\Controllers\Admin\Track\Api;

use App\Http\Controllers\Admin\Track\BaseController;
use App\Models\File;
use Illuminate\Http\Request;

class StoreScanController extends BaseController
{
    public function __invoke(Request $request)
    {

        $data = $request->validate(['path' => ['required'], 'local' => ['required']]);
        $timestamp = $this->service->startScanDir($data['path'], $data['local']);

        if ($data['local'] == 'tm') {
            $file = File::where('local', 'tm')->get();
            $file[0]->update(['path' => $data['path'], 'local' => $data['local'], 'scanTime' => $timestamp]);
        }

        if ($data['local'] == 'ru') {
            $file = File::where('local', 'ru')->get();
            $file[0]->update(['path' => $data['path'], 'local' => $data['local'], 'scanTime' => $timestamp]);
        }

        if ($data['local'] == 'en') {
            $file = File::where('local', 'en')->get();
            $file[0]->update(['path' => $data['path'], 'local' => $data['local'], 'scanTime' => $timestamp]);
        }

        return response([]);
    }
}