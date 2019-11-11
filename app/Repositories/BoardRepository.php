<?php

namespace App\Repositories;

use App\Board;
use App\Contracts\Repositories\BoardRepository as BoardRepositoryContract;
use App\User;
use Carbon\Carbon;

class BoardRepository implements BoardRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function create(User $player)
    {
        return Board::create(['player1_id' => $player->id]);
    }

    /**
     * {@inheritdoc}
     */
    public function live(User $player)
    {
        return Board::whereNotNull('game_start')->whereNull('game_end')->where(function ($query) use ($player) {
            $query->where('player1_id', '=', $player->id)->orWhere('player2_id', '=', $player->id);
        })->first();
    }

    /**
     * {@inheritdoc}
     */
    public function checkForEmptyBoard()
    {
        return Board::whereNull('player2_id')->first();
    }

    /**
     * {@inheritdoc}
     */
    public function startGame(Board $board, User $player)
    {
        $board->player2_id = $player->id;
        $board->game_start = Carbon::now();

        return $board->save();
    }

    /**
     * {@inheritdoc}
     */
    public function ends(Board $board, $gameStatus)
    {
        $board->game_end = Carbon::now();
        $board->game_status = $gameStatus;

        return $board->save();
    }
}
