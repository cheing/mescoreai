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


class CreatePrediction implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function handle() {
      DB::table('prediction')->insert([
          'date_start' => $this->data['date_start'],
          'date_end' => $this->data['date_end'],
          'status_id' => $this->data['status_id'],
          'created_by' =>  $this->data['created_by'],
          'created_at' => now(),
          'updated_at' => now(),
      ]);

    }
}
