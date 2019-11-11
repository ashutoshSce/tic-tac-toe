<?php

namespace App\Contracts\Services;

use App\Board;
use App\User;
use Exception;

interface GameRuleService
{
    /**
     * Reject if not active board
     *
     * @param  Board $board
     * @param  User $player
     * @return self
     *
     * @throws Exception
     */
    public function rejectIfNotActiveBoard(Board $board, User $player);

    /**
     * Reject if not valid user
     *
     * @param  Board $board
     * @param  User $player
     * @return self
     *
     * @throws Exception
     */
    public function rejectIfNotValidUser(Board $board, User $player);


    /**
     * Reject if not valid user turn
     *
     * @param  Board $board
     * @param  User $player
     * @return self
     *
     * @throws Exception
     */
    public function rejectIfNotValidUserTurn(Board $board, User $player);


    /**
     * Reject if not correct move
     *
     * @param  Board $board
     * @param  User $player
     * @param int $row
     * @param int $col
     * @return self
     *
     * @throws Exception
     */
    public function rejectIfNotCorrectMove(Board $board, User $player, $row, $col);
}
