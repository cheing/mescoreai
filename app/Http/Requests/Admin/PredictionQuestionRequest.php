<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PredictionQuestionRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'prediction_id'  => 'required|max:11',
            'prediction_question_id'  => 'required|max:11',
            'seq' => 'required|numeric',
            'title' => 'required|max:255',
            'title_zh' => 'required|max:255',
            'answer_id' => 'nullable|max:11',
        ];
    }

    public function attributes() {
        return [
            'prediction_id' => 'Prediction ID',
            'prediction_question_id' => 'Question ID',
            'seq' => 'Sort Order',
            'title' => 'Title',
            'title_zh' => 'Title Chinese',
            'answer_id' => 'Result',
        ];
    }


}
