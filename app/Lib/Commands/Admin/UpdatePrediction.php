<?php

namespace App\Lib\Commands\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdatePrediction implements ShouldQueue{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function handle(){
        DB::table('prediction')->where('prediction_id', $this->data['prediction_id'])->update(
          [
            'date_start' => $this->data['date_start'],
            'date_end' => $this->data['date_end'],
            'status_id' => $this->data['status_id'],
            'updated_by' => $this->data['updated_by'], 
            'updated_at' => now(),
         ]);
    }

}
