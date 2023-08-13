@extends('frontend.layout.head')
@section('body-content')
@include('frontend.layout.header')
    <div class="register-main-wrapper register-verification-sec">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="registerForw">
                        <img src="../images/structure/message-verifyied-gif.gif" class="r-v-messageIcon" alt="">
                        <h3 class="h3 mt-4 mb-4">{{ __('home.EmailVerified') }}</h3>
                        <p class="p1 mb-5">{{ __('home.Thankyouforverifyingouremail') }}</p>
                        <button type="button" class="btn" href="#" data-bs-toggle="modal" data-bs-target=".loginDialog">{{ __('home.Continue') }}</button>
                    </div>
                </div>
                <!-- offer image div -->
                @include('frontend.layout.offer_promotion')
            </div>
        </div>
    </div>
<!-- common models -->
@include('common_modal')
@include('frontend.layout.footer_script')
@endsection