<?php

namespace App\Components;

use GuzzleHttp\Client;

class ImportDataHeadPhone
{
    public $headphones;


    public function __construct()
    {
        // $this->headphones = new Client([
        // Base URI is used with relative requests
        //     'base_uri' => 'https://hp.telecom.tm:446/api',
        // You can set any number of default request options.
        //     'timeout'  => 5.0,
        // ]);

        $this->headphones = new Client(['base_uri' => 'https://hp.telecom.tm:446/api/']);
    }
}