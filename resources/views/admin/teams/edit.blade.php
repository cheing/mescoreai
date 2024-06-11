@extends('layouts.admin')
@section('title', 'Edit Team')
@section('content')
<div class="row">
  <div class="col-lg-12 col-sm-12 grid-margin">
    <!-- form -->
    <form method="post" id="form-team" action="{{ url('admin/teams/' . $team->id) }}" enctype="multipart/form-data"
      class="forms-sample">

      @csrf

      <div class="card">
        <div class="card-header header-sm ">
          <div class="d-flex ">
            <div class="wrapper d-flex align-items-center">
              <h2 class="card-title mb4">Edit Team</h2>
            </div>
            <div class="wrapper ml-auto action-bar">
              <button type="submit" data-toggle="tooltip" data-placement="top" data-original-title="Save"
                class="btn btn-icons btn-success btn-sm"><i class="fa fa-save"></i></button>
              <a class="btn btn-icons btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top"
                data-original-title="Back" href="{{route('teams.index')}}"><i class="fa fa-close"></i></a>
            </div>
          </div>
        </div>
        <!--//card-header-->
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-md-3 col-form-label" for="image ">Image</label>
                <div class="col-md-9 d-flex ">
                  <div class="user-avatar mb-auto">
                    @if($team->image)
                    <a class="lightbox-image" data-lightbox="gallery" href="{{ Storage::url($team->image) }}"
                      target="_blank">
                      <img src="{{ Storage::url($team->image) }}" alt="profile image"
                        class="profile-img img-lg rounded-circle" id="image_url" /></a>

                    @else
                    <a class="lightbox-image" data-lightbox="gallery" href="{{ asset('images/no_image.jpg') }}"
                      target="_blank">
                      <img src="{{ asset('images/no_image.jpg')}}" alt="profile image"
                        class="profile-img img-lg rounded-circle" id="image_url" /></a>
                    @endif
                    <span class="edit-avatar-icon" data-toggle="modal" data-target="#modalImage"><i
                        class="mdi mdi-upload"></i></span>
                  </div>
                  <input type="hidden" name="image" id="input-image" value="{{$team->image}}" />
                </div>
                <!--//col-->
              </div>
            </div>
            <!--//col-->
          </div>
          <!--row-->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-md-3 col-form-label" for="name">Team Name</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="name" placeholder="English" required
                    value="{{ $team->name }}" />
                  <!-- <input type="text" class="form-control mt-2"  name="name_zh" placeholder="Chinese" required value="{{ $team->name_zh }}"/> -->
                </div>
                <!--//col-->
              </div>
            </div>
            <!--//col-->
          </div>
          <!--row-->
        </div>
        <!--//card-body-->
      </div>

    </form>
    <!-- // form-->
  </div>
</div>

<!-- upload image -->
<div class="modal fade" id="modalImage" tabindex="-1" role="dialog" aria-labelledby="modalImageLabel"
  aria-hidden="true">
  <form method="POST" id="form-image" action="{{url('upload')}}">
    <div class="modal-dialog modal-dialog-centered " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalImageLabel">Upload Image</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="dropFileState" ondragover="return false">
            <div id="dragUploadFile">
              <p>File Type：PNG，JPG，GIF，TIFF<br />
                File Size：2MB
              </p>
              <input type="file" id="photo" name="photo" class="dropify" data-max-file-size="2M"
                data-allowed-file-extensions="jpg png gif tiff jpeg" />
            </div>
          </div>
          <div class="text-center mt-2">
            <button type="button" class="btn btn-success mb-3" id="btnUploadImage"><i class="fa fa-excel"></i>
              Upload</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
@section('footer')
{!! JsValidator::formRequest('App\Http\Requests\UpdateTeamRequest', '#form-team'); !!}
<script>
  $('#form-team').submit(function (e) {
      e.preventDefault();
      if (!$(this).valid()) return false;
      var _btn = $('button[type=submit]', this);
      startSpin(_btn);

      // 如果有文件上传，使用 FormData 对象
      var formData = new FormData(this);
      formData.append('_method', 'PUT');
      $.ajax({
         headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          'X-HTTP-Method-Override': 'PUT'
          },

          url: '{{ url('admin/teams/' . $team->id) }}',
          type: 'POST',
          data: formData,
          processData: false, // 不处理发送的数据
          contentType: false, // 不设置内容类型
      }).fail(function(xhr) {
         var error = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error';
         notifySystemError(error);
      }).done(function(data) {
        notifySuccess('Team successfully update.');
        setTimeout(function(){ location.href='{{url('admin/teams')}}'; }, 2000);
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
      $('#input-image').val(data['path']);
      $('#image_url').attr('src', data['url']);
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