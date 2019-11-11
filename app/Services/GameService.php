<?php

namespace App\Services;

use App\Board;
use App\Contracts\Repositories\BoardMoveRepository;
use App\Contracts\Repositories\BoardRepository;
use App\Contracts\Services\GameService as GameServiceContract;
use App\Events\GameExpired;
use App\Events\GameStarted;
use App\User;
use Carbon\Carbon;

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
    public function start(User $player, $size)
    {
        $liveBoard = $this->boards->live($player);

        // User Still on in any live board
        if (! is_null($liveBoard)) {
            return $liveBoard;
        }

        $board = $this->boards->checkForEmptyBoard($size);

        if (is_null($board)) {
            return $this->boards->create($player, $size);
        }

        // Same user requested for player 2
        if ($board->player1_id === $player->id) {
            return $board;
        }

        $this->boards->startGame($board, $player);

        $this->boardMoves->create($board, $this->initializeMoves($size), $this->initializePointers($size));

        $board = Board::find($board->id);

        event(new GameStarted($board));

        return $board;
    }

    /**
     * {@inheritdoc}
     */
    public function move(Board $board, User $player, $row, $col)
    {
        $marker = '-';
        $pointers = [];
        if ($board->player1_id === $player->id) {
            $marker = '0';
            $pointers = $board->records->player1_pointer;
        }

        if ($board->player2_id === $player->id) {
            $marker = 'X';
            $pointers = $board->records->player2_pointer;
        }

        $this->boardMoves->update($board->records, $player, $row, $col, $marker);

        return $pointers;
    }

    /**
     * {@inheritdoc}
     */
    public function giveUp($board)
    {
        $board->game_end = Carbon::now();
        $board->save();

        $board->records->player1_pointer = [];
        $board->records->player2_pointer = [];
        $board->records->save();
    }

    /**
     * {@inheritdoc}
     */
    public function expire()
    {
        $boardMoves = $this->boardMoves->expire();
        if (count($boardMoves) > 1) {
            $boardMoves->load('board');
        }
        foreach ($boardMoves as $boardMove) {
            $this->boards->ends($boardMove->board, 2);
            event(new GameExpired($boardMove->board));
        }
    }

    protected function initializeMoves($size)
    {
        $maxIndex = $size - 1;
        $moves = [];
        $rowRange = range(0, $maxIndex);
        $columnRange = range(0, $maxIndex);
        foreach ($rowRange as $row) {
            $column = [];
            foreach ($columnRange as $col) {
                $column[$col] = '-';
            }
            $moves[$row] = $column;
        }

        return $moves;
    }

    protected function initializePointers($size)
    {
        $maxIndex = $size - 1;
        $pointers = [
            'diag' => 0,
            'antiDiag' => 0,
            'rows' => [],
            'columns' => [],
        ];
        $range = range(0, $maxIndex);

        foreach ($range as $index) {
            $pointers['rows'][$index] = 0;
            $pointers['columns'][$index] = 0;
        }

        return $pointers;
    }
}
