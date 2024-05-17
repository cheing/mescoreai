@extends('layouts.admin')
@section('title', 'Edit Country')
@section('content')
    <div class="row">
      <div class="col-lg-12 col-sm-12 grid-margin">
        <!-- form -->
        <form method="post" id="form-country" action="{{ url('admin/countries/' . $country->id) }}" enctype="multipart/form-data" class="forms-sample">

            @csrf

        <div class="card">
          <div class="card-header header-sm ">
            <div class="d-flex ">
                <div class="wrapper d-flex align-items-center">
                  <h2 class="card-title mb4">Edit Country</h2>
                </div>
                <div class="wrapper ml-auto action-bar">
                  <button type="submit" data-toggle="tooltip" data-placement="top" data-original-title="Save" class="btn btn-icons btn-success btn-sm"><i class="fa fa-save"></i></button>
                  <a class="btn btn-icons btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" data-original-title="Back"  href="{{route('countries.index')}}"><i class="fa fa-close"></i></a>
                </div>
            </div>
          </div><!--//card-header-->
          <div class="card-body">

            <div class="row">
            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="code ">Code</label>
                    <div class="col-md-9">
                    <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><span class="flag-icon flag-icon-{{ strtolower($country->code) }}"></span></span>
                            </div>
                            <input type="text" class="form-control" name="code" placeholder="" required value="{{ $country->code }}"/>

                          </div>
                   </div><!--//col-->
                </div>
              </div><!--//col-->
              <div class="col-md-8">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="name">Name </label>
                    <div class="col-md-9">
                      <div class="row">
                        <div class="col-md-6">
                          <input type="text" class="form-control"  name="name" placeholder="English"  value="{{ $country->name }}" required/>
                        </div>
                        <div class="col-md-6">
                        <input type="text" class="form-control"  name="name_zh" placeholder="Chinese"  value="{{ $country->name_zh }}"  required/>
                        </div>
                      </div>
                   </div><!--//col-->
                </div>
              </div><!--//col-->


             

            </div><!--row-->

          </div><!--//card-body-->
        </div>

      </form>
      <!-- // form-->
      </div>
    </div>

@endsection
@section('footer')
{!! JsValidator::formRequest('App\Http\Requests\UpdateCountryRequest', '#form-country'); !!}
<script>
  $('#form-country').submit(function (e) {
      e.preventDefault();
      if (!$(this).valid()) return false;
      var _btn = $('button[type=submit]', this);
      startSpin(_btn);

      // 如果有文件上传，使用 FormData 对象
      var formData = new FormData(this);
      formData.append('_method', 'PUT');
      $.ajax({
         headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          'X-HTTP-Method-Override': 'PUT'
          },

          url: '{{ url('admin/countries/' . $country->id) }}',
          type: 'POST',
          data: formData,
          processData: false, // 不处理发送的数据
          contentType: false, // 不设置内容类型
      }).fail(function(xhr) {
         var error = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error';
         notifySystemError(error);
      }).done(function(data) {
        notifySuccess('Country successfully update.');
        setTimeout(function(){ location.href='{{url('admin/countries')}}'; }, 2000);
      }).always(function() {
          stopSpin(_btn);
      });
  });
</script>
@endsection
