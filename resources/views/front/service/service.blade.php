@extends('front.layouts.master')
@section('content')
    <div class="section padding-top-bottom over-hide">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 align-self-center">
                    <div class="subtitle with-line text-center mb-4">MAMA GHAR</div>
                    <h3 class="text-center padding-bottom-small">Special Attraction</h3>
                </div>
                <div class="section clearfix"></div>

                @foreach ($service as $service)
                    <div class="col-sm-6 col-lg-4">
                        <div class="services-box text-center">

                            @if ($service && $service->image_path)
                                <img src="{{ $service->image_path['original'] }}" alt="{{ $service['title'] }}">
                            @else
                                <img src="{{ asset('front_assets/img/room3.jpg') }}" alt="{{ $service['title'] }}">
                            @endif
                            <h5 class="mt-2">{{ $service['title'] }}</h5>
                            <p class="mt-3">{!! Str::limit($service->description, 100, '...') !!}</p>
                            <a class="mt-1 btn btn-primary" href="services.html">read more</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
