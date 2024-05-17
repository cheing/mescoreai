<?php

namespace App\Http\ViewModels\Admin;
use Illuminate\Support\Facades\Log;
use App\Http\ViewModels\ViewModelBase;
use Illuminate\Support\Facades\Auth;

class UserEditViewModel extends ViewModelBase {
  public $dto;

  public function __construct($dto){
  	$this->dto = $dto;
	}

  public function GetStatuses(){
      $records = \Config::get('custom')['statuses'];
      return $records;
  }



}
