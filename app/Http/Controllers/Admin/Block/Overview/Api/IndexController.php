<?php

namespace App\Http\Controllers\Admin\Block\Overview\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OverviewResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $items = [
            ['id' => 1, 'name' => '@1', 'email' => '@1', 'role' => '@1', 'edit' => '@1', 'delete' => '@1',],
            ['id' => 2, 'name' => '@2', 'email' => '@2', 'role' => '@2', 'edit' => '@2', 'delete' => '@2',],
            ['id' => 3, 'name' => '@3', 'email' => '@3', 'role' => '@3', 'edit' => '@3', 'delete' => '@3',],
        ];

        return new OverviewResource($items);
    }
}