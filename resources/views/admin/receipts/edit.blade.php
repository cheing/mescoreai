@extends('layouts.admin')
@section('title', 'Edit Receipt')
@section('content')
<div class="row">
  <div class="col-lg-12 col-sm-12 grid-margin">
    <!-- form -->
    <form method="post" id="form-receipt" action="{{ url('admin/receipts/' . $receipt->id) }}"
      enctype="multipart/form-data" class="forms-sample">

      @csrf

      <div class="card">
        <div class="card-header header-sm ">
          <div class="d-flex ">
            <div class="wrapper d-flex align-items-center">
              <h2 class="card-title mb4">Edit Receipt</h2>
            </div>
            <div class="wrapper ml-auto action-bar">
              @if(!$receipt->processed)
              <button type="button" class="btn btn-icons btn-primary btn-sm" data-toggle="modal"
                data-target="#modalSubscribe"><span data-toggle="tooltip" data-placement="top"
                  data-original-title="Enable Subscription"><i class="fa fa-unlock"></i></span></button>
              @endif
              <button type="submit" data-toggle="tooltip" data-placement="top" data-original-title="Save"
                class="btn btn-icons btn-success btn-sm"><i class="fa fa-save"></i></button>
              <a class="btn btn-icons btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top"
                data-original-title="Back" href="{{route('receipts.index')}}"><i class="fa fa-close"></i></a>
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
                @if($user->id == $receipt->user_id)
                <option value="{{$user->id}}" selected>{{$user->username}}</option>
                @else
                <option value="{{$user->id}}">{{$user->username}}</option>
                @endif
                @endforeach
              </select>
            </div>
            <label class="col-md-2 col-form-label" for="input-username">me88 Username</label>
            <div class="col-md-4">
              <input type="text" class="form-control" id="input-username" name="username" placeholder="" required
                value="{{$receipt->username}}" />
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="input-email">Email</label>
            <div class="col-md-4">
              <input type="text" class="form-control" id="input-email" name="email" placeholder="" required
                value="{{$receipt->email}}" />
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="input-image">Receipt</label>
            <div class="col-md-9 d-flex ">
              <div class="user-avatar mb-auto">

                @php
                $fileExtension = strtolower(pathinfo($receipt->file_path, PATHINFO_EXTENSION));
                @endphp

                @if($receipt->file_path)
                @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                <!-- Display as image -->
                <a class="lightbox-image" data-lightbox="gallery"
                  href="{{ Storage::disk('public')->url($receipt->file_path) }}" target="_blank">
                  <img src="{{ Storage::disk('public')->url($receipt->file_path) }}" alt="profile image"
                    class="profile-img img-lg rounded-circle" id="image_url" />
                </a>
                @elseif($fileExtension === 'pdf')
                <!-- Download PDF -->
                <a href="{{ Storage::disk('public')->url($receipt->file_path) }}" target="_blank">
                  <span class="profile-img img-lg rounded-circle d-flex justify-content-center align-items-center"
                    style="background:#eee; color:#333">
                    <i class="fa fa-file-pdf-o"></i>
                  </span>
                  {{-- <img src="{{ asset('images/pdf_icon.png')}}" alt="PDF file"
                    class="profile-img img-lg rounded-circle" />
                  Download PDF --}}
                </a>
                @endif
                @else
                <!-- No file uploaded -->
                <a class="lightbox-image" data-lightbox="gallery" href="{{ asset('images/no_image.jpg') }}"
                  target="_blank">
                  <img src="{{ asset('images/no_image.jpg')}}" alt="profile image"
                    class="profile-img img-lg rounded-circle" id="image_url" />
                </a>
                @endif

                {{-- @if($receipt->file_path)
                <a class="lightbox-image" data-lightbox="gallery"
                  href="{{ Storage::disk('public')->url($receipt->file_path) }}" target="_blank">
                  <img src="{{ Storage::disk('public')->url($receipt->file_path) }}" alt="profile image"
                    class="profile-img img-lg rounded-circle" id="image_url" /></a>

                @else
                <a class="lightbox-image" data-lightbox="gallery" href="{{ asset('images/no_image.jpg') }}"
                  target="_blank">
                  <img src="{{ asset('images/no_image.jpg')}}" alt="profile image"
                    class="profile-img img-lg rounded-circle" id="image_url" /></a>
                @endif --}}
                <span class="edit-avatar-icon" data-toggle="modal" data-target="#modalImage"><i
                    class="mdi mdi-upload"></i></span>
              </div>
              <input type="hidden" name="file_path" value="{{$receipt->file_path}}" id="input-file-path" />
            </div>
          </div>
          <!--//form-group-->
        </div>
        <!--//card-body-->
      </div>

    </form>
    <!-- // form-->
  </div>
</div>
@include('admin.modal-image')
@include('admin.modal-subscribe')
@endsection
@section('footer')
{!! JsValidator::formRequest('App\Http\Requests\UpdateReceiptRequest', '#form-receipt'); !!}
{!! JsValidator::formRequest('App\Http\Requests\StoreSubscriptionRequest', '#form-subscribe'); !!}

<script>
  $('#form-receipt').submit(function (e) {
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

          url: '{{ url('admin/receipts/' . $receipt->id) }}',
          type: 'POST',
          data: formData,
          processData: false, // 不处理发送的数据
          contentType: false, // 不设置内容类型
      }).fail(function(xhr) {
         var error = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error';
         notifySystemError(error);
      }).done(function(data) {
        notifySuccess('Receipt successfully update.');
        setTimeout(function(){ location.href='{{url('admin/receipts')}}'; }, 2000);
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
        $('#input-file-path').val(data['path']);
        $('#image_url').attr('src', data['url']);
        notifySuccess('Image upload');
        $('#modalImage').modal('hide');
        var drEvent = $('#file_path').dropify();
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
  //Subscribe
  
$('#btnSubscribe').on('click', function() {
  if (!$('#form-subscribe').valid()) return false;
  var formData = new FormData($('#form-subscribe')[0]);
  var _btn = $('#btnSubscribe', this);
  startSpin(_btn);
  $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '{{ url('admin/subscriptions/') }}',
      type: 'POST',
      data:formData,
      contentType: false,
      processData: false,
  }).fail(function(xhr, text, err) {
    var error = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error';
         notifySystemError(error); 
  }).done(function(data) {
     notifySuccess('Subscription successfully create.');

        setTimeout(function(){ location.href='{{url('admin/subscriptions')}}'; }, 2000);
  }).always(function() {
      stopSpin(_btn);
  });
  });
  
</script>
@endsection