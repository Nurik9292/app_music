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
            $name = $data['name'];
            $status = $data['status'];
            $artwork_url = $data['artwork_url'];

            if ($data['artwork_url'] != null)
                $data['artwork_url'] = Storage::disk('public')->put('images', $data['artwork_url']);

            foreach ($data as $key => $item) {
                $data['data'][$key] = $item;
                unset($data[$key]);
            }

            $data['data'] = serialize($data['data']);
            $data['actions'] = $actions;

            if (isset($data['artwork_url']) && $artist->artwork_url != $data['artwork_url']) $data['what'] = 'изображение';
            if ($artist->name != $data['name']) $data['what'] = 'имя артиста';
            if ($artist->status != $data['status']) $data['what'] = 'cтатус';
            if ($artist->bio_tk != $data['bio_tk']) $data['what'] = 'биография';
            if ($artist->bio_ru != $data['bio_ru']) $data['what'] = 'биография';
            if ($artist->country_id != $data['country_id']) $data['what'] = 'страна';
        }

        $data['artist_id'] = $artist->id;
        $data['artist_name'] = $artist->name;
        $data['response'] = 'ожидает';

        dd($data);
        if (count($requsetArtist = RequestArtist::where('artist_id', $artist->id)->get()) > 0)
            $requsetArtist->update($data);
        else
            RequestArtist::create($data);



        return response([]);
    }
}