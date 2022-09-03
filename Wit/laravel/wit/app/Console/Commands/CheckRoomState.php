<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Room;
use App\Models\User;
use App\Events\RemoveRoom;
use App\Events\SaveRoom;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
        $rooms = $room->whereNull('posted_at')->get();
        foreach ($rooms as $room) {
            if ((Room::checkExpiredRoom($room->id))) {
                if ($room->password !== null || $room->tags()->count() == 0) {
                    $room_tags = $room->tags()->get();

                    foreach ($room_tags as $room_tag) {
                        if (Tag::where('id', $room_tag->pivot->tag_id)->doesntExist()) {
                            return logger()->info('tag error');
                        }

                        $tag = Tag::find($room_tag->pivot->tag_id);
                        if ($tag->number < 1) {
                            $tag->delete();
                        } else {
                            $tag->update([
                                'number' => $tag->number - 1
                            ]);
                        }
                    }

                    $room->delete();
                    event(new RemoveRoom($room->id));
                    Storage::disk('local')->deleteDirectory('/roomImages/RoomID:' . $room->id);
                    logger()->info($room->id . ' is removed');
                } else {
                    $room->roomBans()->detach();
                    $room->roomUsers()->detach();

                    $room->posted_at = Carbon::now();
                    $room->save();
                    event(new SaveRoom($room->id));
                    logger()->info($room->id . ' is saved');
                }
            }
        }
        logger()->info('--------------------HANDLE END------------------');
    }
}
