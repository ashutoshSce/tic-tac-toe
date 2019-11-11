<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardMovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_moves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('board_id')->index();
            $table->json('moves');
            $table->json('pointers');
            $table->unsignedBigInteger('player_id')->nullable()->comment('If Game Ends then this column decides has winner player id.');
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
        Schema::dropIfExists('board_moves');
    }
}
