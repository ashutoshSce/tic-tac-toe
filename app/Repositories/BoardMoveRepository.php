<?php

namespace App\Repositories;

use App\Board;
use App\BoardMove;
use App\Contracts\Repositories\BoardMoveRepository as BoardMoveRepositoryContract;
use App\User;
use Carbon\Carbon;

class BoardMoveRepository implements BoardMoveRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function create(Board $board, $moves, $pointers)
    {
        return BoardMove::create([
            'board_id' => $board->id,
            'moves' => $moves,
            'player1_pointer' => $pointers,
            'player2_pointer' => $pointers,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function update(BoardMove $boardMove, User $player, $row, $col, $marker)
    {
        $boardMove->player_id = $player->id;
        $moves = $boardMove->moves;
        $moves[$row][$col] = $marker;
        $boardMove->moves = $moves;
        $boardMove->save();
    }

    /**
     * {@inheritdoc}
     */
    public function expire()
    {
        return BoardMove::where('updated_at', '<', Carbon::now()->subSeconds(intval(env('MAX_BOARD_IDLE_TIME_IN_SECONDS'))))->get();
    }
}
