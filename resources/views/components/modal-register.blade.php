<div class="modal fade" id="modalRegister" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalRegisterLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content bg-dark">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">REGISTER</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-5">
        <form method="POST" id="form-register" action="{{route('register')}}">
          @csrf
          <div class="d-flex justify-content-center self-align-center mb-4">
            <img src="{{asset('../images/logo.png')}}" style="max-height: 30px" />
          </div>
          <input type="hidden" name="status" value="1" />
          <div class="form-group">
            <label for="inputUsername">Username</label>
            <input type="text" class="form-control" id="inputUsername" name="username">
          </div>
          <div class="form-group">
            <label for="inputEmail">Email</label>
            <input type="email" class="form-control" id="inputEmail" name="email">
          </div>
          {{-- <div class="form-group">
            <label for="inputPhone">Phone</label>
            <input type="text" class="form-control" id="inputPhone" name="phone">
          </div> --}}
          <div class="form-group">
            <label for="inputPassword">Password</label>
            <input type="password" class="form-control" id="inputPassword" name="password">
          </div>

          <div class="form-group">
            <label for="inputConfirmPassword">Confirm Password</label>
            <input type="password" class="form-control" id="inputConfirmPassword" name="password_confirmation">
          </div>
          <div class="d-flex align-items-center justify-content-end my-4">
            {{-- <button type="button" class="btn btn-default mr-1" data-dismiss="modal">
              Close
            </button> --}}
            <button type="submit" class="btn btn-block btn-primary" id="btn-register">Submit</button>

          </div>
        </form>
      </div>
      <div class="modal-footer justify-content-start">
        <div class="d-flex justify-content-start align-items-center">

          Already have account? &nbsp;
          <a href="#" class="text-success btnSignIn">Sign in</a>
        </div>
      </div>


    </div>
  </div>
</div>