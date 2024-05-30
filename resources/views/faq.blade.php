@extends('layouts.app')

@section('content')
<div class="main-content innerpagebg wf100">
  <div class="match-results wf100 p40">
    <div class="container">
      <div class="section-title white">
        <h2 class="text-uppercase">{{ __('messages.text_faq')}} </h2>
      </div>
      <div class="row">
        <div class="col-12">

          <div class="accordion" id="accordionFAQ">
            @foreach($faqs as $faq)

            <div class="card">
              <div class="card-header" id="heading-{{$faq->id}}">
                <a class="btn" type="button" data-toggle="collapse" data-target="#collapse-{{$faq->id}}"
                  aria-expanded="true" aria-controls="collapse-{{$faq->id}}">
                  @if(App::getLocale() == 'en')
                  {{ $faq->title }}
                  @else
                  {{ $faq->title_zh }}
                  @endif
                </a>
              </div>
              <div id="collapse-{{$faq->id}}" class="collapse" aria-labelledby="heading-{{$faq->id}}"
                data-parent="#accordionMatch">
                <div class="card-body p-4  mb-4">
                  @if(App::getLocale() == 'en')
                  {{ $faq->content }}
                  @else
                  {{ $faq->content_zh }}
                  @endif

                </div>
              </div>
            </div>
            @endforeach

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Main Content End-->
@endsection
@section('footer')
<script>
  $(document).ready(function() {
    // Automatically open the first accordion panel
    let firstAccordion = $('#accordionFAQ .collapse').first();
    firstAccordion.addClass('show');
    firstAccordion.prev('.card-header').find('a').attr('aria-expanded', 'true');
});
</script>
@endsection