<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public static function storeTag($match)
    {
        $match_trim = trim($match);
        $tag = Tag::UpdateOrCreate(['name' => $match_trim], ['name' => $match_trim, 'number' => DB::raw('number + 1')]);
        return $tag;
    }

    public static function getTrend()
    {
        $trend_tags = Tag::inRandomOrder()->take(15)->get(['name','number']);
        return $trend_tags; 
    }
}

