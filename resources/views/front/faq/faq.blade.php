@extends('front.layouts.master')
@section('content')
    <div class="section big-55-height over-hide z-bigger">

        <div class="parallax parallax-top" style="background-image: url('img/3.jpg')"></div>
        <div class="dark-over-pages"></div>

        <div class="hero-center-section pages">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 parallax-fade-top">
                        <div class="hero-text">Frequently asked questions</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section padding-top-bottom z-bigger">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 align-self-center">
                    <div class="subtitle with-line text-center mb-4">frequently asked questions</div>
                    <h3 class="text-center padding-bottom-small">General queries</h3>
                </div>


                <div class="section clearfix"></div>

                {{-- @foreach ($faqs as $faq)
                    <div class="col-lg-8 mt-5">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="m-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                            aria-expanded="true" aria-controls="collapseOne">
                                            {{ $faq->title }}
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordion">
                                    <div class="card-body">

                                        {{ $faq->description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach --}}



                <div class="container">
                    <div class="row">
                        <div class="col-lg-3">
                            <!-- Sidebar or any other content you want on the left -->
                        </div>
                        <div class="col-lg-9">
                            @foreach ($faqs->groupBy('faq_category.title') as $categoryTitle => $faqsInCategory)
                                <div class="block">
                                    <h5 class="fs-5">{{ $categoryTitle }}</h5>
                                </div>

                                <div class="row">
                                    @foreach ($faqsInCategory as $faq)
                                        <div class="col-lg-8 mt-4">
                                            <div id="accordion{{ $faq->id }}">
                                                <div class="card">
                                                    <div class="card-header" id="heading{{ $faq->id }}">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link" data-toggle="collapse"
                                                                data-target="#collapse{{ $faq->id }}"
                                                                aria-expanded="true"
                                                                aria-controls="collapse{{ $faq->id }}">
                                                                {{ $faq->title }}
                                                            </button>
                                                        </h5>
                                                    </div>
                                                    <div id="collapse{{ $faq->id }}" class="collapse"
                                                        aria-labelledby="heading{{ $faq->id }}"
                                                        data-parent="#accordion{{ $faq->id }}">
                                                        <div class="card-body">
                                                            {{ $faq->description }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
