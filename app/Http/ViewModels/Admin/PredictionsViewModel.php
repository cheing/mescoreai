<?php

namespace App\Http\ViewModels\Admin;
use Illuminate\Support\Facades\Log;
use App\Http\ViewModels\ViewModelBase;
use Illuminate\Support\Facades\Auth;

class PredictionsViewModel extends ViewModelBase {
  public $dto;
  public $paging;

  public function __construct($dto, $paging){
		$this->dto = $dto;
    $this->paging = $paging;
	}


}
