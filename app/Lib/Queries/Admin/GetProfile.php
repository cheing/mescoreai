<?php

namespace App\Lib\Queries\Admin;

use \App\Lib\Queries\QueryBase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GetProfile extends QueryBase {
    public static function Result($id){
       $record = DB::table('users')
              ->where('id', $id)
              ->first();
       return new \App\Lib\Dto\Admin\UserDto($record);
    }
}
