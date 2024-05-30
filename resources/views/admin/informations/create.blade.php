@extends('layouts.admin')
@section('title', 'New Information')
@section('content')
<div class="row">
  <div class="col-lg-12 col-sm-12 grid-margin">
    <!-- form -->
    <form method="post" id="form-information" action="{{url('admin/informations')}}" enctype="multipart/form-data"
      class="forms-sample">
      @csrf

      <div class="card">
        <div class="card-header header-sm ">
          <div class="d-flex ">
            <div class="wrapper d-flex align-items-center">
              <h2 class="card-title mb4">New Information</h2>
            </div>
            <div class="wrapper ml-auto action-bar">
              <button type="submit" data-toggle="tooltip" data-placement="top" data-original-title="Save"
                class="btn btn-icons btn-success btn-sm"><i class="fa fa-save"></i></button>
              <a class="btn btn-icons btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top"
                data-original-title="Back" href="{{route('informations.index')}}"><i class="fa fa-close"></i></a>
            </div>
          </div>
        </div>
        <!--//card-header-->
        <div class="card-body">
          <div class="form-group row">
            <label class="col-md-12 col-form-label" for="key">Key</label>
            <div class="col-md-3">
              <input type="text" class="form-control" name="key" placeholder="" required />
            </div>
          </div>
          <!--//form-group-->

          <div class="form-group row">
            <label class="col-md-12 col-form-label" for="title">Title</label>
            <div class="col-md-12">
              <div class="input-group mb-1">
                <div class="input-group-prepend">
                  <span class="input-group-text"><span class="flag-icon flag-icon-gb"></span></span>
                </div>
                <textarea name="title" id="title" class="form-control" rows="3"></textarea>
              </div>
              <div class="input-group mb-1">
                <div class="input-group-prepend">
                  <span class="input-group-text"><span class="flag-icon flag-icon-cn"></span></span>
                </div>
                <textarea name="title_zh" id="title_zh" class="form-control" rows="3"></textarea>
              </div>
            </div>
            <!--//col-->
          </div>


          <div class="form-group row">
            <label class="col-md-12 col-form-label" for="content">Content</label>
            <div class="col-md-12">
              <div class="input-group mb-1">
                <div class="input-group-prepend">
                  <span class="input-group-text"><span class="flag-icon flag-icon-gb"></span></span>
                </div>
                <textarea name="content" id="content" class="form-control" rows="10"></textarea>
              </div>
              <div class="input-group mb-1">
                <div class="input-group-prepend">
                  <span class="input-group-text"><span class="flag-icon flag-icon-cn"></span></span>
                </div>
                <textarea name="content_zh" id="content_zh" class="form-control" rows="10"></textarea>
              </div>
            </div>
          </div>




        </div>
        <!--//card-body-->
      </div>

    </form>
    <!-- // form-->
  </div>
</div>

@endsection
@section('footer')
{!! JsValidator::formRequest('App\Http\Requests\StoreInformationRequest', '#form-information'); !!}
<script>
  $('#form-information').submit(function (e) {
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
        notifySuccess('Information successfully added.');
        setTimeout(function(){ location.href='{{url('admin/informations')}}'; }, 2000);
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