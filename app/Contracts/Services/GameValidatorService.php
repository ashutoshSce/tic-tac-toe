<?php

namespace App\Contracts\Services;

use App\Board;
use App\User;
use Exception;

interface GameValidatorService
{
    /**
     * Reject if deactive board
     *
     * @param  Board $board
     * @param  User $player
     * @return self
     *
     * @throws Exception
     */
    public function rejectIfDeactiveBoard(Board $board, User $player);

    /**
     * Reject if invalid user
     *
     * @param  Board $board
     * @param  User $player
     * @return self
     *
     * @throws Exception
     */
    public function rejectIfInvalidUser(Board $board, User $player);

    /**
     * Reject if invalid user turn
     *
     * @param  Board $board
     * @param  User $player
     * @return self
     *
     * @throws Exception
     */
    public function rejectIfInvalidUserTurn(Board $board, User $player);

    /**
     * Reject if invalid row and column
     *
     * @param  Board $board
     * @param  User $player
     * @param int $row
     * @param int $col
     * @return self
     *
     * @throws Exception
     */
    public function rejectIfInvalidRowAndColumn(Board $board, User $player, $row, $col);

    /**
     * Reject if wrong move
     *
     * @param  Board $board
     * @param  User $player
     * @param int $row
     * @param int $col
     * @return self
     *
     * @throws Exception
     */
    public function rejectIfWrongMove(Board $board, User $player, $row, $col);
}
