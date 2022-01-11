<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Validation\Validator;
use Symfony\Component\Console\Input\InputOption;

class Json extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'json';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'parsing json';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('command parsing json file');
        $this->info('pleas select one of the models');
        $this->info('php artisan json:product');
        $this->info('php artisan json:category');
        return 0;
    }
}
