@extends('layouts.admin')
@section('title', 'Edit Category')
@section('content')
<div class="row">
  <div class="col-lg-12 col-sm-12 grid-margin">
    <!-- form -->
    <form method="post" id="form-category" action="{{url('admin/blog-categories/' . $category->id)}}"
      enctype="multipart/form-data" class="forms-sample">
      @csrf
      @method('PUT')

      <div class="card">
        <div class="card-header header-sm ">
          <div class="d-flex ">
            <div class="wrapper d-flex align-items-center">
              <h2 class="card-title mb4">Edit Category</h2>
            </div>
            <div class="wrapper ml-auto action-bar">
              <button type="submit" data-toggle="tooltip" data-placement="top" data-original-title="Save"
                class="btn btn-icons btn-success btn-sm"><i class="fa fa-save"></i></button>
              <a class="btn btn-icons btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top"
                data-original-title="Back" href="{{route('blog-categories.index')}}"><i class="fa fa-close"></i></a>
            </div>
          </div>
        </div>
        <!--//card-header-->
        <div class="card-body">

          <!-- Language Tabs -->
          <ul class="nav nav-tabs" id="langTab" role="tablist">
            @foreach($languages as $index => $lang)
            <li class="nav-item">
              <a class="nav-link p-3 {{ $index === 0 ? 'active' : '' }}" id="tab-{{ $lang['code'] }}" data-toggle="tab"
                href="#lang-{{ $lang['code'] }}" role="tab">
                <span class="mr-1 flag-icon flag-icon-{{ $lang['flag'] }}"></span> {{ $lang['name'] }}
              </a>
            </li>
            @endforeach
          </ul>


          <div class="tab-content border border-top-0 p-4  mb-3" id="langTabContent">
            @foreach($languages as $index => $lang)
            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="lang-{{ $lang['code'] }}"
              role="tabpanel">
              <div class="form-group">
                <label>Title</label>
                <input type="text" name="name_{{ $lang['code'] }}" class="form-control" required
                  value="{{ $category->translations->where('locale', $lang['code'])->first()->name ?? '' }}">
              </div>

              <div class="form-group">
                <label>Description</label>
                <textarea name="description_{{ $lang['code'] }}" class="form-control"
                  rows="3">{{ $category->translations->where('locale', $lang['code'])->first()->description ?? '' }}</textarea>
              </div>


              <hr>
              <h6 class="text-muted mt-3 mb-2">SEO Meta</h6>
              <div class="form-group">
                <label>Meta Title</label>
                <input type="text" name="meta_title_{{ $lang['code'] }}" class="form-control" maxlength="255"
                  value="{{ $category->translations->where('locale', $lang['code'])->first()->meta_title ?? '' }}">
              </div>
              <div class="form-group">
                <label>Meta Keywords</label>
                <input type="text" name="meta_keywords_{{ $lang['code'] }}" class="form-control" maxlength="255"
                  value="{{ $category->translations->where('locale', $lang['code'])->first()->meta_keywords ?? '' }}">
              </div>
              <div class="form-group">
                <label>Meta Description</label>
                <textarea name="meta_description_{{ $lang['code'] }}" class="form-control" rows="3"
                  maxlength="500">{{ $category->translations->where('locale', $lang['code'])->first()->meta_description ?? '' }}</textarea>
              </div>
            </div>
            @endforeach

          </div>
          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="sort">Sort</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="sort" placeholder="" required
                value="{{ $category->sort }}" />
            </div>
            <!--//col-->
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="status">Status</label>
            <div class="col-md-10">
              <select name="status" class="form-control">
                @foreach($statuses as $k => $v)
                <option value="{{ $k }}" {{ $category->status == $k ? 'selected' : '' }}>
                  {{ $v }}
                </option>
                @endforeach
              </select>
            </div>
          </div>

          <!--//form-group-->

        </div>
        <!--//card-body-->
      </div>

    </form>
    <!-- // form-->
  </div>
</div>

@endsection
@section('footer')
{!! JsValidator::formRequest('App\Http\Requests\UpdateBlogCategoryRequest', '#form-category'); !!}
<script>
  $('#form-blog button[type=submit]').on('click', function(e) {
  e.preventDefault();

  var form = $('#form-blog');
  if (!form.valid()) return false; // Still works with JsValidator

  var _btn = $('button[type=submit]', this);
  startSpin(_btn);

  var formData = new FormData(form[0]);
  formData.append('_method', 'PUT');

  $.ajax({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    url: form.attr('action'),
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
  }).fail(function(xhr) {
    var error = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error';
    notifySystemError(error);
  }).done(function(data) {
    notifySuccess('Category successfully updated.');
    setTimeout(function() {
      location.href = '{{route('blog-categories.index')}}';
    }, 2000);
  }).always(function() {
    stopSpin(_btn);
  });
});

</script>

@endsection