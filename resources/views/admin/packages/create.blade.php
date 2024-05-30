@extends('layouts.admin')
@section('title', 'New Package')
@section('content')
<div class="row">
  <div class="col-lg-12 col-sm-12 grid-margin">
    <!-- form -->
    <form method="post" id="form-package" action="{{url('admin/packages')}}" enctype="multipart/form-data"
      class="forms-sample">
      @csrf

      <div class="card">
        <div class="card-header header-sm ">
          <div class="d-flex ">
            <div class="wrapper d-flex align-items-center">
              <h2 class="card-title mb4">New Package</h2>
            </div>
            <div class="wrapper ml-auto action-bar">
              <button type="submit" data-toggle="tooltip" data-placement="top" data-original-title="Save"
                class="btn btn-icons btn-success btn-sm"><i class="fa fa-save"></i></button>
              <a class="btn btn-icons btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top"
                data-original-title="Back" href="{{route('packages.index')}}"><i class="fa fa-close"></i></a>
            </div>
          </div>
        </div>
        <!--//card-header-->
        <div class="card-body">


          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="sort">Sort</label>
            <div class="col-md-4">
              <input type="text" class="form-control" name="sort" placeholder="" required />
            </div>
            <label class="col-md-2 col-form-label" for="duration">Duration</label>
            <div class="col-md-4">
              <input type="text" class="form-control" name="duration" placeholder="" required />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="title">Name </label>
            <div class="col-md-4">
              <input type="text" class="form-control" name="name" placeholder="" required />
            </div>
            <label class="col-md-2 col-form-label" for="status">Status</label>
            <div class="col-md-4">
              <select name="status" class="form-control">
                @foreach($statuses as $k=>$v)
                <option value="{{ $k }}">
                  {{ $v }}
                </option>
                @endforeach
              </select>
            </div>
            <!--//col-->
          </div>


          <!-- Multi-language input for English and Chinese -->

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Display Name</label>
            <div class="col-md-10">
              @foreach($languages as $lang)
              <div class="input-group mb-1">
                <div class="input-group-prepend">
                  <span class="input-group-text"><span class="flag-icon flag-icon-{{$lang['flag']}}"></span></span>
                </div>
                <input type="text" id="display_name_{{$lang['code']}}" class="form-control"
                  name="display_name[{{$lang['code']}}]" required placeholder="{{$lang['name']}}" />
              </div>
              @endforeach
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Short Description </label>
            <div class="col-md-10">
              @foreach($languages as $lang)
              <div class="input-group mb-1">
                <div class="input-group-prepend">
                  <span class="input-group-text"><span class="flag-icon flag-icon-{{$lang['flag']}}"></span></span>
                </div>
                <textarea id="short_description_{{$lang['code']}}" class="form-control"
                  name="short_description[{{$lang['code']}}]" rows="5" placeholder="{{$lang['name']}}"></textarea>
              </div>
              @endforeach
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Description </label>
            <div class="col-md-10">
              @foreach($languages as $lang)
              <div class="input-group mb-1">
                <div class="input-group-prepend">
                  <span class="input-group-text"><span class="flag-icon flag-icon-{{$lang['flag']}}"></span></span>
                </div>
                <textarea name="description[{{$lang['code']}}]" id="description_[{{$lang['code']}}]"
                  class="summernote"></textarea>

              </div>
              @endforeach
            </div>
          </div>

          <!--//row-->

        </div>
        <!--//card-body-->
      </div>

    </form>
    <!-- // form-->
  </div>
</div>

@endsection
@section('footer')
{!! JsValidator::formRequest('App\Http\Requests\StorePackageRequest', '#form-package'); !!}
<script>
  $('#form-package').submit(function (e) {
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
        notifySuccess('Package successfully added.');
        setTimeout(function(){ location.href='{{url('admin/packages')}}'; }, 2000);
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