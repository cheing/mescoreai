@extends('layouts.admin') @section('title', 'Tournament Listing')
@section('content')
<div class="row">
    <div class="col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header header-sm">
                <div class="d-flex align-items-center">
                    <div class="wrapper d-flex align-items-center">
                        <h2 class="card-title">Tournament Listing</h2>
                    </div>
                    <div class="wrapper ml-auto action-bar">
                        <a
                            href="{{ route('tournaments.create') }}"
                            class="btn btn-success btn-block"
                            ><i class="fa fa-plus"></i> New Tournament</a
                        >
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10%"></th>
                                <th class="text-left">
                                    @sortablelink('title', 'Title')
                                </th>
                                <!-- <th>@sortablelink('title', 'Title Chinese')</th> -->
                                <th class="text-center">
                                    @sortablelink('status', 'Status')
                                </th>
                                <th>@sortablelink('start_date', 'Date')</th>
                                <!-- <th>@sortablelink('end_date', 'End Date')</th> -->
                            </tr>
                        </thead>
                        <tbody>
                          @if(count($tournaments)>0)
                            @foreach($tournaments as $tournament)
                            <tr>
                                <td>
                                    <a
                                        href="{{ url('admin/tournaments/' . $tournament->id . '/edit') }}"
                                        class="btn btn-icons btn-success btn-action"
                                        ><i class="fa fa-pencil"></i
                                    ></a>
                                    <button
                                        type="button"
                                        class="btn btn-icons btn-danger btn-delete"
                                        data-id="{{$tournament->id}}"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                                <td>{{$tournament->title}}</td>
                                <td class="text-center">
                                    @if($tournament->status)
                                    <span class="badge badge-success"
                                        >Enable</span
                                    >
                                    @else
                                    <span class="badge badge-danger"
                                        >Disabled</span
                                    >
                                    @endif
                                </td>
                                <td>{{$tournament->start_date}}</td>
                            </tr>
                            @endforeach 
                          @else
                          <tr>
                              <td colspan="4" class="text-center">
                                  No record found
                              </td>
                          </tr>
                          @endif
                        </tbody>
                    </table>
                    <div class="mt-5"></div>
                </div>
                <!--table-responsive-->
            </div>
        </div>
    </div>
</div>

<form
    method="DELETE"
    id="form-delete"
    action="{{ url('admin/tournament/delete') }}"
>
    @csrf
    <input type="hidden" id="id" name="id" value="" />
</form>
<div
    class="modal fade"
    id="modalConfirmDelete"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modalConfirmDeleteLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfirmDeleteLabel">
                    Confirm Delete Tournament
                </h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this tournament?</p>
            </div>
            <div class="modal-footer">
                <button id="btnModalConfirmDeleteOK" class="btn btn-primary">
                    Yes
                </button>
                <button data-dismiss="modal" class="btn btn-secondary">
                    No
                </button>
            </div>
        </div>
    </div>
</div>

@endsection @section('footer')
<script>

    $('.btn-delete').on('click', function() {
        var tournamentId = $(this).attr('data-id');
        var deleteUrl = '{{ url('admin/tournaments') }}/' + tournamentId;
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
             notifySuccess('Tournament deleted!');
             setTimeout(function(){ location.href='{{route('tournaments.index')}}'; }, 2000);
           }
         }).always(function() {
         });

        });

      });
</script>

@endsection
