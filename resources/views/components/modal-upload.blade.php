<div class="modal fade" id="modalSubscription" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalSubscriptionLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content bg-dark">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">UPLOAD RECEIPT
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-5">
        {{-- <h2>Upload Receipt</h2> --}}
        <p>
          After deposit in me88 please fill in your receipt and me88’s username here.
        </p>
        <form method="POST" id="form-upload" action="{{ route('upload-receipt') }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="inputUsername">me88 Username</label>
            <input type="text" class="form-control" id="inputme88Username" name="me88Username">
          </div>
          <div class="form-group">
            <label for="inputUsername">Username</label>
            <input type="text" class="form-control" id="inputUsername" name="username">
          </div>
          <div class="form-group">
            <label for="inputEmail">Email</label>
            <input type="email" class="form-control" id="inputEmail" name="email">
          </div>
          <div class="form-group">
            <label for="inputFile">Upload</label>
            <input type="file" class="form-control" name="file" />
          </div>
          <div class="d-flex align-items-center justify-content-end my-4">
            <button type="submit" class="btn btn-block btn-primary" id="btn-upload">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>