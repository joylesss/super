<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Support\DataTablePaginate;

class Questions extends Model
{
    use DataTablePaginate;

    //
    protected $fillable = [
        'id', 'app_id', 'details', 'a', 'b', 'c', 'd', 'answer',
    ];

    //
    protected $hidden   = [];
}
