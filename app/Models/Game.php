<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['winner_user_id', 'type', 'status', 'began_at', 'ended_at', 'total_time', 'board_id'];

    public function board() : HasOne {
        return $this->hasOne(Board::class, 'id', 'board_id');
    }
}
