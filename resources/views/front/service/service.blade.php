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
                        <div class="hero-text">Our Services</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section padding-top-bottom over-hide">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 align-self-center">
                    <div class="subtitle with-line text-center mb-4">MAMA GHAR</div>
                    <h3 class="text-center padding-bottom-small">Special Attraction</h3>
                </div>
                <div class="section clearfix"></div>

                @foreach ($services as $service)
                    <div class="col-sm-6 col-lg-4 mt-3">
                        <div class="services-box text-center">

                            @if ($service && $service->image_path)
                                <img src="{{ $service->image_path['original'] }}" alt="{{ $service['title'] }}">
                            @else
                                <img src="{{ asset('front_assets/img/room3.jpg') }}" alt="{{ $service['title'] }}">
                            @endif
                            <h5 class="mt-2">{{ $service['title'] }}</h5>
                            <p class="mt-3">{!! Str::limit($service->short_description, 100, '...') !!}</p>
                            <a class="mt-1 btn btn-primary" href="services.html">read more</a>
                        </div>


                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
