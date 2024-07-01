@extends('layouts.app')

@section('content')
<div class="main-content innerpagebg wf100">
    <div class="match-results wf100 p40">
        <div class="container">
            <div class="card bg-slate text-white">
                <div class="card-body text-white">
                    <form method="POST" id="form-test" action="{{ route('upload-receipt-email') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="inputUsername">{{
                                __('messages.text_username')
                                }}</label>
                            <input type="text" class="form-control" value="" name="username">
                        </div>
                        <div class="form-group">
                            <label for="inputme88Username">{{
                                __('messages.text_me88_username')
                                }}</label>
                            <input type="text" class="form-control" id="inputme88Username" name="me88Username">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail">{{
                                __('messages.text_email')
                                }}</label>
                            <input type="email" class="form-control" id="inputEmail" name="email">
                        </div>
                        <div class="form-group">
                            <label for="inputFile">{{
                                __('messages.text_upload')
                                }}</label>
                            <input type="file" class="form-control" name="file" />
                        </div>
                        <div class="d-flex align-items-center justify-content-end my-4">
                            <button type="submit" class="btn btn-block btn-primary" id="btn-upload">{{
                                __('messages.btn_submit')
                                }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script>
    $('#form-test').submit(function(e) {
    e.preventDefault();  // Prevent the default form submission behavior
    e.stopPropagation(); // Stop the event from bubbling up the DOM tree
      var _btn = $('#btn-upload');
      if (!$(this).valid()) return false;
      startSpin($(_btn));
      if (_btn.prop('disabled')) {
        // Prevent processing if the button is already disabled
        return false;
    }
 // Disable the button to prevent double clicks
 _btn.prop('disabled', true).text('Processing...');  // Optionally change the button text

      // Use FormData for file upload
      var formData = new FormData(this);
      $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: formData,
        processData: false, // Important for file uploads
        contentType: false, // Important for file uploads
        success: function(data) {
            // notifySuccess('Upload receipt done');
            // Additional actions on success
            if(data.message) {
                notifySuccess(data.message);
                $('#modalSubscription').modal('hide'); // Assuming you have a modal to hide

                // Reload the page after a short delay to show the success message
                setTimeout(function() {
                    window.location.reload();
                }, 1000); // Reload after 2 seconds
            } else if (data.error) {
                notifyError(data.error);
            }
        },
        error: function(xhr) {
            var error = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error';
            notifyError(error);
        },
        complete: function() {
            stopSpin(_btn);
            // Optionally re-enable the button if the form needs to be resubmitted following corrections
            _btn.prop('disabled', false).text('Submit');
        }
      });
  });
</script>
@endsection