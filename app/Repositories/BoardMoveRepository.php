<?php

namespace App\Repositories;

use App\Board;
use App\BoardMove;
use App\Contracts\Repositories\BoardMoveRepository as BoardMoveRepositoryContract;
use App\User;

class BoardMoveRepository implements BoardMoveRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function create(Board $board, $moves, $pointers)
    {
        return BoardMove::create(['board_id' => $board->id, 'moves' => $moves, 'pointers' => $pointers]);
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
}
