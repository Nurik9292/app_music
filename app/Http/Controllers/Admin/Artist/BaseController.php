<?php

namespace App\Http\Controllers\Admin\Artist;

use App\Http\Controllers\Controller;
use App\Services\Admin\Artist\Service;

class BaseController extends Controller
{
    protected $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}