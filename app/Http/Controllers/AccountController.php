<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;

class AccountController extends Controller{

    private $limits = 15;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function SignOut() {
        Auth::logout();
        return redirect('/login');
    }

    public function ChangePassword() {

      return view('password',  compact('view'));
    }

    public function ChangePasswordPost(\App\Http\Requests\Account\PasswordRequest $request) {
        $data = $request->validated();
        $data['id'] = Auth::id();
        dispatch(new \App\Lib\Commands\Account\UpdatePassword($data));
        return $this->JsonOk();
    }

    public function Profile() {

      if(Auth::user()->role == 0 || Auth::user()->role ==1){
        $view = 'layouts.app';
      }elseif(Auth::user()->role == 2){
        $view = 'layouts.agent';
      }

        $dto = \App\Lib\Queries\Account\GetProfile::Result(Auth::id());
        return view('admin/profile',['data' => $dto], compact('view'));
    }

    public function ProfilePost(\App\Http\Requests\Account\ProfileRequest $request) {
        $data = $request->validated();
        $data['id'] = Auth::id();
        dispatch(new \App\Lib\Commands\Account\UpdateProfile($data));
        return $this->JsonOk();
    }

}
