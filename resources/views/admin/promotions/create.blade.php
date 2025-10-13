@extends('layouts.admin')
@section('title', 'New Promotion')
@section('content')
<div class="row">
  <div class="col-lg-12 col-sm-12 grid-margin">
    <!-- form -->

    <form method="POST" id="form-promotion" action="{{url('admin/promotions')}}" enctype="multipart/form-data"
      class="forms-sample">
      @csrf
      <div class="card">
        <div class="card-header header-sm ">
          <div class="d-flex ">
            <div class="wrapper d-flex align-items-center">
              <h2 class="card-title mb4">New Promotion</h2>
            </div>
            <div class="wrapper ml-auto action-bar">
              <button type="submit" data-toggle="tooltip" data-placement="top" data-original-title="Save"
                class="btn btn-icons btn-success btn-sm"><i class="fa fa-save"></i></button>
              <a class="btn btn-icons btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top"
                data-original-title="Back" href="{{route('promotions.index')}}"><i class="fa fa-close"></i></a>
            </div>
          </div>
        </div>
        <!--//card-header-->


        <div class="card-body">


          <!-- Multi-language input for English and Chinese -->

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Title</label>
            <div class="col-md-10">
              @foreach($languages as $lang)
              <div class="input-group mb-1">
                <div class="input-group-prepend">
                  <span class="input-group-text"><span class="flag-icon flag-icon-{{$lang['flag']}}"></span></span>
                </div>
                <input type="text" id="input-title-{{$lang['code']}}" class="form-control"
                  name="title_{{$lang['code']}}" required placeholder="{{$lang['name']}}" />
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
                  name="short_description_{{$lang['code']}}" rows="5" placeholder="{{$lang['name']}}"></textarea>
              </div>
              @endforeach
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="input-url">Redirect URL</label>
            <div class="col-md-10">
              <input type="text" class="form-control" id="input-url" name="redirect_url" placeholder="" required />
            </div>
          </div>

          <div class="form-group row">
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
      </div>
    </form>
  </div>
</div>
@include('admin.modal-image') @endsection @section('footer') {!!
JsValidator::formRequest('App\Http\Requests\StorePromotionRequest', '#form-promotion' ); !!} <script>
  $('#form-promotion').submit(function (e) {
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
      notifySuccess('Promotion successfully added.');
      setTimeout(function(){ location.href='{{url('admin/promotions')}}'; }, 2000);
    }).always(function() {
      stopSpin(_btn);
    });
  });

  
  // Variable to store which item is being uploaded
  var currentUploadItem = '';

  // When the upload modal is opened, determine which item is being uploaded
  $('#modalImage').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    currentUploadItem = button.data('item'); // Extract info from data-* attributes
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

</script>

@endsection