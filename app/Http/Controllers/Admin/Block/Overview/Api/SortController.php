<?php

namespace App\Http\Controllers\Admin\Block\Overview\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockShema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SortController extends Controller
{
    public function __invoke(Request $request)
    {
        $blocks = $request->blocks;
        Log::debug($blocks);

        foreach ($blocks as $item) {
            $item['order_number'] = $item['order'];
            unset($item['order']);
            $data[] = $item;
        }


        foreach ($data as $item) {
            $block = BlockShema::where('id', $item['id'])->get();
            $block[0]->update($item);
        }

        return response([]);
    }
}
