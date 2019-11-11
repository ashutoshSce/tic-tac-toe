<?php

namespace App\Http\Controllers;

use App\Board;
use App\Contracts\Services\GameRuleService;
use App\Contracts\Services\GameService;
use App\User;
use Illuminate\Http\Request;

class MoveGameController extends Controller
{
    /**
     * The Game service.
     *
     * @var GameService
     */
    protected $game;

    /**
     * The Game Rule service.
     *
     * @var GameRuleService
     */
    protected $rule;

    /**
     * Create a new controller instance.
     *
     * @param GameService $game
     * @param GameRuleService $rule
     * @return void
     */
    public function __construct(GameService $game, GameRuleService $rule)
    {
        $this->game = $game;
        $this->rule = $rule;
    }

    /**
     * Move
     *
     * @param  \Illuminate\Http\Request $request
     * @param  User $player
     * @param Board $board
     * @param integer $row
     * @param integer $col
     * @return \App\Board
     *
     * @throws \Exception
     */
    public function move(Request $request, Board $board, User $player, $row, $col)
    {
        $this->rule->rejectIfNotActiveBoard($board, $player)->rejectIfNotValidUser($board, $player)->rejectIfNotValidUserTurn($board, $player)->rejectIfNotCorrectMove($board, $player, $row, $col);

        $this->game->move($board, $player, $row, $col);

        return $board;
    }
}
