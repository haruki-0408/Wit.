<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckRoomId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (is_null($request->room_id)) {
            return response()->Json('ルームIDの値が不正です',Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $room_id = $request->room_id;

        $user = User::find(Auth::id());

        if ($user->inRoomCount->count() !== 1) {
            return response()->Json('ルームIDの値が不正です',Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($user->inRoomCount[0]->id !== $room_id) {
            return response()->Json('ルームIDの値が不正です',Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $next($request);
    }
}
