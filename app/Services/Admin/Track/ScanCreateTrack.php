<?php

namespace App\Services\Admin\Track;

use App\Models\Album;
use App\Models\Track;
use App\Models\Artist;
use App\Models\Country;
use App\Services\Admin\HelperService;
use Illuminate\Support\Facades\Log;
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
            $artists = null;
            $album = null;

            $artists = $this->createArtist($item['artists'], $item['is_national']);

            if (isset($artists))
                $artist = $artists->name;
            else  $artist = $artist ?? '';

            if (isset($item['album']))
                $album = $this->createAlbum($item['album'], $item['is_national']);

            if (isset($artists) && isset($album)) {
                $artists->albums()->detach($album->id);
                $artists->albums()->attach($album->id);
            }

            if (isset($item['thumb_url']))
                $image_name = basename($item['thumb_url']);
            else $image_name = '';

            // $item['audio_url'] = "https://storage2.ma.st.com.tm" . $item['audio_url'];
            $item['audio_url'] =  preg_replace('/(:1000\/files)/', '', $item['audio_url']);;
            $item['audio_url'] =  "https://storage2.ma.st.com.tm/" . preg_replace('/(\/nfs\/storage2\/)/', '', $item['audio_url']);;

            Log::debug($item['thumb_url']);

            if ($item['thumb_url'] != null) {
                $artwork = Image::make($item['thumb_url']);
                $artWork_webp =  Image::make($item['thumb_url']);

                $thumb = Image::make($item['thumb_url']);
                $thumb_webp =  Image::make($item['thumb_url']);
            }

            if (isset($artist)) $artist = preg_replace('/(.webp)/', '', basename($item['thumb_url']));

            [$path_second_artwork, $path_second_thumb] = $this->createPath($item['is_national'], $album, $artist, $item['title']);

            $path_thumb = $this->path_first . $path_second_thumb;
            $path_artWork = $this->path_first . $path_second_artwork;

            if (!file_exists($path_thumb))
                mkdir($path_thumb, 0777, true);

            if (!file_exists($path_artWork))
                mkdir($path_artWork, 0777, true);

            if ($item['thumb_url'] != null) {
                $base_name  = preg_replace('/.webp/', '', $thumb_webp->basename) . ".jpg";

                $thumb_webp->fit(142, 166)->save($path_thumb . $image_name)->encode('webp');
                $thumb->fit(142, 166)->save($path_thumb . $base_name)->encode('jpg');

                $artWork_webp->fit(375, 250)->save($path_artWork . $image_name)->encode('webp');
                $artwork->fit(375, 250)->save($path_artWork . $base_name)->encode('jpg');

                $image_thumb = $this->helper->pathImageForDb . $path_second_thumb . $base_name;
                $image_artWork = $this->helper->pathImageForDb . $path_second_artwork . $base_name;
            }

            $item['thumb_url'] = $image_thumb ?? '';
            $item['artwork_url'] = $image_artWork ?? '';

            unset($item['artists']);
            unset($item['album']);

            $track = Track::create($item);

            if (isset($artists))
                $track->artists()->attach($artists->id);

            if (isset($album))
                $track->album()->attach($album->id);
        }
    }


    private function createArtist($artist, $inNational)
    {

        if (isset($artist)) {
            $artists = Artist::firstOrCreate(['name' => $artist], [
                'name' => $artist,
                'country_id' =>  $inNational ? Country::where('name', 'like', 'Туркмения')->get()[0]->id : 1,
            ]);
        } else {
            $artists = Artist::create([
                'name' => 'none',
                'country_id' =>  $inNational ? Country::where('name', 'like', 'Туркмения')->get()[0]->id : 1,
            ]);
        }

        return $artists;
    }

    private function createAlbum($albums, $isNational)
    {

        Log::debug($albums);
        if (mb_detect_encoding($albums) == 'ASCII-8')
            $albums = iconv('ASCII', 'UTF-8//IGNORE', $albums);

        $album = Album::firstOrCreate(['title' => $albums], [
            'title' => $albums,
            'status' => true,
            'is_national' =>  $isNational ? true : false,
        ]);

        return $album;
    }

    private function createPath($isNational, $album, $artist, $title)
    {
        if ($isNational) {
            if (isset($album)) {
                $path_second_artwork = "tm_tracks/{$artist}/{$album->title}/{$title}/artwokr/";
                $path_second_thumb = "tm_tracks/{$artist}/{$album->title}/{$title}/thumb/";

                $path_second_artwork = preg_replace('/\/{2,}/', '', $path_second_artwork);
                $path_second_thumb = preg_replace('/\/{2,}/', '', $path_second_thumb);
            } else {
                $path_second_artwork = "tm_tracks/{$artist}/{$title}/artwokr/";
                $path_second_thumb = "tm_tracks/{$artist}/{$title}/thumb/";

                $path_second_artwork = preg_replace('/\/{2,}/', '', $path_second_artwork);
                $path_second_thumb = preg_replace('/\/{2,}/', '', $path_second_thumb);
            }
        } else {
            if (isset($album)) {
                $path_second_artwork = "tracks/{$artist}/{$album->title}/{$title}/artwokr/";
                $path_second_thumb = "tracks/{$artist}/{$album->title}/{$title}/thumb/";

                $path_second_artwork = preg_replace('/\/{2,}/', '', $path_second_artwork);
                $path_second_thumb = preg_replace('/\/{2,}/', '', $path_second_thumb);
            } else {
                $path_second_artwork = "tracks/{$artist}/{$title}/artwokr/";
                $path_second_thumb = "tracks/{$artist}/{$title}/thumb/";

                $path_second_artwork = preg_replace('/\/{2,}/', '', $path_second_artwork);
                $path_second_thumb = preg_replace('/\/{2,}/', '', $path_second_thumb);
            }
        }

        return [$path_second_artwork, $path_second_thumb];
    }
}