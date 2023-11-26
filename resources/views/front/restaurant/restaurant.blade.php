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
                        <div class="hero-text">Restaurant</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section padding-top-bottom z-bigger">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 align-self-center">
                    <div class="subtitle with-line text-center mb-4">main dishes</div>
                    <h3 class="text-center padding-bottom-small">Our menu</h3>
                </div>
                <div class="section clearfix"></div>
                @foreach ($restaurants as $restaurant)
                    <div class="col-md-6 mt-5" data-scroll-reveal="enter bottom move 50px over 0.7s after 0.2s">
                        <div class="restaurant-box">
                            @if ($restaurant && $restaurant->image_path)
                                <img style="width: 100%; max-height: 300px;" src="{{ $restaurant->image_path['original'] }}"
                                    alt="{{ $restaurant['title'] }}">
                            @else
                                <img style="width: 100%; max-height: 300px;" src="{{ asset('front_assets/img/room3.jpg') }}"
                                    alt="{{ $restaurant['title'] }}">
                            @endif
                            <h6><span>{{ $restaurant->title }}</span></h6>
                            @if ($restaurant->category)
                                <p><span>{{ $restaurant->category->title ?? '' }}</span></p>
                            @endif
                            <h5><span>NPR {{ $restaurant->price }}</span></h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
@endsection
