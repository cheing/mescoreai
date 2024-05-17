@extends('layouts.admin')
@section('title', 'New Team')
@section('content')
    <div class="row">
      <div class="col-lg-12 col-sm-12 grid-margin">
        <!-- form -->
        <form method="post" id="form-team" action="{{url('admin/teams')}}" enctype="multipart/form-data"  class="forms-sample">
            @csrf

        <div class="card">
          <div class="card-header header-sm ">
            <div class="d-flex ">
                <div class="wrapper d-flex align-items-center">
                  <h2 class="card-title mb4">New Team</h2>
                </div>
                <div class="wrapper ml-auto action-bar">
                  <button type="submit" data-toggle="tooltip" data-placement="top" data-original-title="Save" class="btn btn-icons btn-success btn-sm"><i class="fa fa-save"></i></button>
                  <a class="btn btn-icons btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" data-original-title="Back"  href="{{route('teams.index')}}"><i class="fa fa-close"></i></a>
                </div>
            </div>
          </div><!--//card-header-->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="image ">Image</label>
                    <div class="col-md-9 d-flex ">
                    <div class="user-avatar mb-auto">
                          <img src="{{ asset('images/no_image.jpg')}}" alt="profile image" class="profile-img img-lg rounded-circle" id="image_url"/>
                      <span class="edit-avatar-icon" data-toggle="modal" data-target="#modalImage"><i class="mdi mdi-upload"></i></span>
                    </div>
                      <input type="hidden" name="image" value="" id="input-image" />
                  </div><!--//col-->
                </div>
              </div><!--//col-->
            </div><!--row-->
            
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="name">Team Name</label>
                    <div class="col-md-9">
                    <input type="text" class="form-control"  name="name" placeholder="English" required/>
                    <!-- <input type="text" class="form-control mt-2"  name="name_zh" placeholder="Chinese" required/> -->
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
    @include('admin.modal-image')

@endsection
@section('footer')
{!! JsValidator::formRequest('App\Http\Requests\StoreTeamRequest', '#form-team'); !!}
<script>
  $('#form-team').submit(function (e) {
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
        notifySuccess('Team successfully added.');
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
