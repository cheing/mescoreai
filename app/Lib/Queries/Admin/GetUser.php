<?php

namespace App\Lib\Queries\Admin;

use \App\Lib\Queries\QueryBase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GetUser extends QueryBase {
    public static function Result($id){
       $record = DB::table('users')
              ->where('id', $id)
              ->first();
              if(!empty($record))
       return new \App\Lib\Dto\Admin\UserDto($record);
    }

    //Validated result
    public static function ValidateDelete($id){
      $result = true;

      return $result;
    }
}
