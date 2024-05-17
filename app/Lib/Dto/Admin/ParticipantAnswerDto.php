<?php

namespace App\Lib\Dto\Admin;

use Illuminate\Support\Facades\Log;

use App\Lib\Dto\DtoBase;

class ParticipantAnswerDto extends DtoBase {
	public $participant_answer_id;
	public $participant_id  = '';
	public $prediction_question_id  = '';
	public $prediction_option_id  = '';

	public function __construct($record) {
			$this->participant_answer_id   = $record->participant_answer_id;
			$this->participant_id   = $record->participant_id;
			$this->prediction_question_id   = $record->prediction_question_id;
			$this->prediction_option_id   = $record->prediction_option_id;
			$this->seq   = $record->seq;
			$this->question   = $record->question;
			$this->code   = $record->code;
			$this->answer   = $record->answer;



	}


	public static function Collection($records) {

		$col = [];
		foreach ($records as $record) {
			$col[] = new ParticipantAnswerDto(
				$record, ''
			);
		}
		return $col;
	}

}
