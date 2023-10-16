<div class="section padding-top-bottom-small background-black over-hide footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3 text-center text-md-left">
                <img src="{{ getSiteSetting()->footer_logo_path['original'] ?? asset('front_assets/img/logo.png') }}"
                    alt="">
                <p class="color-grey mt-4">
                    {{ getSiteSetting()->address ?? 'Kathmandu' }}<br>{{ getSiteSetting()->city ?? 'Kathmandu' }}</p>
            </div>
            <div class="col-md-4 text-center text-md-left">
                <h6 class="color-white mb-3">information</h6>
                <a href="{{ route('front.room') }}">Rooms</a>
                <a href="{{ route('front.room') }}">Services</a>
                <a href="{{ route('front.restaurant') }}">Restaurant</a>
                <a href="{{ route('front.restaurant') }}">Faq</a>
                <a href="#">Gallery & images</a>
            </div>
            <div class="col-md-5 mt-4 mt-md-0 text-center text-md-left logos-footer">
                <h6 class="color-white mb-3">about us</h6>
                <p class="color-grey mb-4">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis
                    praesentium voluptatum deleniti atque corrupti quos dolores.</p>
            </div>
        </div>
    </div>
</div>

<div class="section py-4 background-dark over-hide footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-left mb-2 mb-md-0">
                <p>2023 © Mamaghar. All rights reserved.</p>
            </div>
            @if (getSiteSetting() && (getSiteSetting()->facebook || getSiteSetting()->twitter || getSiteSetting()->instagram))
                <div class="col-md-6 text-center text-md-right">
                    @if (getSiteSetting() && getSiteSetting()->facebook)
                        <a href="{{ getSiteSetting()->facebook }}" class="social-footer-bottom">Facebook</a>
                    @endif
                    @if (getSiteSetting() && getSiteSetting()->twitter)
                        <a href="{{ getSiteSetting()->twitter }}" class="social-footer-bottom">Twitter</a>
                    @endif
                    @if (getSiteSetting() && getSiteSetting()->instagram)
                        <a href="{{ getSiteSetting()->instagram }}" class="social-footer-bottom">Instagram</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
