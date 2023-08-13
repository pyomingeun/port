@extends('frontend.layout.head')
@section('body-content')
@include('frontend.layout.header')
    <div class="register-main-wrapper register-verification-sec">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="registerForw">
                        <img src="../images/structure/message-gif.gif" class="r-v-messageIcon" alt="">
                        <h3 class="h3 mt-4 mb-4">{{ __('home.Wevesentyoualink') }}</h3>
                        <p class="p1 mb-5"> {{ __('home.Hitthelinkintheemailwevesentto') }} <a href="javaScript:Void(0);">{{$user->email}}</a> {{ __('home.forresetyourpassword') }}</p>
                        <button  type="button" class="btn" data-email="{{$user->email}}" id="resendforgotemail">{{ __('home.resendEmail') }}</buttosn>
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
    <!-- JS section  -->   
    @section('js-script')
    <script>
        $(document).ready(function(){
            $(document).on('click','#resendforgotemail',function(){
                var email = $('#resendforgotemail').attr('data-email');
                $("#resendforgotemail").prop("disabled",true); 
                loading();
                $.post("{{ route('forgot_password') }}", {forgot_email:email,_token:"{{ csrf_token() }}"} , function( data ) {
                            console.log(data);
                            if(data.status==1){
                                // window.location.href = data.nextpageurl; 
                                unloading();
                                $("#commonSuccessMsg").text(data.message);
                                $("#commonSuccessBox").css('display','block');
                                $("#resendforgotemail").prop("disabled",false);     
                                setTimeout(function() {
                                    $("#commonSuccessBox").hide();
                                }, 3000);
                            } 
                            else
                            {
                                unloading();
                                $("#commonErrorMsg").text(data.message);
                                $("#commonErrorBox").css('display','block');
                                $("#resendforgotemail").prop("disabled",false);
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