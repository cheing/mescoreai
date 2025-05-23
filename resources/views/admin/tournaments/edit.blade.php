@extends('layouts.admin') @section('title', 'Edit Tournament')
@section('content')
<div class="row">
    <div class="col-lg-12 col-sm-12 grid-margin">
        <!-- form -->

        <form method="post" id="form-tournament" action="{{ url('admin/tournaments/' . $tournament->id) }}"
            enctype="multipart/form-data" class="forms-sample">
            @csrf
            <div class="card">
                <div class="card-header header-sm">
                    <div class="d-flex">
                        <div class="wrapper d-flex align-items-center">
                            <h2 class="card-title mb4">Edit Tournament</h2>
                        </div>
                        <div class="wrapper ml-auto action-bar">
                            <button type="submit" data-toggle="tooltip" data-placement="top" data-original-title="Save"
                                class="btn btn-icons btn-success btn-sm">
                                <i class="fa fa-save"></i>
                            </button>
                            <button type="button" class="btn btn-icons btn-danger btn-sm" id="btnDelete"
                                data-toggle="modal" data-target="#modalConfirmDelete">
                                <i class="fa fa-trash"></i>
                            </button>
                            <a class="btn btn-icons btn-outline-primary btn-sm" data-toggle="tooltip"
                                data-placement="top" data-original-title="Back"
                                href="{{ url('/admin/tournaments') }}"><i class="fa fa-close"></i></a>
                        </div>
                    </div>
                </div>
                <!--//card-header-->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="title">Title</label>
                                <div class="col-md-9">
                                    <input id="title" type="text" class="form-control" name="title"
                                        value="{{ $tournament->title }}" />
                                </div>
                                <!--//col-->
                            </div>
                        </div>
                        <!--//col-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="status">Status</label>
                                <div class="col-md-9">
                                    <select name="status" class="form-control">
                                        @foreach($statuses as $k=>$v)
                                        @if($tournament->status == $k)
                                        <option value="{{ $k }}" selected>
                                            {{ $v }}
                                        </option>
                                        @else
                                        <option value="{{ $k }}">
                                            {{ $v }}
                                        </option>
                                        @endif @endforeach
                                    </select>
                                </div>
                                <!--//col-->
                            </div>
                            <!--//form-group-->
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="start_date">Date Start
                                </label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input id="start_date" type="text" class="form-control date" name="start_date"
                                            data-date-format="YYYY-mm-dd" placeholder="YYYY-MM-DD"
                                            value="{{ $tournament->start_date }}" />
                                        <div class="input-group-append">
                                            <span>
                                                <i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <!--//col-->
                            </div>
                        </div>
                        <!--//col-->

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="end_date ">Date End
                                </label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input id="end_date" type="text" class="form-control date" name="end_date"
                                            data-date-format="YYYY-mm-dd" placeholder="YYYY-MM-DD"
                                            value="{{ $tournament->end_date }}" />
                                        <div class="input-group-append">
                                            <span>
                                                <i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <!--//col-->
                            </div>
                        </div>
                        <!--//col-->

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="input-sort">Sort</label>
                                <div class="col-md-9">
                                    <input id="input-sort" type="text" class="form-control" name="sort"
                                        value="{{ $tournament->sort }}" />
                                </div>
                                <!--//col-->
                            </div>
                        </div>
                        <!--//col-->
                    </div>
                    <!--row-->
                </div>
                <!--//card-body-->
            </div>
        </form>
        <!-- // form-->
    </div>
</div>

