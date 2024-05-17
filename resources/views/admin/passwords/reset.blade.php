@extends('layouts.login')
@section('title', 'Reset Password')
@section('content')
 <h2 class="text-center mb-4 text-white">{{ __('Reset Password') }}</h2>

 <div class="auto-form-wrapper">
          <form method="POST" action="{{ url('admin/password/reset') }}" id="form-password">
              @csrf

              <input type="hidden" name="token" value="{{ $vm }}" >

              <div class="form-group ">
                  <label for="password" class="label">{{ __('Password') }}</label>
                  <div class="input-group">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="*********">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                    </div>
                      @if ($errors->has('password'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif

              </div>

              <div class="form-group ">
                  <label for="password2" class="label">{{ __('Re-enter Password') }}</label>
                  <div class="input-group">
                    <input id="password2" type="password" class="form-control" name="password2" required placeholder="*********" />
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>

              </div>

              <div class="form-group ">
                  <button type="submit" class="btn btn-primary submit-btn btn-block">
                      {{ __('Reset Password') }}
                  </button>
              </div>
          </form>
</div><!-- auto-form-wrapper-->
{!! JsValidator::formRequest('\App\Http\Requests\Admin\ResetPasswordRequest', '#form-password'); !!}
<script>
      $('#form-password').submit(function (e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          if (!$(this).valid()) return false;
          var _btn = $('button[type=submit]', this);
          startSpin(_btn);
          $.ajax({
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
              if (!data.result) {
                  notifyError(data.error);
                  return;
              }
              notifySuccess('Password reset completed');
              setTimeout(function() { location.href='{{url('/admin')}}'; }, 2000);
          }).always(function() {
              stopSpin(_btn);
          });
      });
  </script>

  <script>
      $(function() {
          $('#password').focus();
      });
  </script>

@endsection
