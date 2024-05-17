<?php

namespace App\Lib\Dto\Admin;

use Illuminate\Support\Facades\Log;

use App\Lib\Dto\DtoBase;

class UserDto extends DtoBase {
	public $id = '';
	public $username = '';
	public $name = '';
	public $email = '';
	public $status_id = '';
	public $status = '';

	public function __construct($record) {
				$this->id = $record->id;
				$this->username = $record->username;
				$this->name = $record->name;
				$this->email = $record->email;
				$this->status_id = $record->status;
				if($record->status == 0){
					$this->status = "<span class='badge badge-danger'>Disable</label>";
				}else if($record->status == 1){
					$this->status = "<span class='badge badge-success'>Enable</label>";
				}
	}


	public static function Collection($records) {

		$col = [];
		foreach ($records as $record) {
			$col[] = new UserDto(
				$record, ''
			);
		}
		return $col;
	}

}
