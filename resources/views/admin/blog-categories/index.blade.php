@extends('layouts.admin')
@section('title', 'Category Listing')
@section('content')
<div class="row">
  <div class="col-lg-12 col-sm-12">
    <div class="card">
      <div class="card-header header-sm">
        <div class="d-flex align-items-center">
          <div class="wrapper d-flex align-items-center">
            <h2 class="card-title ">Category Listing</h2>
          </div>
          <div class="wrapper ml-auto action-bar">
            <a href="{{route('blog-categories.create')}}" class="btn btn-success btn-block"><i class="fa fa-plus"></i>
              New
              Category</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        {{-- <form method="GET" action="{{url('admin/blog-categories')}}" style="width:100%">
          <div class="form-group row">
            <div class="col-md-6">
              <input name="keyword" id="keyword" placeholder="Keyword" class="form-control"
                value="{{ request('keyword') }}" />

            </div>
            <div class="col-md-1">
              <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </form> --}}
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th style="width:10%"></th>
                <th>@sortablelink('name_en', 'Name')</th>
                <th class="text-right">@sortablelink('sort', 'Sort')</th>
                <th class="text-center">@sortablelink('status', 'Status')</th>
              </tr>
            </thead>
            <tbody>
              @foreach($categories as $category)

              <tr>
                <td>
                  <a href="{{ url('admin/blog-categories/' . $category->id . '/edit') }}"
                    class="btn btn-icons btn-success btn-action"><i class="fa fa-pencil"></i></a>
                  <button type="button" class="btn btn-icons btn-danger  btn-delete" data-id="{{$category->id}}"><i
                      class="fa fa-trash"></i></button>
                </td>
                <td>{{ $category->translations->where('locale', 'en')->first()->name ?? '' }}</td>
                <td class="text-right">{{$category->sort}} </td>
                <td class="text-center">
                  @if($category->status)
                  <span class="badge badge-success">Enable</span>
                  @else
                  <span class="badge badge-danger">Disabled</span>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="mt-5">
            {{ $categories->appends(request()->except('page'))->links('vendor.pagination.custom') }}

          </div>
        </div>
        <!--table-responsive-->
      </div>
    </div>
  </div>
</div>

<form method="DELETE" id="form-delete" action="{{url('admin/blog-categories/delete')}}">
  @csrf
  <input type="hidden" id="id" name="id" value="" />
</form>
<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDeleteLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalConfirmDeleteLabel">Confirm Delete Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this category?</p>
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
    var categoryId = $(this).attr('data-id');
    var deleteUrl = '{{ url('admin/blog-categories') }}/' + categoryId;

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
         notifySuccess('Category deleted!');
         setTimeout(function(){ location.href='{{route('blog-categories.index')}}'; }, 2000);
       }
     }).always(function() {
     });

    });

  });

</script>

@endsection