@extends('layouts.app')

@section('content')
<!--Secondary Nav-->
<header class="secondary-nav d-flex">
  <div class="container">
    <ul class="d-flex justify-content-center align-items-center">
      @foreach($dates as $date)
      <li><a href="{{ route('matches', ['date' => $date['date']]) }}" class="{{ $date['active'] ? 'active' : '' }}">{{
          $date['label'] }}</a></li>

      @endforeach
    </ul>
  </div>
</header>
<!--Main Content Start-->
<div class="main-content innerpagebg wf100">
  <!--Match Result Start-->
  <div class="match-results wf100 p40">
    <div class="container">

      <div class="row">
        <div class="col-md-4 col-sm-12 mb-4">
          <div class="card bg-secondary text-white">
            <div class="card-body flex-column justify-content-center align-items-center">
              <span class="d-flex align-items-center justify-content-center mb-2">Predict Correct Rate</span>
              <div class="progress-circle over50 p90">
                <span>90.7%</span>
                <div class="left-half-clipper">
                  <div class="first50-bar"></div>
                  <div class="value-bar"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 mb-4">
          <div class="card bg-secondary text-white">
            <div class="card-body flex-column justify-content-center align-items-center">
              <span class="d-flex align-items-center justify-content-center mb-2">
                Win Rate
              </span>
              <div class="progress-circle over50 p83">
                <span>83.2%</span>
                <div class="left-half-clipper">
                  <div class="first50-bar"></div>
                  <div class="value-bar"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 mb-4">
          <div class="card bg-secondary text-white">
            <div class="card-body flex-column justify-content-center align-items-center">
              <span class="d-flex align-items-center justify-content-center mb-2"> Correct Matches </span>
              <div class="progress-circle over50 p51">
                <span>51</span>
                <div class="left-half-clipper">
                  <div class="first50-bar"></div>
                  <div class="value-bar"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="accordion" id="accordionMatch">
            @foreach($tournaments as $tournamentGroup)
            @php
            $tournament = $tournamentGroup->first()->tournament; // 获取赛事类型信息
            @endphp

            <div class="card">
              <div class="card-header" id="heading-{{$tournament->id}}">
                <a class="btn" type="button" data-toggle="collapse" data-target="#collapse-{{$tournament->id}}"
                  aria-expanded="true" aria-controls="collapse-{{$tournament->id}}">
                  {{ $tournament->title }}
                </a>
              </div>
              <div id="collapse-{{$tournament->id}}" class="collapse" aria-labelledby="heading-{{$tournament->id}}"
                data-parent="#accordionMatch">

                <div class="card-body">
                  <div class="match-table-widget table-responsive">
                    <table>
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th class="match">Match</th>
                          <th>1</th>
                          <th>X</th>
                          <th>2</th>
                          <th>Tip</th>
                          <th>Handicap</th>
                          <th>O/U</th>
                          <th>Correct Score</th>
                          <th>Best Tip</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($tournamentGroup->sortByDesc('start_time') as $match)
                        <tr>
                          <td>
                            {{ $match->start_time->format('Y-m-d') }}
                            <br />
                            @if($match->start_time < now()) <span class="badge badge-secondary">Finished</span>
                              @else
                              <span class="badge badge-success">Upcoming</span>
                              @endif
                          </td>
                          <td>
                            <div class="d-flex justify-content-center align-items-center">
                              <div class="score-left d-flex align-items-center justify-content-end">
                                <strong>{{ $match->teamA->name}} </strong>
                                <img src="{{  Storage::url($match->teamA->image) }}" alt="" class="img-fluid" />
                              </div>
                              <strong class="vs">VS</strong>
                              <div class="score-right d-flex align-items-center justify-content-start">
                                <img src="{{  Storage::url($match->teamB->image) }}" class="img-fluid">
                                <strong>{{ $match->teamB->name}} </strong>

                              </div>
                            </div>
                          </td>
                          @if($match->start_time < now()) <td>
                            <span class="badge badge-primary">{{ $match->first_odd}}</span>
                            </td>
                            <td>
                              <span class="badge badge-primary">{{ $match->x_odd}}</span>
                            </td>
                            <td>
                              <span class="badge badge-primary">{{ $match->second_odd}}</span>
                            </td>
                            <td>
                              {{ $match->tip}}<br />
                              <span class="badge badge-secondary">{{ $match->tip_odd}}</span>
                            </td>
                            <td>
                              {{ $match->handicap}}<br />
                              <span class="badge badge-secondary">{{ $match->handicap_odd}}</span>
                            </td>
                            <td>
                              {{ $match->o_u}}<br />
                              <span class="badge badge-secondary">{{ $match->o_u_odd}}</span>
                            </td>
                            <td>
                              {{ $match->correct_score}}<br />
                              <span class="badge badge-secondary">{{ $match->correct_score_odd}}</span>
                            </td>
                            <td>
                              {{ $match->best_tip}}<br />
                              <span class="badge badge-secondary">{{ $match->best_tip_odd}}</span>
                            </td>
                            <td></td>
                            @elseif(auth()->check())
                            @if(Auth::user()->subscribe)
                            <td>
                              <span class="badge badge-primary">{{ $match->first_odd}}</span>
                            </td>
                            <td>
                              <span class="badge badge-primary">{{ $match->x_odd}}</span>
                            </td>
                            <td>
                              <span class="badge badge-primary">{{ $match->second_odd}}</span>
                            </td>
                            <td>
                              {{ $match->tip}}<br />
                              <span class="badge badge-secondary">{{ $match->tip_odd}}</span>
                            </td>
                            <td>
                              {{ $match->handicap}}<br />
                              <span class="badge badge-secondary">{{ $match->handicap_odd}}</span>
                            </td>
                            <td>
                              {{ $match->o_u}}<br />
                              <span class="badge badge-secondary">{{ $match->o_u_odd}}</span>
                            </td>
                            <td>
                              {{ $match->correct_score}}<br />
                              <span class="badge badge-secondary">{{ $match->correct_score_odd}}</span>
                            </td>
                            <td>
                              {{ $match->best_tip}}<br />
                              <span class="badge badge-secondary">{{ $match->best_tip_odd}}</span>
                            </td>
                            <td></td>
                            @else
                            @for($i=0; $i<8; $i++) <td><a href="#" data-toggle="modal" data-target="#modalInfo"
                                style="display: block">
                                <span data-container="body" data-toggle="popover" data-placement="top"
                                  data-content="Please subscribe in order to see the predictions" data-trigger="hover">
                                  @if($i > 2)
                                  <span class="blur-text">x</span><br />
                                  @endif
                                  <span
                                    class="blur-text badge {{ $i > 2 ? 'badge-secondary' : 'badge-primary' }} ">x</span></span></a>
                              </td>
                              @endfor
                              <td>
                                <button type="button" class="btn btn-icon" data-toggle="modal" data-target="#modalInfo">
                                  <i class="fa fa-lock"></i>
                                </button>
                              </td>
                              @endif
                              @else
                              {{-- 用户未登录，显示锁定图标提示登录 --}}
                              @for($i=0; $i<8; $i++) <td><a href="#" data-toggle="modal" data-target="#modalLogin"
                                  style="display: block">
                                  <span data-container="body" data-toggle="popover" data-placement="top"
                                    data-content="Please subscribe in order to see the predictions"
                                    data-trigger="hover">
                                    @if($i > 2)
                                    <span class="blur-text">x</span><br />
                                    @endif
                                    <span
                                      class="blur-text badge {{ $i > 2 ? 'badge-secondary' : 'badge-primary' }} ">x</span></span></a>
                                </td>
                                @endfor
                                <td>
                                  <button type="button" class="btn btn-icon" data-toggle="modal"
                                    data-target="#modalLogin">
                                    <i class="fa fa-lock"></i>
                                  </button>
                                </td>
                                @endif
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <!--- accordionMatch End -->
        </div>
      </div>
    </div>
  </div>
  <!--Match Result End-->
</div>
<!--Main Content End-->
@include('components.modal-deposit')

@endsection
@section('footer')
<script>
  $(document).ready(function() {
    // Automatically open the first accordion panel
    let firstAccordion = $('#accordionMatch .collapse').first();
    firstAccordion.addClass('show');
    firstAccordion.prev('.card-header').find('a').attr('aria-expanded', 'true');
});
</script>
@endsection