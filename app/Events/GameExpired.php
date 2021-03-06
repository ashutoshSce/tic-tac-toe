<?php

namespace App\Events;

use App\Board;
use Illuminate\Queue\SerializesModels;

class GameExpired
{
    use SerializesModels;

    public $board;

    /**
     * Create a new event instance.
     *
     * @param  \App\Board $board
     * @return void
     */
    public function __construct(Board $board)
    {
        $this->board = $board;
    }
}
