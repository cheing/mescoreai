<?php

namespace App\Lib\Dto\Home;

use Illuminate\Support\Facades\Log;

use App\Lib\Dto\DtoBase;

class PredictionQuestionDto extends DtoBase {
	public $prediction_question_id  = '';
	public $prediction_id  = '';
	public $title = '';
	public $title_zh = '';
	public $seq = '';
	public $status_id = '';
	public $status = '';
	public $questions = array();

	public function __construct($record) {
				$this->prediction_question_id  = $record->prediction_question_id ;
				$this->prediction_id  = $record->prediction_id ;
				$this->title = $record->title;
				$this->title_zh = $record->title_zh;
				$this->seq = $record->seq;
				$this->answer_id = $record->answer_id;
				//option
				$options =  \App\Lib\Queries\Home\GetPrediction::GetOptions($record->prediction_question_id);
				if(!empty($options)){
					$this->options=$options;
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
			$col[] = new PredictionQuestionDto(
				$record, ''
			);
		}
		return $col;
	}

}
