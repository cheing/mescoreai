@extends('layouts.admin')
@section('title', 'Profile')
@section('content')

<div class="row">
  <div class="col-lg-6 col-sm-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Profile</h4>
        <form method="POST" action="{{ url('/admin/profile') }}" id="form-profile">
            @csrf
            <input type="hidden" name="id" value="{{$data->id}}" />
            <div class="form-group row">
              <div class="col">
                  <label for="username">Username</label>
                  <label for="username">{{$data->username}}</label>
               </div><!--//col-->
            </div>
            <div class="form-group row">
            <div class="col">
                <label for="name">Name</label>
                <input type="text" class="form-control" value="{{$data->name}}" name="name" placeholder="Name" required/>
             </div><!--//col-->
               <div class="col">
                 <label for="email">Email</label>
                 <input type="email" class="form-control" value="{{$data->email}}" name="email" placeholder="Email" required />
             </div><!--//col-->

            </div>

            <div class="form-group ">
                <button type="submit" class="btn btn-primary submit-btn btn-block">
                  Update
                </button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('footer')

    {!! JsValidator::formRequest('App\Http\Requests\Admin\ProfileRequest', '#form-profile'); !!}
    <script>
        $('#form-profile').submit(function (e) {
            e.preventDefault();
            if (!$(this).valid()) return false;
            var _btn = $('button[type=submit]', this);
            startSpin(_btn);
            $.ajax({
                url: this.action,
                type: this.method,
                data: $(this).serialize(),
            }).fail(function(xhr, text, err) {
               notifySystemError(err);
            }).done(function(data) {
              notifySuccess('Profile Update');
              setTimeout(function(){ location.href='{{url('/admin/dashboard')}}'; }, 2000);
            }).always(function() {
                stopSpin(_btn);
            });
        });
    </script>

@endsection
