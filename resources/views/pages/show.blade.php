@extends('layouts.app')

@section('meta_title', $meta->title)
@section('meta_description', $meta->description)
@section('meta_keywords', $meta->keywords)

@section('content')

<div class="inner-banner-header wf100">
    <h1 data-generated="{{ $page->translate()->title }}">
        {{ $meta->title}}
    </h1>
</div>

<div class="main-content innerpagebg wf100  page" style="color:#9e9da2">
    {!! $page->translate()->content !!}
</div>
@endsection