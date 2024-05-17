<?php

namespace App\Lib\Commands\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CopyQuestion implements ShouldQueue{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function handle(){
        $prediction_question_id =  DB::table('prediction_question')->insertGetId([
            'prediction_id' => $this->data['prediction_id'],
            'seq' => $this->data['seq'],
            'title' => $this->data['title'],
            'title_zh' =>  $this->data['title_zh'],
            'created_by' =>  $this->data['created_by'],
            'updated_by' =>  $this->data['created_by'],
            'created_at' => now(),
        ]);

        //insert options
        if(!empty($this->data['options'])){
          foreach($this->data['options'] as $o){
            DB::table('prediction_option')->insert([
                'prediction_id' => $this->data['prediction_id'],
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

    }

}
