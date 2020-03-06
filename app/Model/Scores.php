<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Support\DataTablePaginate;

class Scores extends Model
{
    use DataTablePaginate;

    //
    protected $fillable = [
        'id', 'user_id', 'app_id', 'point', 'play_times'
    ];

    //
    protected $hidden   = [];
}
