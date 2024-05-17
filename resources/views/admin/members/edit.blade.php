@extends('layouts.admin')
@section('title', 'Edit Member')
@section('content')
<div class="row">
  <div class="col-lg-8 col-sm-8 grid-margin">
    <div class="card">
      <form id="form-member" method="POST" action="{{ route('members.update', $member->id) }}">
          @csrf
        <input type="hidden" name="id" value="{{$member->id}}" />
      <div class="card-header header-sm ">
        <div class="d-flex ">
            <div class="wrapper d-flex align-items-center">
              <h2 class="card-title mb4  ">Edit Member</h2>
            </div>
            <div class="wrapper ml-auto action-bar">
              <button type="submit" class="btn btn-icons btn-success btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="Save"><i class="fa fa-save"></i></button>
              <button  type="button" class="btn btn-icons btn-danger btn-sm" id="btnDelete"  data-toggle="modal" data-target="#modalConfirmDelete">
                <i class="fa fa-trash"></i>
              </button>
              <a class="btn btn-icons btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" data-original-title="Back"  href="{{url('/admin/members')}}"><i class="fa fa-close"></i></a>
            </div>
        </div>
      </div><!--//card-header-->
      <div class="card-body">
        <!-- form -->

          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                  <label class="col-md-4 col-form-label" for="username">Username </label>
                  <div class="col-md-8">
                    <input type="text" class="form-control"  name="name"  value="{{$member->username}}" disabled/>
                 </div><!--//col-->
              </div>
            </div><!--//col-->
             <div class="col-md-6">
               <div class="form-group row">
                  <label class="col-md-4 col-form-label" for="status">Status</label>
                  <div class="col-md-8">
                  <select name="status" class="form-control ">
                        @foreach($statuses as $k=>$v)
                          @if($member->status == $k)
                            <option value="{{$k}}" selected>{{$v}}</option>
                          @else                         
                            <option value="{{$k}}" >{{$v}}</option>
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
                  <label class="col-md-4 col-form-label" for="email">Email</label>
                  <div class="col-md-8">
                     <input type="email" class="form-control" name="email" placeholder="" required value="{{$member->email}}"  />
                  </div><!--//col-->
                </div><!--//form-group-->
            </div>

            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-md-4 col-form-label" for="phone">Phone</label>
                <div class="col-md-8">
                  <input type="text" class="form-control"  name="phone" placeholder="" required value="{{$member->phone}}" />
                </div><!--//col-->
              </div><!--//form-group-->
            </div>
          </div><!--row-->

          <div class="row">

            <div class="col-md-6">
               <div class="form-group row">
                  <label class="col-md-4 col-form-label" >Subscribe</label>
                  <div class="col-md-8">
                  <div class="form-check form-check-flat">
                      <label class="form-check-label" for="input-subscribe" >
                      <input type="hidden" value="0" name="subscribe">
        <input type="checkbox" id="input-subscribe" value="1" name="subscribe" class="form-check-input" {{ $member->subscribe ? 'checked' : '' }}> Yes

                        <!-- @if($member->subscribe)
                        <input type="checkbox"  id="input-subscribe" value="1" name="subscribe"  class="form-check-input" checked> Yes </label>
                        @else
                        <input type="checkbox"  id="input-subscribe" value="1" name="subscribe"  class="form-check-input" > Yes </label>

                        @endif -->
                    </div>
                  </div><!--//col-->
                </div><!--//form-group-->
            </div>

            
            <div class="col-md-6">
              <div class="form-group row">
                  <label class="col-md-4 col-form-label" for="me88username">me88 Username </label>
                  <div class="col-md-8">
                    <input type="text" class="form-control"  name="me88username" value="{{$member->me88username}}" />
                 </div><!--//col-->
              </div>
            </div><!--//col-->

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
          <form method="POST" id="form-password" action="{{url('/admin/member/reset')}}" >
            @csrf
           <input type="hidden" name="id" value="{{$member->id}}" />

           <div class="form-group row">
             <label class="col-md-4 col-form-label" for="password">Password</label>
             <div class="col-md-8">
               <input type="password" class="form-control"  name="password" placeholder="" required maxlength="50"/>
             </div>
           </div><!-- form-group-->
          <div class="form-group row">
             <label class="col-md-4 col-form-label" for="password2">Confirm Password</label>
             <div class="col-md-8">
               <input type="password" class="form-control" name="password2" placeholder="" required maxlength="50" />
             </div>
          </div><!-- form-group-->
          <div class="row justify-content-end">
             <div class="col-md-8">
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

<form method="POST" id="form-delete" action="{{url('admin/member/delete')}}">
  @csrf
  <input type="hidden" name="id" value="{{$member->id}}" />
</form>
<!-- // form-->
<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDeleteLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="modalConfirmDeleteLabel">Confirm Delete Member</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
               <p>Are you sure you want to delete this member?</p>
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
{!! JsValidator::formRequest('App\Http\Requests\UpdateMemberRequest', '#form-member'); !!}
{!! JsValidator::formRequest('App\Http\Requests\Admin\ResetUserPasswordRequest', '#form-password'); !!}
<script>
 $('#form-member').submit(function (e) {
      e.preventDefault();
      if (!$(this).valid()) return false;
      var _btn = $('button[type=submit]', this);
      startSpin(_btn);

      // 如果有文件上传，使用 FormData 对象
      var formData = new FormData(this);
      formData.append('_method', 'PATCH');
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          'X-HTTP-Method-Override': 'PUT'
          },
          url: '{{ route('members.update', $member->id) }}',
          type: 'POST',
          data: formData,
          processData: false, // 不处理发送的数据
          contentType: false, // 不设置内容类型
      }).fail(function(xhr) {
         var error = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error';
         notifySystemError(error);
      }).done(function(data) {
        notifySuccess('Member successfully update.');
        setTimeout(function(){ location.href=`{{route('members.index')}}`;  }, 2000);
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
       notifySuccess('Member deleted');
       setTimeout(function(){ location.href=`{{route('members.index')}}`; }, 2000);
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
      setTimeout(function(){ location.href='{{url('/admin/members')}}'; }, 2000);
    }).always(function() {
        stopSpin(_btn);
    });
});
</script>
@endsection
