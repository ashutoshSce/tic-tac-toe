<?php

namespace App\Services;

use App\Board;
use App\BoardMove;
use App\Contracts\Repositories\BoardMoveRepository;
use App\Contracts\Repositories\BoardRepository;
use App\Contracts\Services\GameService as GameServiceContract;
use App\User;

class GameService implements GameServiceContract
{
    /**
     * The board repository.
     *
     * @var BoardRepository
     */
    protected $boards;

    /**
     * The board moves repository.
     *
     * @var BoardMoveRepository
     */
    protected $boardMoves;

    /**
     * Create a new controller instance.
     *
     * @param  BoardRepository $boards
     * @param  BoardMoveRepository $boardMoves
     * @return void
     */
    public function __construct(BoardRepository $boards, BoardMoveRepository $boardMoves)
    {
        $this->boards = $boards;
        $this->boardMoves = $boardMoves;
    }

    /**
     * {@inheritdoc}
     */
    public function start(User $player)
    {
        $liveBoard = $this->boards->live($player);

        // User Still on in any live board
        if (! is_null($liveBoard)) {
            return $liveBoard;
        }

        $board = $this->boards->checkForEmptyBoard();

        if (is_null($board)) {
            return $this->boards->create($player);
        }

        // Same user requested for player 2
        if ($board->player1_id === $player->id) {
            return $board;
        }

        $this->boards->startGame($board, $player);

        $this->boardMoves->create($board, $this->initializeMoves(), $this->initializePointers());

        return $board;
    }

    /**
     * {@inheritdoc}
     */
    public function move(Board $board, User $player, $row, $col)
    {
        $marker = '-';

        if ($board->player1_id === $player->id) {
            $marker = '0';
        }

        if ($board->player2_id === $player->id) {
            $marker = 'X';
        }

        $this->boardMoves->update($board->moves, $player, $row, $col, $marker);

        if ($this->isWon($board->moves, $player, $row, $col)) {
            $this->boards->ends($board, 2);
        }
        // Handle Draw Condition
    }

    protected function isWon(BoardMove $boardMoves, User $player, $row, $col)
    {

        $boardSize = count($boardMoves->moves[0]);
        $diag = $boardMoves->pointers['diag'];
        $antiDiag = $boardMoves->pointers['antiDiag'];
        $rows = $boardMoves->pointers['rows'];
        $columns = $boardMoves->pointers['columns'];

        $rows[$row]++;
        $columns[$col]++;
        if ($row === $col) {
            $diag[$row]++;
        }
        if ($row + $col === $boardSize) {
            $antiDiag[$row]++;
        }

        // Update Pointers
        $boardMoves->pointers = [
            'diag' => $diag,
            'antiDiag' => $antiDiag,
            'rows' => $rows,
            'columns' => $columns,
        ];

        $boardMoves->save();

        if ($rows[$row] === $boardSize || $columns[$col] === $boardSize || $diag[$row] === $boardSize || $antiDiag[$row] === $boardSize) {
            return true;
        }

        return false;
    }

    protected function initializeMoves()
    {
        $moves = [];
        $rowRange = range(0, 2);
        $columnRange = range(0, 2);
        foreach ($rowRange as $row) {
            $column = [];
            foreach ($columnRange as $col) {
                $column[$col] = '-';
            }
            $moves[$row] = $column;
        }

        return $moves;
    }

    protected function initializePointers()
    {
        $pointers = [
            'diag' => [],
            'antiDiag' => [],
            'rows' => [],
            'columns' => [],
        ];
        $range = range(0, 2);

        foreach ($range as $index) {
            $pointers['diag'][$index] = 0;
            $pointers['antiDiag'][$index] = 0;
            $pointers['rows'][$index] = 0;
            $pointers['columns'][$index] = 0;
        }

        return $pointers;
    }
}
