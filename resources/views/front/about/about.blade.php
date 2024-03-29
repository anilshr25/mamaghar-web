@extends('front.layouts.master')
@section('content')
    <div class="section big-55-height over-hide z-bigger">

        <div id="poster_background-about"></div>
        <div id="video-wrap" class="parallax-top">
            <video id="video_background" preload="auto" autoplay loop="loop" muted="muted" poster="img/trans.png">
                <source src="video/video-about.mp4" type="video/mp4">
            </video>
        </div>
        <div class="dark-over-pages"></div>

        <div class="hero-center-section pages">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 parallax-fade-top">
                        <div class="hero-text">About Us</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section padding-top-bottom-smaller background-dark-2 over-hide">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h5 class="color-grey">A new dimension of luxury.</h5>
                    <p class="color-white mt-3 mb-3"><em>our presentation, 0:48 min</em></p>
                    <a href="https://vimeo.com/54851233" class="video-button" data-fancybox><i class="fa fa-play"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="section padding-top-bottom over-hide">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 align-self-center">
                    <div class="subtitle with-line text-center mb-4">a bit about us</div>
                    <h3 class="text-center padding-bottom-small">finest home stay</h3>
                </div>
                <div class="section clearfix"></div>
                <div class="col-md-4">
                    <div class="services-box text-center">
                        <img src="img/4.svg" alt="">
                        <h5 class="mt-2">Newari Cuisine & Many More</h5>
                        <p class="mt-3">Indulge in the rich flavors of traditional Newari cuisine and a variety of
                            delectable dishes that cater to every palate. Our menu offers a culinary journey through Nepali
                            gastronomy.</p>
                        <a class="mt-1 btn btn-primary" href="#">read more</a>
                    </div>
                </div>
                <div class="col-md-4 mt-5 mt-md-0">
                    <div class="services-box text-center">
                        <img src="img/5.svg" alt="">
                        <h5 class="mt-2">Seminar and Party Hall</h5>
                        <p class="mt-3">Host your seminars, conferences, and parties in our well-equipped halls. With
                            modern amenities and flexible setups, we ensure your events are successful and memorable.</p>
                        <a class="mt-1 btn btn-primary" href="#">read more</a>
                    </div>
                </div>
                <div class="col-md-4 mt-5 mt-md-0">
                    <div class="services-box text-center">
                        <img src="img/6.svg" alt="">
                        <h5 class="mt-2">Abseiling & Many more adventure</h5>
                        <p class="mt-3">Embark on thrilling adventures with our abseiling and various outdoor activities.
                            Experience the adrenaline rush while exploring the natural beauty of the surroundings.</p>
                        <a class="mt-1 btn btn-primary" href="#">read more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section background-grey over-hide">
        <div class="container-fluid px-0">
            <div class="row mx-0">
                <div class="col-xl-6 px-0">
                    <div class="img-wrap" id="rev-1">
                        <img src="img/room1.jpg" alt="">
                        <div class="text-element-over">private pool suite</div>
                    </div>
                </div>
                <div class="col-xl-6 px-0 mt-4 mt-xl-0 align-self-center">
                    <div class="row justify-content-center">
                        <div class="col-10 col-xl-8 text-center">
                            <h3 class="text-center">Why
                                MAMAGHAR ?</h3>
                            <p class="text-center mt-4">Mamaghar welcomes you to the comforts of homely feeling backed by
                                the warmin of our stalis, impeccable service and delicious cuisines. with the objective of
                                providing homely feel to our services, we are here to cater to your
                                all necas. Away from the chaos of the city lying alongside the lush Gokarna forest, we are
                                situated at a perfect place to breathe in tres air and enjoy the greenery. Whether you want
                                a stress-free base for doing business or a relaxing environment with friends and lamily, we
                                can be your perect companion.</p>
                            <a class="mt-5 btn btn-primary" href="#">check availability</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mx-0">
                <div class="col-xl-6 px-0 mt-4 mt-xl-0 pb-5 pb-xl-0 align-self-center">
                    <div class="row justify-content-center">
                        <div class="col-10 col-xl-8 text-center">
                            <h3 class="text-center">About
                                MAMAGHAR</h3>
                            <p class="text-center mt-4">Mamaghar is located at Deshe, Gokarna,
                                KTM - an important historical and cultural hub.
                                If you are looking forward for fun activities to do near our location - religiously
                                significant
                                Sites as
                                Gokarneshwor
                                Mahadev, Uttargaya are just minutes' walk away.
                                Yagyadol (Jagdol)
                                IS another near
                                destination. For the nature lovers, Nagi Gumba hike and Shivapuri hike are other special
                                attractions.</p>
                            <a class="mt-5 mb-5 btn btn-primary" href="#">check availability</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 px-0 order-first order-xl-last mt-5 mt-xl-0">
                    <div class="img-wrap" id="rev-2">
                        <img src="img/room2.jpg" alt="">
                        <div class="text-element-over">sea view suite</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="section padding-top-bottom-big over-hide">
        <div class="parallax" style="background-image: url('img/5.jpg')"></div>
        <div class="section z-bigger">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div id="owl-sep-1" class="owl-carousel owl-theme">
                            <div class="item">
                                <div class="quote-sep">
                                    <h4>"Chilling out on the bed in your hotel room watching television, while wearing your
                                        own pajamas, is sometimes the best part of a vacation."</h4>
                                    <h6>Jason Salvatore</h6>
                                </div>
                            </div>
                            <div class="item">
                                <div class="quote-sep">
                                    <h4>"Every good day starts off with a cappuccino, and there's no place better to enjoy
                                        some frothy caffeine than at the Mamaghar Hotel."</h4>
                                    <h6>Terry Mitchell</h6>
                                </div>
                            </div>
                            <div class="item">
                                <div class="quote-sep">
                                    <h4>"I still enjoy traveling a lot. I mean, it amazes me that I still get excited in
                                        hotel rooms just to see what kind of shampoo they've left me."</h4>
                                    <h6>Michael Brighton</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="section background-dark over-hide">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <a href="#">
                        <div class="img-wrap services-wrap">
                            <img src="img/ser-1.jpg" alt="">
                            <div class="services-text-over">spa salon</div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3 pt-4 pt-sm-0">
                    <a href="#">
                        <div class="img-wrap services-wrap">
                            <img src="img/ser-2.jpg" alt="">
                            <div class="services-text-over">restaurant</div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3 pt-4 pt-lg-0">
                    <a href="#">
                        <div class="img-wrap services-wrap">
                            <img src="img/ser-3.jpg" alt="">
                            <div class="services-text-over">pool</div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3 pt-4 pt-lg-0">
                    <a href="#">
                        <div class="img-wrap services-wrap">
                            <img src="img/ser-4.jpg" alt="">
                            <div class="services-text-over">activities</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
