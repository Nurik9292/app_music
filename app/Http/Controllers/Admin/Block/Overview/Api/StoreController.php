<?php

namespace App\Http\Controllers\Admin\Block\Overview\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockShema;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->all();


        $data['body'] = json_encode([
            "name_status" => $data['name_status'] ?? '',
            'albums' => $data['albums'] ?? '',
            'playlists' => $data['playlists'] ?? '',
            'tracks' => $data['tracks'] ?? '',
            'artists' => $data['artists'] ?? '',
        ]);

        unset($data['playlists'], $data['albums'], $data['tracks'], $data['artists'], $data['name_status']);

        if (count(BlockShema::where('order_number', $data['order_number'])->get()) > 0) {
            $blocks = BlockShema::where('order_number', '>=', $data['order_number'])->get();
            foreach ($blocks as $block) $block->increment('order_number');
        }


        BlockShema::create($data);

        $audit = Audit::latest()->first();

        $audit->update(['user_type' => 'App\Model\User', $data['user_id']]);

        return response([]);
    }
}
