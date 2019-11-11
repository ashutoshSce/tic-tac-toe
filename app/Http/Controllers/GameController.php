<?php

namespace App\Http\Controllers;

use App\Board;
use App\Contracts\Services\GameService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    /**
     * The Game service.
     *
     * @var GameService
     */
    protected $game;

    /**
     * Create a new controller instance.
     *
     * @param GameService $game
     * @return void
     */
    public function __construct(GameService $game)
    {
        $this->game = $game;
    }

    /**
     * Start a Game, if 2 players found OR Register a request to start a game, in case of first player
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Board
     */
    public function start(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->playerEntry($request->all());

        return $this->game->start($user);
    }

    /**
     * Show a Current game
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Board $board
     * @return \App\Board
     */
    public function show(Request $request, Board $board)
    {
        return $board;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
    }

    /**
     * CreateOrUpdate a user instance after a valid request of Game.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function playerEntry(array $data)
    {
        $user = User::where('email', '=', $data['email'])->first();

        if ($user) {
            $user->update(['name' => $data['name']]);

            return $user;
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }
}
