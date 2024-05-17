<?php

namespace App\Http\ViewModels\Admin;
use Illuminate\Support\Facades\Log;
use App\Http\ViewModels\ViewModelBase;
use Illuminate\Support\Facades\Auth;

class PredictionViewModel extends ViewModelBase {

  public function GetStatuses(){
      $records = \Config::get('custom')['statuses'];
      return $records;
  }

}
