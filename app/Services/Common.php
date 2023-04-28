<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;

class Common {

    /*
    * Pagination with limit
    * input Illuminate\Database\Eloquent\Collection
    * return Illuminate\Pagination\LengthAwarePaginator
    * $perPage count per page
    */
    public static function custom_paginator($collection, $perPage)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if ($currentPage == 1) {
            $start = 0;
        }
        else {
            $start = ($currentPage - 1) * $perPage;
        }

        $currentPageCollection = $collection->slice($start, $perPage)->all();

        $paginatedTop100 = new LengthAwarePaginator($currentPageCollection, count($collection), $perPage);

        return $paginatedTop100->setPath(LengthAwarePaginator::resolveCurrentPath());
    }

}