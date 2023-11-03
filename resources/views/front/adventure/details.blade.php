@extends('front.layouts.master')
@section('content')
    <div class="section big-55-height over-hide">

        <div class="parallax parallax-top" style="background-image: url('img/rooms.jpg')"></div>
        <div class="dark-over-pages"></div>

        <div class="hero-center-section pages">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 parallax-fade-top">
                        <div class="hero-text">{{ $adventure->title }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section padding-top-bottom z-bigger">
        <div class="section z-bigger">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mt-4 mt-lg-0">
                        <div class="section">
                            <div class="customNavigation rooms-sinc-1-2">
                                <a class="prev-rooms-sync-1"></a>
                                <a class="next-rooms-sync-1"></a>
                            </div>
                            <div id="rooms-sync1" class="owl-carousel">
                                <div class="item">
                                    <img src={{ $adventure->image_path['original'] }} alt="">
                                </div>
                            </div>
                        </div>

                        <div class="section pt-5">
                            <h5>discription</h5>
                            <p class="mt-3">{!! $adventure->description !!}</p>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
