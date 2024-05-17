<div class="modal fade" id="modalRound" role="dialog" aria-labelledby="modalRoundLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRoundLabel">Add Round</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  
            <div class="modal-body">
              <form method="post" id="form-round"  action="{{url('admin/rounds')}}">
                @csrf
                <input type="hidden" id="match_id" name="match_id"  />
                <input type="hidden" id="round_id" name="round_id"  />

                <div class="row">
                  <div class="col-md-12">

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"  for="seq">Sort Order</label>
                        <div class="col-md-9">
                          <input type="text" id="sort" class=" form-control"  name="sort" placeholder="1"  />
                        </div><!--//col-->
                    </div>

                    <div class="form-group row">
                      <label class="col-md-3 col-form-label"  for="title">Date Time</label>
                      <div class="col-md-9">
                        <div class="input-group ">
                          <input id="round_datetime" type="text" class="form-control datetimepicker" name="round_datetime"  placeholder="" value="" />
                          <div class="input-group-append">
                              <span> <i class="fa fa-calendar"></i></span>
                          </div>
                        </div>
                      </div><!--//col-->
                    </div>

                    <div class="form-group row">
                      <label class="col-md-3 col-form-label"  for="title">Team A</label>
                      <div class="col-md-9">
                        <select name="team_a_id" id="team_a_id" class="select2 form-control">
                          @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                          @endforeach
                        </select>
                      </div><!--//col-->
                    </div>

                    <div class="form-group row">
                      <label class="col-md-3 col-form-label"  for="title">Team B</label>
                      <div class="col-md-9">
                        <select name="team_b_id" id="team_b_id" class="select2 form-control">
                          @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                          @endforeach
                        </select>
                      </div><!--//col-->
                    </div>

                    <div class="form-group row">
                      <label class="col-md-3 col-form-label"  for="title">Point</label>
                      <div class="col-md-9">
                        <input type="text" id="points" class=" form-control"  name="points" placeholder=""/>
                      </div><!--//col-->
                    </div>

                 

                    <div class="form-group row">
                      <label class="col-md-3 col-form-label"  for="title">Status</label>
                      <div class="col-md-9">
                        <select name="status" class="form-control ">
                          @foreach($statuses as $k=>$v)
                              <option value="{{$k}}" >{{$v}}</option>
                          @endforeach
                        </select>
                        
                      </div><!--//col-->
                    </div>

                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
                <button id="btnRoundSubmit" type="button" class="btn btn-primary">Submit</button>
                <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>
