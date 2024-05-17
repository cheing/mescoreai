<?php

namespace App\Lib\Queries\Admin;

use App\Lib\Queries\QueryBase;
use Illuminate\Support\Facades\DB;

class GetUsers extends QueryBase
{
    public $limits;
    public $sort;
    public $direction;

    public static function Result($data)
    {
        foreach ($data as $key) {
            $limits = $key['limits'];
            $sort = $key['sort'];
            $direction = $key['direction'];
        }

        $record = DB::table('users')->where('role', 'admin')->orderBy($sort, $direction)
         ->paginate($limits);

        return \App\Lib\Dto\Admin\UserDto::Collection($record);
    }

    public static function Paging($data)
    {
        foreach ($data as $key) {
            $limits = $key['limits'];
            $sort = $key['sort'];
            $direction = $key['direction'];
        }

        $record = DB::table('users')->where('role', 'admin')
        ->paginate($limits)
        ->appends(['limits' => $limits, 'sort' => $sort, 'direction' => $direction]);

        if (!empty($record)) {
            return $record;
        }
    }

    public static function All()
    {
        $record = DB::table('users')
        ->orderBy('name')
           ->get();
        if (!empty($record)) {
            return \App\Lib\Dto\Admin\UserDto::Collection($record);
        }
    }
}
