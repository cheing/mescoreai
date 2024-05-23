<div class="modal fade " id="modalLogin" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalLoginLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark ">
      <!-- form -->
      <form method="POST" id="form-login" action="{{route('member-login')}}">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title " id="staticBackdropLabel">{{
            __('messages.text_login')
            }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-5">
          <div class="d-flex justify-content-center self-align-center mb-4">
            <img src="{{asset('../images/logo.png')}}" style="max-height: 30px" />
          </div>

          <div class="form-group">
            <label for="inputUsername1">{{
              __('messages.text_username')
              }}</label>
            <input type="text" class="form-control" id="inputUsername1" name="username" />
          </div>
          <div class="form-group">
            <label for="inputPassword1">{{
              __('messages.text_password')
              }}</label>
            <input type="password" class="form-control" id="inputPassword1" name="password">
          </div>
          <div class="d-flex align-items-center justify-content-end my-4">

            <button id="btn-login" type="submit" class="btn btn-block btn-primary">{{
              __('messages.btn_submit')
              }}</button>

          </div>
        </div>
        <div class="modal-footer justify-content-start">
          <div class="d-flex justify-content-start align-items-center">
            {{
            __('messages.text_dont_have_account')
            }} &nbsp;
            <a href="#" class="text-success" id="btnSignUp">{{
              __('messages.text_sign_up')
              }} </a>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>