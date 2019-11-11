<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('size');
            $table->unsignedBigInteger('player1_id')->index();
            $table->unsignedBigInteger('player2_id')->index()->nullable();
            $table->dateTime('game_start')->nullable();
            $table->dateTime('game_end')->nullable()->comment('If Null, then game is going on');
            $table->unsignedTinyInteger('game_status')->nullable()->comment('1: draw, 2: won');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
}
