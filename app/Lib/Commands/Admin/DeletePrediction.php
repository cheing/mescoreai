<?php

namespace App\Lib\Commands\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeletePrediction implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function handle() {
      DB::table('prediction_option')->where('prediction_id', '=', $this->data['id'])->delete();
      DB::table('prediction_question')->where('prediction_id', '=', $this->data['id'])->delete();
      DB::table('prediction')->where('prediction_id', '=', $this->data['id'])->delete();

    }
}
