<?php

namespace App\Lib\Dto\Home;

use Illuminate\Support\Facades\Log;

use App\Lib\Dto\DtoBase;

class PredictionDto extends DtoBase {
	public $prediction_id  = '';
	public $date_start = '';
	public $date_end = '';
	public $status_id = '';
	public $status = '';
	public $questions = array();

	public function __construct($record) {
				$this->prediction_id  = $record->prediction_id ;
				$this->date_start = $record->date_start;
				$this->date_end = $record->date_end;
				$this->status_id = $record->status_id;
				if($record->status_id == 0){
					$this->status = "<span class='badge badge-danger'>Disable</label>";
				}else if($record->status_id == 1){
					$this->status = "<span class='badge badge-success'>Enable</label>";
				}

				$questions =  \App\Lib\Queries\Home\GetPrediction::GetQuestions($record->prediction_id);
				if(!empty($questions)){
					$this->questions=$questions;
				}

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
			$col[] = new PredictionDto(
				$record, ''
			);
		}
		return $col;
	}

}
