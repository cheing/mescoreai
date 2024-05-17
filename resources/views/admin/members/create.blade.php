@extends('layouts.admin')
@section('title', 'New User')
@section('content')
    <div class="row">
      <div class="col-lg-12 col-sm-12 grid-margin">
        <!-- form -->
        <form method="post" id="form-member" action="{{url('admin/members')}}" class="forms-sample">
            @csrf
        <div class="card">
          <div class="card-header header-sm ">
            <div class="d-flex ">
                <div class="wrapper d-flex align-items-center">
                  <h2 class="card-title mb4">New member</h2>
                </div>
                <div class="wrapper ml-auto action-bar">
                  <button type="submit" data-toggle="tooltip" data-placement="top" data-original-title="Save" class="btn btn-icons btn-success btn-sm"><i class="fa fa-save"></i></button>
                  <a class="btn btn-icons btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" data-original-title="Back" href="{{route('members.index')}}"><i class="fa fa-close"></i></a>
                </div>
            </div>
          </div><!--//card-header-->
          <div class="card-body">

          

            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-md-3 col-form-label" for="username">Username</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control"  name="username" placeholder="" required/>
                  </div>
                </div>
               </div><!--//col-->

              <!-- <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-md-3 col-form-label" for="name">Name</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control"  name="name" placeholder="" required/>
                  </div>
                </div>
              </div> -->

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
                    <label class="col-md-3 col-form-label" for="email">Email</label>
                    <div class="col-md-9">
                       <input type="email" class="form-control" name="email" placeholder="" required />
                    </div><!--//col-->
                  </div><!--//form-group-->
              </div>

              <div class="col-md-6">

                <div class="form-group row">
                      <label class="col-md-3 col-form-label" for="phone">Phone</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" name="phone" placeholder="" required />
                      </div><!--//col-->
                    </div><!--//form-group-->
                </div>
            </div><!--row-->

            <div class="row">

              <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="password">Password</label>
                    <div class="col-md-9">
                      <input type="password" class="form-control"  name="password" placeholder="" required maxlength="50"/>
                    </div><!--//col-->
                 </div><!-- form-group-->
              </div><!--//col-->

               <div class="col-md-6">
                 <div class="form-group row">
                     <label class="col-md-3 col-form-label" for="password_confirmation">Confirm Password</label>
                     <div class="col-md-9">
                       <input type="password" class="form-control" name="password_confirmation" placeholder="" required maxlength="50" />
                     </div><!--//col-->
                 </div><!-- form-group-->
               </div><!--//col-->
            </div><!--//row-->


            <div class="row">

            <div class="col-md-6">
               <div class="form-group row">
                  <label class="col-md-3 col-form-label" >Subscribe</label>
                  <div class="col-md-9">
                  <div class="form-check form-check-flat">
                              <label class="form-check-label" for="input-subscribe" >
                                <input type="checkbox"id="input-subscribe" value="1" name="subscribe"  class="form-check-input"> Yes </label>
                            </div>
                  </div><!--//col-->
                </div><!--//form-group-->
            </div>

            
            <div class="col-md-6">
              <div class="form-group row">
                  <label class="col-md-3 col-form-label" for="me88username">me88 Username </label>
                  <div class="col-md-9">
                    <input type="text" class="form-control"  name="me88username"   />
                 </div><!--//col-->
              </div>
            </div><!--//col-->

            </div><!--row-->

          </div><!--//card-body-->
        </div>

      </form>
      <!-- // form-->
      </div>
    </div>

@endsection
@section('footer')
{!! JsValidator::formRequest('App\Http\Requests\StoreMemberRequest', '#form-member'); !!}
<script>
  $('#form-member').submit(function (e) {
      e.preventDefault();
      if (!$(this).valid()) return false;
      var _btn = $('button[type=submit]', this);
      startSpin(_btn);
      $.ajax({
          url: this.action,
          type: this.method,
          data: $(this).serialize(),
      }).fail(function(xhr, text, err) {
         notifySystemError(err);
      }).done(function(data) {
        notifySuccess('Member successfully added.');
        setTimeout(function(){ location.href=`{{route('members.index')}}`; }, 2000);
      }).always(function() {
          stopSpin(_btn);
      });
  });
</script>
@endsection
