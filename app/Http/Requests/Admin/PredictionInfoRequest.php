<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PredictionInfoRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'prediction_id'  => 'required|max:11',
            'date_start' => 'required|date_format:Y-m-d',
            'date_end' => 'required|date_format:Y-m-d',
            'status_id' => 'required',
        ];
    }

    public function attributes() {
        return [
          'date_start' => 'Date Start',
          'date_end' => 'Date End',
          'status_id' => 'Status',
        ];
    }


}
