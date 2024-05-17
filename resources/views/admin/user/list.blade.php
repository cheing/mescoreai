@extends('layouts.admin')
@section('title', 'User Listing')
@section('content')
<div class="row">
<div class="col-lg-12 col-sm-12">
  <div class="card">
    <div class="card-header header-sm">
      <div class="d-flex align-items-center">
        <div class="wrapper d-flex align-items-center">
          <h2 class="card-title ">User Listing</h2>
        </div>
        <div class="wrapper ml-auto action-bar">
            <a href="{{url('admin/user/add')}}" class="btn btn-success btn-block"><i class="fa fa-plus"></i> New User</a>
        </div>
      </div>
    </div>
    <div class="card-body">

      <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr >
                  <th style="width:10%"></th>
                  <th style="width:10%" class="text-center">@sortablelink('status', ' Status')</th>
                  <th>@sortablelink('username', ' Username')</th>
                  <th>@sortablelink('name', ' Name')</th>
                  <th>@sortablelink('email', ' Email')</th>
                </tr>
              </thead>
              <tbody>

                @foreach($vm->dto as $user)
                <tr>
                  <td>
                      <a href="{{url('admin/user/edit/'.$user->id.'')}}" class="btn  btn-icons btn-success btn-action "><i class="fa fa-pencil"></i></a>
                      <button type="button" class="btn btn-icons btn-danger  btn-delete" data-id="{{$user->id}}"><i class="fa fa-trash"></i></button>
                  </td>
                  <td class="text-center">{!! $user->status !!} </td>
                  <td>{{$user->username}} </td>
                  <td>{{$user->name}} </td>
                  <td>{{$user->email}}</td>
                </tr>

               @endforeach

              </tbody>

          </table>
          <div class="mt-5">
            {{$vm->paging->links()}}
          </div>
      </div><!--table-responsive-->
    </div>
  </div>
</div>
</div>

<form method="POST" id="form-delete" action="{{url('admin/user/delete')}}">
@csrf
<input type="hidden" id="id" name="id" value="" />

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
<script>
$('.btn-delete').on('click', function() {
   $('#modalConfirmDelete').modal();
   $('#id').val($(this).attr('data-id'));
 });


 $('#btnModalConfirmDeleteOK').on('click', function() {
     if (!$('#form-delete').valid()) return false;

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
         notifySuccess('User deleted!');
         setTimeout(function(){ location.href='{{url('admin/users')}}'; }, 2000);
       }

     }).always(function() {
     });
 });
</script>

@endsection
