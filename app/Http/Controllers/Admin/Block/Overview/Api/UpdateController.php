<?php

namespace App\Http\Controllers\Admin\Block\Overview\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockShema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdateController extends Controller
{
    public function __invoke(Request $request, BlockShema $block)
    {
        $data = $request->all();

        Log::debug($data);

        $data['body'] = json_encode([
            "name_status" => $data['name_status'] ?? '',
            'albums' => $data['albums'] ?? '',
            'playlists' => $data['playlists'] ?? '',
            'tracks' => $data['tracks'] ?? '',
            'genres' => $data['genres'] ?? '',
        ]);

        unset($data['playlists'], $data['albums'], $data['tracks'], $data['genres'], $data['name_status']);

        $block->update($data);

        return response([]);
    }
}
