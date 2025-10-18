@extends('layouts.app')

@section('meta_title', $meta->title ?? '')
@section('meta_description', $meta->content ?? '')
@section('meta_keywords', $meta->keywords ?? '')

@section('content')


<div class="inner-banner-header wf100 flex-row align-items-center justify-content-center">
    {{-- <h2 class="text-uppercase">{{ $category->translate()->name }}</h2> --}}
    <h1 data-generated="{{ __('messages.text_blogs') }} ">{{ $category->translate()->name }}</h1>
    @if($category->translate()->description)
    <div class="w-75 " style="margin:0 auto">
        <p class="mt-2 text-white px-5 ">{{ $category->translate()->description }}</p>
    </div>
    @endif
    {{-- <div class="gt-breadcrumbs">
        <ul>
            <li> <a href="#" class="active"> <i class="fas fa-home"></i> Home </a> </li>
            <li> <a href="#"> News </a> </li>
            <li> <a href="#"> News List </a> </li>
        </ul>
    </div> --}}
    {{-- style="background-color: #0d0d0d;" --}}
</div>
<div class="main-content innerpagebg wf100 p80">
    <div class="container">

        <div class="row">
            <div class="col-lg-8">
                <div class="news-wrap">
                    @foreach($category->blogs as $blog)
                    <div class="news-list-post">
                        <div class="post-thumb">
                            <a href="{{ route('blog.show', $blog->slug) }}"><i class="fas fa-link"></i></a>
                            <!-- Thumbnail -->
                            @php
                            $image = $blog->thumbnail
                            ? asset('storage/' . $blog->thumbnail)
                            : asset('images/no_image_square.jpg'); // 👈 default image
                            @endphp
                            <img src="{{ $image }}" alt="{{ $blog->translate()->title }}">

                        </div>
                        <!-- Content -->
                        <div class="post-txt">
                            <!-- author -->
                            <ul class="post-author">
                                <li><img src="{{asset('images/user1.jpg');}} " alt=""> <strong> {{
                                        $blog->author->uername ?? 'Smith
                                        Jones' }} </strong></li>
                                {{-- <li class="likes"><i class="far fa-heart"></i> 52 Likes</li> --}}
                            </ul>
                            <!-- Title -->
                            <h4><a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->translate()->title }}</a>
                            </h4>

                            <!-- Meta -->
                            <ul class="post-meta">
                                <li><i class="fas fa-calendar-alt"></i> {{ date('d M, Y',
                                    strtotime($blog->published_at)) }} </li>
                                {{-- <li><i class="far fa-comment"></i> 89 Comments</li> --}}
                            </ul>

                            <!-- Excerpt -->
                            <p>
                                {{ Str::limit($blog->translate()->short_description, 100) }}
                            </p>

                            <a href="{{ route('blog.show', $blog->slug) }}" class="rm">{{ __('messages.text_read_more')
                                }} </a>
                            <!-- Category -->
                            {{-- @if($blog->categories->count())
                            <div class="mb-2">
                                @foreach($blog->categories as $cat)
                                <span class="badge badge-secondary me-1 text-uppercase">
                                    {{ $cat->translate()->name }}
                                </span>
                                @endforeach
                            </div>
                            @endif --}}

                        </div>
                    </div>
                    @endforeach

                </div>

                {{ $blogs->links('vendor.pagination.front') }}
            </div>

            <div class="col-lg-4">
                @include('blogs.sidebar')
            </div>
        </div>


    </div>
</div>

@endsection
@section('footer')
<style>
    /* === Blog List Customization === */

    /* --- Main container --- */
    .news-list-post {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 40px;
        background: #111;
        border-radius: 8px;
        overflow: hidden;
    }

    /* --- Thumbnail (Left side, fixed width) --- */
    .news-list-post .post-thumb {
        position: relative;
        flex: 0 0 40%;
        /* left column width */
        height: 290px;
        /* consistent height for all images */
        overflow: hidden;
        background: #1a1a1a;
    }

    .news-list-post .post-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .news-list-post:hover .post-thumb img {
        transform: scale(1.05);
    }

    /* --- Content area (Right side) --- */
    .news-list-post .post-txt {
        flex: 1;
        padding: 25px 30px;
        background: #0d0d0d;
    }

    /* --- Title & Text --- */
    .news-list-post .post-txt h4 a {
        color: #fff;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .news-list-post .post-txt h4 a:hover {
        color: #ff4c00;
    }

    .news-list-post .post-txt p {
        color: #aaa;
        margin-bottom: 15px;
        line-height: 1.6;
    }

    /* --- Author section --- */
    .news-list-post .post-author img {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        margin-right: 8px;
        object-fit: cover;
    }

    .news-list-post .post-author strong {
        color: #fff;
        font-size: 0.9rem;
    }

    /* --- Meta --- */
    .news-list-post .post-meta {
        margin: 10px 0;
        padding: 0;
        list-style: none;
        display: flex;
        gap: 15px;
        color: #888;
        font-size: 0.85rem;
    }

    .news-list-post .post-meta i {
        color: #ff4c00;
        margin-right: 5px;
    }

    /* --- Read More --- */
    .news-list-post .rm {
        display: inline-block;
        padding: 8px 18px;
        color: #fff;
        background: #ff4c00;
        border-radius: 3px;
        font-size: 0.85rem;
        text-transform: uppercase;
        transition: background 0.3s ease;
    }

    .news-list-post .rm:hover {
        background: #ff6c2f;
    }

    /* --- Responsive --- */
    @media (max-width: 991px) {
        .news-list-post {
            flex-direction: column;
        }

        .news-list-post .post-thumb {
            flex: 0 0 100%;
            width: 100%;
            height: 200px;
            /* shorter for tablets */
        }

        .news-list-post .post-txt {
            padding: 20px;
        }
    }

    @media (max-width: 576px) {
        .news-list-post .post-thumb {
            height: 180px;
            /* mobile height */
        }

        .news-list-post .post-txt h4 {
            font-size: 1.1rem;
        }
    }
</style>
@endsection