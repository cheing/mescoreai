@extends('layouts.admin')
@section('title', 'Promotions ')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header header-sm">
                <div class="d-flex align-items-center">
                    <div class="wrapper d-flex align-items-center">
                        <h2 class="card-title ">Promotion Listing</h2>
                    </div>
                    <div class="wrapper ml-auto action-bar">
                        <a href="{{route('promotions.create')}}" class="btn btn-success btn-block"><i
                                class="fa fa-plus"></i> New
                            Promotion</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width:10%"></th>
                                <th>Image</th>
                                <th>@sortablelink('title_en', 'Title')</th>
                                <th class="text-left w-1">@sortablelink('sort', 'sort')</th>
                                <th class="text-center">@sortablelink('status', 'Status')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($promotions as $p)

                            <tr>
                                <td>
                                    <a href="{{ route('promotions.edit', $p->id) }}"
                                        class="btn btn-icons btn-success btn-action"><i class="fa fa-pencil"></i></a>
                                    <button type="button" class="btn btn-icons btn-danger  btn-delete"
                                        data-id="{{$p->id}}"><i class="fa fa-trash"></i></button>
                                </td>
                                <td>
                                    @if($p->thumbnail)
                                    <img src="{{ asset('storage/'.$p->thumbnail) }}" width="80" />
                                    @endif
                                </td>
                                <td>{{ $p->title_en }}</td>
                                <td class="text-left w-1">{{$p->sort}} </td>

                                <td class="text-center">
                                    @if($p->status)
                                    <span class="badge badge-success">Enable</span>
                                    @else
                                    <span class="badge badge-danger">Disabled</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $promotions->links('vendor.pagination.custom') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<form method="DELETE" id="form-delete" action="{{url('admin/promotions/delete')}}">
    @csrf
    <input type="hidden" id="id" name="id" value="" />
</form>
<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDeleteLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfirmDeleteLabel">Confirm Delete Promotion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this promotion?</p>
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
    var pId = $(this).attr('data-id');
    var deleteUrl = '{{ url('admin/promotions') }}/' + pId;
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
         notifySuccess('Promotion deleted!');
         setTimeout(function(){ location.href='{{route('promotions.index')}}'; }, 2000);
       }
     }).always(function() {
     });

    });

  });

</script>

@endsection