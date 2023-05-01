<?php

namespace App\Http\Controllers\Admin\Block\Overview\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockShema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->all();

        Log::debug($data);

        $block = $data['block']['id'];
        $data['name'] = $data['block']['name'];
        unset($data['block']);

        foreach ($data['newAlbums'] as $newalbum)
            $newAlbums[] = $newalbum['id'];

        foreach ($data['newPlaylists'] as $newPlaylist)
            $newPlaylists[] = $newPlaylist['id'];

        foreach ($data['updatedPlaylists'] as $updatedPlaylist)
            $updatedPlaylists[] = $updatedPlaylist['id'];


        $arr = array_merge(['newAlbums' => $data['newAlbums'],  'newPlaylists' => $data['newPlaylists'], 'updatedPlaylists' => $data['updatedPlaylists']]);
        $data['body'] = json_encode($arr);

        unset($data['newAlbums']);
        unset($data['newPlaylists']);
        unset($data['updatedPlaylists']);

        $blockShema = BlockShema::create($data);

        $blockShema->blockAlbums()->attach($newAlbums);
        $blockShema->blockPlaylists()->attach($newPlaylists);
        $blockShema->blockUpdatedPlaylists()->attach($updatedPlaylists);
        $blockShema->blockNames()->attach($block);

        return response([]);
    }
}