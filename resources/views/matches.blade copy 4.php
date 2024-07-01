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
                            @foreach($tournamentGroup->sortBy('start_time') as $match)
                            @php
                            $currentTime = now();
                            $matchStartTime = $match->start_time;
                            $minutesDifference = $matchStartTime->diffInMinutes($currentTime, false);
                            // $timeSinceStart = $currentTime->diffInMinutes($matchStartTime, false);
                            @endphp
                            <tr>
                              <td>
                                {{ $match->start_time->format('H:i') }}
                                <br />
                                {{-- @if($matchStartTime->diffInMinutes(now(), false) >=90)
                                <span class="badge badge-secondary">{{
                                  __('match.text_finished')
                                  }}</span>
                                @else
                                <span class="badge badge-success">{{
                                  __('match.text_upcoming')
                                  }}</span>
                                @endif --}}
                                @if($matchStartTime > $currentTime)
                                <span class="badge badge-success">{{ __('match.text_upcoming') }}</span>
                                @elseif($minutesDifference >= 0 && $minutesDifference < 90) <span
                                  class="badge badge-success">{{
                                  __('match.text_in_progress')
                                  }}</span>
                                  @else

                                  <span class="badge badge-secondary">{{ __('match.text_finished') }}</span>
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

                              <!-- Check various conditions for display of match predictions -->
                              {{-- @if($match->start_time < now() || $match->start_time->diffInMinutes(now(), false) >=
                                120) --}}
                                {{-- @if($matchStartTime < now() || $minutesDifference>= 90) --}}
                                  @if($matchStartTime->diffInMinutes(now(), false) >=90)

                                  {{-- <td>@php echo $minutesDifference @endphp</td> --}}


                                  <!-- Conditions 1 and 2: Match is past or has been ongoing for at least 2 hours -->
                                  @include('partials.match_predictions', ['match' => $match])
                                  @else
                                  @if(auth()->check())
                                  <!-- Check user login and subscription status -->
                                  @if(auth()->user()->activeSubscription() || Auth::user()->role == "admin")
                                  <!-- Condition 3: User has an active subscription -->
                                  @include('partials.match_predictions', ['match' => $match])
                                  @else
                                  <!-- Condition 5: User is logged in but does not have a subscription -->
                                  @include('partials.locked_match_details')
                                  @endif
                                  @else
                                  <!-- Condition 4: User not logged in and match is upcoming -->
                                  @include('partials.not_logged_match_details')
                                  @endif

                                  @endif
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                      <div class="d-block d-sm-none">
                        @foreach($tournamentGroup->sortBy('start_time') as $match)
                        @php
                        $currentTime = now();
                        $matchStartTime = $match->start_time;
                        $minutesDifference = $matchStartTime->diffInMinutes($currentTime, false);
                        // $timeSinceStart = $currentTime->diffInMinutes($matchStartTime, false);
                        @endphp
                        <table class="table">
                          <thead>
                            <tr>
                              <th colspan="10">

                                <div class="d-flex justify-content-between align-items-center">
                                  <span class="badge badge-success"> {{ $match->start_time->format('H:i') }}</span>

                                  @if($matchStartTime > $currentTime)
                                  <span class="badge badge-success">{{ __('match.text_upcoming') }}</span>
                                  @elseif($minutesDifference >= 0 && $minutesDifference < 90) <span
                                    class="badge badge-success">{{
                                    __('match.text_in_progress')
                                    }}</span>
                                    @else
                                    <span class="badge badge-secondary">{{ __('match.text_finished') }}</span>
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
                              @if($match->start_time < now() || $match->start_time->diffInMinutes(now(), false) >= 120)
                                @include('partials.match_predictions_mobile', ['match' => $match])

                                @elseif(auth()->check())
                                @if(auth()->user()->activeSubscription())

                                @include('partials.match_predictions_mobile', ['match' => $match])

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
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <!--- accordionMatch End -->

          <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-auto mb-2 mb-md-0">
              <!-- Stacks on small devices, inline on medium and up -->
              <a href="https://me88cash.com/register?affid=5678" class="afflink btn btn-primary text-uppercase w-100">
                {{ __('messages.btn_bet_now') }}
                <div class="fill-one"></div>
              </a>
            </div>
          </div>
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

$('#modalInfo').on('shown.bs.modal', function () {
    updateAffiliateLinks();  // Update links when modal is shown
});
</script>
@endsection