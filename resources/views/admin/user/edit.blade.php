@extends('layouts.admin')
@section('title', 'Edit User')
@section('content')
<div class="row">
  <div class="col-lg-8 col-sm-8 grid-margin">
    <div class="card">
      <form method="post" id="form-user" action="{{url('admin/user/edit')}}">
          @csrf
        <input type="hidden" name="id" value="{{$vm->dto->id}}" />
      <div class="card-header header-sm ">
        <div class="d-flex ">
            <div class="wrapper d-flex align-items-center">
              <h2 class="card-title mb4  ">Edit User</h2>
            </div>
            <div class="wrapper ml-auto action-bar">
              <button type="submit" class="btn btn-icons btn-success btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="Save"><i class="fa fa-save"></i></button>
              <button  type="button" class="btn btn-icons btn-danger btn-sm" id="btnDelete"  data-toggle="modal" data-target="#modalConfirmDelete">
                <i class="fa fa-trash"></i>
              </button>
              <a class="btn btn-icons btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" data-original-title="Back"  href="{{url('/admin/users')}}"><i class="fa fa-close"></i></a>
            </div>
        </div>
      </div><!--//card-header-->
      <div class="card-body">
        <!-- form -->

          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                  <label class="col-md-3 col-form-label" for="username">Username </label>
                  <div class="col-md-9">
                    <input type="text" class="form-control"  name="name"  value="{{$vm->dto->username}}" disabled/>
                 </div><!--//col-->
              </div>
            </div><!--//col-->

             <div class="col-md-6">
               <div class="form-group row">
                  <label class="col-md-3 col-form-label" for="status">Status</label>
                  <div class="col-md-9">
                    <select name="status" class="form-control ">
                      @foreach($vm->GetStatuses() as $k=>$v)
                        @if($k == $vm->dto->status_id)
                         <option value="{{$k}}" selected>{{$v}}</option>
                        @else
                         <option value="{{$k}}">{{$v}}</option>
                        @endif
                      @endforeach
                    </select>
                  </div><!--//col-->
               </div><!--//form-group-->
             </div>

          </div><!--row-->

          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-md-3 col-form-label" for="name">Name</label>
                <div class="col-md-9">
                  <input type="text" class="form-control"  name="name" placeholder="" required value="{{$vm->dto->name}}" />
                </div><!--//col-->
              </div><!--//form-group-->
            </div>

            <div class="col-md-6">
               <div class="form-group row">
                  <label class="col-md-3 col-form-label" for="email">Email</label>
                  <div class="col-md-9">
                     <input type="email" class="form-control" name="email" placeholder="" required value="{{$vm->dto->email}}"  />
                  </div><!--//col-->
                </div><!--//form-group-->
            </div>
          </div><!--row-->

        </form>
        <!-- // form-->
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-sm-4 grid-margin">
      <div class="card">
        <div class="card-header header-sm">
          <div class="wrapper d-flex align-items-center">
            <h2 class="card-title">Change Password</h2>
          </div>
        </div>
        <div class="card-body">
          <!-- form -->
          <form method="POST" id="form-password" action="{{url('/admin/user/reset')}}" >
            @csrf
           <input type="hidden" name="id" value="{{$vm->dto->id}}" />

           <div class="form-group row">
             <label class="col-md-3 col-form-label" for="password">Password</label>
             <div class="col-md-9">
               <input type="password" class="form-control"  name="password" placeholder="" required maxlength="50"/>
             </div>
           </div><!-- form-group-->
          <div class="form-group row">
             <label class="col-md-3 col-form-label" for="password2">Confirm Password</label>
             <div class="col-md-9">
               <input type="password" class="form-control" name="password2" placeholder="" required maxlength="50" />
             </div>
          </div><!-- form-group-->
          <div class="row justify-content-end">
             <div class="col-md-9">
               <button class="btn btn-primary btn-block btn-fw" id="btnReset" type="button">
                 <i class="fa fa-lock"></i>Change Password
               </button>
             </div>
           </div>
         </form>
         <!-- // form-->
        </div><!--card-body-->
      </div><!--card-->
    </div>
</div><!-- row -->

<form method="POST" id="form-delete" action="{{url('admin/user/delete')}}">
  @csrf
  <input type="hidden" name="id" value="{{$vm->dto->id}}" />
</form>
<!-- // form-->
<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDeleteLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="modalConfirmDeleteLabel">Confirm Delete User</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
               <p>Are you sure you want to delete this user?</p>
           </div>
           <div class="modal-footer">
               <button id="btnModalConfirmDeleteOK" class="btn btn-primary">Yes</button>
               <button data-dismiss="modal" class="btn btn-secondary">No</button>
           </div>
       </div>
   </div>
</div>
@endsection
@section('footer')
{!! JsValidator::formRequest('App\Http\Requests\Admin\UserInfoRequest', '#form-user'); !!}
{!! JsValidator::formRequest('App\Http\Requests\Admin\ResetUserPasswordRequest', '#form-password'); !!}
<script>
$('#form-user').submit(function (e) {
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
      notifySuccess('User updated');
    setTimeout(function(){ location.href='{{url('/admin/users')}}'; }, 2000);
    }).always(function() {
        stopSpin(_btn);
    });
});

$('#btnModalConfirmDeleteOK').on('click', function() {
   //$('#form-delete').submit();
//  e.preventDefault();
   if (!$('#form-delete').valid()) return false;

   startSpin($('#btnDelete'));
   $.ajax({
       url: '{{url('admin/user/delete')}}',
       type: 'POST',
       data: $('#form-delete').serialize(),
   }).fail(function(xhr, text, err) {
      notifySystemError(err);
   }).done(function(data) {
     $('#modalConfirmDelete').modal('hide');
     if(data['error']){
       notifySystemError(data['error']);
     }else{
       notifySuccess('User deleted');
       setTimeout(function(){ location.href='{{url('/admin/users')}}'; }, 2000);
     }


   }).always(function() {
       stopSpin($('#btnDelete'));
   });
});

$('#btnReset').on('click', function() {
    if (!$('#form-password').valid()) return false;
     startSpin($('#btnReset'));
    $.ajax({
        url: '{{url('admin/user/reset')}}',
        type: 'POST',
        data: $('#form-password').serialize(),
    }).fail(function(xhr, text, err) {
       notifySystemError(err);
    }).done(function(data) {
      notifySuccess('Password Changed');
      setTimeout(function(){ location.href='{{url('/admin/users')}}'; }, 2000);
    }).always(function() {
        stopSpin(_btn);
    });
});
</script>
@endsection
