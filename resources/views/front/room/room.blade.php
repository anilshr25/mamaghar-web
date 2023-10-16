@extends('front.layouts.master')
@section('content')
    <div class="section big-55-height over-hide z-bigger">

        <div class="parallax parallax-top" style="background-image: url('img/rooms.jpg')"></div>
        <div class="dark-over-pages"></div>

        <div class="hero-center-section pages">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 parallax-fade-top">
                        <div class="hero-text">Our Rooms</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section padding-top-bottom-smaller background-dark over-hide z-too-big">
        <div class="section">
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
                                <a class="booking-button-big" href="#">check<br>availability</a>
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
                                <a class="mt-1 btn btn-primary"
                                    href="{{ route('front.roomdetail', ['slug' => $room->slug]) }}">NPR
                                    {{ $room->price }}</a>
                                <div class="room-icons mt-4 pt-4">
                                    <img src="{{ asset('front_assets/img/5.svg') }}" alt="">
                                    <img src="{{ asset('front_assets/img/2.svg') }}" alt="">
                                    <img src="{{ asset('front_assets/img/3.svg') }}" alt="">
                                    <img src="{{ asset('front_assets/img/1.svg') }}" alt="">
                                    <a href="{{ route('front.roomdetail', ['slug' => $room->slug]) }}">full info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
