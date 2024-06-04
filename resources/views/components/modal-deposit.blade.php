<!-- Modal Deposit / Subscribe-->
<div class="modal fade" id="modalInfo" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalInfoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark">
      <div class="modal-header">
        <h5 class="modal-title " id="staticBackdropLabel" style="text-transform:unset ">{!!
          __('messages.text_deposit_in_me88_to_unlock')
          !!}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-5">
        <div class="text-center">
          <h2 class="text-uppercase">{{
            __('messages.text_our_plan')
            }} </h2>
          <p>{{
            __('messages.text_plan_desc')
            }}
          </p>
        </div>
      </div>
      <div class="modal-footer justify-content-center ">
        <div class="d-flex flex-row  justify-content-center align-items-center">
          <a href="https://me88cash.com/register?affid=5678" class="afflink btn  btn-primary mr-3">{{
            __('messages.text_deposit_50')
            }}</a>
          <button type="button" class="btn  btn-default" id="btnUpload">
            {{
            __('messages.btn_upload_receipt')
            }}
          </button>
        </div>
      </div>
    </div>
  </div>
</div>