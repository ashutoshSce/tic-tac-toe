## Tic-Tac-Toe Challenge

Only API Execution of Tic-Tac-Toe implemented.

Installation
============
```shell
$ composer install
$ php artisan migrate
```

It will install all 3rd party dependencies, and also create tables based on DB Configuration mentioned in .env file.

Assumptions
===========
* Only `2 Players` play this game.

* Value of `MAX_BOARD_SIZE` in .env file determines maximum size of matrix user can enter while selecting board before start playing. (Max value can go upto 255 as datatype is unsigned tiny integer).

* Value of `MAX_BOARD_IDLE_TIME_IN_SECONDS` in .env file determines maximum idle time before any player turn comes. Board will expire and other player will win.

Model Schema
===========
* `User` PHP Model class for table users.
* `Board` PHP Model class for table boards.
* `BoardMove`  PHP Model class for table board_moves. (One to one with Board)

Events
===========
* `GameDraw` Event called when game draws.
* `GameExpired`  Event called when game expired by Crons after given frequency.
* `GameStarted`  Event Called when game started.
* `GameWon`  Event Called when game won.
* `PlayerGiveUp`  Incase any player give up, other player will win and this event called up.

Listeners
===========
* `GameEventListner` As game ends, so to empty all calculation pointers for both players stored in DB, inorder to dave memory.

Services
===========
* `GameService` : start, move, giveUp and expire a game.
* `GameStrategyService` : evaluate strategy for winning and draw for ongoing active game.
* `GameValidatorService` : VAlidates all possibility to cheat current game while playing it.

Repositories
===========
* `BoardRepository` : DB operation for Board Model.
* `BoardMoveRepository` : DB operation for Board Move Model.

Controller
===========
* `GameController` : Start Game, Show Current Game.
* `MoveGameController` : Game Movement, Give up Game

API Routes
===========
* `routes/api.php` : All 4 routes.

Postman Link for all test cases
===========
https://www.getpostman.com/collections/444b6e27311a663045a7


Future Scope
===========
* Frontend
* WebSocket can be added to broadcast message in frontend after listening `All above Events`
* Message Queue can be added to facilitate Broadcasting.
* Email service can be added to inform user about game stats.
* Authentication can be implemented to Check History and Game logs for any logged in user.

Language/Framework 
===========
* [Laravel](https://laravel.com/)

> Please reach me at ashutosh.sce@hotmail.com if you have any questions about code and its execution.
