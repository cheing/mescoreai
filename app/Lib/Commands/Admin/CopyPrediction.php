<?php

namespace App\Lib\Commands\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CopyPrediction implements ShouldQueue{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function handle(){
        $prediction_id =  DB::table('prediction')->insertGetId([
            'date_start' => $this->data['date_start'],
            'date_end' => $this->data['date_end'],
            'status_id' => $this->data['status_id'],
            'created_by' =>  $this->data['created_by'],
            'created_at' => now(),
        ]);

        if(!empty($this->data['questions'])){

          foreach($this->data['questions'] as $q){
            $prediction_question_id =  DB::table('prediction_question')->insertGetId([
                'prediction_id' => $prediction_id,
                'seq' => $q['seq'],
                'title' => $q['title'],
                'title_zh' => $q['title_zh'],
                'created_by' =>  $this->data['created_by'],
                'updated_by' =>  $this->data['created_by'],
                'created_at' => now(),
            ]);

            //insert options
            if(!empty($q['options'])){
              foreach($q['options'] as $o){
                DB::table('prediction_option')->insert([
                    'prediction_id' => $prediction_id,
                    'prediction_question_id' => $prediction_question_id,
                    'code' => $o['code'],
                    'title' => $o['title'],
                    'title_zh' => $o['title_zh'],
                    'created_by' =>  $this->data['created_by'],
                    'updated_by' =>  $this->data['created_by'],
                    'created_at' => now(),
                ]);
              }
            }

          }//endforeach
        }
    }

}
