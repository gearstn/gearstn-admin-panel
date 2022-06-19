<?php
namespace App\Classes;

class SortModel
{

    public static function sort($q,$sort_by)
    {
        return $q->when(isset($sort_by) && $sort_by != null, function ($q) use ($sort_by) {
            $sort = explode(',', $sort_by);
            if ($sort[1] == 'asc') {
                return $q->sortBy($sort[0]);
            } else {
                return $q->SortByDesc($sort[0]);
            }
        });

    }
}
