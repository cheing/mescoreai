<?php

namespace App\Lib\Commands\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUser implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        DB::table('users')->insert([
            'username' => $this->data['username'],
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'status' => $this->data['status'],
            'password' => Hash::make($this->data['password']),
            // 'phone' => $this->data['phone'],
            'role' => $this->data['role'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
