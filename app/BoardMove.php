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
    protected $fillable = ['board_id', 'moves', 'pointers'];

    /**
     * Database columns to cast.
     *
     * @var array
     */
    protected $casts = [
        'moves' => 'array',
        'pointers' => 'pointers'
    ];
}
