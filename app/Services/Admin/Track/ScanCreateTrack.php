<?php

namespace App\Services\Admin\Track;

use App\Models\Album;
use App\Models\Track;
use App\Models\Artist;
use App\Models\Country;
use App\Services\Admin\HelperService;
use Intervention\Image\Facades\Image;

class ScanCreateTrack
{
    private $helper;
    private $path_first;

    public function __construct()
    {
        $this->helper = new HelperService();
        $this->path_first = $this->helper->pathImageForServer;
    }

    public function create($data)
    {
        ini_set('max_execution_time', '300');
        set_time_limit(300);

        foreach ($data as $item) {
            // dd($item);
            if ($item['artists'])
                $artists = Artist::query()->firstOrCreate(['name' => $item['artists']], [
                    'name' => $item['artists'],
                    'country_id' =>  $item['is_national'] ? Country::where('name', 'like', 'Туркмения')->get()[0]->id : 1,
                ]);

            if ($item['album'])
                $album = Album::query()->firstOrCreate(['title' => $item['album']], [
                    'title' => $item['album'],
                    'status' => true,
                    'is_national' =>  $item['is_national'] ? true : false,
                ]);

            if ($item['artists'] && $item['album'])
                $album->artists()->attach($artists->id);


            if ($item['thumb_url'])
                $image_name = basename($item['thumb_url']);
            else $image_name = '';

            if (isset($artists))
                $artist = $artists->name;
            else  $artist = $item['artists'] ?? '';

            // $item['audio_url'] = "https://storage2.ma.st.com.tm" . $item['audio_url'];
            $item['audio_url'] =  preg_replace('/(:1000\/files)/', '', $item['audio_url']);;
            $item['audio_url'] =  "https://storage2.ma.st.com.tm" . preg_replace('/(\/nfs\/storage2\/)/', '', $item['audio_url']);;

            // dd($item['audio_url']);

            if ($item['thumb_url'] != null) {
                $thumb = Image::make($item['thumb_url'])->encode('jpg');
                $webp =  Image::make($item['thumb_url'])->encode('webp');
            }

            if ($item['is_national']) {
                if (isset($album))
                    $path_second = "tm_tracks/{$artist}/{$album->title}/{$item['title']}/";
                else
                    $path_second = "tm_tracks/{$artist}/{$item['title']}/";
            } else {
                if (isset($album))
                    $path_second = "tracks/{$artist}/{$album->title}/{$item['title']}/";
                else
                    $path_second = "tracks/{$artist}/{$item['title']}/";
            }


            $path_thumb = $this->path_first . $path_second;

            if (!file_exists($path_thumb))
                mkdir($path_thumb, 0777, true);

            if ($item['thumb_url'] != null) {
                $base_name  = preg_replace('/.webp/', '', $webp->basename) . ".jpg";
                $webp->fit(142, 166)->save($path_thumb . $image_name);
                $thumb->fit(142, 166)->save($path_thumb . $base_name);
                $image = $this->helper->pathImageForDb . $path_second . $base_name;
            }

            $item['thumb_url'] = $image ?? '';

            if (isset($item['artists']))
                unset($item['artists']);

            if (isset($item['album']))
                unset($item['album']);


            $track = Track::create($item);

            if (isset($artists))
                $track->artists()->attach($artists->id);

            if (isset($album))
                $track->album()->attach($album->id);
        }
    }
}