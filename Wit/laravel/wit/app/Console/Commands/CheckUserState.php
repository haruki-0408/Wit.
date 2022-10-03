<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class CheckUserState extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage User status and gracefully delete expired user records';

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
        $users = User::where('status', '0')->orWhere('status', '1')->get();
        foreach ($users as $user) {
            $now = Carbon::now();
            $expire_time = $user->created_at->addHour();
            if ($now > $expire_time) {
                logger()->info('name:' . $user->name . '&   email:' . $user->email . 'is removed.');
                $user->delete();
            }
        }
        return 0;
    }
}
