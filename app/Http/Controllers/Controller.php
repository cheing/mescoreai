<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Page;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // Load Top Menu
        $topMenuPages = Page::where('menu_position', 'top')
            ->where('status', 1)
            ->orderBy('sort')
            ->get();

        // Load Footer Menu
        $footerMenuPages = Page::where('menu_position', 'footer')
            ->where('status', 1)
            ->orderBy('sort')
            ->get();

        // Share with all Blade views
        View::share('topMenuPages', $topMenuPages);
        View::share('footerMenuPages', $footerMenuPages);
    }


  protected function JsonOk(array $params = []) {
    return \Response::json(array_merge($params, ['result' => true]));
  }

  protected function JsonError(string $msg = '', array $params = []) {
    return \Response::json(array_merge($params, ['result' => false, 'error' => $msg]));
  }
}
