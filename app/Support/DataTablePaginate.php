<?php
namespace App\Support;

trait DataTablePaginate {

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTablePaginate($query) {
        $sort_column    = 'id';
        $direction      = 'desc';
        $per_page       = '10';
        $request        = request();

        if (!empty($request->sort_column)) $sort_column = $request->sort_column;
        if (!empty($request->direction)) $direction = $request->direction;
        if (!empty($request->per_page)) $per_page = $request->per_page;
        return $query->orderBy($sort_column, $direction)->paginate($per_page);
    }
}
