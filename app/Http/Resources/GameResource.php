<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'gameType' => $this->board->board_cols . "x" . $this->board->board_rows,
            'time' => $this->total_time ?? "BLANK",
            'turns' => json_decode($this->custom, true)["user1"],
            'date' => explode(' ', $this->began_at)[0],
        ];
    }
}
