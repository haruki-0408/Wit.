<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Room;
use App\Models\User;

class CheckRoomState extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkroom:state';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage room time limits and change to Save or Remove status (Test Commnad)';

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
        $room = new Room;
        $rooms = $room->whereNull('posted_at')->count();
        logger()->info($rooms);
    }
}
