<?php

namespace App\Contracts\Repositories;

use App\Board;
use App\User;

interface BoardRepository
{
    /**
     * Create an Board with the first player.
     *
     * @param  User $player
     * @return Board
     */
    public function create(User $player);

    /**
     * Check for User is a part of any live game.
     *
     * @param  User $player
     * @return Board
     */
    public function live(User $player);

    /**
     * Check for Empty Board
     *
     * @return Board
     */
    public function checkForEmptyBoard();

    /**
     * Start a game after updating second player
     *
     * @param Board $board
     * @param  User $player
     * @return Board
     */
    public function startGame(Board $board, User $player);

    /**
     * End the Game
     *
     * @param Board $board
     * @param integer $gameStatus
     * @return Board
     */
    public function ends(Board $board, $gameStatus);
}
