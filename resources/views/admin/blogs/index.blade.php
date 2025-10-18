@extends('layouts.admin')
@section('title', 'Blogs')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header header-sm">
                <div class="d-flex align-items-center">
                    <div class="wrapper d-flex align-items-center">
                        <h2 class="card-title">Blog Listing</h2>
                    </div>
                    <div class="wrapper ml-auto action-bar">
                        <a href="{{ route('blogs.create') }}" class="btn btn-success btn-block">
                            <i class="fa fa-plus"></i> New Blog
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{url('admin/blogs')}}" style="width:100%">
                    <div class="form-group row">
                        <div class="col-md-2">
                            <select name="category_id" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id ? 'selected' : ''
                                    }}>
                                    {{ $cat->translate('en')->name ?? $cat->slug }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                @foreach($statuses as $k => $v)
                                <option value="{{ $k }}" {{ request('status')==$k ? 'selected' : '' }}>
                                    {{ $v }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary btn-block"><i
                                    class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>


                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width:10%"></th>
                                <th>Image</th>
                                <th>@sortablelink('title_en', 'Title')</th>
                                <th>Categories</th>
                                <th>@sortablelink('published_at', 'Published Date')</th>
                                <th class="text-center">@sortablelink('status', 'Status')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $b)
                            <tr>
                                <td>
                                    <a href="{{ route('blogs.edit', $b->id) }}"
                                        class="btn btn-icons btn-success btn-action">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-icons btn-danger btn-delete"
                                        data-id="{{ $b->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                                <td>
                                    @if($b->thumbnail)
                                    <img src="{{ asset('storage/'.$b->thumbnail) }}" width="80" />
                                    @endif
                                </td>
                                <td>{{ $b->translate('en')->title ?? '-' }}</td>
                                <td>
                                    @forelse($b->categories as $cat)
                                    <span class="badge badge-primary">{{ $cat->translate('en')->name ?? '-' }}</span>
                                    @empty
                                    <span class="text-muted">—</span>
                                    @endforelse
                                </td>

                                <td>{{ $b->published_at ? $b->published_at->format('Y-m-d') : '-' }}</td>
                                <td class="text-center">
                                    @if($b->status)
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
                        {{ $blogs->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="DELETE" id="form-delete" action="{{ url('admin/blogs/delete') }}">
    @csrf
    <input type="hidden" id="id" name="id" value="" />
</form>

<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDeleteLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfirmDeleteLabel">Confirm Delete Blog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this blog?</p>
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
    var blogId = $(this).attr('data-id');
    var deleteUrl = '{{ url('admin/blogs') }}/' + blogId;
    $('#modalConfirmDelete').modal();
    $('#btnModalConfirmDeleteOK').off('click').on('click', function() {
      $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: deleteUrl,
        type: 'DELETE',
        data: $('#form-delete').serialize(),
      }).fail(function(xhr, text, err) {
        notifySystemError(err);
      }).done(function(data) {
        $('#modalConfirmDelete').modal('hide');
        if (data['error']) {
          notifySystemError(data['error']);
        } else {
          notifySuccess('Blog deleted!');
          setTimeout(function() { location.href = '{{ route('blogs.index') }}'; }, 2000);
        }
      });
    });
  });
</script>
@endsection