@extends('layouts.admin')
@section('title', 'New FAQ')
@section('content')
    <div class="row">
      <div class="col-lg-12 col-sm-12 grid-margin">
        <!-- form -->
        <form method="post" id="form-faq" action="{{url('admin/faqs')}}" enctype="multipart/form-data"  class="forms-sample">
            @csrf

        <div class="card">
          <div class="card-header header-sm ">
            <div class="d-flex ">
                <div class="wrapper d-flex align-items-center">
                  <h2 class="card-title mb4">New FAQ</h2>
                </div>
                <div class="wrapper ml-auto action-bar">
                  <button type="submit" data-toggle="tooltip" data-placement="top" data-original-title="Save" class="btn btn-icons btn-success btn-sm"><i class="fa fa-save"></i></button>
                  <a class="btn btn-icons btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" data-original-title="Back"  href="{{route('faqs.index')}}"><i class="fa fa-close"></i></a>
                </div>
            </div>
          </div><!--//card-header-->
          <div class="card-body">

            <div class="row">
              
               <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-md-12 col-form-label" for="sort">Sort</label>
                    <div class="col-md-3">
                      <input type="text" class="form-control" name="sort" placeholder="" required/>
                   </div><!--//col-->
                </div>
              </div><!--//col-->
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-md-12 col-form-label" for="title">Title </label>
                    <div class="col-md-12">
                      <textarea name="title" id="title" class="form-control" rows="3"></textarea>
                   </div><!--//col-->
                </div>
              </div><!--//col-->
            </div><!--row-->
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-md-12 col-form-label" for="content">Content</label>
                    <div class="col-md-12">
                      <textarea name="content" id="content" class="summernote" ></textarea>
                   </div><!--//col-->
                </div>
              </div><!--//col-->
            </div><!--row-->


          </div><!--//card-body-->
        </div>

      </form>
      <!-- // form-->
      </div>
    </div>

@endsection
@section('footer')
{!! JsValidator::formRequest('App\Http\Requests\StoreFAQRequest', '#form-faq'); !!}
<script>
  $('#form-faq').submit(function (e) {
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
        notifySuccess('FAQ successfully added.');
        setTimeout(function(){ location.href='{{url('admin/faqs')}}'; }, 2000);
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
