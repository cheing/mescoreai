<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PredictionRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
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
