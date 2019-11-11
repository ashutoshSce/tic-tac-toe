<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardMove extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'board_moves';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['board_id', 'moves', 'player1_pointer', 'player2_pointer'];

    /**
     * Database columns to cast.
     *
     * @var array
     */
    protected $casts = [
        'moves' => 'array',
        'player1_pointer' => 'array',
        'player2_pointer' => 'array',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'board_id'
    ];

    /**
     * Get the board associated with this board move
     */
    public function board()
    {
        return $this->hasOne(Board::class, 'id', 'board_id');
    }
}
