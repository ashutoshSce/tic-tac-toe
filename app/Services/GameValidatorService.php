<?php

namespace App\Services;

use App\Board;
use App\Contracts\Services\GameValidatorService as GameRuleServiceContract;
use App\User;
use Exception;

class GameValidatorService implements GameRuleServiceContract
{
    /**
     * {@inheritdoc}
     */
    public function rejectIfDeactiveBoard(Board $board, User $player)
    {
        if (is_null($board->game_start) || ! is_null($board->game_end)) {
            throw new Exception($board->id.' is not Active Board.');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function rejectIfInvalidUser(Board $board, User $player)
    {
        if ($board->player1_id !== $player->id && $board->player2_id !== $player->id) {
            throw new Exception('Invalid User.');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function rejectIfInvalidUserTurn(Board $board, User $player)
    {
        if ($board->records->player_id === $player->id) {
            throw new Exception('Invalid User Turn.');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function rejectIfInvalidRowAndColumn(Board $board, User $player, $row, $col)
    {
        if (! isset($board->records->moves[$row][$col])) {
            throw new Exception('Invalid Row and/or Column Address.');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function rejectIfWrongMove(Board $board, User $player, $row, $col)
    {
        if ($board->records->moves[$row][$col] !== '-') {
            throw new Exception('Wrong User Move, This Column is already occupied');
        }

        return $this;
    }
}
