<?php

namespace App\Lib\Queries\Admin;

use \App\Lib\Queries\QueryBase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GetPrediction extends QueryBase {
    public static function Result($id){
       $record = DB::table('prediction')
              ->where('prediction_id', $id)
              ->first();
              if(!empty($record))
       return new \App\Lib\Dto\Admin\PredictionDto($record);
    }

    public static function GetQuestions($id){
        $records = DB::table('prediction_question')
            ->where('prediction_id', $id)
            ->orderBy('seq', 'asc')
            ->get();
          if(!empty($records)){
             return \App\Lib\Dto\Admin\PredictionQuestionDto::Collection($records);
          }
    }

    public static function GetQuestion($id){
       $record = DB::table('prediction_question')
              ->where('prediction_question_id', $id)
              ->first();
              if(!empty($record))
       return new \App\Lib\Dto\Admin\PredictionQuestionDto($record);
    }

    public static function GetOptions($id){
        $records = DB::table('prediction_option')
            ->where('prediction_question_id', $id)
            // ->orderBy('code', 'asc')
            ->orderByRaw("CAST(code as UNSIGNED) ASC")
            ->get();
          if(!empty($records)){
             return \App\Lib\Dto\Admin\PredictionOptionDto::Collection($records);
          }
    }

    public static function GetOption($id){
       $record = DB::table('prediction_option')
              ->where('prediction_option_id', $id)
              ->first();
              if(!empty($record))
       return new \App\Lib\Dto\Admin\PredictionOptionDto($record);
    }

    public static function GetParticipants($data){
        foreach ($data as $key ) {
            $sort =  $key['sort'];
            $direction =  $key['direction'];
            $id =  $key['id'];
         }
        $records = DB::table('participant')
            ->where('prediction_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();
          if(!empty($records)){
             return \App\Lib\Dto\Admin\ParticipantDto::Collection($records);
          }
    }

    public static function GetParticipantAnswers($id){
        $records = DB::table('participant_answer')
            ->leftjoin('prediction_question', 'prediction_question.prediction_question_id', '=', 'participant_answer.prediction_question_id')
            ->leftjoin('prediction_option', 'prediction_option.prediction_option_id', '=', 'participant_answer.prediction_option_id')
           ->select('participant_answer.*','prediction_question.seq as seq', 'prediction_question.title as question', 'prediction_option.code as code','prediction_option.title as answer')
            ->where('participant_id', $id)
            ->orderBy('prediction_question.seq', 'asc')
            ->get();
          if(!empty($records)){
             return \App\Lib\Dto\Admin\ParticipantAnswerDto::Collection($records);
          }
    }

    public static function GetMatches($data){

      foreach ($data as $key ) {
          $sort =  $key['sort'];
          $direction =  $key['direction'];
          $id =  $key['id'];
          // $matches =  $key['matches'];
       }

       //GetQuestions
       $records = DB::table('prediction_question')
       ->where('prediction_question.prediction_id', '=', $id)->get();

       $result=[];

       if(!empty($records)){
         $participants = array();
         foreach($records as $q){
            //Get correct answer
            $answers = DB::table('participant_answer')
           ->leftjoin('participant','participant_answer.participant_id', '=', 'participant.participant_id')
           ->leftjoin('prediction_option', 'participant_answer.prediction_option_id', '=' ,'prediction_option.prediction_option_id')
           ->where('participant_answer.prediction_option_id', '=', $q->answer_id)->get();

           // echo "<pre>";
           // print_r($answers);
           // echo "</pre>";
           foreach($answers as $a){
                $result[$a->participant_id]['participant_id'] = $a->participant_id;
                $result[$a->participant_id]['username'] = $a->username;
                $result[$a->participant_id]['created_at'] = $a->created_at;

                foreach($records as $r){
                  $result[$a->participant_id]['answers'][$r->prediction_question_id]['prediction_question_id']
                  = $r->prediction_question_id;
                  if($a->prediction_question_id == $r->prediction_question_id){
                    $result[$a->participant_id]['answers'][$r->prediction_question_id]['title'] = $a->title;
                  }
                }
           }


         }

       }
       // echo "<pre>";
       // print_r($result);
       // echo "</pre>";
       return($result);

    }

    //Validated result
    public static function ValidateDelete($id){
      $result = true;

      return $result;
    }
}
