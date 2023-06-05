<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\ArtistAudit;
use OwenIt\Auditing\Models\Audit;

class RestoreController extends Controller
{
    public function __invoke(Audit $audit)
    {
        $data = $audit['old_values'];

        if ($audit->events == 'deleted')
            $this->delete($data, $audit);

        if ($audit->events == 'created')
            $this->create($data, $audit);

        Audit::latest()->first()->delete();

        return response([]);
    }

    private function delete($data, $audit)
    {
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

    private function create($data, $audit)
    {
        $artistAudit = ArtistAudit::where('audit_id', $audit->id)->get();

        $artist = Artist::create($data);
        if (isset($tracks))
            $artist->tracks()->attach($tracks);
        if (isset($albums))
            $artist->albums()->attach($albums);

        $artistAudit[0]->delete();
        $audit->delete();
    }
}
