<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Support\DataTablePaginate;

class Wins extends Model
{
    use DataTablePaginate;

    //
    protected $fillable = [
        'id', 'user_id', 'prize', 'plan_test'
    ];

    //
    protected $hidden   = [];
}
