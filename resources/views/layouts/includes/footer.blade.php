<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="container d-flex align-items-center">

                    <div class="logo me-auto">
                        <a href="/"><img src="{{ asset('assets/landing/img/Logo.png') }}" alt="" class="img-fluid"></a>
                    </div>

                    <nav id="navbar" class="navbar order-last order-lg-0">
                        <ul>
                            <li><a class="nav-link" href="{{route('terms-condition')}}">Terms and Conditions</a></li>
                            <li><a class="nav-link" href="{{route('privacy')}}">Privacy Policy</a></li>
                            <li><a class="nav-link" href="{{route('faq')}}">FAQs</a></li>
                            <li><a class="nav-link" href="{{route('help')}}">Help</a></li>
                        </ul>
                        <i class="bi bi-list mobile-nav-toggle"></i>
                    </nav><!-- .navbar -->
                </div>
            </div>
        </div>
    </div>
    <img src="{{asset('assets/landing/img/Line 4.png')}}" width="100%" alt="Line 4">
    <div class="container">
        <div class="d-flex flex-column">
            <div class="p-2 mx-auto">
                <div class="header-social-links d-flex align-items-center">
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
            <div class="copyright text-white">Terms and Conditions and Privacy Policy | ©2022 reservecc.com.All Rights Reserved</div>
        </div>
    </div>
</footer><!-- End Footer -->
