<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Support\DataTablePaginate;

class Apps extends Model
{
    use DataTablePaginate;

    //
    protected $fillable = [
        'id', 'name', 'version_ios', 'version_android', 'prize', 'plan_test'
    ];

    //
    protected $hidden   = [];
}
