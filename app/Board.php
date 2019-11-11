<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'boards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['player1_id'];

    /**
     * Fields that should be treated  as Carbon Instances.
     *
     * @var array
     */
    protected $dates = ['game_start', 'game_end'];

    /**
     * Get the Move record associated with the Board.
     */
    public function moves()
    {
        return $this->hasOne(BoardMove::class);
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['moves'];
}
