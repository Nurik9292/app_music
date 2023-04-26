<?php

namespace App\Http\Controllers\Admin\Playlist;

use App\Http\Controllers\Controller;
use App\Services\Admin\Playlist\Service;

class BaseController extends Controller
{
    protected $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
