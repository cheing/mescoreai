<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class ParticipateZHRequest extends FormRequest {
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
            'username' => '注册会员用户名',
            'question.*.question_id' => '问题',
            'question.*.option_id' => '答案',
        ];
    }

    public function messages() {
      return[
        'required' => '必须填写:attribute 。',
      ];
    }


}
