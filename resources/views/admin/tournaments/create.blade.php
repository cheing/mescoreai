@extends('layouts.admin')
@section('title', 'New Tournament')
@section('content')
    <div class="row">
      <div class="col-lg-12 col-sm-12 grid-margin">
        <!-- form -->

        <form method="post" id="form-tournament" action="{{url('admin/tournaments')}}" enctype="multipart/form-data"  class="forms-sample">

            @csrf
        <div class="card">
          <div class="card-header header-sm ">
            <div class="d-flex ">
                <div class="wrapper d-flex align-items-center">
                  <h2 class="card-title mb4">New Tournament</h2>
                </div>
                <div class="wrapper ml-auto action-bar">
                  <button type="submit" data-toggle="tooltip" data-placement="top" data-original-title="Save" class="btn btn-icons btn-success btn-sm"><i class="fa fa-save"></i></button>
                  <a class="btn btn-icons btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" data-original-title="Back"  href="{{url('/admin/tournaments')}}"><i class="fa fa-close"></i></a>
                </div>
            </div>
          </div><!--//card-header-->
          <div class="card-body">

            <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="title">Title</label>
                    <div class="col-md-9">
                        <input id="title" type="text" class="form-control " name="title"   />
                   </div><!--//col-->
                </div>
              </div><!--//col-->

              <div class="col-md-6">
                 <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="status">Status</label>
                    <div class="col-md-9">
                      <select name="status" class="form-control ">
                        @foreach($statuses as $k=>$v)
                           <option value="{{$k}}" >{{$v}}</option>
                        @endforeach
                      </select>
                    </div><!--//col-->
                 </div><!--//form-group-->
               </div>


              <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="start_date">Date Start </label>
                    <div class="col-md-9">
                      <div class="input-group ">
                        <input id="start_date" type="text" class="form-control date" name="start_date"  data-date-format="YYYY-mm-dd" placeholder="YYYY-MM-DD" value="" />
                        <div class="input-group-append">
                             <span> <i class="fa fa-calendar"></i></span>
                        </div>
                      </div>
                   </div><!--//col-->
                </div>
              </div><!--//col-->

              <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="end_date ">Date End </label>
                    <div class="col-md-9">
                      <div class="input-group ">
                        <input id="end_date" type="text" class="form-control date" name="end_date"  data-date-format="YYYY-mm-dd" placeholder="YYYY-MM-DD" value="" />
                        <div class="input-group-append">
                             <span> <i class="fa fa-calendar"></i></span>
                        </div>
                      </div>
                   </div><!--//col-->
                </div>
              </div><!--//col-->

              <div class="col-md-6">
                 <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="input-sort">Sort</label>
                    <div class="col-md-9">
                      <input id="input-sort" type="text" class="form-control " name="sort"   />

                    </div><!--//col-->
                 </div><!--//form-group-->
               </div>

              
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
{!! JsValidator::formRequest('App\Http\Requests\StoreTournamentRequest', '#form-tournament'); !!}
<script>
  $('#form-tournament').submit(function (e) {
      e.preventDefault();
      if (!$(this).valid()) return false;
      var _btn = $('button[type=submit]', this);
      startSpin(_btn);
      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: this.action,
          type: this.method,
          data: $(this).serialize(),
      }).fail(function(xhr, text, err) {
        var error = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error';
         notifySystemError(error);
      }).done(function(data) {
        if (data.data && data.data.id) {
           notifySuccess('Tournament successfully added.');
           setTimeout(function(){
            location.href = `{{ url('admin/tournaments') }}/${data.data.id}/edit`;
            }, 2000);
        }
      
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
 }).done(function(data) {
  if (data['path']) {
            // Update the correct field and image based on the item being uploaded
            if (currentUploadItem === 'banner') {
                $('#input-banner').val(data['path']);
                $('#banner_url').attr('src', data['url']);
            } else if (currentUploadItem === 'plan') {
                $('#input-plan').val(data['path']);
                $('#plan_url').attr('src', data['url']);
            }
            notifySuccess('Image uploaded');
        } else {
            notifySystemError(data['error']);
        }
 }).fail(function(xhr, text, err) {
    notifySystemError(err);
 }).always(function() {
     stopSpin(_btn);
    $('#modalImage').modal('hide');
    resetDropify();
 });
});

// Reset Dropify after modal close
function resetDropify() {
    var drEvent = $('#photo').dropify();
    drEvent = drEvent.data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();
}

$(document).ready(function() {
    // Generic remove function for both banner and plan
    $('.btn-remove-image').on('click', function() {
        var targetImage = $(this).data('target-image');
        var targetInput = $(this).data('target-input');

        // Clear the hidden input value
        $(targetInput).val('');
        // Reset the image to the default placeholder
        $(targetImage).attr('src', '{{ asset('images/no_image.jpg') }}');
    });
});

</script>
@endsection
