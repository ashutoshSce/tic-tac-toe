<?php

// Request to start a Game
Route::post('/game', 'GameController@start')->name('startGame');

Route::get('/game/{board}', 'GameController@show')->name('showGame')->where('board', '[0-9]+');

// Player Move for given board
Route::put('/game/{board}/move/{player}', 'MoveGameController@move')->name('moveGame')->where('board', '[0-9]+')->where('player', '[0-9]+');

// Give up game
Route::put('/game/{board}/give-up/{player}', 'MoveGameController@giveUp')->name('giveUpGame')->where('board', '[0-9]+')->where('player', '[0-9]+');
