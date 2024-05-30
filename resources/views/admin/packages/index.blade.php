@extends('layouts.admin')
@section('title', 'Package Listing')
@section('content')
<div class="row">
  <div class="col-lg-12 col-sm-12">
    <div class="card">
      <div class="card-header header-sm">
        <div class="d-flex align-items-center">
          <div class="wrapper d-flex align-items-center">
            <h2 class="card-title ">Package Listing</h2>
          </div>
          <div class="wrapper ml-auto action-bar">
            <a href="{{route('packages.create')}}" class="btn btn-success btn-block"><i class="fa fa-plus"></i> New
              Package</a>
          </div>
        </div>
      </div>
      <div class="card-body">

        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th style="width:10%"></th>
                <th>@sortablelink('name', 'Name')</th>
                <th class="text-left w-1">@sortablelink('duration', 'Duration')</th>
                <th class="text-left w-1">@sortablelink('sort', 'Sort')</th>
              </tr>
            </thead>
            <tbody>
              @foreach($packages as $package)
              <tr>
                <td>
                  <a href="{{ url('admin/packages/' . $package->id . '/edit') }}"
                    class="btn btn-icons btn-success btn-action"><i class="fa fa-pencil"></i></a>
                  <button type="button" class="btn btn-icons btn-danger  btn-delete" data-id="{{$package->id}}"><i
                      class="fa fa-trash"></i></button>
                </td>
                <td>{{$package->name}} </td>
                <td class="text-left w-1">{{$package->duration}} </td>
                <td class="text-left w-1">{{$package->sort}} </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="mt-5">
            {{ $packages->appends(request()->except('page'))->links('vendor.pagination.custom') }}

          </div>
        </div>
        <!--table-responsive-->
      </div>
    </div>
  </div>
</div>

<form method="DELETE" id="form-delete" action="{{url('admin/package/delete')}}">
  @csrf
  <input type="hidden" id="id" name="id" value="" />
</form>
<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDeleteLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalConfirmDeleteLabel">Confirm Delete Package</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this package?</p>
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
    var packageId = $(this).attr('data-id');
    var deleteUrl = '{{ url('admin/packages') }}/' + packageId;
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
         notifySuccess('Package deleted!');
         setTimeout(function(){ location.href='{{route('packages.index')}}'; }, 2000);
       }
     }).always(function() {
     });

    });

  });

</script>

@endsection