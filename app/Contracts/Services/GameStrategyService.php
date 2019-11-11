<?php

namespace App\Contracts\Services;

use App\Board;
use App\User;

interface GameStrategyService
{
    /**
     * Evaluate Draw and Win Strategy
     *
     * @param  Board $board
     * @param User $player
     * @param integer $row
     * @param integer $col
     * @return void
     *
     */
    public function evaluate(Board $board, User $player, $row, $col);
}
