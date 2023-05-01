<?php

namespace App\Http\Controllers\Admin\Block\Overview\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockShema;
use Illuminate\Http\Request;

class DestroyController extends Controller
{
    public function __invoke(BlockShema $blockShema)
    {
        $blockShema->blockAlbums()->detach();
        $blockShema->blockPlaylists()->detach();
        $blockShema->blockUpdatedPlaylists()->detach();
        $blockShema->blockNames()->detach();

        $blockShema->delete();

        return response([]);
    }
}