<!--start matches-->
<div class="card mt-5">
    <div class="card-header header-sm">
        <div class="d-flex">
            <div class="wrapper d-flex align-items-center">
                <h2 class="card-title mb-4">Matches</h2>
            </div>
            <div class="wrapper ml-auto action-bar">
                <button type="button" class="btn btn-primary btn-fw" id="btnAddMatch" data-toggle="modal"
                    data-target="#modalMatch" data-toggle="tooltip" data-placement="top"
                    data-original-title="Add Match">
                    <i class="fa fa-plus"></i> Add Match
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="tableMatch">
            <thead>
                <tr style="border-bottom:solid 2px #000 text-center">
                    <th class="text-center">Date Time</th>
                    <th class="text-center">Match</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">1</th>
                    <th class="text-center">x</th>
                    <th class="text-center">2</th>
                    <th class="text-center">Tip</th>
                    <th class="text-center">Handicap</th>
                    <th class="text-center">O/U</th>
                    <th class="text-center">Correct Score</th>
                    <th class="text-center">Best Tip</th>
                    <th class="text-center">Mix Parlay</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($tournament->matches as $match)
                <tr class="text-center">
                    <td>{{ optional($match->start_time)->format('Y-m-d') }}
                        <br />

                        <span class="badge badge-success">{{ optional($match->start_time)->format('H:i') }}</span>
                    </td>
                    <td><img src="{{  Storage::url($match->teamA->image) }}" style="height: 20px; width:auto">
                        <span class="mr-2">{{$match->teamA->name }}</span>
                        <span class="badge badge-outline-primary">vs</span> <span class="ml-2">{{$match->teamB->name
                            }}</span>
                        <img src="{{  Storage::url($match->teamB->image) }}" style="height: 20px">
                    </td>
                    <td class="text-center">
                        @if($match->status == 1)
                        <span class="badge badge-success">Enable</span>
                        @else
                        <span class="badge badge-danger">Disabled</span>
                        @endif
                    </td>
                    <td><span class="badge badge-primary mt-1">{{$match->first_odd}}</span></td>
                    <td><span class="badge badge-primary mt-1">{{$match->x_odd}}</span></td>
                    <td><span class="badge badge-primary mt-1">{{$match->second_odd}}</span></td>
                    <td>{{$match->tip}}<br /><span class="badge badge-primary mt-1">{{$match->tip_odd}}</span></td>
                    <td>{{$match->handicap}}<br /><span class="badge badge-primary mt-1">{{$match->handicap_odd}}</span>
                    </td>
                    <td>{{$match->o_u}}<br /><span class="badge badge-primary mt-1">{{$match->o_u_odd}}</span></td>
                    <td>{{$match->correct_score}}<br /><span
                            class="badge badge-primary mt-1">{{$match->correct_score_odd}}</span></td>
                    <td>{{$match->best_tip}}<br /><span class="badge badge-primary mt-1">{{$match->best_tip_odd}}</span>
                    </td>
                    <td>{{$match->mixparlay}}</td>
                    <td class="text-right">
                        <button type="button" class="btn btn-icons btn-success btn-edit-match"
                            data-id="{{$match->id}}"><i class="fa fa-pencil"></i></button>
                        <button type="button" class="btn btn-icons btn-danger btn-delete-match"
                            data-id="{{$match->id}}"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!--end matches-->

<!-- delete-->
<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDeleteLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfirmDeleteLabel">
                    Confirm Delete Tournament
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
@include('admin.modal-image')

<!-- add match -->
@include('admin.tournaments.modal-match')
@endsection

