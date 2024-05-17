<?php

namespace App\Http\ViewModels\Admin;
use Illuminate\Support\Facades\Log;
use App\Http\ViewModels\ViewModelBase;
use Illuminate\Support\Facades\Auth;

class ParticipantsViewModel extends ViewModelBase {
  public $id;
  public $dto1;
  public $dto2;

  public function __construct($id, $dto1, $dto2){
  	$this->id = $id;
  	$this->dto1 = $dto1;
  	$this->dto2 = $dto2;
	}



}
