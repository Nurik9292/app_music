<?php


namespace App\Services\Admin\Moderator;

use App\Models\Artist;
use App\Models\ArtistAudit;

class Service
{
    public function create($audit)
    {
        $data = $audit->new_values;

        $artistAudit = ArtistAudit::where('audit_id', $audit->id)->get();
        $tracks = json_decode($artistAudit[0]->tracks);
        $albums = json_decode($artistAudit[0]->albums);

        $artist = Artist::create($data);
        if (isset($tracks))
            $artist->tracks()->attach($tracks);
        if (isset($albums))
            $artist->albums()->attach($albums);

        $artistAudit[0]->delete();
        $audit->delete();
    }

    public function delete($audit)
    {
        $artistAudit = ArtistAudit::where('audit_id', $audit->id)->get();

        $artist = Artist::where('id', $audit->new_values['id'])->get()[0];

        if (($path = $artist->artwork_url) != '') {
            $path = substr($path, 0, strpos($path, basename($path)));
            $path = pathToServer() . substr($path, strpos($path, "images"));
            $path = preg_replace('/artist_artWork\//', '', $path);
            $this->deletePath($path);
        }

        $artist->albums()->detach();
        $artist->tracks()->detach();
        $artist->delete();

        if (count($artistAudit) > 0)
            $artistAudit[0]->delete();
        $audit->delete();
    }

    public function returnOldData($audit)
    {
        $data = $audit->old_values;
        $data['status'] = true;

        $artist = Artist::where('name', $audit->new_values['name'])->get();
        $artist[0]->update($data);

        $audit->delete();
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