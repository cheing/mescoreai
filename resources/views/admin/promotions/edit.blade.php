@extends('layouts.admin')
@section('title', 'Edit Promotion')
@section('content')
<div class="row">
  <div class="col-lg-12 col-sm-12 grid-margin">

    <form method="POST" id="form-promotion" action="{{ url('admin/promotions/' . $promotion->id) }}"
      enctype="multipart/form-data" class="forms-sample">
      @csrf
      @method('PUT')

      <div class="card">
        <div class="card-header header-sm ">
          <div class="d-flex ">
            <div class="wrapper d-flex align-items-center">
              <h2 class="card-title mb4">Edit Promotion</h2>
            </div>
            <div class="wrapper ml-auto action-bar">
              <button type="submit" data-toggle="tooltip" data-placement="top" data-original-title="Save"
                class="btn btn-icons btn-success btn-sm"><i class="fa fa-save"></i></button>
              <a class="btn btn-icons btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top"
                data-original-title="Back" href="{{route('promotions.index')}}"><i class="fa fa-close"></i></a>
            </div>
          </div>
        </div>

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
                <input type="text" name="title_{{$lang['code']}}" class="form-control" placeholder="{{$lang['name']}}"
                  value="{{ $promotion->{'title_'.$lang['code']} ?? '' }}" />
              </div>
              @endforeach
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Short Description</label>
            <div class="col-md-10">
              @foreach($languages as $lang)
              <div class="input-group mb-1">
                <div class="input-group-prepend">
                  <span class="input-group-text"><span class="flag-icon flag-icon-{{$lang['flag']}}"></span></span>
                </div>
                <textarea name="short_description_{{$lang['code']}}" class="form-control" rows="3"
                  placeholder="{{$lang['name']}}">{{ $promotion->translations->where('locale', $lang['code'])->first()->short_description ?? '' }}</textarea>
              </div>
              @endforeach
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="input-url">Redirect URL</label>
            <div class="col-md-10">
              <input type="text" class="form-control" id="input-url" name="redirect_url"
                value="{{ $promotion->redirect_url }}" placeholder="https://example.com/promotion" />
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="image ">Image</label>
            <div class="col-md-10 d-flex align-items-center">
              <div class="user-avatar mb-auto">
                <img
                  src="{{ $promotion->thumbnail ? asset('storage/'.$promotion->thumbnail) : asset('images/no_image.jpg') }}"
                  alt="Promotion Image" class="profile-img img-lg rounded-circle" id="thumbnail_url" />
                <span class="edit-avatar-icon" data-toggle="modal" data-target="#modalImage">
                  <i class="mdi mdi-upload"></i>
                </span>
              </div>
              <input type="hidden" name="thumbnail" value="{{ $promotion->thumbnail }}" id="input-thumbnail" />
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="sort">Sort</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="sort" placeholder="" required
                value="{{ $promotion->sort }}" />
            </div>
            <!--//col-->
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="status">Status</label>
            <div class="col-md-10">
              <select name="status" class="form-control">
                @foreach($statuses as $k => $v)
                <option value="{{ $k }}" {{ $promotion->status == $k ? 'selected' : '' }}>
                  {{ $v }}
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
{!! JsValidator::formRequest('App\Http\Requests\UpdatePromotionRequest', '#form-promotion'); !!}

<script>
  $('#form-promotion button[type=submit]').on('click', function(e) {
  e.preventDefault();

  var form = $('#form-promotion');
  if (!form.valid()) return false; // Still works with JsValidator

  var _btn = $('button[type=submit]', this);
  startSpin(_btn);

  var formData = new FormData(form[0]);
  formData.append('_method', 'PUT');

  $.ajax({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    url: form.attr('action'),
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
  }).fail(function(xhr) {
    var error = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error';
    notifySystemError(error);
  }).done(function(data) {
    notifySuccess('Promotion successfully updated.');
    setTimeout(function() {
      location.href = '{{route('promotions.index')}}';
    }, 2000);
  }).always(function() {
    stopSpin(_btn);
  });
});

// Upload image
$('#btnUploadImage').on('click', function() {
  if (!$('#form-image').valid()) return false;
  var formData = new FormData($('#form-image')[0]);
  var _btn = $('#btnUploadImage', this);
  startSpin(_btn);
  $.ajax({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    url: '{{route('upload.image')}}',
    type: 'POST',
    data: formData,
    enctype: 'multipart/form-data',
    contentType: false,
    processData: false,
  }).fail(function(xhr, text, err) {
    notifySystemError(err);
  }).done(function(data) {
    if (data['path']) {
      $('#input-thumbnail').val(data['path']);
      $('#thumbnail_url').attr('src', data['url']);
      notifySuccess('Image uploaded');
      $('#modalImage').modal('hide');
    } else {
      notifySystemError(data['error']);
    }
  }).always(function() {
    stopSpin(_btn);
  });
});
</script>
@endsection