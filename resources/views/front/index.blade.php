@extends('front.layouts.master')
@section('content')

    <div class="section background-dark over-hide">

        <div class="hero-center-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-10 col-sm-8 parallax-fade-top">
                        <div class="hero-text">Discover your paradise under the Greek sky</div>
                    </div>

                    <div class="col-12 mt-3 parallax-fade-top">
                        <div class="booking-hero-wrap">
                            <div class="row justify-content-center">
                                <div class="col-5 no-mob">
                                    <div class="input-daterange input-group" id="flight-datepicker">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-item">
                                                    <span class="fontawesome-calendar"></span>
                                                    <input class="input-sm" type="text" autocomplete="off"
                                                        id="start-date-1" name="start" placeholder="chech-in date"
                                                        data-date-format="DD, MM d" />
                                                    <span class="date-text date-depart"></span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-item">
                                                    <span class="fontawesome-calendar"></span>
                                                    <input class="input-sm" type="text" autocomplete="off"
                                                        id="end-date-1" name="end" placeholder="check-out date"
                                                        data-date-format="DD, MM d" />
                                                    <span class="date-text date-return"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5 no-mob">
                                    <div class="row">
                                        <div class="col-6">
                                            <select name="adults" class="wide">
                                                <option data-display="adults">adults</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <select name="children" class="wide">
                                                <option data-display="children">children</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6  col-sm-4 col-lg-2">
                                    <a class="booking-button" href="search.html">book now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="slideshow">
            @foreach ($sliders as $key => $item)
                @if ($key == 0)
                    <div class="slide slide--current parallax-top">
                        <figure class="slide__figure">
                            <div class="slide__figure-inner">
                                <div class="slide__figure-img"
                                    style="background-image: url({{ $item->image_path['original'] }})"></div>
                                <div class="slide__figure-reveal"></div>
                            </div>
                        </figure>
                    </div>
                @else
                    <div class="slide parallax-top">
                        <figure class="slide__figure">
                            <div class="slide__figure-inner">
                                <div class="slide__figure-img"
                                    style="background-image: url({{ $item->image_path['original'] }})"></div>
                                <div class="slide__figure-reveal"></div>
                            </div>
                        </figure>
                    </div>
                @endif
            @endforeach
            <!-- revealer -->
            <div class="revealer">
                <div class="revealer__item revealer__item--left"></div>
                <div class="revealer__item revealer__item--right"></div>
            </div>
            <nav class="arrow-nav fade-top">
                <button class="arrow-nav__item arrow-nav__item--prev">
                    <svg class="icon icon--nav">
                        <use xlink:href="#icon-nav"></use>
                    </svg>
                </button>
                <button class="arrow-nav__item arrow-nav__item--next">
                    <svg class="icon icon--nav">
                        <use xlink:href="#icon-nav"></use>
                    </svg>
                </button>
            </nav>
            <!-- navigation -->
            <nav class="nav fade-top">
                <button class="nav__button">
                    <span class="nav__button-text"></span>
                </button>
                <h2 class="nav__chapter">discover your paradise</h2>
                <div class="toc">
                    @foreach ($sliders as $key => $item)
                        <a class="toc__item" href="#entry-{{ $key }}">
                            <span class="toc__item-title">{{ $item->title }}</span>
                        </a>
                    @endforeach
                </div>
            </nav>
            <!-- little sides -->
            <div class="slideshow__indicator"></div>
            <div class="slideshow__indicator"></div>
        </div>
    </div>


    <div class="section padding-top-bottom over-hide">
        <div class="container">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <div class="row justify-content-center">
                        <div class="col-10">
                            <div class="subtitle text-center mb-4">Newari Cuisine & Many More</div>
                            <h2 class="text-center">Explore Newari Cuisine with Us!</h2>
                            <p class="text-center mt-5">At our restaurant, we take pride in offering a diverse menu inspired
                                by the traditions of Newari cuisine, bringing you a delectable array of dishes that capture
                                the essence of this culinary heritage. From savory delights to sweet temptations, our menu
                                showcases the finest ingredients and culinary expertise, promising a delightful experience
                                for your palate.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="img-wrap">
                        <img src="{{ asset('front_assets/img/rooms.png') }}" alt="">
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
                        <img src="{{ asset('front_assets/img/room1.jpg') }}" alt="">
                        <div class="text-element-over">Abseiling & Many more adventure</div>
                    </div>
                </div>
                <div class="col-xl-6 px-0 mt-4 mt-xl-0 align-self-center">
                    <div class="row justify-content-center">
                        <div class="col-10 col-xl-8 text-center">
                            <h3 class="text-center">Abseiling & Many more adventure</h3>
                            <p class="text-center mt-4">Experience the thrill of abseiling and a plethora of other
                                adventures with us! From rock climbing to exploring hidden caves, our exciting activities
                                cater to all adventure enthusiasts. Join us for an unforgettable journey filled with
                                adrenaline and discovery</p>
                            <a class="mt-5 btn btn-primary" href="search.html">check availability</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mx-0">
                <div class="col-xl-6 px-0 mt-4 mt-xl-0 pb-5 pb-xl-0 align-self-center">
                    <div class="row justify-content-center">
                        <div class="col-10 col-xl-8 text-center">
                            <h3 class="text-center">Live music every weekend</h3>
                            <p class="text-center mt-4">Elevate your weekends with our mesmerizing live music events!
                                Immerse yourself in the soulful tunes and lively beats as our talented musicians create an
                                electrifying ambiance. Gather your friends, sip on your favorite drinks, and let the music
                                weave unforgettable memories. From acoustic serenades to energetic performances, our
                                weekends are filled with musical magic.</p>
                            <a class="mt-5 mb-3 btn btn-primary" href="search.html">check availability</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 px-0 order-first order-xl-last mt-5 mt-xl-0">
                    <div class="img-wrap" id="rev-2">
                        <img src="{{ asset('front_assets/img/room2.jpg') }}" alt="">
                        <div class="text-element-over">Live Music</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section background-dark over-hide">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <a href="services.html">
                        <div class="img-wrap services-wrap">
                            <img src="{{ asset('front_assets/img/ser-1.jpg') }}" alt="">
                            <div class="services-text-over">spa salon</div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3 pt-4 pt-sm-0">
                    <a href="services.html">
                        <div class="img-wrap services-wrap">
                            <img src="{{ asset('front_assets/img/ser-2.jpg') }}" alt="">
                            <div class="services-text-over">restaurant</div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3 pt-4 pt-lg-0">
                    <a href="services.html">
                        <div class="img-wrap services-wrap">
                            <img src="{{ asset('front_assets/img/ser-3.jpg') }}" alt="">
                            <div class="services-text-over">pool</div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3 pt-4 pt-lg-0">
                    <a href="services.html">
                        <div class="img-wrap services-wrap">
                            <img src="{{ asset('front_assets/img/ser-4.jpg') }}" alt="">
                            <div class="services-text-over">activities</div>
                        </div>
                    </a>
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
                <div class="col-sm-6 col-lg-4">
                    <div class="services-box text-center">
                        <img src="{{ asset('front_assets/img/1.svg') }}" alt="">
                        <h5 class="mt-2">Poolside Sitting Area</h5>
                        <p class="mt-3">Relax by our pristine poolside sitting area, perfect for unwinding after a day of
                            exploration.</p>
                        <a class="mt-1 btn btn-primary" href="services.html">read more</a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 mt-5 mt-sm-0">
                    <div class="services-box text-center">
                        <img src="{{ asset('front_assets/img/2.svg') }}" alt="">
                        <h5 class="mt-2">Terrace Sitting Area</h5>
                        <p class="mt-3">Enjoy the scenic beauty from our terrace sitting area, ideal for a peaceful
                            evening.</p>
                        <a class="mt-1 btn btn-primary" href="services.html">read more</a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 mt-5 mt-lg-0">
                    <div class="services-box text-center">
                        <img src="{{ asset('front_assets/img/3.svg') }}" alt="">
                        <h5 class="mt-2">Garden Sitting Area</h5>
                        <p class="mt-3">Immerse yourself in nature at our garden sitting area, surrounded by blooming
                            flowers and lush greenery.</p>
                        <a class="mt-1 btn btn-primary" href="services.html">read more</a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 mt-5">
                    <div class="services-box text-center">
                        <img src="{{ asset('front_assets/img/4.svg') }}" alt="">
                        <h5 class="mt-2">Private Nest Area</h5>
                        <p class="mt-3">Experience ultimate privacy in our exclusive private nest area, designed for a
                            cozy and intimate stay.</p>
                        <a class="mt-1 btn btn-primary" href="services.html">read more</a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 mt-5">
                    <div class="services-box text-center">
                        <img src="{{ asset('front_assets/img/5.svg') }}" alt="">
                        <h5 class="mt-2">Typical Newari Siting Area</h5>
                        <p class="mt-3">Immerse yourself in the rich cultural heritage of Nepal at our typical Newari
                            sitting area, adorned with traditional decor.</p>
                        <a class="mt-1 btn btn-primary" href="services.html">read more</a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 mt-5">
                    <div class="services-box text-center">
                        <img src="{{ asset('front_assets/img/6.svg') }}" alt="">
                        <h5 class="mt-2">Party / Seminar Halll</h5>
                        <p class="mt-3">Host your events in style at our versatile party and seminar hall, equipped with
                            modern amenities.</p>
                        <a class="mt-1 btn btn-primary" href="services.html">read more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section padding-top-bottom-big over-hide">
        <div class="parallax" style="background-image: url('{{ asset('front_assets/img/4.jpg') }}');"></div>
        <div class="section z-bigger">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="col-md-6 col-xl-4 px-sm-0">
                                <div class="booking-sep-wrap">
                                    <div class="input-daterange input-group" id="flight-datepicker-1">
                                        <div class="form-item">
                                            <span class="fontawesome-calendar"></span>
                                            <input class="input-sm" type="text" autocomplete="off" id="start-date"
                                                name="start" placeholder="check-in" data-date-format="DD, MM d" />
                                            <span class="date-text date-depart"></span>
                                        </div>
                                        <div class="form-item">
                                            <span class="fontawesome-calendar"></span>
                                            <input class="input-sm" type="text" autocomplete="off" id="end-date"
                                                name="end" placeholder="check-out" data-date-format="DD, MM d" />
                                            <span class="date-text date-return"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xl-2 px-sm-0">
                                <div class="quantity">
                                    <input type="number" min="1" max="9999" step="1" value="1">
                                </div>
                            </div>
                            <div class="col-md-3 col-xl-2 px-sm-0">
                                <a class="booking-button-big" href="search.html">check<br>availability</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section padding-top-bottom over-hide background-grey">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 align-self-center">
                    <div class="subtitle with-line text-center mb-4">luxury</div>
                    <h3 class="text-center padding-bottom-small">Our rooms</h3>
                </div>
                <div class="section clearfix"></div>
                @foreach ($rooms as $room)
                    <div class="col-md-6 mt-5">
                        <div class="room-box background-white">
                            <div class="room-name">{{ $room->category->title ?? '' }}</div>

                            @if ($room && $room->image_path)
                                <img src="{{ $room->image_path['original'] }}" alt="{{ $room['title'] }}">
                            @else
                                <img src="{{ asset('front_assets/img/room3.jpg') }}" alt="{{ $room['title'] }}">
                            @endif
                            <div class="room-box-in">
                                <h5 class="">{{ $room['title'] }}</h5>
                                <p class="mt-3">{!! Str::limit($room->description, 100, '...') !!}</p>
                                <a class="mt-1 btn btn-primary" href="rooms-gallery.html">book from 130$</a>
                                <div class="room-icons mt-4 pt-4">
                                    <img src="{{ asset('front_assets/img/5.svg') }}" alt="">
                                    <img src="{{ asset('front_assets/img/2.svg') }}" alt="">
                                    <img src="{{ asset('front_assets/img/3.svg') }}" alt="">
                                    <img src="{{ asset('front_assets/img/1.svg') }}" alt="">
                                    <a href="rooms-gallery.html">full info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="section padding-top-bottom-big over-hide">
        <div class="parallax" style="background-image: url('{{ asset('front_assets/img/5.jpg') }}');"></div>
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
    </div>

    <div class="section padding-top-bottom-small background-dark-2 over-hide">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h5 class="color-grey">A new dimension of luxury.</h5>
                    <p class="color-white mt-3 mb-3"><em>our presentation, 0:48 min</em></p>
                    <a href="https://vimeo.com/54851233" class="video-button" data-fancybox><i
                            class="fa fa-play"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="section padding-top-bottom background-grey over-hide">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 align-self-center">
                    <div class="subtitle with-line text-center mb-4">Ready to Serve</div>
                    <h3 class="text-center padding-bottom-small">Camp Fire &amp; BBQ</h3>
                </div>
                <div class="section clearfix"></div>
            </div>
            <div class="row background-white p-0 m-0">
                <div class="col-xl-6 p-0">
                    <div class="img-wrap" id="rev-3">
                        <img src="{{ asset('front_assets/img/rest-1.jpg') }}" alt="">
                    </div>
                </div>
                <div class="col-xl-6 p-0 align-self-center">
                    <div class="row justify-content-center">
                        <div class="col-9 pt-4 pt-xl-0 pb-5 pb-xl-0 text-center">
                            <h5 class="">Camp Fire</h5>
                            <p class="mt-3">Gather around our cozy campfire and enjoy the warmth as you share stories and
                                create lasting memories. Experience the joy of togetherness under the starlit sky.</p>
                            <a class="mt-1 btn btn-primary" href="restaurant.html">explore</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row background-white p-0 m-0">
                <div class="col-xl-6 p-0 align-self-center">
                    <div class="row justify-content-center">
                        <div class="col-9 pt-4 pt-xl-0 pb-5 pb-xl-0 text-center">
                            <h5 class="">Excellent BBQ</h5>
                            <p class="mt-3">Indulge in our excellent BBQ offerings, expertly prepared and served with a
                                touch of perfection. Savor the rich flavors and delight your taste buds with our culinary
                                creations.</p>
                            <a class="mt-1 btn btn-primary" href="restaurant.html">explore</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 order-first order-xl-last p-0">
                    <div class="img-wrap" id="rev-4">
                        <img src="{{ asset('front_assets/img/rest-2.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section padding-top z-bigger">
        <div class="container">
            <div class="row justify-content-center padding-bottom-smaller">
                <div class="col-md-8">
                    <div class="subtitle with-line text-center mb-4">get in touch</div>
                    <h3 class="text-center padding-bottom-small">drop us a line</h3>
                </div>
                <div class="section clearfix"></div>
                <div class="col-md-6 col-lg-4">
                    <div class="address">
                        <div class="address-in text-left">
                            <p class="color-black">Address:</p>
                        </div>
                        <div class="address-in text-right">
                            <p>{{ getSiteSetting()->address ?? 'Kathmandu' }}</p>
                        </div>
                    </div>
                    <div class="address">
                        <div class="address-in text-left">
                            <p class="color-black">City:</p>
                        </div>
                        <div class="address-in text-right">
                            <p>{{ getSiteSetting()->city ?? 'Kathmandu' }}</p>
                        </div>
                    </div>
                    <div class="address">
                        <div class="address-in text-left">
                            <p class="color-black">Check-In:</p>
                        </div>
                        <div class="address-in text-right">
                            <p>8:00 am</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="address">
                        <div class="address-in text-left">
                            <p class="color-black">Phone:</p>
                        </div>
                        <div class="address-in text-right">
                            <p>{{ getSiteSetting()->phone ?? '98*******' }}</p>
                        </div>
                    </div>
                    <div class="address">
                        <div class="address-in text-left">
                            <p class="color-black">Email:</p>
                        </div>
                        <div class="address-in text-right">
                            <p>{{ getSiteSetting()->email ?? '98*******' }}</p>
                        </div>
                    </div>
                    <div class="address">
                        <div class="address-in text-left">
                            <p class="color-black">Check-Out:</p>
                        </div>
                        <div class="address-in text-right">
                            <p>8:00 am</p>
                        </div>
                    </div>
                </div>
                <div class="section clearfix"></div>
                <div class="col-md-8 text-center mt-5" data-scroll-reveal="enter bottom move 50px over 0.7s after 0.2s">
                    <p class="mb-0"><em>available at: 8am - 10pm</em></p>
                    <h2 class="text-opacity">{{ getSiteSetting()->phone ?? '98*******' }}</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="subscribe-home">
                        <input type="text" placeholder="your email here" />
                        <button data-lang="en">subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div id="owl-sep-2" class="owl-carousel owl-theme">
            <div class="item">
                <a href="{{ asset('front_assets/img/gallery/1.jpg') }}" data-fancybox="gallery">
                    <div class="img-wrap gallery-small">
                        <img src="{{ asset('front_assets/img/gallery/1-s.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{ asset('front_assets/img/gallery/2.jpg') }}" data-fancybox="gallery">
                    <div class="img-wrap gallery-small">
                        <img src="{{ asset('front_assets/img/gallery/2-s.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{ asset('front_assets/img/gallery/3.jpg') }}" data-fancybox="gallery">
                    <div class="img-wrap gallery-small">
                        <img src="{{ asset('front_assets/img/gallery/3-s.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{ asset('front_assets/img/gallery/4.jpg') }}" data-fancybox="gallery">
                    <div class="img-wrap gallery-small">
                        <img src="{{ asset('front_assets/img/gallery/4-s.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{ asset('front_assets/img/gallery/5.jpg') }}" data-fancybox="gallery">
                    <div class="img-wrap gallery-small">
                        <img src="{{ asset('front_assets/img/gallery/5-s.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{ asset('front_assets/img/gallery/6.jpg') }}" data-fancybox="gallery">
                    <div class="img-wrap gallery-small">
                        <img src="{{ asset('front_assets/img/gallery/6-s.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{ asset('front_assets/img/gallery/7.jpg') }}" data-fancybox="gallery">
                    <div class="img-wrap gallery-small">
                        <img src="{{ asset('front_assets/img/gallery/7-s.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{ asset('front_assets/img/gallery/8.jpg') }}" data-fancybox="gallery">
                    <div class="img-wrap gallery-small">
                        <img src="{{ asset('front_assets/img/gallery/8-s.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{ asset('front_assets/img/gallery/9.jpg') }}" data-fancybox="gallery">
                    <div class="img-wrap gallery-small">
                        <img src="{{ asset('front_assets/img/gallery/9-s.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{ asset('front_assets/img/gallery/10.jpg') }}" data-fancybox="gallery">
                    <div class="img-wrap gallery-small">
                        <img src="{{ asset('front_assets/img/gallery/10-s.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{ asset('front_assets/img/gallery/1.jpg') }}" data-fancybox="gallery">
                    <div class="img-wrap gallery-small">
                        <img src="{{ asset('front_assets/img/gallery/1-s.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{ asset('front_assets/img/gallery/2.jpg') }}" data-fancybox="gallery">
                    <div class="img-wrap gallery-small">
                        <img src="{{ asset('front_assets/img/gallery/2-s.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{ asset('front_assets/img/gallery/3.jpg') }}" data-fancybox="gallery">
                    <div class="img-wrap gallery-small">
                        <img src="{{ asset('front_assets/img/gallery/3-s.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{ asset('front_assets/img/gallery/4.jpg') }}" data-fancybox="gallery">
                    <div class="img-wrap gallery-small">
                        <img src="{{ asset('front_assets/img/gallery/4-s.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{ asset('front_assets/img/gallery/5.jpg') }}" data-fancybox="gallery">
                    <div class="img-wrap gallery-small">
                        <img src="{{ asset('front_assets/img/gallery/5-s.jpg') }}" alt="">
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
