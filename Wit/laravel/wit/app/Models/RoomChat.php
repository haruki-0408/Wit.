<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RoomChat extends Pivot
{
    use HasFactory;
    protected $casts = [
        'choice' => 'boolean',
    ];
}
