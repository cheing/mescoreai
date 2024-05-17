<?php

namespace App\Lib\Commands\Home;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;


class CreateParticipant implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function handle() {
      $participant_id =  DB::table('participant')->insertGetId([
          'prediction_id' => $this->data['prediction_id'],
          'username' => strtolower($this->data['username']),
          'created_at' => now(),
      ]);

      foreach ($this->data['question'] as $question) {
        DB::table('participant_answer')->insert([
            'participant_id' => $participant_id,
            'prediction_question_id' => $question['question_id'],
            'prediction_option_id' => $question['option_id'],

        ]);
      }

    }
}
