<?php

namespace App\Lib\Queries\Home;

use \App\Lib\Queries\QueryBase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GetPrediction extends QueryBase {
    public static function Result(){
     $record = DB::table('prediction')
            ->where('status_id', 1)
            ->first();
          if(!empty($record)){
            return new \App\Lib\Dto\Home\PredictionDto($record);
          }

    }

    public static function GetQuestions($id){
        $records = DB::table('prediction_question')
            ->where('prediction_id', $id)
            ->orderBy('seq', 'asc')
            ->get();
          if(!empty($records)){
             return \App\Lib\Dto\Home\PredictionQuestionDto::Collection($records);
          }
    }

    public static function GetOptions($id){
        $records = DB::table('prediction_option')
            ->where('prediction_question_id', $id)
            ->orderByRaw("CAST(code as UNSIGNED) ASC")
            ->get();
          if(!empty($records)){
             return \App\Lib\Dto\Home\PredictionOptionDto::Collection($records);
          }
    }

    //Validated result
  public static function ValidateUsername($id, $username){
    $result = true;

    $participant =  DB::table('participant')->where('prediction_id', '=', $id)->where('username', $username)
      ->count();

    if($participant > 0){
      $result = false;
    }

    return $result;
  }
}
