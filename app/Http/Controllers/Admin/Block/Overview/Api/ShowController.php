<?php

namespace App\Http\Controllers\Admin\Block\Overview\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OverviewResource;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke()
    {
        $blocks = [
            'Новинки и обновленияНовинки и обновления',
            'Рекомендуем послушать',
            'Новая музыка',
            'Лучшие новые песни',
            'Чарты',
            'Жанры и Категории',
            'Для детей',
            'Настроение',
        ];

        return new OverviewResource($blocks);
    }
}
