<nav id="menu-wrap" class="menu-back cbp-af-header">
    <div class="menu-top background-black">
        <div class="container">
            <div class="row">
                <div class="col-6 px-0 px-md-3 pl-1 py-3">
                    <span class="call-top">call us:</span> <a href="#"
                        class="call-top">{{ getSiteSetting()->phone ?? '98*******' }}</a>
                </div>
                <div class="col-6 px-0 px-md-3 py-3 text-right">
                    <span class="call-top">Email:</span> <a href="#"
                        class="call-top">{{ getSiteSetting()->email ?? 'email' }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="menu">
        <a href="/">
            <div class="logo">
                <img src="{{ getSiteSetting()->logo['original'] ?? asset('front_assets/img/mamaghar_logo.jpeg') }}"
                    alt="">
            </div>
        </a>
        <ul>
            <li>
                <a class="curent-page" href="/">Home</a>
            </li>
            <li>
                <a href="{{ route('front.room') }}">Rooms</a>
            </li>
            <li>
                <a href="{{ route('front.restaurant') }}">Restaurant</a>
            </li>
            <li>
                <a href="{{ route('front.adventure') }}">Adventure</a>
            </li>
            <li>
                <a href="{{ route('front.about') }}">About us</a>
            </li>
            <li>
                <a href="{{ route('front.blog') }}">Blogs</a>
            </li>
            <li>
                <a href="{{ route('front.contact') }}">Contact</a>
            </li>
            <li>
                <a href="#"><span>Book now</span></a>
            </li>
        </ul>
    </div>
</nav>
