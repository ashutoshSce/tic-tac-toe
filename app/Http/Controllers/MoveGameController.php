<?php

namespace App\Http\Controllers;

use App\Board;
use App\Contracts\Services\GameService;
use App\Contracts\Services\GameStrategyService;
use App\Contracts\Services\GameValidatorService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MoveGameController extends Controller
{
    /**
     * The Game service.
     *
     * @var GameService
     */
    protected $game;

    /**
     * The Game Validator service.
     *
     * @var GameValidatorService
     */
    protected $gameValidator;

    /**
     * The Game Strategy service.
     *
     * @var GameValidatorService
     */
    protected $gameStrategy;

    /**
     * Create a new controller instance.
     *
     * @param GameService $game
     * @param GameValidatorService $gameValidator
     * @param GameStrategyService $gameStrategy
     * @return void
     */
    public function __construct(
        GameService $game,
        GameValidatorService $gameValidator,
        GameStrategyService $gameStrategy
    ) {
        $this->game = $game;
        $this->gameValidator = $gameValidator;
        $this->gameStrategy = $gameStrategy;
    }

    /**
     * Move
     *
     * @param  \Illuminate\Http\Request $request
     * @param  User $player
     * @param Board $board
     * @return \App\Board
     *
     * @throws \Exception
     */
    public function move(Request $request, Board $board, User $player)
    {
        $this->validator($request->all())->validate();

        $row = $request->input('row');
        $col = $request->input('col');
        $this->gameValidator->rejectIfDeactiveBoard($board, $player)->rejectIfInvalidUser($board, $player)->rejectIfInvalidUserTurn($board, $player)->rejectIfInvalidRowAndColumn($board, $player, $row, $col)->rejectIfWrongMove($board, $player, $row, $col);

        $this->game->move($board, $player, $row, $col);

        $this->gameStrategy->evaluate($board, $player, $row, $col);

        return $board;
    }

    /**
     * Move
     *
     * @param  \Illuminate\Http\Request $request
     * @param  User $player
     * @param Board $board
     * @return \App\Board
     *
     * @throws \Exception
     */
    public function giveUp(Request $request, Board $board, User $player)
    {
        $this->gameValidator->rejectIfDeactiveBoard($board, $player)->rejectIfInvalidUser($board, $player)->rejectIfInvalidUserTurn($board, $player);

        $this->game->giveUp($board);

        return $board;
    }

    /**
     * Get a validator for an incoming request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $size = intval(env('MAX_BOARD_SIZE')) - 1;

        return Validator::make($data, [
            'row' => ['required', 'integer', 'min:0', 'max:'.$size],
            'col' => ['required', 'integer', 'min:0', 'max:'.$size],
        ]);
    }
}
