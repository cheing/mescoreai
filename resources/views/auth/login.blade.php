<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FIFA') }}</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/mdi/css/materialdesignicons.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('vendor/jquery-confirm-master/css/jquery-confirm.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/css/vendor.bundle.base.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/css/vendor.bundle.addons.css')}}" />
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('backend/css/shared/style.css')}}" />
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('backend/css/style.css')}}" />
</head>
<body>

<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper auth p-0 theme-two">
       <div class="row d-flex align-items-stretch">
           <div class="col-md-4 banner-section d-none d-md-flex align-items-stretch justify-content-center">
               <div class="slide-content bg-1"> </div>
           </div>
           <div class="col-12 col-md-8 h-100 bg-white">
             <div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">
              @if (Route::has('password.request'))
              @endif

              <form method="POST" action="{{ url('/login') }}" id="form-login">
                @csrf
                <h3 class="mr-auto">LOGIN 登录</h3>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="mdi mdi-account-outline"></i>
                      </span>
                    </div>
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}"   autofocus placeholder="Username 用户名"/>
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="mdi mdi-lock-outline"></i>
                      </span>
                    </div>
                    <input id="input-password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  placeholder="Password 密码" >
                  </div>
                </div>

                <div class="form-group">
                  <div class="form-check form-check-flat">
                    <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    {{ __('Remember Me 记得我') }} </label>
                  </div>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary submit-btn">{{ __('Sign in 登入') }}</button>
                </div>

                <div class="wrapper mt-5 text-gray">
                  <p class="footer-text">Copyright © 2020 -  {{date('Y')}}. All rights reserved.</p>
                </div>
              </form>

          </div>
        </div>
      </div>
    </div>
  </div>
<!-- page-body-wrapper ends -->
</div>


 <script src="{{asset('backend/js/vendor.bundle.base.js')}}"></script>
 <script src="{{asset('backend/js/vendor.bundle.addons.js')}}"></script>
 <script src="{{asset('backend/js/off-canvas.js')}}"></script>
 <script src="{{asset('backend/js/hoverable-collapse.js')}}"></script>
 <script src="{{asset('backend/js/misc.js')}}"></script>

 <script src="{{asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
 <script src="{{asset('vendor/bootstrap4-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
 <script src="{{asset('vendor/jquery-confirm-master/js/jquery-confirm.js') }}"></script>
  <script src="{{asset('backend/js/custom.js')}}"></script>

 {!! JsValidator::formRequest('App\Http\Requests\Admin\LoginRequest', '#form-login'); !!}
   <script>
       $('#form-login').submit(function (e) {
           e.preventDefault();
           e.stopImmediatePropagation();
           if (!$(this).valid()) return false;
           var _btn = $('button[type=submit]', this);
           startSpin(_btn);
           $.ajax({
             headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
               url: this.action,
               type: this.method,
               data: $(this).serialize(),
           }).fail(function(xhr, text, err) {
             var json = $.parseJSON(xhr.responseText);
             if (json['errors'] && json['errors'] != '') {
                 var msg ='';
                 $.each(json['errors'], function (key, value) {
                    msg +=  value + '<br/>';
                 });
                 notifyError(msg);
             }else{
               notifySystemError(err);
             }
           }).done(function(data) {
               if(data['error']){
                   notifyError(data['error']);
               }else{
                 location.href='{{url('/admin')}}';
               }
           }).always(function() {
               stopSpin(_btn);
           });
       });

   </script>
</body>
</html>
