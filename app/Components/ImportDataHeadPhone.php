<?php

namespace App\Components;

use GuzzleHttp\Client;

class ImportDataHeadPhone
{
    public $headphones;


    public function __construct()
    {
        $this->headphones = new Client(['base_uri' => 'https://hp.telecom.tm:446/api/']);
    }
}