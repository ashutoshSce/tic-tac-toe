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
    protected $fillable = ['player1_id', 'size'];

    /**
     * Fields that should be treated  as Carbon Instances.
     *
     * @var array
     */
    protected $dates = ['game_start', 'game_end'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'player1_id',
        'player2_id'
    ];

    /**
     * Get the Move record associated with the Board.
     */
    public function records()
    {
        return $this->hasOne(BoardMove::class);
    }

    /**
     * Get the First Player Info
     */
    public function player1()
    {
        return $this->hasOne(User::class, 'id', 'player1_id');
    }

    /**
     * Get the Second Player Info
     */
    public function player2()
    {
        return $this->hasOne(User::class, 'id', 'player2_id');
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['records', 'player1', 'player2'];
}