@section('footer') {!!
JsValidator::formRequest('App\Http\Requests\UpdateTournamentRequest',
'#form-tournament'); !!}
{!!
JsValidator::formRequest('App\Http\Requests\StoreTournamentMatchRequest',
'#form-match'); !!}
{!!JsValidator::formRequest('App\Http\Requests\UpdateTournamentMatchRequest',
'#form-match'); !!}
<script>
    // Variable to store which item is being uploaded
    var currentUploadItem = '';

    // When the upload modal is opened, determine which item is being uploaded
    $('#modalImage').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        currentUploadItem = button.data('item'); // Extract info from data-* attributes
    });

     //upload
     $('#btnUploadImage').on('click', function() {
     if (!$('#form-image').valid()) return false;
     var formData = new FormData($('#form-image')[0]);
     var _btn = $('#btnUploadImage', this);
     startSpin(_btn);
     $.ajax({
         headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         url: '{{route('upload.image')}}',
         type: 'POST',
         data:formData,
         enctype: 'multipart/form-data',
         contentType: false,
         processData: false,
     }).done(function(data) {
      if (data['path']) {
                // Update the correct field and image based on the item being uploaded
                if (currentUploadItem === 'banner') {
                    $('#input-banner').val(data['path']);
                    $('#banner_url').attr('src', data['url']);
                } else if (currentUploadItem === 'plan') {
                    $('#input-plan').val(data['path']);
                    $('#plan_url').attr('src', data['url']);
                }
                notifySuccess('Image uploaded');
            } else {
                notifySystemError(data['error']);
            }
     }).fail(function(xhr, text, err) {
        notifySystemError(err);
     }).always(function() {
         stopSpin(_btn);
        $('#modalImage').modal('hide');
        resetDropify();
     });
    });

    // Reset Dropify after modal close
    function resetDropify() {
        var drEvent = $('#photo').dropify();
        drEvent = drEvent.data('dropify');
        drEvent.resetPreview();
        drEvent.clearElement();
    }

    $(document).ready(function() {
        // Generic remove function for both banner and plan
        $('.btn-remove-image').on('click', function() {
            var targetImage = $(this).data('target-image');
            var targetInput = $(this).data('target-input');

            // Clear the hidden input value
            $(targetInput).val('');
            // Reset the image to the default placeholder
            $(targetImage).attr('src', '{{ asset('images/no_image.jpg') }}');
        });
    });
    $('#form-tournament').submit(function (e) {
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

              url: '{{ url('admin/tournaments/' . $tournament->id) }}',
              type: 'POST',
              data: formData,
              processData: false, // 不处理发送的数据
              contentType: false, // 不设置内容类型
          }).fail(function(xhr) {
             var error = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error';
             notifySystemError(error);
          }).done(function(data) {
            notifySuccess('Tournament successfully update.');
            // setTimeout(function(){ location.href='{{url('admin/tournaments')}}'; }, 2000);
          }).always(function() {
              stopSpin(_btn);
          });
      });

      $('#btnModalConfirmDeleteOK').off('click').on('click', function() {
          $.ajax({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              },
              url: `{{ url('admin/tournaments/') . '/' . $tournament->id}}`,
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

    //Match
    $('#btnAddMatch').on('click', function() {
      $('#modalMatchLabel').html('Add Match');
      $("#form-match")[0].reset();
      $('#modalMatch').modal();
    });


    $('#btnMatchSubmit').on('click', function(e) {
      
        e.preventDefault();
         if (!$('#form-match').valid()) return false;
         var _btn = $('#btnMatchSubmit');
         startSpin(_btn);

         var formData = new FormData($('#form-match')[0]);
         formData.append('tournament_id', '{{$tournament->id}}');

         if($('#id').val() != ""){

          formData.append('_method', 'PUT');
          var _id = $('#id').val();
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-HTTP-Method-Override': 'PUT'
              },
              url:  '{{url('admin/matches')}}' + '/' + _id,
              type: 'POST',
              data: formData,
              enctype: 'multipart/form-data',
              contentType: false,
              processData: false,
            }).fail(function(xhr, text, err) {
              notifySystemError(err);
            }).done(function(data) {
              $("#form-match")[0].reset();
              notifySuccess('Match updated ');
              $('#modalMatch').modal('hide');
              location.reload();
            }).always(function() {
                stopSpin(_btn);
            });
         }else{
          //add round
          $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              },
            url:  '{{url('admin/matches')}}',
            type: 'POST',
            data: formData,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false,
          }).fail(function(xhr, text, err) {
            notifySystemError(err);
          }).done(function(data) {
            $("#form-match")[0].reset();
            notifySuccess('Match added');
            $('#modalMatch').modal('hide');
            location.reload();
          }).always(function() {
              stopSpin(_btn);
          });
         }

    });


    $(document).on('click', '.btn-edit-match', function(e) {
       e.preventDefault();
       e.stopImmediatePropagation();
       var _id = $(this).attr('data-id');

        $.ajax({
            url: '{{ url('admin/tournament-match/') }}/' + _id, // API 路径
            type: 'GET',
            success: function(response) {
                // 假设 response 包含 round 数据
                populateMatchData(response);
                $('#modalMatchLabel').html('Edit Match');
                $('#modalMatch').modal('show');
            },
            error: function(xhr) {
                // 处理错误情况
                console.error("Error fetching match data", xhr);
            }
        });
    });


    $(document).on('click', '.btn-delete-match', function(e) {
       e.preventDefault();
       e.stopImmediatePropagation();
       if (!confirm('Are you sure you want to delete this match?')) return;
       var _id = $(this).attr('data-id');
      //  var _formData = new FormData();
      //  _formData.append('id', _id);
       $.ajax({
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              },
              url: `{{ url('admin/matches/')}}` + '/'  + _id,
             type: 'DELETE',
              contentType: false,
              processData: false,
              // data: _formData,
       }).fail(function(xhr, text, err) {
          notifySystemError(err);
       }).done(function(data){
         if(data){
           notifySuccess('Match deleted');
           location.reload();
         }else{
           notifySystemError(data['error']);
         }
       }).always(function(){
       });
    });

    function populateMatchData(data) {

        // 填充表单字段
        $('#modalMatch #form-match #id').val(data.data.id);
        $('#modalMatch #form-match #start_time').val(data.data.start_time);
        $('#modalMatch #form-match #team_a_id').val(data.data.team_a_id).trigger('change');
        $('#modalMatch #form-match #team_b_id').val(data.data.team_b_id).trigger('change');
        $('#modalMatch #form-match #status').val(data.data.status).trigger('change');
        $('#modalMatch #form-match #team_a_result').val(data.data.team_a_result);
        $('#modalMatch #form-match #team_b_result').val(data.data.team_b_result);
        $('#modalMatch #form-match #first_odd').val(data.data.first_odd);
        $('#modalMatch #form-match #x_odd').val(data.data.x_odd);
        $('#modalMatch #form-match #second_odd').val(data.data.second_odd);
        $('#modalMatch #form-match #tip').val(data.data.tip);
        $('#modalMatch #form-match #tip_odd').val(data.data.tip_odd);
        $('#modalMatch #form-match #handicap').val(data.data.handicap);
        $('#modalMatch #form-match #handicap_odd').val(data.data.handicap_odd);
        $('#modalMatch #form-match #o_u').val(data.data.o_u);
        $('#modalMatch #form-match #o_u_odd').val(data.data.o_u_odd);
        $('#modalMatch #form-match #correct_score').val(data.data.correct_score);
        $('#modalMatch #form-match #correct_score_odd').val(data.data.correct_score_odd);
        $('#modalMatch #form-match #best_tip').val(data.data.best_tip);
        $('#modalMatch #form-match #best_tip_odd').val(data.data.best_tip_odd);
        $('#modalMatch #form-match #mixparlay').val(data.data.mixparlay);


        // 更新表单动作 URL
        $('#modalMatch #form-match').attr('action', '{{ url('admin/matches/') }}/' + data.id);
    }

  
</script>
@endsection