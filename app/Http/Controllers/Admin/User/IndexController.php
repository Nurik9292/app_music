<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Imports\TrackImport;
use App\Models\Artist;
use App\Models\User;
use getID3;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        $users = User::all();


        $aa =  Artist::all();

        dd($aa);

        $remotefilename = 'https://storage1.ma.st.com.tm/tm/Azat_Dönmezow/Aladam_sen.mp3';
        if ($fp_remote = fopen($remotefilename, 'rb')) {
            $localtempfilename = tempnam('/tmp', 'getID3');
            if ($fp_local = fopen($localtempfilename, 'wb')) {
                while ($buffer = fread($fp_remote, 8192)) {
                    fwrite($fp_local, $buffer);
                }
                fclose($fp_local);
                // Initialize getID3 engine
                $getID3 = new getid3;
                $ThisFileInfo = $getID3->analyze($localtempfilename);
                // Delete temporary file
                unlink($localtempfilename);
            }
            fclose($fp_remote);
        }

        dd($ThisFileInfo);


        // $url = "/home/nury/Загрузки/instasamka-za-dengi-da-mp3.mp3";

        // $track = new GetId3($url);

        // dd($track->extractInfo());

        return view('users.index', compact('users'));
    }
}