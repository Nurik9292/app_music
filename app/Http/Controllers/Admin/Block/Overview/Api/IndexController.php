<?php

namespace App\Http\Controllers\Admin\Block\Overview\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BlockResource;
use App\Http\Resources\Admin\OverviewResource;
use App\Http\Resources\BlockShemaResource;
use App\Models\BlockShema;

class IndexController extends Controller
{
    public function __invoke()
    {
        $blocks = BlockShema::orderBy('order_number')->get();

        return BlockResource::collection($blocks);
    }
}
