<?php

namespace App\Http\ViewModels\Home;
use Illuminate\Support\Facades\Log;
use App\Http\ViewModels\ViewModelBase;
use Illuminate\Support\Facades\Auth;

class HomeViewModel extends ViewModelBase {
  public $dto;

  public function __construct($dto){
		$this->dto = $dto;
	}


}
