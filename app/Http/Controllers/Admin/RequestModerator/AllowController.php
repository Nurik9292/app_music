<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Models\Artist;
use App\Models\ArtistAudit;
use App\Models\Track;
use OwenIt\Auditing\Models\Audit;

class AllowController extends BaseController
{
    public function __invoke(Audit $audit)
    {
        if ($audit->event == 'updated') {

            if (preg_match('/(Artist)/', $audit->auditable_type)) {
                $artist_name = $audit->new_values['name'];
                $item = Artist::where('name', $artist_name)->get()[0];
            }
            if (preg_match('/(Track)/', $audit->auditable_type)) {
                preg_match('/\d+$/', $audit->url, $id);
                $this->service->delete($audit);
                $item = Track::where('id', $id[0])->get()[0];
            }
        } else {
            $id = $audit->new_values['id'];

            if (preg_match('/(Artist)/', $audit->auditable_type))
                $item = Artist::where('id', $id)->get()[0];

            if (preg_match('/(Track)/', $audit->auditable_type))
                $item = Track::where('id', $id)->get()[0];
        }

        $item->update(['status' => true]);


        if (count($artistAudit = ArtistAudit::where('audit_id', $audit->id)->get()) > 0)
            $artistAudit[0]->delete();


        $audit->delete();

        return response([]);
    }
}