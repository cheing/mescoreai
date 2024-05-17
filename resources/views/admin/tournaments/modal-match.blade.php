<div class="modal fade" id="modalMatch" role="dialog" aria-labelledby="modalMatchLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMatchLabel">Add Match</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  
            <div class="modal-body">
              <form method="post" id="form-match"  action="{{url('admin/matches')}}">
                @csrf
                <input type="hidden" id="tournament_id" name="tournament_id"   />
                <input type="hidden" id="id" name="id"   />
                <div class="row">
                  <div class="col-md-12">

                    <div class="form-group row">
                      <label class="col-md-3 col-form-label"  for="start_time">Date Time</label>
                      <div class="col-md-9">
                        <div class="input-group ">
                          <input id="start_time" type="text" class="form-control datetimepicker" name="start_time"  placeholder="" value="" />
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
                      <label class="col-md-3 col-form-label"  for="status">Status</label>
                      <div class="col-md-9">
                        <select name="status" class="form-control ">
                        @foreach($statuses as $k=>$v)
                            <option value="{{$k}}" >{{$v}}</option>
                        @endforeach
                      </select>
                        
                      </div><!--//col-->
                    </div>
                      <div class="table-responsive">
                      <table class="table table-bordered border-grey">
                        <thead>
                          <tr class="text-center ">
                            <th>1</th>
                            <th>x</th>
                            <th>2</th>
                            <th>Tip</th>
                            <th>Handicap</th>
                            <th>O/U</th>
                            <th>Correct Score</th>
                            <th>Best Tip</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr class="text-center" >
                            <td><input type="text" class="form-control" name="first_odd" id="first_odd"/></td>
                            <td><input type="text" class="form-control" name="x_odd" id="x_odd"/></td>
                            <td><input type="text" class="form-control" name="second_odd" id="second_odd"/></td>
                            <td>
                              <input type="text" class="form-control" name="tip" id="tip"/><br/>
                              <input type="text" class="form-control mt-1" name="tip_odd" id="tip_odd"/>
                            </td>
                            <td>
                              <input type="text" class="form-control" name="handicap" id="handicap"/><br/>
                              <input type="text" class="form-control mt-1" name="handicap_odd" id="handicap_odd"/>
                            </td>
                            <td>
                              <input type="text" class="form-control" name="o_u" id="o_u"/><br/>
                              <input type="text" class="form-control mt-1" name="o_u_odd" id="o_u_odd"/>
                            </td>
                            <td>
                              <input type="text" class="form-control" name="correct_score" id="correct_score"/><br/>
                              <input type="text" class="form-control mt-1" name="correct_score_odd" id="correct_score_odd"/>
                            </td>
                            <td>
                              <input type="text" class="form-control" name="best_tip" id="best_tip"/><br/>
                              <input type="text" class="form-control mt-1" name="best_tip_odd" id="best_tip_odd"/>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
                <button id="btnMatchSubmit" type="button" class="btn btn-primary">Submit</button>
                <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>
