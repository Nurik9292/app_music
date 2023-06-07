<?php


namespace App\Services\Admin\Moderator;

use App\Models\Artist;
use App\Models\ArtistAudit;
use App\Models\Track;

class Service
{
    public function create($audit)
    {
        if (preg_match('/(Artist)/', $audit->auditable_type))
            $this->createArtist($audit);

        if (preg_match('/(Track)/', $audit->auditable_type))
            $this->createTrack($audit);

        $audit->delete();
    }


    private function createArtist($audit)
    {
        $data = $audit->old_values;

        $artistAudit = ArtistAudit::where('audit_id', $audit->id)->get();
        $tracks = json_decode($artistAudit[0]->tracks);
        $albums = json_decode($artistAudit[0]->albums);

        $artist = Artist::create($data);
        if (isset($tracks))
            $artist->tracks()->attach($tracks);
        if (isset($albums))
            $artist->albums()->attach($albums);

        $artistAudit[0]->delete();
    }

    private function createTrack($audit)
    {
        Track::withTrashed()->where('id', $audit->old_values['id'])->restore();
    }


    public function delete($audit)
    {
        if (preg_match('/(Artist)/', $audit->auditable_type))
            $this->deleteArtist($audit);

        if (preg_match('/(Track)/', $audit->auditable_type))
            $this->deleteTrack($audit);


        $audit->delete();
    }


    private function deleteArtist($audit)
    {

        if ($audit->event == 'deleted')
            $artwork_url = $audit->old_values['artwork_url'];
        else {
            $artist = Artist::where('id', $audit->new_values['id'])->get()[0];
            $artist->albums()->detach();
            $artist->tracks()->detach();
        }

        if (($path = $artwork_url ?? $artist->artwork_url) != '') {
            $path = substr($path, 0, strpos($path, basename($path)));
            $path = pathToServer() . substr($path, strpos($path, "images"));
            $path = preg_replace('/artist_artWork\//', '', $path);
            $this->deletePath($path);
        }

        if (isset($artist))
            $artist->delete();

        ArtistAudit::where('audit_id', $audit->id)->get()[0]->delete();
    }


    private function deleteTrack($audit)
    {

        if ($audit->event == 'deleted')
            $track =  Track::withTrashed()->where('id',  $audit->old_values['id'])->get()[0];
        else
            $track = Track::where('id', $audit->new_values['id'])->get()[0];

        if (($path = $track->artwork_url)) {
            $path = substr($path, 0, strpos($path, basename($path)));
            $path = pathToServer() . substr($path, strpos($path, "images"));
            $path = preg_replace('/artwork\//', '', $path);
            $this->deletePath($path);
        }
        if (isset($track->albums))
            $track->albums()->detach();
        if (isset($track->artists));
        $track->artists()->detach();
        if (isset($track->genres))
            $track->genres()->detach();

        $track->delete();
    }


    public function returnOldData($audit)
    {
        if (preg_match('/(Artist)/', $audit->auditable_type))
            $this->dataArtist($audit);

        if (preg_match('/(Track)/', $audit->auditable_type))
            $this->dataTrack($audit);


        $audit->delete();
    }


    private function dataArtist($audit)
    {
        $data = $audit->old_values;
        $data['status'] = true;

        $artist = Artist::where('name', $audit->new_values['name'])->get();
        $artist[0]->update($data);
    }

    private function dataTrack($audit)
    {
        $data = $audit->old_values;
        $data['status'] = true;

        $track = Track::where('title', $audit->new_values['title'])->get();
        $track[0]->update($data);
    }

    private function deletePath($path)
    {

        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file) {
                $this->deletePath(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        } else if (is_file($path) === true) {
            return unlink($path);
        }

        return false;
    }
}