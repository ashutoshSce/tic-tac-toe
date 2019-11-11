<?php

namespace App\Contracts\Repositories;

use App\Board;
use App\BoardMove;
use App\User;

interface BoardMoveRepository
{
    /**
     * Create an Board Moves with the empty matrix.
     *
     * @param  Board $board
     * @param array $moves
     * @param array $pointers
     * @return \App\BoardMove
     */
    public function create(Board $board, $moves, $pointers);

    /**
     * Update Board Moves
     *
     * @param BoardMove $boardMove
     * @param  User $player
     * @param  Integer $row
     * @param  Integer $col
     * @param String $marker
     * @return bool
     */
    public function update(BoardMove $boardMove, User $player, $row, $col, $marker);

    /**
     * Expire All active Boards after given amount of time, If next player not turned his/her move
     *
     */
    public function expire();
}
