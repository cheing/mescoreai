@extends('layouts.admin')
@section('title', 'Member Listing')
@section('content')
<div class="row">
  <div class="col-lg-12 col-sm-12">
    <div class="card">
      <div class="card-header header-sm">
        <div class="d-flex align-items-center">
          <div class="wrapper d-flex align-items-center">
            <h2 class="card-title ">Member Listing</h2>
          </div>
          <div class="wrapper ml-auto action-bar">
            <a href="{{route('members.create')}}" class="btn btn-success btn-block"><i class="fa fa-plus"></i> New
              Member</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="page-header-toolbar">
          <form method="GET" action="{{url('/admin/members')}}" style="width:100%">
            <div class="form-group row">
              <div class="col-md-6 col-xs-12">
                <input name="keyword" id="keyword" placeholder="Keyword" class="form-control" value="{{$keyword}}" />
              </div>
              <div class="col-md-1 col-xs-12">
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </form>
        </div>

        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th style="width:10%"></th>
                <th>@sortablelink('username', 'Username')</th>
                <!-- <th>@sortablelink('name', 'Name')</th> -->
                <th>@sortablelink('name', 'Email')</th>
                <th class="text-center">@sortablelink('status', 'Status')</th>
                <th class="text-center">@sortablelink('subscribe', 'Subscribe ')</th>

                <th>@sortablelink('created_at', 'Created on')</th>

              </tr>
            </thead>
            <tbody>
              @foreach($members as $member)

              <tr>
                <td>
                  <a href="{{ url('admin/members/' . $member->id . '/edit') }}"
                    class="btn btn-icons btn-success btn-action"><i class="fa fa-pencil"></i></a>
                  <button type="button" class="btn btn-icons btn-danger  btn-delete" data-id="{{$member->id}}"><i
                      class="fa fa-trash"></i></button>
                </td>
                <td>{{$member->username}} </td>
                <!-- <td >{{$member->name}} </td> -->
                <td>{{$member->email}} </td>


                <td class="text-center">
                  @if($member->status)
                  <span class="badge badge-success">Enable</span>
                  @else
                  <span class="badge badge-danger">Disabled</span>
                  @endif
                </td>
                <td class="text-center">
                  @if($member->subscribe)
                  <span class="badge badge-success">Yes</span>
                  @else
                  <span class="badge badge-danger">No</span>
                  @endif
                </td>
                <td>{{$member->created_at}} </td>


              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="mt-5">
            {{ $members->appends(request()->except('page'))->links('vendor.pagination.custom') }}

          </div>
        </div>
        <!--table-responsive-->
      </div>
    </div>
  </div>
</div>

<form method="DELETE" id="form-delete" action="{{url('admin/members')}}">
  @csrf
  <input type="hidden" id="id" name="id" value="" />
</form>
<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDeleteLabel"
  aria-hidden="true">
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
<script>
  $('.btn-delete').on('click', function() {
    var memberId = $(this).attr('data-id');
    var deleteUrl = '{{ url('admin/members') }}/' + memberId;
    $('#modalConfirmDelete').modal();
    $('#btnModalConfirmDeleteOK').off('click').on('click', function() {
      $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          },
          url: deleteUrl,
         type: 'DELETE',
         data: $('#form-delete').serialize(),
     }).fail(function(xhr, text, err) {
        notifySystemError(err);
     }).done(function(data) {
       $('#modalConfirmDelete').modal('hide');
       if(data['error']){
         notifySystemError(data['error']);
       }else{
         notifySuccess('Member deleted!');
         setTimeout(function(){ location.href='{{route('members.index')}}'; }, 2000);
       }
     }).always(function() {
     });

    });

  });

</script>

@endsection