<?php

namespace App\Http\Controllers\Admin\Album;

use App\Http\Controllers\Controller;
use App\Services\Admin\Album\Service;

class BaseController extends Controller
{
    protected $service;


    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}