@extends('layouts.app')

@section('content')
<!--Main Content Start-->
<div class="main-content innerpagebg wf100">
  <div class="match-results wf100 p40">
    <div class="container">
      <div class="row">
        @if(auth()->check())
        @if(auth()->user()->activeSubscription())
        <div class="col-12 text-center p-5">
          <p class="text-white">{{ __('messages.text_ady_subscribe')}} </p>
        </div>
        @else
        <div class="col-md-6 col-sm-12">
          <div class="section-title white mb-5">
            <h2 class="text-uppercase">{{ __('messages.text_subscription')}} </h2>
          </div>
          <div class="text-white">
            @if(isset($data->content))
            @if(App::getLocale() == 'en')
            {!! $data->content !!}
            @else
            {!! $data->content_zh !!}
            @endif
            @endif
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="card bg-slate text-white">
            <div class="card-body p-4">
              <h4 class="text-uppercase pt-2">{{ __('messages.text_upload')}} </h4>
              <p>{{
                __('messages.text_upload_detail')
                }}
              </p>
              <form method="POST" id="form-upload" action="{{ route('upload-receipt') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="inputUsername">{{
                    __('messages.text_username')
                    }}</label>
                  <input type="text" class="form-control" value="{{ Auth::user()->username}}" disabled>
                </div>
                <div class="form-group">
                  <label for="inputme88Username">{{
                    __('messages.text_me88_username')
                    }}</label>
                  <input type="text" class="form-control" id="inputme88Username" name="username">
                </div>
                <div class="form-group">
                  <label for="inputEmail">{{
                    __('messages.text_email')
                    }}</label>
                  <input type="email" class="form-control" id="inputEmail" name="email">
                </div>
                <div class="form-group">
                  <label for="inputFile">{{
                    __('messages.text_upload')
                    }}</label>
                  <input type="file" class="form-control" name="file" />
                </div>
                <div class="d-flex align-items-center justify-content-end my-4">
                  <button type="submit" class="btn btn-block btn-primary" id="btn-upload">{{
                    __('messages.btn_submit')
                    }}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        @endif

        @else

        <div class="col-md-6 col-sm-12">
          <div class="section-title white mb-5">
            <h2 class="text-uppercase">{{ __('messages.text_subscription')}} </h2>
          </div>
          <div class="text-white">
            @if(isset($data->content))
            @if(App::getLocale() == 'en')
            {!! $data->content !!}
            @else
            {!! $data->content_zh !!}
            @endif
            @endif
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="card bg-slate text-white">
            <div class="card-body p-4">


              <br />
              <!-- form -->
              <form method="POST" id="form-login" action="{{route('member-login')}}">
                @csrf
                <div class="d-flex justify-content-center self-align-center mb-4">
                  <img src="{{asset('../images/logo.png')}}" style="max-height: 30px" />
                </div>
                <p class="text-center">{{
                  __('messages.text_please_login_to_subscribe')
                  }}</p>
                <div class="form-group">
                  <label for="inputUsername1">{{
                    __('messages.text_username')
                    }}</label>
                  <input type="text" class="form-control" id="inputUsername1" name="username" class="text-white" />
                </div>
                <div class="form-group">
                  <label for="inputPassword1">{{
                    __('messages.text_password')
                    }}</label>
                  <input type="password" class="form-control" id="inputPassword1" name="password">
                </div>
                @if (Route::has('password.request'))
                <div class="form-group">

                  <a class="btn btn-link text-white " href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                  </a>
                </div>
                @endif
                <div class="d-flex align-items-center justify-content-end my-4">

                  <button id="btn-login" type="submit" class="btn btn-block btn-primary">{{
                    __('messages.btn_submit')
                    }}</button>

                </div>
              </form>
              <div class="d-flex justify-content-start align-items-center">
                {{
                __('messages.text_dont_have_account')
                }} &nbsp;
                <a href="#" data-toggle="modal" data-target="#modalRegister" class="text-success">{{
                  __('messages.text_sign_up')
                  }} </a>
              </div>
            </div>
          </div>
        </div>

        @endif
      </div>
    </div>
  </div>
</div>
<!--Main Content End-->

@endsection
@section('footer')
@endsection