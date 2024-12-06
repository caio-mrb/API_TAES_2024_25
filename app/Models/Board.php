<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Board extends Model
{
    use HasFactory;

    protected $fillable = ['board_cols', 'board_rows'];

    public function game() : BelongsTo {
        return $this->belongsTo(Game::class);
    }
}
