<?php

namespace App\Console\Commands;

use App\Components\ImportDataHeadPhone;
use Illuminate\Console\Command;

class ImportHeadPhoneCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'headphone:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data from HeadPhones';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $import = new ImportDataHeadPhone;

        $response = $import->headphones->request('GET', 'get_data');

        dd($response);
    }
}