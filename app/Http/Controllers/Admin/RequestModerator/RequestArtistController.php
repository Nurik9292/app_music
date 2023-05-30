<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\RequestArtist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RequestArtistController extends Controller
{
    public function __invoke(Request $request, Artist $artist)
    {
        $data = $request->all();

        if ($data['actions'] == 'update') {
            $actions = $data['actions'];

            if ($data['artwork_url'] != null)
                $data['artwork_url'] = Storage::disk('public')->put('images', $data['artwork_url']);

            foreach ($data as $key => $item) {
                $data['data'][$key] = $item;
                unset($data[$key]);
            }

            $data['data'] = serialize($data['data']);
            $data['actions'] = $actions;
        }

        $data['artist_id'] = $artist->id;
        $data['response'] = 'ожидает';

        if (count($requsetArtist = RequestArtist::where('artist_id', $artist->id)->get()) > 0)
            $requsetArtist->update($data);
        else
            RequestArtist::create($data);

        return response([]);
    }
}
