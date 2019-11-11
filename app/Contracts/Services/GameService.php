<?php

namespace App\Contracts\Services;

use App\Board;
use App\User;

interface GameService
{
    /**
     * Start a game
     *
     * @param  User $player
     * @return \App\Board
     *
     */
    public function start(User $player);

    /**
     * Player Turn
     *
     * @param  Board $board
     * @param  User $player
     * @param Integer $row
     * @param Integer $col
     * @return \App\Board
     *
     */
    public function move(Board $board, User $player, $row, $col);
}
