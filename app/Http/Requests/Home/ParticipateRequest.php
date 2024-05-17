<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class ParticipateRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'prediction_id' => 'required|max:11',
            'username' => 'required|max:250',
            // 'username' => [Rule::unique('participant', 'participant')->where(function ($query) use ($request) { return $query->where('username','=', $request->username)->where('prediction_id', '=', $request->prediction_id),
            'question.*.question_id' => 'required|max:11',
            'question.*.option_id' => 'required|max:11',
        ];
    }

    public function attributes() {
        return [
            'prediction_id' => 'prediction_id',
            'username' => 'Affiliate Username',
            'question.*.question_id' => 'Question',
            'question.*.option_id' => 'Answer',
        ];
    }


}
