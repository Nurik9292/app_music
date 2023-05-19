<?php

namespace App\Http\Filters;

use App\Models\Artist;
use App\Models\Track;
use Illuminate\Database\Eloquent\Builder;

class ArtistTrackFilter extends AbstractFilter
{
    public const ARTIST = 'artist';

    protected function getCallbacks(): array
    {
        return [
            self::ARTIST => [$this, 'artist']
        ];
    }

    public function artist(Builder $builder, $value)
    {
        $builder->where('id', $value)->get();

        // $query = Artist::query();

        // if (isset($data['artist'])) {
        //     $artist = $query->where('id', $data['artist'])->get();
        //     $tracks = $artist[0]->tracks;
        // } else {
        //     $tracks = Track::all();
        // }
    }
}
