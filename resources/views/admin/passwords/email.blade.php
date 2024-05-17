@extends('layouts.login')
@section('title', 'Reset Password')
@section('content')



       <h2 class="text-center mb-4 text-white">{{ __('Reset Password') }}</h2>
       <div class="auto-form-wrapper">
       @if (session('status'))
           <div class="alert alert-success" role="alert">
               {{ session('status') }}
           </div>
       @endif
      <form method="POST" action="{{ url('admin/forgot') }}" id="form-forgot">
          @csrf

          <div class="form-group">
            <label for="email" class="label">{{ __('E-Mail Address') }}</label>
            <div class="input-group">
              <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('E-Mail Address') }}">
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="mdi mdi-check-circle-outline"></i>
                </span>
              </div>
            </div>

          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary submit-btn btn-block">
                {{ __('Send Password Reset Link') }}
            </button>
          </div>
          <div class="text-block text-center my-3">
              <span class="text-small font-weight-semibold">Already have and account ?</span>
            <a href="{{ url('/admin') }}" class="text-black text-small">{{ __('Back to Login') }}</a>
          </div>

      </form>

      </div>
{!! JsValidator::formRequest('App\Http\Requests\Admin\ForgotRequest', '#form-forgot'); !!}
<script>
    $('#form-forgot').submit(function (e) {
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
          //  $(firstnameInput).next('.invalid-feedback').text(xhr.responseJSON.errors.firstname["0"]).css('font-size','0.9rem');
           notifySystemError(xhr.responseJSON.errors.email[0]);
        }).done(function(data) {
            if (!data.result) {
                notifyError('Sorry, the email address entered does not exist in our system.');
                return;
            }
            notifySuccess('Reset email sent!');
            location.href='{{url('/admin')}}';
        }).always(function() {
            stopSpin(_btn);
        });
    });

</script>
@endsection
