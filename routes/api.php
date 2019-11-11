<?php

// Request to start a Game
Route::post('/game', 'GameController@start')->name('startGame');

Route::get('/game/{board}', 'GameController@show')->name('showGame')->where('board', '[0-9]+');

// Player Move for given board
Route::put('/game/{board}/move/{player}/{row}/{col}', 'MoveGameController@move')->name('moveGame')->where('board', '[0-9]+')->where('player', '[0-9]+')->where('row', '[0-9]+')->where('col', '[0-9]+');
