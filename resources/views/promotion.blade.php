@extends('layouts.app')

@section('meta_title', $meta->title ?? 'Promotions')
@section('meta_description', $meta->content ?? '')

@section('content')
<div class="main-content innerpagebg wf100" style="background-color: #0d0d0d;">
  <div class="match-results wf100 py-5">
    <div class="container">
      <div class="section-title white">
        <h2 class="text-uppercase">{{ __('messages.text_promotions') }}</h2>
      </div>

      <div class="row justify-content-center">
        @forelse($promotions as $promotion)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
          <a href="{{ $promotion->redirect_url ?? '#' }}" target="_blank"
            class="promo-card d-block position-relative overflow-hidden rounded">

            <!-- Background image -->
            <img
              src="{{ $promotion->thumbnail ? asset('storage/'.$promotion->thumbnail) : asset('images/no_image.jpg') }}"
              alt="{{ $promotion->translate(app()->getLocale())->title ?? 'Promotion' }}"
              class="promo-img w-100 h-100 position-absolute top-0 start-0">

            <!-- Image gradient overlay -->
            <div class="promo-gradient-overlay position-absolute w-100 h-100 top-0 start-0"></div>

            <!-- Content container -->
            <div class="promo-content position-absolute w-100 text-white p-3">
              <h5 class="fw-bold mb-2">{{ $promotion->translate(app()->getLocale())->title ?? '' }}</h5>
              <p class="m-0 small promo-description">
                {{ Str::limit($promotion->translate(app()->getLocale())->short_description ?? '', 120) }}
              </p>
            </div>
          </a>
        </div>
        @empty
        <div class="col-12 text-center text-white">
          <p>{{ __('messages.text_no_promotion_found') }}</p>
        </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection

@section('footer')
<style>
  /* Card layout */
  .promo-card {
    height: 250px;
    background: #000;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
  }

  /* Image zoom effect */
  .promo-img {
    object-fit: cover;
    /* transition: transform 0.5s ease; */
    transition: transform 1s ease, opacity .5s ease .25s;
    transform: scale(1);
    -webkit-transform: scale(1);
  }

  .promo-card:hover .promo-img {
    transform: scale(1.1);
  }

  /* Gradient overlay (for readability) */
  .promo-gradient-overlay {
    background: linear-gradient(to bottom, rgba(15, 15, 15, 0.3), rgba(15, 15, 15, 0.8) 100%);
    z-index: 1;
  }


  /* Title + Description container */
  .promo-content {
    bottom: 0;
    left: 0;
    z-index: 2;
    transition: all 0.4s ease;
    background: linear-gradient(0deg, rgba(0, 0, 0, 0.8) 0%, transparent 100%);
  }


  .promo-content h5 {
    font-size: 16px;
    line-height: 1.3;
    margin: 0;
    transform: translateY(0);
    transition: transform 0.4s ease;
  }

  .promo-content .promo-description {
    max-height: 0;
    overflow: hidden;
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.4s ease;
  }

  /* On hover → both title & description move up */
  .promo-card:hover .promo-content {
    bottom: 0;
    background: linear-gradient(0deg, rgba(0, 0, 0, 0.6) 0%, transparent 100%);
  }

  .promo-card:hover .promo-content h5 {
    transform: translateY(-10px);
  }

  .promo-card:hover .promo-content .promo-description {
    max-height: 80px;
    opacity: 1;
    transform: translateY(-5px);
  }


  /* Title (bottom-left) */
  /* .promo-title {
    bottom: 0;
    left: 0;
    background: linear-gradient(0deg, rgba(0, 0, 0, 0.8) 0%, transparent 100%);
    transition: opacity 0.4s ease;
    z-index: 2;
  }

  .promo-title h5 {
    font-size: 16px;
    line-height: 1.3;
    margin: 0;
  } */

  /* Hidden overlay for description */
  /* .promo-overlay {
    bottom: -100%;
    left: 0;
    background: rgba(0, 0, 0, 0.85);
    background: linear-gradient(0deg, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.1) 100%);
    transition: bottom 0.4s ease;
    z-index: 3;
    padding: 20px;
  } */

  /* Slide up animation */
  /* .promo-card:hover .promo-overlay {
    bottom: 0;
  } */

  /* Hide title when hover */
  /* .promo-card:hover .promo-title {
    opacity: 0;
  } */

  /* Responsive tweak for smaller screens */
  @media (max-width: 576px) {
    .promo-card {
      height: 200px;
    }

    .promo-title h5 {
      font-size: 14px;
    }
  }
</style>
@endsection