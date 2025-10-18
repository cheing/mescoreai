@extends('layouts.app')

@section('meta_title', $meta->title ?? '')
@section('meta_description', $meta->content ?? '')
@section('meta_keywords', $meta->keywords ?? '')

@section('content')

<div class="inner-banner-header wf100">
    <h1 data-generated="{{ __('messages.text_blogs') }}">{{ __('messages.text_blogs') }}</h1>
</div>

<div class="main-content innerpagebg wf100 p80">
    <div class="container">
        <div class="row">
            <!-- Left Content -->
            <div class="col-lg-8">

                <div class="news-details-wrap">
                    <div class="news-large-post ">
                        <!-- Thumbnail -->
                        @php
                        $image = $blog->thumbnail
                        ? asset('storage/' . $blog->thumbnail)
                        : asset('images/no_image_square.jpg');
                        @endphp
                        <div class="post-thumb">
                            <img src="{{ $image }}" alt="{{ $blog->translate()->title }}" class="img-fluid w-100">
                        </div>

                        <!-- Header -->
                        <div class="post-txt">
                            <h3 class="text-white">{{ $blog->translate()->title }}</h3>
                            <ul class="post-meta">
                                <li><i class="fas fa-user"></i> {{ $blog->author->username ?? 'Smith
                                    Jones' }} </li>
                                <li><i class="fas fa-calendar-alt"></i> {{ $blog->published_at ?
                                    $blog->published_at->format('d M, Y') : '' }}</li>
                                {{-- <li><i class="far fa-comment"></i> 89 Comments</li>
                                <li><i class="far fa-heart"></i> 52 Likes</li> --}}
                            </ul>
                            {{-- <ul class="post-meta">
                                @if($blog->categories->count())
                                <li>
                                    <i class="fas fa-folder-open"></i>
                                    @foreach($blog->categories as $cat)
                                    <a href="{{ route('blog.category', $cat->slug) }}">
                                        {{ $cat->translate()->name }}
                                    </a>{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                </li>
                                @endif
                            </ul> --}}

                            <!-- Content -->
                            <div class="post-content">
                                {!! $blog->translate()->content !!}
                            </div>

                            <!-- Quote / Highlight section (optional) -->
                            {{-- <div class="blockquote my-4">
                                <i class="fas fa-quote-left"></i>
                                <p>{{ $blog->translate()->short_description ?? '' }}</p>
                            </div> --}}

                            <!-- Social Share -->
                            {{-- <div class="share-post my-5">
                                <h5 class="text-uppercase mb-3">{{ __('messages.text_share_post') ?? 'Share this
                                    post'
                                    }}
                                </h5>
                                <ul class="social-links d-flex gap-3">
                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                            target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}"
                                            target="_blank"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="https://www.linkedin.com/shareArticle?url={{ urlencode(request()->url()) }}"
                                            target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="https://wa.me/?text={{ urlencode(request()->url()) }}"
                                            target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                                </ul>
                            </div> --}}

                        </div>


                        <div class="post-bottom">
                            <!--Post Tags start-->
                            <ul class="post-tags">
                                @foreach($blog->categories as $cat)
                                <li> <a href="{{ route('blog.category', $cat->slug) }}">
                                        {{ $cat->translate()->name }}
                                    </a>{{ !$loop->last ? ',' : '' }}</li>
                                @endforeach

                            </ul>
                            <!--Post Tags End-->
                            <!--Author Box Start-->
                            <div class="post-author-box">
                                <img src="{{ asset('images/postauthor.jpg')}}" alt="">
                                <h4>About Author</h4>
                                <p> Curabitur imperdiet ante non vehicula condimentum. Suspendisse id enim iaculis,
                                    maximus mi id, sodales dui. Aenean quis neque rutrum, dignissim nunc vestibulum,
                                    suscipit arcu. Quisque ullamcorper quis nibh sed. </p>
                            </div>
                            <!--Author Box End-->

                        </div>
                    </div>



                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                @include('blogs.sidebar')
            </div>
        </div>

        <!-- Related Posts -->
        @if($relatedPosts ?? false)
        <div class="related-posts mt-5">
            <h4 class="text-uppercase mb-4 text-white">{{ __('messages.text_related_posts') ?? 'Related
                Posts' }}</h4>
            <div class="row">
                @foreach($relatedPosts as $rp)
                @php
                $rpImage = $rp->thumbnail
                ? asset('storage/' . $rp->thumbnail)
                : asset('images/no_image_square.jpg');
                @endphp
                <div class="col-lg-4 col-md-6">

                    <div class="ng-box">
                        <div class="thumb">
                            <a href="{{ route('blog.show', $rp->slug) }}"><i class="fas fa-link"></i></a>
                            <img src="{{ $rpImage }}" alt="{{ $rp->translate()->title }}" class="img-fluid w-100">
                        </div>
                        <div class="ng-txt">
                            <ul class="post-author">
                                <li><img src="{{asset('images/user1.jpg');}} " alt=""> <strong> {{
                                        $rp->author->uername ?? 'Smith
                                        Jones' }} </strong></li>
                                {{-- <li class="likes"><i class="far fa-heart"></i> 52 Likes</li> --}}
                            </ul>
                            <h4><a href="{{ route('blog.show', $rp->slug) }}">{{ $rp->translate()->title
                                    }}</a>
                            </h4>
                            <ul class="post-meta">
                                <li><i class="fas fa-calendar-alt"></i> {{ date('d M, Y',
                                    strtotime($rp->published_at)) }} </li>
                                {{-- <li><i class="far fa-comment"></i> 89 Comments</li> --}}
                            </ul>
                            <p>
                                {{ Str::limit($rp->translate()->short_description, 100) }}
                            </p>
                            <a href="{{ route('blog.show', $rp->slug) }}" class="rm">{{
                                __('messages.text_read_more')
                                }} </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('footer')
<style>
    /* --- Post banner --- */


    .news-large-post {
        background: #111;
        color: #ccc;
        margin: 0;
        padding: 0
            /* border: solid 1px #ff4c00 */
    }

    .blog-single-post .post-thumb img {
        width: 100%;
        height: 450px;
        object-fit: cover;
        border-radius: 10px;
    }

    /* --- Meta Info --- */
    .single-post-header .post-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        list-style: none;
        padding: 0;
        margin: 0 0 10px;
        color: #ccc;
        font-size: 0.9rem;
    }

    .single-post-header .post-meta i {
        color: #ff4c00;
        margin-right: 6px;
    }

    /* --- Quote block --- */
    .blockquote {
        background: #191919;
        border-left: 4px solid #ff4c00;
        padding: 20px;
        font-style: italic;
        color: #ddd;
        border-radius: 5px;
    }

    /* --- Share buttons --- */
    .share-post ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .share-post ul li {
        display: inline-block;
        margin-right: 10px;
    }

    .share-post ul li a {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        background: #ff4c00;
        transition: all 0.3s ease;
    }

    .share-post ul li a:hover {
        background: #ff6c2f;
    }

    /* --- Related posts --- */
    .related-post-card {
        border-radius: 8px;
        overflow: hidden;
        position: relative;
    }

    .related-post-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .related-post-card:hover img {
        transform: scale(1.05);
    }

    .related-post-card .overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(15, 15, 15, 0.1), rgba(15, 15, 15, 0.85));
    }

    .related-info h6 {
        font-weight: 500;
        font-size: 0.95rem;
    }

    /* --- Responsive --- */
    @media (max-width: 991px) {
        .blog-single-post .post-thumb img {
            height: 300px;
        }
    }

    @media (max-width: 576px) {
        .blog-single-post .post-thumb img {
            height: 220px;
        }
    }
</style>
@endsection