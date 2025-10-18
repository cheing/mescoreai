@extends('layouts.admin')
@section('title', 'New Blog')
@section('content')
<div class="row">
  <div class="col-lg-12 col-sm-12 grid-margin">
    <form method="POST" id="form-blog" action="{{ url('admin/blogs') }}" enctype="multipart/form-data"
      class="forms-sample">
      @csrf
      <div class="card">
        <div class="card-header header-sm">
          <div class="d-flex">
            <h2 class="card-title mb4">New Blog</h2>
            <div class="ml-auto">
              <button type="submit" data-toggle="tooltip" data-placement="top" data-original-title="Save"
                class="btn btn-icons btn-success btn-sm"><i class="fa fa-save"></i></button>
              <a class="btn btn-icons btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top"
                data-original-title="Back" href="{{route('blogs.index')}}"><i class="fa fa-close"></i></a>
            </div>
          </div>
        </div>
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
                <input type="text" name="title_{{ $lang['code'] }}" class="form-control" required>
              </div>

              <div class="form-group">
                <label>Excerpt</label>
                <textarea name="short_description_{{ $lang['code'] }}" class="form-control" rows="3"></textarea>
              </div>

              <div class="form-group">
                <label>Content</label>
                <textarea name="content_{{ $lang['code'] }}" class="form-control summernote"></textarea>
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

          <div class=" form-group row">
            <label class="col-md-2 col-form-label" for="image ">Image</label>
            <div class="col-md-10 d-flex ">
              <div class="user-avatar mb-auto">
                <img src="{{ asset('images/no_image.jpg')}}" alt="profile image"
                  class="profile-img img-lg rounded-circle" id="thumbnail_url" />
                <span class="edit-avatar-icon" data-toggle="modal" data-target="#modalImage"><i
                    class="mdi mdi-upload"></i></span>
              </div>
              <input type="hidden" name="thumbnail" value="" id="input-thumbnail" />
            </div>
            <!--//col-->
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Status</label>
            <div class="col-md-10">
              <select name="status" class="form-control">
                @foreach($statuses as $k=>$v)
                <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="blog_category_id">Categories</label>
            <div class="col-md-10">
              <select class="js-example-basic-multiple" name="blog_category_id[]" multiple="multiple">
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}">
                  {{ $cat->translate('en')->name ?? $cat->slug }}
                </option>
                @endforeach
              </select>
            </div>
          </div>


        </div>
      </div>
    </form>
  </div>
</div>

@include('admin.modal-image')
@endsection

@section('footer')
{!! JsValidator::formRequest('App\Http\Requests\StoreBlogRequest', '#form-blog'); !!}
<script>
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
  $('#form-blog button[type=submit]').on('click', function(e) {
    e.preventDefault();
      var form = $('#form-blog');
  if (!form.valid()) return false; // Still works with JsValidator

    var _btn = $('button[type=submit]', this);
    startSpin(_btn);

    // 如果有文件上传，使用 FormData 对象
  var formData = new FormData(form[0]);
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: form.attr('action'),
      type: 'POST',
      data: formData,
      processData: false, // 不处理发送的数据
      contentType: false, // 不设置内容类型
    }).fail(function(xhr) {
      var error = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error';
      notifySystemError(error);
    }).done(function(data) {
      notifySuccess('Blog successfully added.');
      setTimeout(function(){ location.href='{{url('admin/blogs')}}'; }, 2000);
    }).always(function() {
      stopSpin(_btn);
    });
  });


   //upload
$('#btnUploadImage').on('click', function() {
 if (!$('#form-image').valid()) return false;
 var formData = new FormData($('#form-image')[0]);
 var _btn = $('#btnUploadImage', this);
 startSpin(_btn);
 $.ajax({
     headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     },
     url: '{{route('upload.image')}}',
     type: 'POST',
     data:formData,
     enctype: 'multipart/form-data',
     contentType: false,
     processData: false,
 }).fail(function(xhr, text, err) {
    notifySystemError(err);
 }).done(function(data) {
   if(data['path']){
      $('#input-thumbnail').val(data['path']);
      $('#thumbnail_url').attr('src', data['url']);
      notifySuccess('Image upload');
      $('#modalImage').modal('hide');
      var drEvent = $('#photo').dropify();
      drEvent = drEvent.data('dropify');
      drEvent.resetPreview();
      drEvent.clearElement();
   }else{
     notifySystemError(data['error']);
   }
 }).always(function() {
     stopSpin(_btn);
 });
});

  $(document).ready(function() {
    $('.summernote').summernote({ height: 300 });
  });



</script>
@endsection