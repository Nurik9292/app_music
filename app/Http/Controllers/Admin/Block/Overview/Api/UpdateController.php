<?php

namespace App\Http\Controllers\Admin\Block\Overview\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockShema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdateController extends Controller
{
    public function __invoke(Request $request, BlockShema $blockShema)
    {
        $data = $request->all();

        Log::debug($data);

        if ($data['newAlbums'])
            foreach ($data['newAlbums'] as $newalbum)
                $newAlbums[] = $newalbum['id'];

        if ($data['newPlaylists'])
            foreach ($data['newPlaylists'] as $newPlaylist)
                $newPlaylists[] = $newPlaylist['id'];

        if ($data['updatedPlaylists'])
            foreach ($data['updatedPlaylists'] as $updatedPlaylist)
                $updatedPlaylists[] = $updatedPlaylist['id'];


        $arr = array_merge(['newAlbums' => $data['newAlbums'],  'newPlaylists' => $data['newPlaylists'], 'updatedPlaylists' => $data['updatedPlaylists']]);
        $data['body'] = json_encode($arr);

        unset($data['newAlbums']);
        unset($data['newPlaylists']);
        unset($data['updatedPlaylists']);


        $blockShema->update($data);

        if ($newAlbums)
            $blockShema->blockAlbums()->sync($newAlbums);
        if ($newPlaylists)
            $blockShema->blockPlaylists()->sync($newPlaylists);
        if ($updatedPlaylists)
            $blockShema->blockUpdatedPlaylists()->sync($updatedPlaylists);

        return response([]);
    }
}