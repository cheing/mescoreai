<?php

namespace App\Lib\Dto\Admin;

use Illuminate\Support\Facades\Log;

use App\Lib\Dto\DtoBase;

class PredictionOptionDto extends DtoBase {
	public $prediction_option_id   = '';
	public $prediction_question_id = '';
	public $code = '';
	public $title = '';
	public $title_zh = '';

	public function __construct($record) {
				$this->prediction_option_id   = $record->prediction_option_id;
				$this->prediction_id  = $record->prediction_id;
				$this->prediction_question_id   = $record->prediction_question_id;
				$this->code = $record->code;
				$this->title = $record->title;
				$this->title_zh = $record->title_zh;
				if(!empty($record->created_at)){
					$this->created_at = date("Y-m-d", strtotime($record->created_at));
				}else{
					$this->created_at = $record->created_at;
				}
				if(!empty($record->updated_at)){
					$this->updated_at = date("Y-m-d", strtotime($record->updated_at));
				}else{
					$this->updated_at = $record->updated_at;
				}
				$this->created_by = $record->created_by;
				$this->updated_by = $record->updated_by;
	}


	public static function Collection($records) {

		$col = [];
		foreach ($records as $record) {
			$col[] = new PredictionOptionDto(
				$record, ''
			);
		}
		return $col;
	}

}
