<div class="section padding-top-bottom-small background-black over-hide footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3 text-center text-md-left">
                <img src="{{ getSiteSetting()->footer_logo['original'] ?? asset('front_assets/img/mamaghar_logo.jpeg') }}"
                    alt="">
                <p class="color-grey mt-4">
                    {{ getSiteSetting()->address ?? 'Kathmandu' }}<br>{{ getSiteSetting()->city ?? 'Kathmandu' }}</p>
            </div>
            <div class="col-md-4 text-center text-md-left">
                <h6 class="color-white mb-3">information</h6>
                <a href="{{ route('front.room') }}">Rooms</a>
                <a href="{{ route('front.service') }}">Services</a>
                <a href="{{ route('front.restaurant') }}">Restaurant</a>
                <a href="{{ route('front.faq') }}">Faq's</a>
                <a href="{{ route('front.restaurant') }}">Gallery & images</a>
            </div>
            <div class="col-md-5 mt-4 mt-md-0 text-center text-md-left logos-footer">
                <h6 class="color-white mb-3">about us</h6>
                <p class="color-grey mb-4">At our restaurant, we take pride in offering a diverse menu inspired by the
                    traditions of Newari cuisine, bringing you a delectable array of dishes that capture the essence of
                    this culinary heritage. From savory delights to sweet temptations, our menu showcases the finest
                    ingredients and culinary expertise, promising a delightful experience for your palate.</p>
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
