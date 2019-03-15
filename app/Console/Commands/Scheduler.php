<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Item;

class Scheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:scheduler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run scheduler for scraping';

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
     * @return mixed
     */
    public function handle()
    {
        \Log::info('Scheduler start');
        $now = Carbon::now();
        $day = $now->day;

        if($day == 1){
            $this->call('command:scraping');
        }
    }
}
