<?php

namespace App\Lib\Queries\Admin;

use \App\Lib\Queries\QueryBase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GetPredictions extends QueryBase {
    public $limits;
    public $sort;
    public $direction;

    public static function Result($data){
      foreach ($data as $key ) {
         $limits =  $key['limits'];
         $sort =  $key['sort'];
         $direction =  $key['direction'];
      }

       $record =  DB::table('prediction')->orderBy($sort, $direction)
        ->paginate($limits);

       return \App\Lib\Dto\Admin\PredictionDto::Collection($record);
    }

    public static function Paging($data){
        foreach ($data as $key ) {
          $limits =  $key['limits'];
          $sort =  $key['sort'];
          $direction =  $key['direction'];
       }

       $record =  DB::table('prediction')
       ->paginate($limits)
       ->appends(['limits' => $limits, 'sort' => $sort, 'direction' => $direction]);

       if(!empty($record)){
         return $record;
       }
    }



}
