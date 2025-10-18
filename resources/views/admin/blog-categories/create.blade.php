@extends('layouts.admin')
@section('title', 'New Category')
@section('content')
<div class="row">
  <div class="col-lg-12 col-sm-12 grid-margin">
    <!-- form -->
    <form method="post" id="form-category" action="{{url('admin/blog-categories')}}" enctype="multipart/form-data"
      class="forms-sample">
      @csrf

      <div class="card">
        <div class="card-header header-sm ">
          <div class="d-flex ">
            <div class="wrapper d-flex align-items-center">
              <h2 class="card-title mb4">New Category</h2>
            </div>
            <div class="wrapper ml-auto action-bar">
              <button type="submit" data-toggle="tooltip" data-placement="top" data-original-title="Save"
                class="btn btn-icons btn-success btn-sm"><i class="fa fa-save"></i></button>
              <a class="btn btn-icons btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top"
                data-original-title="Back" href="{{route('blog-categories.index')}}"><i class="fa fa-close"></i></a>
            </div>
          </div>
        </div>
        <!--//card-header-->
        <div class="card-body">

          <!-- Language Tabs -->
          <ul class="nav nav-tabs" id="langTab" role="tablist">
            @foreach($languages as $index => $lang)
            <li class="nav-item">
              <a class="nav-link p-3 {{ $index === 0 ? 'active' : '' }}" id="tab-{{ $lang['code'] }}" data-toggle="tab"
                href="#lang-{{ $lang['code'] }}" role="tab">
                <span class="mr-1 flag-icon flag-icon-{{ $lang['flag'] }}"></span> {{ $lang['name'] }}
              </a>
            </li>
            @endforeach
          </ul>


          <div class="tab-content border border-top-0 p-4  mb-3" id="langTabContent">
            @foreach($languages as $index => $lang)
            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="lang-{{ $lang['code'] }}"
              role="tabpanel">
              <div class="form-group">
                <label>Title</label>
                <input type="text" name="name_{{ $lang['code'] }}" class="form-control" required>
              </div>

              <div class="form-group">
                <label>Description</label>
                <textarea name="description_{{ $lang['code'] }}" class="form-control" rows="3"></textarea>
              </div>


              <hr>
              <h6 class="text-muted mt-3 mb-2">SEO Meta</h6>
              <div class="form-group">
                <label>Meta Title</label>
                <input type="text" name="meta_title_{{ $lang['code'] }}" class="form-control" maxlength="255">
              </div>
              <div class="form-group">
                <label>Meta Keywords</label>
                <input type="text" name="meta_keywords_{{ $lang['code'] }}" class="form-control" maxlength="255">
              </div>
              <div class="form-group">
                <label>Meta Description</label>
                <textarea name="meta_description_{{ $lang['code'] }}" class="form-control" rows="3"
                  maxlength="500"></textarea>
              </div>
            </div>
            @endforeach
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="sort">Sort</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="sort" placeholder="" required />
            </div>
            <!--//col-->
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="status">Status</label>
            <div class="col-md-10">
              <select name="status" class="form-control ">
                @foreach($statuses as $k=>$v)
                <option value="{{$k}}">{{$v}}</option>
                @endforeach
              </select>
            </div>
            <!--//col-->
          </div>
          <!--//form-group-->

        </div>
        <!--//card-body-->
      </div>

    </form>
    <!-- // form-->
  </div>
</div>

@endsection
@section('footer')
{!! JsValidator::formRequest('App\Http\Requests\StoreBlogCategoryRequest', '#form-category'); !!}
<script>
  $('#form-category').submit(function (e) {
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
        notifySuccess('Category successfully added.');
        setTimeout(function(){ location.href='{{url('admin/blog-categories')}}'; }, 2000);
      }).always(function() {
          stopSpin(_btn);
      });
  });
</script>

@endsection