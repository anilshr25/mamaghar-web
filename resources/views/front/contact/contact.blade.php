@extends('front.layouts.master')
@section('content')
    <div class="section big-55-height over-hide z-bigger">

        <div class="parallax parallax-top" style="background-image: url('img/gallery/10.jpg')"></div>
        <div class="dark-over-pages"></div>

        <div class="hero-center-section pages">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 parallax-fade-top">
                        <div class="hero-text">Get in Touch</div>
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

    <div class="section padding-top z-bigger">
        <div class="container">
            <div class="row justify-content-center padding-bottom-smaller">
                <form action="{{ route('inquery') }}" method="post">
                    @csrf
                    <div class="col-md-12">
                        <div class="subtitle with-line text-center mb-4">get in touch</div>
                        <h3 class="text-center padding-bottom-small">drop us a line</h3>
                    </div>
                    <div class="section clearfix"></div>
                    <div class="col-md-12 mt-5 ajax-form">
                        <input name="first_name" type="text" placeholder="First Name: *" autocomplete="off" />
                    </div>
                    <div class="col-md-12 mt-5 ajax-form">
                        <input name="last_name" type="text" placeholder="Last Name: *" autocomplete="off" />
                    </div>
                    <div class="col-md-12 mt-5  ajax-form">
                        <input name="email" type="text" placeholder="E-Mail: *" autocomplete="off" />
                    </div>
                    <div class="col-md-12 mt-5 ajax-form">
                        <input name="phone_no" type="text" placeholder="Phone No: *" autocomplete="off" />
                    </div>
                    <div class="col-md-12 mt-5  ajax-form">
                        <input name="subject" type="text" placeholder="Subject: *" autocomplete="off" />
                    </div>
                    <div class="section clearfix"></div>
                    <div class="col-md-12 mt-4 ajax-form">
                        <textarea name="message" placeholder="Tell Us Everything"></textarea>
                    </div>
                    <div class="section clearfix"></div>
                    <div class="col-md-12 mt-3 ajax-checkbox">
                        <ul class="list">
                            <li class="list__item">
                                <label class="label--checkbox">
                                    <input type="checkbox" class="checkbox">
                                    collect my details through this form
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="section clearfix"></div>
                    <div class="col-md-12 mt-3 ajax-form text-center">
                        <button type="submit" class="send_message" id="send"
                            data-lang="en"><span>submit</span></button>
                    </div>
                </form>
                <div class="section clearfix"></div>
                <div class="col-md-8 padding-top-bottom">
                    <div class="sep-line"></div>
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
                            <p>8:00 pm</p>
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
                            <p>6:00 pm</p>
                        </div>
                    </div>
                </div>
                <div class="section clearfix"></div>
                <div class="col-md-8 text-center mt-5" data-scroll-reveal="enter bottom move 50px over 0.7s after 0.2s">
                    <p class="mb-0"><em>available at: 8am - 6pm</em></p>
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
@endsection
