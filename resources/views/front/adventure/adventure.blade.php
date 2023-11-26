@extends('front.layouts.master')
@section('content')
    <div class="section big-55-height over-hide z-bigger">

        <div id="poster_background-res"></div>
        <div id="video-wrap" class="parallax-top">
            <video id="video_background" preload="auto" autoplay loop="loop" muted="muted" poster="img/trans.png">
                <source src="video/video-res.mp4" type="video/mp4">
            </video>
        </div>
        <div class="dark-over-pages"></div>

        <div class="hero-center-section pages">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 parallax-fade-top">
                        <div class="hero-text">Adventure</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section padding-top-bottom z-bigger">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 align-self-center">
                    <div class="subtitle with-line text-center mb-4">Thrilling</div>
                    <h3 class="text-center padding-bottom-small">Adventure</h3>
                </div>
                <div class="section clearfix"></div>
                @foreach ($adventures as $adventure)
                    <div class="col-md-6 mt-5" data-scroll-reveal="enter bottom move 50px over 0.7s after 0.2s">
                        <div class="restaurant-box">
                            @if ($adventure && $adventure->image_path)
                                <img style="width: 100%; max-height: 300px;" src="{{ $adventure->image_path['original'] }}"
                                    alt="{{ $adventure['title'] }}">
                            @else
                                <img style="width: 100%; max-height: 300px;" src="{{ asset('front_assets/img/room3.jpg') }}"
                                    alt="{{ $adventure['title'] }}">
                            @endif
                            <h6><span>{{ $adventure->title }}</span></h6>
                            @if ($adventure->category)
                                <p><span>{{ $adventure->category->title ?? '' }}</span></p>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
@endsection
