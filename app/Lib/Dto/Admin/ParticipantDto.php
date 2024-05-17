<?php

namespace App\Lib\Dto\Admin;

use Illuminate\Support\Facades\Log;

use App\Lib\Dto\DtoBase;

class ParticipantDto extends DtoBase {
	public $participant_id  = '';
	public $prediction_id  = '';
	public $username = '';
	public $created_at = '';

	public function __construct($record) {
			$this->participant_id   = $record->participant_id  ;
			$this->prediction_id  = $record->prediction_id ;
			$this->username = $record->username;
			$this->created_at = date('Y-m-d', strtotime($record->created_at));
			$answers =  \App\Lib\Queries\Admin\GetPrediction::GetParticipantAnswers($record->participant_id);
			if(!empty($answers)){
				$this->answers=$answers;
			}


	}


	public static function Collection($records) {

		$col = [];
		foreach ($records as $record) {
			$col[] = new ParticipantDto(
				$record, ''
			);
		}
		return $col;
	}

}
