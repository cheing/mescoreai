<?php

namespace App\Lib\Commands\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;


class CreateOption implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function handle() {
      DB::table('prediction_option')->insert([
          'prediction_id' => $this->data['prediction_id'],
          'prediction_question_id' => $this->data['prediction_question_id'],
          'code' => $this->data['code'],
          'title' => $this->data['title'],
          'title_zh' => $this->data['title_zh'],
          'created_by' =>  $this->data['created_by'],
          'updated_by' =>  $this->data['updated_by'],
          'created_at' => now(),
          'updated_at' => now(),
      ]);

    }
}
