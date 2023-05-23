<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Jobs\DownloadDataB3Job;
class DownloadDataB3Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:data-b3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $job = new DownloadDataB3Job;
        $job->handle();
    }

}
