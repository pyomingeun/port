@extends('frontend.layout.head')
@section('body-content')
@include('frontend.layout.header')
    <div class="register-main-wrapper register-verification-sec">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="registerForw">
                        <img src="../images/structure/message-gif.gif" class="r-v-messageIcon" alt="">
                        <h3 class="h3 mt-4 mb-4">{{ __('home.weVeSentYouALink') }}</h3>
                        <p class="p1 mb-5">{{ __('home.hitTheLinkInTheEmail') }} <a href="javaScript:Void(0);">{{$email}}</a> {{ __('home.toVerifyYourEmailAddress') }}.</p>
                        <button href="email-verified.html" type="button" class="btn" data-email="{{$email}}" id="resendsingupemail">{{ __('home.resendEmail') }}</button> 
                    </div>
                </div>
                <!-- offer image div -->
                @include('frontend.layout.offer_promotion')
            </div>
        </div>
    </div>
    <!-- common models -->
    @include('common_models')
    @include('frontend.layout.footer_script')
    @endsection
    <!-- JS section  -->   
    @section('js-script')
    <script>
        $(document).ready(function(){
            $(document).on('click','#resendsingupemail',function(){
                var email = $('#resendsingupemail').attr('data-email');
                $("#resendsingupemail").prop("disabled",true); 
                loading();
                $.post("{{ route('resend_signup_link') }}", {email:email,_token:"{{ csrf_token() }}"} , function( data ) {
                            console.log(data);
                            if(data.status==1){
                                // window.location.href = data.nextpageurl; 
                                unloading();
                                $("#commonSuccessMsg").text(data.message);
                                $("#commonSuccessBox").css('display','block');
                                $("#resendsingupemail").prop("disabled",false);     
                                setTimeout(function() {
                                    $("#commonSuccessBox").hide();
                                }, 3000);
                            } 
                            else
                            {
                                unloading();
                                $("#commonErrorMsg").text(data.message);
                                $("#commonErrorBox").css('display','block');
                                $("#resendsingupemail").prop("disabled",false);
                                setTimeout(function() {
                                    $("#commonErrorBox").hide();
                                }, 3000);
                            }                           
                            unloading();
                });
            });
        });
    </script>    
    @endsection