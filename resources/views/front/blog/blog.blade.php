@extends('front.layouts.master')
@section('content')
    <div>
        <div class="section big-55-height over-hide z-bigger">

            <div class="parallax parallax-top" style="background-image: url('img/explore.jpg')"></div>
            <div class="dark-over-pages"></div>

            <div class="hero-center-section pages">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 parallax-fade-top">
                            <div class="hero-text">Our News and updates</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section padding-top padding-bottom-smaller z-bigger background-grey">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="subtitle with-line text-center mb-4">journal</div>
                        <h3 class="text-center padding-bottom-small">latest news</h3>
                    </div>
                    <div class="section clearfix"></div>
                    @foreach ($blogs as $blog)
                        <div class="col-md-6 col-xl-4 mt-5">
                            <div class="room-box background-white">
                                <img src="{{ asset('front_assets/img/room3.jpg') }}" alt="">
                                <div class="room-box-in">
                                    <h6 class="">{{ $blog->title }}</h6>
                                    <p class="mt-3">{{ $blog->description }}</p>
                                    <a class="mt-1 btn btn-primary" href="post.html">read more</a>
                                    <div class="room-icons news-tags mt-4 pt-4">
                                        <a href="#">{{ $blog->seo_keyword }}</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>

        <div class="section padding-bottom-smaller z-bigger background-grey over-hide">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="project-nav-wrap">
                            <a href="#">
                                <div class="left-nav" data-scroll-reveal="enter left move 60px over 0.9s after 0.1s">new
                                    <div class="text-on-hover">latest news</div>
                                </div>
                            </a>
                            <a href="#">
                                <div class="right-nav" data-scroll-reveal="enter right move 60px over 0.9s after 0.1s">old
                                    <div class="text-on-hover">older news</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
