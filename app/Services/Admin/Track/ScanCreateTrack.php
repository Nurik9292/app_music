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
    private $scanDir;

    public function __construct()
    {
        $this->helper = new HelperService();
        $this->scanDir = new ScanDir();
        $this->path_first = $this->helper->pathImageForServer;
    }


    public function start($path, $local)
    {

        $this->scanDir->getContentDir($path, $local);
        $this->scanDir->addContent($local);
        $timestamp = $this->scanDir->getTimestamp();
        $data = $this->scanDir->getData();

        if ($data != null)
            $this->create($data);

        return $timestamp;
    }

    public function create($data)
    {
        foreach ($data as $item) {

            $artists = null;
            $album = null;

            $artists = $this->createArtist($item['artists'], $item['is_national']);

            if (isset($artists))
                $artist = $artists->name;
            else  $artist = $artist ?? 'none';

            if (isset($item['album']) && $item['is_national'] != 'tm')
                $album = $this->createAlbum($item['album']);

            if (isset($artists) && isset($album)) {
                $artists->albums()->detach($album->id);
                $artists->albums()->attach($album->id);
            }

            if (isset($item['artwork_url']))
                $image_name = basename($item['artwork_url']);
            else $image_name = '';

            $item['audio_url'] =  preg_replace('/(:1000\/files)/', '', $item['audio_url']);
            $item['audio_url'] =  "https://storage2.ma.st.com.tm/" . preg_replace('/(\/nfs\/storage2\/)/', '', $item['audio_url']);;
            $item['audio_url'] = preg_replace('/(\/)(?=\1)/', '', $item['audio_url']);


            if (!isset($artist)) $artist = preg_replace('/(.webp)/', '', basename($item['artwork_url']));

            [$path_second_artwork, $path_second_thumb] = $this->createPath($item['is_national'], $album, $artist, $item['title']);


            $path_thumb = $this->path_first . $path_second_thumb;
            $path_artWork = $this->path_first . $path_second_artwork;

            if (!file_exists($path_thumb))
                mkdir($path_thumb, 0777, true);

            if (!file_exists($path_artWork))
                mkdir($path_artWork, 0777, true);


            if ($item['artwork_url'] != null) {
                [$item['thumb_url'], $item['artwork_url']] = $this->pathForDatabase($item['artwork_url'], $path_artWork, $path_thumb, $image_name, $path_second_artwork, $path_second_thumb);
            }


            unset($item['artists']);
            unset($item['album']);


            if (isset($artists)) {

                foreach ($artists->tracks as $mp3) {
                    if ($mp3->title != $item['title']) {
                        $track = Track::create($item);
                    }
                }

                if (count($artists->tracks) === 0)
                    $track = Track::firstOrCreate(['title' => $item['title']], $item);
            }


            if (isset($artists)) {
                $track->artists()->detach($artists->id);
                $track->artists()->attach($artists->id);
            }

            if (isset($album)) {
                $track->album()->detach($album->id);
                $track->album()->attach($album->id);
            }
        }
    }


    private function createArtist($artist, $inNational)
    {

        if (isset($artist)) {
            $artists = Artist::firstOrCreate(['name' => $artist], [
                'name' => $artist,
                'status' => true,
                'country_id' =>  $inNational ? Country::where('name', 'like', 'Туркмения')->get()[0]->id : 1,
            ]);
        } else {
            $artists = Artist::create([
                'name' => 'none',
                'status' => true,
                'country_id' =>  $inNational ? Country::where('name', 'like', 'Туркмения')->get()[0]->id : 1,
            ]);
        }

        return $artists;
    }

    private function createAlbum($albums, $isNational = null)
    {
        if (mb_detect_encoding($albums) == 'ASCII-8')
            $albums = iconv('ASCII', 'UTF-8//IGNORE', $albums);

        if (!$this->is_utf8($albums)) $albums = 'album';

        $album = Album::firstOrCreate(['title' => $albums], [
            'title' => $albums,
            'status' => true,
            'is_national' => false,
        ]);

        return $album;
    }

    private function createPath($isNational, $album, $artist, $title)
    {
        if ($isNational) {
            $path_second_artwork = "tm_tracks/{$artist}/{$title}/artwork/";
            $path_second_thumb = "tm_tracks/{$artist}/{$title}/thumb/";
        } else {
            if (isset($album)) {
                $path_second_artwork = "tracks/{$artist}/{$album->title}/{$title}/artwork/";
                $path_second_thumb = "tracks/{$artist}/{$album->title}/{$title}/thumb/";
            } else {
                $path_second_artwork = "tracks/{$artist}/{$title}/artwork/";
                $path_second_thumb = "tracks/{$artist}/{$title}/thumb/";
            }
        }
        $path_second_artwork = preg_replace('/(\/)(?=\1)/', '', $path_second_artwork);
        $path_second_thumb = preg_replace('/(\/)(?=\1)/', '', $path_second_thumb);

        return [$path_second_artwork, $path_second_thumb];
    }


    private function pathForDatabase($image, $path_artWork, $path_thumb, $image_name, $path_second_artwork, $path_second_thumb)
    {
        $artwork = Image::make($image);
        $artWork_webp =  Image::make($image);

        $thumb = Image::make($image);
        $thumb_webp =  Image::make($image);

        if (str_ends_with($thumb_webp->basename, 'jpeg')) {
            $base_name  = preg_replace('/.jpeg/', '', $thumb_webp->basename) . ".webp";

            $thumb_webp->fit(142, 166)->save($path_thumb . $image_name)->encode('jpeg');
            $thumb->fit(142, 166)->save($path_thumb . $base_name)->encode('webp');

            $artWork_webp->fit(375, 250)->save($path_artWork . $image_name)->encode('jpeg');
            $artwork->fit(375, 250)->save($path_artWork . $base_name)->encode('webp');
        }
        if (str_ends_with($thumb_webp->basename, 'jpg')) {
            $base_name  = preg_replace('/.jpg/', '', $thumb_webp->basename) . ".webp";

            $thumb_webp->fit(142, 166)->save($path_thumb . $image_name)->encode('jpg');
            $thumb->fit(142, 166)->save($path_thumb . $base_name)->encode('webp');

            $artWork_webp->fit(375, 250)->save($path_artWork . $image_name)->encode('jpg');
            $artwork->fit(375, 250)->save($path_artWork . $base_name)->encode('webp');
        }
        if (str_ends_with($thumb_webp->basename, 'png')) {
            $base_name  = preg_replace('/.png/', '', $thumb_webp->basename) . ".webp";

            $thumb_webp->fit(142, 166)->save($path_thumb . $image_name)->encode('png');
            $thumb->fit(142, 166)->save($path_thumb . $base_name)->encode('webp');

            $artWork_webp->fit(375, 250)->save($path_artWork . $image_name)->encode('png');
            $artwork->fit(375, 250)->save($path_artWork . $base_name)->encode('webp');
        }

        $image_thumb = $this->helper->pathImageForDb . $path_second_thumb . $base_name;
        $image_artWork = $this->helper->pathImageForDb . $path_second_artwork . $base_name;

        return [$image_artWork, $image_thumb];
    }



    function is_utf8($string)
    {
        // Log::debug($string);
        return preg_match('%^(?:
        [\x09\x0A\x0D\x20-\x7E]
        | [\xC2-\xDF][\x80-\xBF]
        | \xE0[\xA0-\xBF][\x80-\xBF]
        | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}
        | \xED[\x80-\x9F][\x80-\xBF]
        | \xF0[\x90-\xBF][\x80-\xBF]{2}
        | [\xF1-\xF3][\x80-\xBF]{3}
        | \xF4[\x80-\x8F][\x80-\xBF]{2}
        )*$%xs', $string);
    }
}
