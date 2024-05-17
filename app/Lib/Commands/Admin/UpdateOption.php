<?php

namespace App\Lib\Commands\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateOption implements ShouldQueue{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function handle(){
        DB::table('prediction_option')->where('prediction_option_id', $this->data['prediction_option_id'])->update(          [
            'code' => $this->data['code'],
            'title' => $this->data['title'],
            'title_zh' => $this->data['title_zh'],
            'updated_by' =>  $this->data['updated_by'],
            'updated_at' => now(),
         ]);
    }

}
