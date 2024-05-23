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

      <div class="row percentage">
        <div class="col-4 mb-4">
          <div class="card bg-secondary text-white">
            <div class="card-body flex-column justify-content-center align-items-center">
              <h3 class="d-flex align-items-center justify-content-center mb-2">{{
                __('match.text_predict_correct_rate')
                }}</h3>
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
        <div class="col-4 mb-4">
          <div class="card bg-secondary text-white">
            <div class="card-body flex-column justify-content-center align-items-center">
              <h3 class="d-flex align-items-center justify-content-center mb-2">
                {{
                __('match.text_win_rate')
                }}
              </h3>
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
        <div class="col-4 mb-4">
          <div class="card bg-secondary text-white">
            <div class="card-body flex-column justify-content-center align-items-center">
              <h3 class="d-flex align-items-center justify-content-center mb-2">{{
                __('match.text_correct_matches')
                }}</h3>
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
                  <div class="match-table-widget">
                    <div class="table-responsive">
                      <div class="d-none d-sm-block">
                        <table>
                          <thead>
                            <tr>
                              <th>{{
                                __('match.text_date')
                                }}</th>
                              <th class="match">{{
                                __('match.text_match')
                                }}</th>
                              <th>1</th>
                              <th>X</th>
                              <th>2</th>
                              <th>{{
                                __('match.text_tip')
                                }}</th>
                              <th>{{
                                __('match.text_handicap')
                                }}</th>
                              <th>{{
                                __('match.text_o_u')
                                }}</th>
                              <th>{{
                                __('match.text_correct_score')
                                }}</th>
                              <th>{{
                                __('match.text_best_tip')
                                }}</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($tournamentGroup->sortByDesc('start_time') as $match)
                            <tr>
                              <td>
                                {{ $match->start_time->format('H:m') }}
                                <br />
                                @if($match->start_time < now()) <span class="badge badge-secondary">{{
                                  __('match.text_finished')
                                  }}</span>
                                  @else
                                  <span class="badge badge-success">{{
                                    __('match.text_upcoming')
                                    }}</span>
                                  @endif
                              </td>
                              <td>
                                <div class="d-flex justify-content-center align-items-center">
                                  <div class="score-left d-flex align-items-center justify-content-end">
                                    <strong>{{ $match->teamA->name}} </strong>
                                    <img src="{{  Storage::url($match->teamA->image) }}" alt="" class="img-fluid" />
                                  </div>
                                  @if($match->team_a_result != "-" && $match->team_b_result != "")
                                  <strong class="badge badge-success">{{$match->team_a_result}}</strong><span
                                    class="badge">:</span><strong
                                    class="badge badge-success">{{$match->team_b_result}}</strong>
                                  @else
                                  <strong class="vs">VS</strong>
                                  @endif
                                  <div class="score-right d-flex align-items-center justify-content-start">
                                    <img src="{{  Storage::url($match->teamB->image) }}" class="img-fluid">
                                    <strong>{{ $match->teamB->name}} </strong>
                                  </div>
                                </div>
                              </td>
                              @if($match->start_time < now()) <td>

                                <span class="badge badge-primary" data-container="body" data-toggle="popover"
                                  data-placement="top" data-content="{{
                                    __('match.text_odd')
                                    }}" data-trigger="hover">{{
                                  $match->first_odd}}</span>
                                </td>
                                <td>
                                  <span class="badge badge-primary" data-container="body" data-toggle="popover"
                                    data-placement="top" data-content="{{
                                    __('match.text_odd')
                                    }}" data-trigger="hover">{{ $match->x_odd}}</span>
                                </td>
                                <td>
                                  <span class="badge badge-primary" data-container="body" data-toggle="popover"
                                    data-placement="top" data-content="{{
                                    __('match.text_odd')
                                    }}" data-trigger="hover">{{ $match->second_odd}}</span>
                                </td>
                                <td>
                                  {{ $match->tip}}<br />
                                  <span class="badge badge-secondary" data-container="body" data-toggle="popover"
                                    data-placement="top" data-content="{{
                                    __('match.text_odd')
                                    }}" data-trigger="hover">{{ $match->tip_odd}}</span>
                                </td>
                                <td>
                                  {{ $match->handicap}}<br />
                                  <span class="badge badge-secondary" data-container="body" data-toggle="popover"
                                    data-placement="top" data-content="{{
                                    __('match.text_odd')
                                    }}" data-trigger="hover">{{ $match->handicap_odd}}</span>
                                </td>
                                <td>
                                  {{ $match->o_u}}<br />
                                  <span class="badge badge-secondary" data-container="body" data-toggle="popover"
                                    data-placement="top" data-content="{{
                                    __('match.text_odd')
                                    }}" data-trigger="hover">{{ $match->o_u_odd}}</span>
                                </td>
                                <td>
                                  {{ $match->correct_score}}<br />
                                  <span class="badge badge-secondary" data-container="body" data-toggle="popover"
                                    data-placement="top" data-content="{{
                                    __('match.text_odd')
                                    }}" data-trigger="hover">{{ $match->correct_score_odd}}</span>
                                </td>
                                <td>
                                  {{ $match->best_tip}}<br />
                                  <span class="badge badge-secondary" data-container="body" data-toggle="popover"
                                    data-placement="top" data-content="{{
                                    __('match.text_odd')
                                    }}" data-trigger="hover">{{ $match->best_tip_odd}}</span>
                                </td>
                                <td></td>
                                @elseif(auth()->check())
                                @if(Auth::user()->subscribe)
                                <td>
                                  <span class="badge badge-primary" data-container="body" data-toggle="popover"
                                    data-placement="top" data-content="{{
                                    __('match.text_odd')
                                    }}" data-trigger="hover">{{ $match->first_odd}}</span>
                                </td>
                                <td>
                                  <span class="badge badge-primary" data-container="body" data-toggle="popover"
                                    data-placement="top" data-content="{{
                                    __('match.text_odd')
                                    }}" data-trigger="hover">{{ $match->x_odd}}</span>
                                </td>
                                <td>
                                  <span class="badge badge-primary" data-container="body" data-toggle="popover"
                                    data-placement="top" data-content="{{
                                    __('match.text_odd')
                                    }}" data-trigger="hover">{{ $match->second_odd}}</span>
                                </td>
                                <td>
                                  {{ $match->tip}}<br />
                                  <span class="badge badge-secondary" data-container="body" data-toggle="popover"
                                    data-placement="top" data-content="{{
                                    __('match.text_odd')
                                    }}" data-trigger="hover">{{ $match->tip_odd}}</span>
                                </td>
                                <td>
                                  {{ $match->handicap}}<br />
                                  <span class="badge badge-secondary" data-container="body" data-toggle="popover"
                                    data-placement="top" data-content="{{
                                    __('match.text_odd')
                                    }}" data-trigger="hover">{{ $match->handicap_odd}}</span>
                                </td>
                                <td>
                                  {{ $match->o_u}}<br />
                                  <span class="badge badge-secondary" data-container="body" data-toggle="popover"
                                    data-placement="top" data-content="{{
                                    __('match.text_odd')
                                    }}" data-trigger="hover">{{ $match->o_u_odd}}</span>
                                </td>
                                <td>
                                  {{ $match->correct_score}}<br />
                                  <span class="badge badge-secondary" data-container="body" data-toggle="popover"
                                    data-placement="top" data-content="{{
                                    __('match.text_odd')
                                    }}" data-trigger="hover">{{ $match->correct_score_odd}}</span>
                                </td>
                                <td>
                                  {{ $match->best_tip}}<br />
                                  <span class="badge badge-secondary" data-container="body" data-toggle="popover"
                                    data-placement="top" data-content="{{
                                    __('match.text_odd')
                                    }}" data-trigger="hover">{{ $match->best_tip_odd}}</span>
                                </td>
                                <td></td>
                                @else
                                @for($i=0; $i<8; $i++) <td><a href="#" data-toggle="modal" data-target="#modalInfo"
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
                                      data-target="#modalInfo">
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
                      <div class="d-block d-sm-none">
                        @foreach($tournamentGroup->sortByDesc('start_time') as $match)

                        <table class="table">
                          <thead>
                            <tr>
                              <th colspan="10">

                                <div class="d-flex justify-content-between align-items-center">
                                  <span class="badge badge-success"> {{ $match->start_time->format('H:m') }}</span>

                                  @if($match->start_time < now()) <span class="badge badge-secondary">{{
                                    __('match.text_finished')
                                    }}</span>
                                    @else
                                    <span class="badge badge-success">{{
                                      __('match.text_upcoming')
                                      }}</span>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                  <div class="score-left d-flex align-items-center justify-content-end">
                                    <strong>{{ $match->teamA->name}} </strong>
                                    <img src="{{  Storage::url($match->teamA->image) }}" alt="" class="img-fluid" />
                                  </div>
                                  @if($match->team_a_result != "-" && $match->team_b_result != "")
                                  <strong class="badge badge-success ml-2">{{$match->team_a_result}}</strong><span
                                    class="badge">:</span><strong
                                    class="badge badge-success  mr-2">{{$match->team_b_result}}</strong>
                                  @else
                                  <strong class="vs">VS</strong>
                                  @endif <div class="score-right d-flex align-items-center justify-content-start">
                                    <img src="{{  Storage::url($match->teamB->image) }}" class="img-fluid">
                                    <strong>{{ $match->teamB->name}} </strong>
                                  </div>
                                </div>


                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr class="bg-dark text-center text-white">
                              <th></th>
                              <th>1</th>
                              <th>X</th>
                              <th>2</th>
                              <th>{{
                                __('match.text_tip')
                                }}</th>
                              <th>{{
                                __('match.text_handicap')
                                }}</th>
                              <th>{{
                                __('match.text_o_u')
                                }}</th>
                              <th>{{
                                __('match.text_correct_score')
                                }} </th>
                              <th>{{
                                __('match.text_best_tip')
                                }} </th>
                              <th></th>
                            </tr>
                            <tr>
                              @if($match->start_time < now()) <td> {{
                                __('match.text_odd')
                                }}</td>
                                <td>
                                  <span class="badge badge-primary">{{ $match->first_odd}}</span>
                                </td>
                                <td><span class="badge badge-primary">{{ $match->x_odd}}</span></td>
                                <td><span class="badge badge-primary">{{ $match->second_odd}}</span></td>
                                <td>{{ $match->tip}}<br />
                                  <span class="badge badge-secondary ml-1">{{ $match->tip_odd}}</span>
                                </td>
                                <td> {{ $match->handicap}}<br />
                                  <span class="badge badge-secondary ml-1">{{ $match->handicap_odd}}</span>
                                </td>
                                <td> {{ $match->o_u}}<br />
                                  <span class="badge badge-secondary ml-1">{{ $match->o_u_odd}}</span>
                                </td>
                                <td>{{ $match->correct_score}}<br />
                                  <span class="badge badge-secondary ml-1">{{ $match->correct_score_odd}}</span>
                                </td>
                                <td> {{ $match->best_tip}}<br />
                                  <span class="badge badge-secondary ml-1">{{ $match->best_tip_odd}}</span>
                                </td>
                                <td></td>
                                @elseif(auth()->check())
                                @if(Auth::user()->subscribe)
                                <td> {{
                                  __('match.text_odd')
                                  }}</td>
                                <td>
                                  <span class="badge badge-primary">{{ $match->first_odd}}</span>
                                </td>
                                <td><span class="badge badge-primary">{{ $match->x_odd}}</span></td>
                                <td><span class="badge badge-primary">{{ $match->second_odd}}</span></td>
                                <td>{{ $match->tip}}<br />
                                  <span class="badge badge-secondary ml-1">{{ $match->tip_odd}}</span>
                                </td>
                                <td> {{ $match->handicap}}<br />
                                  <span class="badge badge-secondary ml-1">{{ $match->handicap_odd}}</span>
                                </td>
                                <td> {{ $match->o_u}}<br />
                                  <span class="badge badge-secondary ml-1">{{ $match->o_u_odd}}</span>
                                </td>
                                <td>{{ $match->correct_score}}<br />
                                  <span class="badge badge-secondary ml-1">{{ $match->correct_score_odd}}</span>
                                </td>
                                <td> {{ $match->best_tip}}<br />
                                  <span class="badge badge-secondary ml-1">{{ $match->best_tip_odd}}</span>
                                </td>
                                <td></td>
                                @else
                                <td colspan="10">
                                  <button type="button" class="btn btn-icon" data-toggle="modal"
                                    data-target="#modalInfo">
                                    <i class="fa fa-lock"></i>
                                  </button>
                                </td>
                                @endif
                                @else
                                <td colspan="10">
                                  <button type="button" class="btn btn-icon" data-toggle="modal"
                                    data-target="#modalLogin">
                                    <i class="fa fa-lock"></i>
                                  </button>
                                </td>
                                @endif
                            </tr>
                          </tbody>
                        </table>
                        @endforeach
                        {{-- <table class="table">
                          <thead>
                            <tr class="style1">

                              <th>{{
                                __('match.text_time')
                                }}</th>
                              <th>{{
                                __('match.text_match')
                                }}</th>
                              <th>{{
                                __('match.text_1_x_2_tips')
                                }}</th>
                              <th>{{
                                __('match.text_correct_score')
                                }} </th>
                              <th>{{
                                __('match.text_handicap')
                                }} </th>
                              <th>{{
                                __('match.text_o_u')
                                }} </th>
                              <th>{{
                                __('match.text_best_tip')
                                }} </th>
                            </tr>
                          </thead>

                          <tbody>

                            @foreach($tournamentGroup->sortByDesc('start_time') as $match)
                            <tr style="border-bottom:solid 2px #eee; vertical-align:middle">
                              <td rowspan="2">
                                {{ $match->start_time->format('H:m') }}
                                @if($match->start_time < now()) <span class="badge badge-secondary">
                                  {{
                                  __('match.text_finished')
                                  }}</span>
                                  @else
                                  <span class="badge badge-success">{{
                                    __('match.text_upcoming')
                                    }}</span>
                                  @endif
                              </td>

                              <td>
                                <img src="{{  Storage::url($match->teamA->image) }}" alt="" class="img-fluid" />
                              </td>
                              @if($match->start_time < now()) <td rowspan="2">{{$match->tip}}</td>
                                <td rowspan="2">{{$match->correct_score}}</td>
                                <td rowspan="2">{{$match->handicap}}</td>
                                <td rowspan="2">{{$match->o_u}}</td>
                                <td rowspan="2">{{$match->best_tip}}</td>
                                @elseif(auth()->check())
                                @if(Auth::user()->subscribe)
                                <td rowspan="2">{{$match->tip}}</td>
                                <td rowspan="2">{{$match->correct_score}}</td>
                                <td rowspan="2">{{$match->handicap}}</td>
                                <td rowspan="2">{{$match->o_u}}</td>
                                <td rowspan="2">{{$match->best_tip}}</td>
                                @else
                                <td colspan="5" rowspan="2">
                                  <button type="button" class="btn btn-icon" data-toggle="modal"
                                    data-target="#modalInfo">
                                    <i class="fa fa-lock"></i>
                                  </button>
                                </td>
                                @endif
                                @else
                                <td colspan="5" rowspan="2">
                                  <button type="button" class="btn btn-icon" data-toggle="modal"
                                    data-target="#modalLogin">
                                    <i class="fa fa-lock"></i>
                                  </button>
                                </td>
                                @endif
                            </tr>
                            <tr style="border-bottom:none 0px #eee">
                              <td style="border-bottom:none 0px #eee"><img
                                  src="{{  Storage::url($match->teamB->image) }}" class="img-fluid"></td>
                            </tr>



                            @endforeach
                          <tbody>

                        </table> --}}
                      </div>
                    </div>
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