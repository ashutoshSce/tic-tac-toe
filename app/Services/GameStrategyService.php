<?php

namespace App\Services;

use App\Board;
use App\Contracts\Services\GameStrategyService as GameStrategyServiceContract;
use App\Events\GameDraw;
use App\Events\GameWon;
use App\Repositories\BoardRepository;
use App\User;

class GameStrategyService implements GameStrategyServiceContract
{
    /**
     * The board repository.
     *
     * @var BoardRepository
     */
    protected $boards;

    /**
     * Create a new controller instance.
     *
     * @param  BoardRepository $boards
     * @return void
     */
    public function __construct(BoardRepository $boards)
    {
        $this->boards = $boards;
    }

    public function evaluate(Board $board, User $player, $row, $col)
    {
        $moves = $board->records->moves;

        $pointers = [];
        if ($board->player1_id === $player->id) {
            $pointers = $board->records->player1_pointer;
        }

        if ($board->player2_id === $player->id) {
            $pointers = $board->records->player2_pointer;
        }

        if ($this->isDraw($moves)) {
            $this->boards->ends($board, 1);
            event(new GameDraw($board));

            return;
        }

        if ($this->isWon(count($board->records->moves[0]), $pointers, $row, $col)) {
            $this->boards->ends($board, 2);
            event(new GameWon($board));

            return;
        }

        // Else Update Board Records Player Pointers
        if ($board->player1_id === $player->id) {
            $board->records->player1_pointer = $pointers;
        }

        if ($board->player2_id === $player->id) {
            $board->records->player2_pointer = $pointers;
        }
        $board->records->save();
    }

    private function isDraw($moves)
    {
        foreach ($moves as $rows) {
            foreach ($rows as $col) {
                if ($col === '-') {
                    return false;
                }
            }
        }

        return true;
    }

    private function isWon($boardSize, &$pointers, $row, $col)
    {
        $pointers['rows'][$row]++;
        $pointers['columns'][$col]++;
        if ($row === $col) {
            $pointers['diag']++;
        }
        if ($row + $col === $boardSize) {
            $pointers['antiDiag']++;
        }

        if ($pointers['rows'][$row] === $boardSize || $pointers['columns'][$col] === $boardSize || $pointers['diag'] === $boardSize || $pointers['antiDiag'] === $boardSize) {
            return true;
        }

        return false;
    }
}
