<?php

namespace App\Services;

use App\Board;
use App\Contracts\Services\GameRuleService as GameRuleServiceContract;
use App\User;
use Exception;

class GameRuleService implements GameRuleServiceContract
{
    /**
     * {@inheritdoc}
     */
    public function rejectIfNotActiveBoard(Board $board, User $player)
    {
        if (is_null($board->game_start) || ! is_null($board->game_end)) {
            throw new Exception('Not Active Board');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function rejectIfNotValidUser(Board $board, User $player)
    {
        if ($board->player1_id !== $player->id && $board->player2_id !== $player->id) {
            throw new Exception('Not valid User');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function rejectIfNotValidUserTurn(Board $board, User $player)
    {
        if ($board->moves->player_id === $player->id) {
            throw new Exception('Not valid User Turn');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function rejectIfNotCorrectMove(Board $board, User $player, $row, $col)
    {
        if ($board->moves->moves[$row][$col] !== '-') {
            throw new Exception('Not valid User Move, This Column is already occupied');
        }

        return $this;
    }
}
