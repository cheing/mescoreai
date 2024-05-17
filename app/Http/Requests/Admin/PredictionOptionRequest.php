<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PredictionOptionRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'prediction_id'  => 'required|max:11',
            'prediction_question_id'  => 'required|max:11',
            'prediction_option_id'  => 'required|max:11',
            'code' => 'required|max:255',
            'title' => 'required|max:255',
            'title_zh' => 'required|max:255',
        ];
    }

    public function attributes() {
        return [
            'prediction_id' => 'Prediction ID',
            'prediction_question_id' => 'Question ID',
            'prediction_option_id'  => 'Option ID',
            'code' => 'Code',
            'title' => 'Title',
            'title_zh' => 'Title Chinese',
        ];
    }


}
