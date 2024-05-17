<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function JsonOk(array $params = []) {
    return \Response::json(array_merge($params, ['result' => true]));
  }

  protected function JsonError(string $msg = '', array $params = []) {
    return \Response::json(array_merge($params, ['result' => false, 'error' => $msg]));
  }
}
