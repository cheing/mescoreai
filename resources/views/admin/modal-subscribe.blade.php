<!-- subscribe -->
<div class="modal fade" id="modalSubscribe" tabindex="-1" role="dialog" aria-labelledby="modalSubscribeLabel"
  aria-hidden="true">
  <form method="POST" id="form-subscribe" action="{{ url('admin/subscriptions/') }}">
    <div class="modal-dialog modal-dialog-centered " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalSubscribeLabel">Subscribe</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="user_id" value="{{$receipt->user_id}}" />
          <input type="hidden" name="receipt_id" value="{{$receipt->id}}" />
          <div class="form-group row">
            <label class="col-md-3 col-form-label" for="input-package">Package</label>
            <div class="col-md-9">
              <select type="text" class="form-control" id="input-package" name="package_id">
                @foreach($packages as $package)
                <option value="{{$package->id}}">{{$package->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group text-center">
            <button type="button" id="btnSubscribe" class="btn btn-success">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>