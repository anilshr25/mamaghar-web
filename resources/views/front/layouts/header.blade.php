<nav id="menu-wrap" class="menu-back cbp-af-header">
    <div class="menu-top background-black">
        <div class="container">
            <div class="row">
                <div class="col-6 px-0 px-md-3 pl-1 py-3">
                    <span class="call-top">call us:</span> <a href="#"
                        class="call-top">{{ getSiteSetting()->phone ?? '98*******' }}</a>
                </div>
                <div class="col-6 px-0 px-md-3 py-3 text-right">
                    <a href="#" class="social-top">fb</a>
                    <a href="#" class="social-top">tw</a>
                    <div class="lang-wrap">
                        eng
                        <ul>
                            <li><a href="#">ger</a></li>
                            <li><a href="#">rus</a></li>
                            <li><a href="#">ser</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="menu">
        <a href="/">
            <div class="logo">
                <img src="{{ getSiteSetting()->logo_path['original'] ?? asset('front_assets/img/logo.png') }}"
                    alt="">
            </div>
        </a>
        <ul>
            <li>
                <a class="curent-page" href="/">Home</a>
            </li>
            <li>
                <a href="room">Rooms</a>
            </li>
            <li>
                <a href="restaurant">Restaurant</a>
            </li>
            <li>
                <a href="restaurant">Adventure</a>
            </li>
            <li>
                <a href="about">About us</a>
            </li>
            <li>
                <a href="news">News</a>
            </li>
            <li>
                <a href="contact">Contact</a>
            </li>
            <li>
                <a href="#"><span>Book now</span></a>
            </li>
        </ul>
    </div>
</nav>
