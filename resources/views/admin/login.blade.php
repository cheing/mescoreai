@extends('layouts.login')
@section('title', 'Login')
@section('content')
 <div class="auto-form-wrapper">
   <div class="text-center mb-5">
    <img src="{{asset('admins/images/logo.png')}}" alt="{{env('APP_Name')}}" />
  </div>
    <form method="POST" action="{{ url('admin') }}" id="form-login">
        @csrf
      <div class="form-group">
        <label for="email" class="label">{{ __('E-Mail Address') }}</label>
        <div class="input-group">
          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"  autofocus placeholder="{{ __('E-Mail Address') }}">
          <div class="input-group-append">
            <span class="input-group-text">
              <i class="mdi mdi-check-circle-outline"></i>
            </span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="password" class="label">{{ __('Password') }}</label>
          <input id="password" type="password" class="form-control" name="password"  placeholder="*********" />
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary submit-btn btn-block">
            {{ __('Login') }}
        </button>
      </div>
      <div class="form-group d-flex justify-content-between">
        <div class="form-check form-check-flat mt-0">
        </div>
        <a class="text-small forgot-password text-black" href="{{ url('admin/forgot') }}">
            {{ __('Forgot Your Password?') }}
        </a>
      </div>

    </form>
  </div>


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
                location.href='{{route('admin.dashboard')}}';
              }
          }).always(function() {
              stopSpin(_btn);
          });
      });

  </script>
    @endsection
