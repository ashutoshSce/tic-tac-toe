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
     * @param integer $size
     * @return \App\Board
     *
     */
    public function start(User $player, $size);

    /**
     * Player Turn
     *
     * @param  Board $board
     * @param  User $player
     * @param Integer $row
     * @param Integer $col
     * @return array pointers
     *
     */
    public function move(Board $board, User $player, $row, $col);

    /**
     * Player Turn
     *
     * @param  Board $board
     * @return array pointers
     *
     */
    public function giveUp($board);

    /**
     * Expire All active Boards after given amount of time, If next player not turned his/her move
     *
     */
    public function expire();
}
