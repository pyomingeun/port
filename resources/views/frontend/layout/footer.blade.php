<footer>
        <div class="container">
            <div class="footerRow1">
                <div class="row">
                    <div class="col-xl-4 col-ld-4 col-md-4 col-sm-12 col-12 footerLogobox">
                        <a href="{{ route('home') }}">
                            <img src="{{asset('/assets/images/')}}/logo/Logo.png" alt="" class="footerLogo">
                        </a>
                        <p class="p2 mb-0 mt-3">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                    <div class="col-xl-3 col-ld-3 col-md-4 col-sm-12 col-12 footermenu">
                        <h6 class="h6 mb-3">{{ __('home.Company') }}</h6>
                        <ul class="footermenu-ul">
                            <li class="footermenu-li mb-2"><a class="footermenu-a" href="#">{{ __('home.WhatistheTravelG') }}</a></li>
                            <li class="footermenu-li mb-2"><a class="footermenu-a" href="about-us.html">{{ __('home.AboutUs') }}</a></li>
                            <li class="footermenu-li mb-2"><a class="footermenu-a" href="#">{{ __('home.PartnerProgram') }}</a></li>
                        </ul>
                    </div>
                    <div class="col-xl-3 col-ld-3 col-md-4 col-sm-12 col-12 footermenu">
                        <h6 class="h6 mb-3">{{ __('home.Contact') }}</h6>
                        <ul class="footermenu-ul">
                            <li class="footermenu-li mb-2"><a class="footermenu-a" href="faq.html">{{ __('home.FAQ') }}</a></li>
                            <li class="footermenu-li mb-2"><a class="footermenu-a" href="help.html">{{ __('home.HelpInquiry') }}</a></li>
                        </ul>
                    </div>
                    <div class="col-xl-2 col-ld-2 col-md-4 col-sm-12 col-12 footermenu">
                        <h6 class="h6 mb-3">{{ __('home.Policy') }}</h6>
                        <ul class="footermenu-ul">
                            <li class="footermenu-li mb-2"><a class="footermenu-a" href="{{ route('privacy_policy') }}">{{ __('home.PrivacyPolicy') }}</a></li>
                            <li class="footermenu-li mb-2"><a class="footermenu-a" href="cookie-policy.html">{{ __('home.CookiePolicy') }}</a></li>
                            <li class="footermenu-li mb-2"><a class="footermenu-a" href="{{ route('term_and_conditions')}}">{{ __('home.TermsofUse') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footerRow2">
                <div class="row">
                    <div class="col-xl-6 col-ld-6 col-md-3 col-sm-6 col-12">
                        <p class="p2 mb-0">©copyright 2023 HankookVillas.com. All rights reserved.</p>
                    </div>
                    <div class="col-xl-6 col-ld-6 col-md-3 col-sm-6 col-12 d-flex align-items-center justify-content-end footer-socialIcons">
                        <a href="#"><img src="{{asset('/assets/images/structure/facebook.svg')}}" alt=""></a>
                        <a href="#"><img src="{{asset('/assets/images/structure/twitter.svg')}}" alt=""></a>
                        <a href="#"><img src="{{asset('/assets/images/structure/instagram.svg')}}" alt=""></a>
                        <a href="#"><img src="{{asset('/assets/images/structure/youtube.svg')}}" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>