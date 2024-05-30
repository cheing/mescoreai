@extends('layouts.admin')
@section('title', 'New Subscription')
@section('content')
<div class="row">
  <div class="col-lg-12 col-sm-12 grid-margin">
    <!-- form -->
    <form method="post" id="form-subscription" action="{{url('admin/subscriptions')}}" enctype="multipart/form-data"
      class="forms-sample">
      @csrf

      <div class="card">
        <div class="card-header header-sm ">
          <div class="d-flex ">
            <div class="wrapper d-flex align-items-center">
              <h2 class="card-title mb4">New Subscription</h2>
            </div>
            <div class="wrapper ml-auto action-bar">
              <button type="submit" data-toggle="tooltip" data-placement="top" data-original-title="Save"
                class="btn btn-icons btn-success btn-sm"><i class="fa fa-save"></i></button>
              <a class="btn btn-icons btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top"
                data-original-title="Back" href="{{route('subscriptions.index')}}"><i class="fa fa-close"></i></a>
            </div>
          </div>
        </div>
        <!--//card-header-->
        <div class="card-body">
          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="input-user">User</label>
            <div class="col-md-4">
              <select name="user_id" id="input-user" class="form-control select2">
                @foreach($users as $user)
                <option value="{{$user->id}}">{{$user->username}}</option>
                @endforeach
              </select>
            </div>
            <label class="col-md-2 col-form-label" for="input-package">Package</label>
            <div class="col-md-4">
              <select name="package_id" id="input-package" class="form-control select2">
                @foreach($packages as $package)
                <option value="{{$package->id}}">{{$package->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <!-- form group -->
        </div>
        <!--//card-body-->
      </div>

    </form>
    <!-- // form-->
  </div>
</div>

@endsection
@section('footer')
{!! JsValidator::formRequest('App\Http\Requests\StoreSubscriptionRequest', '#form-subscription'); !!}
<script>
  $('#form-subscription').submit(function (e) {
      e.preventDefault();
      if (!$(this).valid()) return false;
      var _btn = $('button[type=submit]', this);
      startSpin(_btn);

      // 如果有文件上传，使用 FormData 对象
      var formData = new FormData(this);
      $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: this.action,
          type: this.method,
          data: formData,
          processData: false, // 不处理发送的数据
          contentType: false, // 不设置内容类型
      }).fail(function(xhr) {
         var error = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error';
         notifySystemError(error);
      }).done(function(data) {
        notifySuccess('Subscription successfully added.');
        setTimeout(function(){ location.href='{{url('admin/subscriptions')}}'; }, 2000);
      }).always(function() {
          stopSpin(_btn);
      });
  });

  $(document).ready(function() {
  $('.summernote').summernote({
    height: 300

  });
});
</script>

@endsection