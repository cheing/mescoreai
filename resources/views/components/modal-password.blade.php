<div class="modal fade " id="modalPassword" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalPasswordLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark ">
      <!-- form -->
      <form method="POST" id="form-password" action="{{ route('change-password') }}">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">{{
            __('messages.text_change_password')
            }} </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-5">
          <div class="form-group">
            <label for="inputCurrentPassword">{{
              __('messages.text_current_password')
              }} </label>
            <input type="password" class="form-control" id="inputCurrentPassword" name="current_password">
          </div>
          <div class="form-group">
            <label for="inputNewPassword">{{
              __('messages.text_password')
              }}</label>
            <input type="password" class="form-control" id="inputNewPassword" name="new_password">
          </div>
          <div class="form-group">
            <label for="inputPassword2">{{
              __('messages.text_confirm_password')
              }} </label>
            <input type="password" class="form-control" id="inputPassword2" name="new_password_confirmation">
          </div>
          <div class="d-flex align-items-center justify-content-end my-4">
            <button id="btn-password" type="submit" class="btn btn-block btn-primary">{{
              __('messages.btn_submit')
              }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>