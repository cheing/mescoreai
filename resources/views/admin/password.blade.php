@extends('layouts.admin')
@section('title', 'Change Password')
@section('content')

    <div class="row">
      <div class="col-lg-6 col-sm-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Change Password</h4>
            <form method="POST" action="{{ url('/admin/password') }}" id="form-password">
                @csrf
                <div class="form-group ">
                    <label for="password" class="label">{{ __('Password') }}</label>
                    <div class="input-group">
                      <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="*********">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="fa fa-key"></i>
                        </span>
                      </div>
                      </div>

                </div>

                <div class="form-group ">
                    <label for="password2" class="label">{{ __('Confirm Password') }}</label>
                    <div class="input-group">
                      <input id="password2" type="password" class="form-control" name="password2" required placeholder="*********" />
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="fa fa-key"></i>
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
          </div>
        </div>
      </div>
    </div>


    {!! JsValidator::formRequest('App\Http\Requests\Admin\PasswordRequest', '#form-password'); !!}
    <script>
        $('#form-password').submit(function (e) {
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
               notifySystemError(err);
            }).done(function(data) {
              notifySuccess('Password updated');
              setTimeout(function(){ location.href='{{url('/admin/dashboard')}}'; }, 2000);
            }).always(function() {
                stopSpin(_btn);
            });
        });
    </script>

@endsection
