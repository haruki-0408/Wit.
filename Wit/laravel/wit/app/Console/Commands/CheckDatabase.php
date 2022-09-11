<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the scheme of the connected database';

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
        dd(config('database.connections.mysql'),config('database.connections.mysql-test'),'DB_CONNECTION is '.env('DB_CONNECTION'),'DB_DATABASE is '.env('DB_DATABASE'),'DB_HOST is '.env('DB_HOST'),'DB_USERNAME is '.env('DB_USERNAME'));
    }
}
