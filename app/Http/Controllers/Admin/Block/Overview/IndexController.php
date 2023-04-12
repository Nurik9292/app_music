<?php

namespace App\Http\Controllers\Admin\Block\Overview;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        $headphones = new Client();

        $response = $headphones->request('GET', 'https://hp.telecom.tm:446/api/get_data');

        dd($response->getBody());

        return view('block.overview.index');
    }
}