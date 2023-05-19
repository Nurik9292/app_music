<?php

namespace App\Services\Admin\Track;

use App\Models\File;
use App\Services\Admin\HelperService;
use DirectoryIterator;
use Illuminate\Support\Facades\Log;
use Owenoj\LaravelGetId3\GetId3;

class ScanDir
{

    private $data;
    private $mp3;
    private $helper;
    private $timestamp;

    public function __construct()
    {
        $this->helper = new HelperService();
    }

    public function getContentDir($path, $local)
    {
        if (str_starts_with($path, "https://storage2.ma.st.com.tm:1000/files/"))
            $path = $this->helper->pathTrackForServer . preg_replace('/(https:\/\/storage2.ma.st.com.tm:1000\/files\/)/', '', $path);

        Log::debug($path);
        if (!str_ends_with($path, '/'))
            $path = $path . '/';

        $file = File::where('local', $local)->get();

        $iter = new DirectoryIterator($path);

        foreach ($iter as $item) {
            if ($item != '.' && $item != '..') {
                if ($item->isDir()) $this->getContentDir($path . $item->getBasename() . "/", $local);

                if ($item->isFile()) {

                    if ($file[0]->scanTime < $item->getATime()) {
                        if ($item->getSize() != 0)
                            str_ends_with($item->getBasename(), '.mp3') ? $this->mp3[] = $item->getRealPath() : '';
                    }

                    $this->timestamp = $item->getATime();
                }
            }
        }
    }

    public function addContent($local)
    {
        if ($this->mp3 != null)
            $this->addMp3($local);
    }

    private function addMp3($local)
    {
        foreach ($this->mp3 as $audio_url) {

            $track = new GetId3($audio_url);

            $artist = $track->getArtist() ?? null;
            $title = $track->getTitle() ?? null;
            $album = $track->getAlbum() ?? null;
            $image = $track->getArtwork(true) ?? null;
            if ($track->getPlaytimeSeconds())
                $duration = intval(round($track->getPlaytimeSeconds()));
            if (isset($track->extractInfo()['bitrate']))
                $bitrate = intval(round($track->extractInfo()['bitrate']));


            $this->data[] = [
                'title' => $title,
                'artists' => $artist,
                'album' => $album,
                'duration' => isset($duration) ? $duration : 0,
                'bit_rate' => isset($bitrate) ? $bitrate : 0,
                'lyrics' => '',
                'audio_url' => $audio_url,
                'is_national' => $local == 'tm' ? true : false,
                'artwork_url' => $image,
                'status' =>  true
            ];
        }
    }


    public function getMp3()
    {
        return $this->mp3;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
