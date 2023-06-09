<?php


namespace App\Services\Admin\Moderator;

use App\Models\Artist;
use App\Models\ArtistAudit;
use App\Models\Track;
use App\Services\Admin\HelperService;


class Service
{

    private $helper;

    public function __construct()
    {
        $this->helper = new HelperService();
    }

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
            $this->helper->delete($path);
        }

        if (isset($artist))
            $artist->delete();

        ArtistAudit::where('audit_id', $audit->id)->get()[0]->delete();
    }


    private function deleteTrack($audit)
    {
        if ($audit->event == 'deleted') {
            $track =  Track::withTrashed()->where('id',  $audit->old_values['id'])->get()[0];
        }
        if ($audit->event == 'created') {
            $track = Track::where('id', $audit->new_values['id'])->get()[0];
        }
        if ($audit->event == 'updated')
            $artwork_url = $audit->old_values['artwork_url'];


        if (($path = $track->artwork_url ?? ($artwork_url ?? false))) {
            $path = substr($path, 0, strpos($path, basename($path)));
            $path = pathToServer() . substr($path, strpos($path, "images"));
            $path = preg_replace('/artwork\//', '', $path);
            $this->helper->delete($path);
        }

        if ($audit->event == 'deleted' || $audit->event == 'created') {
            if (isset($track->albums))
                $track->albums()->detach();
            if (isset($track->artists));
            $track->artists()->detach();
            if (isset($track->genres))
                $track->genres()->detach();

            $track->delete();
        }
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

        preg_match('/\d+$/', $audit->url, $id);
        $data['status'] = true;

        $track = Track::where('id', $id[0])->get()[0];

        if ($audit->old_values['artwork_url'] != $audit->new_values['artwork_url'])
            $this->deletingAnImage($track->artwork_url);

        $track->update($data);
    }

    public function deletingMultipleEventsByOneId($audits)
    {
        $results = null;

        // Проеряем на совпадение на моделей
        while (count($audits) > 0) {
            $processed = $this->similarAudit($audits);

            $results[] = $this->removingTheEventOfOneId($processed);
        }

        return $results;
    }


    /**
     * Находит сибытие на одинаковые модели
     *
     * @param object  $audits
     * @return array || null
     */
    private function similarAudit(&$audits)
    {

        $firstUrl = null;
        $secondUrl = null;
        $similar = [];

        // Берет первый любой элемент
        if ($audits->first()->event == 'deleted') {
            $firstUrl = preg_replace('/(\/\d+)$/', '', $audits->first()->url);
        } else {
            $firstUrl = $audits->first()->url;
        }
        // Сравниваем первый элемент с остальными
        foreach ($audits as $key => $audit) {
            if ($audit->event == 'deleted') {
                $secondUrl = preg_replace('/(\/\d+)$/', '', $audit->url);
            } else {
                $secondUrl = $audit->url;
            }
            // если они похожи сохраняем
            if ($firstUrl == $secondUrl) {
                $similar[] = $audit;
                unset($audits[$key]);
            }
        }

        return $similar;
    }


    private function removingTheEventOfOneId($processed)
    {
        $idResult = null;

        // если обрабатываемый элемент один то передаем в конечный результат иначе убираем обрабатываем
        if (count($processed) === 1) {
            $lastModifaction = $processed[0];
        } else {
            $lastModifaction = $processed[0];

            foreach ($processed as $key => $item) {
                if ($lastModifaction->created_at < $item->created_at) {
                    $lastModifaction = $item;
                    $idResult = $key;
                }
            }
            // удалеям последний элемент из общего
            unset($processed[$idResult]);

            foreach ($processed as $item) {

                if ($item->event == 'deleted')
                    $this->create($item);
                if ($item->event == 'updated')
                    $lastModifaction->event != 'deleted' ? $this->returnOldData($item) : $item->delete();
            }

            // передаем в конечный результат послдний элемент
        }
        return $lastModifaction;
    }


    private function deletingAnImage($path)
    {
        $path = substr($path, 0, strpos($path, basename($path)));
        $path = pathToServer() . substr($path, strpos($path, "images"));

        $path = preg_replace('/artwork\//', '', $path);

        $this->helper->delete($path);
    }
}
