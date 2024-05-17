@extends('layouts.app')

@section('content')
<div class="hero_main2 wf100">
  <div class="iframe-container ">

    <iframe src="https://me88livestreaming.com/live?mode=s1" title="Live Streaming" frameborder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
      referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>

    </iframe>
    <img src="{{asset('images/adbanner.jpg')}}" class="adbanner" />

  </div>
</div>
<div class="hero_main wf100">

  <div class="container text-center">

    <div class="d-flex justify-content-center align-items-center mt-4">
      <a href="https://playme1.asia/register?affid=5678" class="btn btn-primary text-uppercase mr-4">Bet Now <div
          class="fill-one">
        </div>
      </a>
      <a href="{{route('matches')}}" class="btn btn-primary text-uppercase">Match Prediction <div class="fill-two">
        </div>
      </a>
    </div>
  </div>
</div>
<!--Main Content Start-->
<div class="main-content wf100">
  <!--Sports Intro Start-->
  <section class="wf100 p80 bg-dark">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="section-title white">
            <h2 class="text-uppercase">Welcome to me scoreAI</h2>
          </div>
          <ul class="list-1 text-white">
            <li>
              99% of fans don't know about this AI football prediction
            </li>
            <li>This prediction has an accuracy rate of over 85%</li>
            <li>
              After extensive research and testing, AI football
              predictions, me scoreAI have been launched
            </li>
            <li>
              Currently, me scoreAI relies on big data analysis and AI
              filtering algorithms, achieving a hit rate of over 85%
            </li>
            <li>
              Most of the data comes from the API-Football provided by the
              Rapid API platform
            </li>
            <li>
              Through AI algorithm deductions, me scoreAI directly
              provides predictions and explanations in a simplified form.
            </li>
            <li>
              Some players have already earned a good income through AI
              football predictions.
            </li>
            <li>
              Joining me scoreAI, you can get accurate football
              predictions and watch live football matches for free.
            </li>
          </ul>
          <div class="d-flex align-items-center justify-content-center">
            <a href="https://t.me/mescoreai/" class="m-4 btn-primary text-uppercase">Hurry and join Telegram!</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--Sports Intro End-->
  <!--Sports Video Start-->
  <section class="team-squad wf100 p80-50">
    <div class="container">
      <div class="d-flex justify-content-center align-items-center">
        <video controls class="video" poster="{{asset('images/cover.jpg')}}">
          <source src="video/me_ai_score_2.mp4?v=20240514" type="video/mp4" />
        </video>
        <!-- <iframe
          width="560"
          height="315"
          src="https://www.youtube.com/embed/3Ry3pQ3Cq7k?si=eosoG2ak9TyCMmE2"
          title="YouTube video player"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          referrerpolicy="strict-origin-when-cross-origin"
          allowfullscreen></iframe> -->
      </div>
    </div>
  </section>
  <!--Sports Video End-->

  <!--Plan Start-->
  <section class="plan wf100 p80">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="text-center">
            <h2 class="text-uppercase">Our Plan</h2>
            <p>
              We offer full access to all the football tips, statistics,
              filters and any other functionality.
            </p>
          </div>
        </div>
      </div>
      <table class="tb-plan mt-4">
        <thead>
          <tr>
            <th>
              me scoreAI lifetime subscription <br />
              <img src="images/logo-white.png" style="max-height: 24px" />
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>
              Deposit at least RM50 in me88
              <hr />
              Full Access
            </th>
          </tr>
          <tr>
            <td><br />Predict Correct Rate 90.7%</td>
          </tr>
          <tr>
            <td>Ai Prediction</td>
          </tr>
          <tr>
            <td>Tips for Eurocup and English Premier League</td>
          </tr>
          <tr>
            <td>1x2 tips</td>
          </tr>
          <tr>
            <td>Correct Score Prediction</td>
          </tr>
          <tr>
            <td>Total Goal Tips</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td>
              <a href="https://playme1.asia/register?affid=5678" class="btn btn-primary btn-animate"
                style="text-transform: inherit">
                DEPOSIT me88 NOW
              </a>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </section>

  <!--Subscription start-->
  <section class="subscription wf100 p40">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <div class="title">
          <h1>Subscription</h1>
          <p>Submit your detail for subscription now</p>
        </div>
        <div class="button">
          <a data-toggle="modal" data-target="#modalSubscription"
            class="btn btn-primary text-uppercase">Subscription</a>
        </div>
      </div>
    </div>
  </section>
  <!--Subscription end-->
</div>
<!--Main Content End-->
@endsection

@section('footer')



@endsection