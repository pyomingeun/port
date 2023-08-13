@extends('frontend.layout.head')
@section('body-content')
@include('hotel.header')
    <div class="main-wrapper-gray">
        @if(auth()->user()->access == 'admin')
            @include('admin.leftbar')        
        @else
            @include('hotel.leftbar')
        @endif
        <div class="content-box-right setting-notification-sec">
            <div class="container-fluid">
                <div class="setting-nottification-row d-flex flex-wrap">
                    <div class="setting-nottification-left-col">
                        <ul class="nav nav-pills flex-column" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{route('notification-setting'); }}" class="nav-link {{ (Request::segment(1) =='notification-setting')?'active':'' }}"><img src="{{asset('/assets/images/')}}/structure/notification-circle.svg" alt="" class="settingicon"> {{ __('home.notifications') }} {{ __('home.Settings') }}</a>
                            </li>
                            <li class="nav-item ">
                                <a href="{{route('hm_bankinfo',3); }}" class="nav-link {{ (Request::segment(1) =='hm_bankinfo')?'active':'' }}" role="presentation"><img src="{{asset('/assets/images/')}}/structure/bank-circle.svg" alt="" class="settingicon">  {{ __('home.bankDetails') }}</a>
                            </li>
                        </ul>
                        <!-- <div class="informBox">
                            <p class="p3 mb-0"><img src="{{asset('/assets/images/')}}/structure/info-orange.svg" alt="" class="informicon"> Your listing will not be published unless bank details is provided.</p>
                        </div> -->
                    </div>
                    <div class="setting-nottification-right-col">
                        <div class="tab-content">
                            <form action="javaScript:Void(0);" method="post" id="notification_form">
                                <div class="setting-notification-check-row d-flex align-items-center">
                                    <img src="{{asset('/assets/images/')}}/structure/notification-circle.svg" alt="" class="s-n-Icon">
                                    <h6 class="h6 mb-0">{{ __('home.booking') }} ({{ __('home.ONHold') }})</h6>
                                    <div class="ml-auto">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="on_hold_email" name="on_hold_email" value="1" {{ (isset($setting->booking_on_hold_email) && $setting->booking_on_hold_email == 1)?'checked':''; }} >
                                            <label class="form-check-label" for="on_hold_email" >{{ __('home.email') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="on_hold_sms" name="on_hold_sms" value="1" {{ (isset($setting->booking_on_hold_sms) && $setting->booking_on_hold_sms == 1)?'checked':''; }}>
                                            <label class="form-check-label" for="on_hold_sms"  >{{ __('home.SMS') }}</label>
                                        </div>
                                        <!-- <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="booking3" value="option2">
                                            <label class="form-check-label" for="booking3">Push</label>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="setting-notification-check-row d-flex align-items-center">
                                    <img src="{{asset('/assets/images/')}}/structure/notification-circle.svg" alt="" class="s-n-Icon">
                                    <h6 class="h6 mb-0">{{ __('home.confirm') }} {{ __('home.booking') }}</h6>
                                    <div class="ml-auto">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="confirmed_email" name="confirmed_email" value="1" {{ (isset($setting->booking_confirmed_email) && $setting->booking_confirmed_email == 1)?'checked':''; }}>
                                            <label class="form-check-label" for="confirmed_email">{{ __('home.email') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="confirmed_sms" name="confirmed_sms" value="1" {{ (isset($setting->booking_confirmed_sms) && $setting->booking_confirmed_sms == 1)?'checked':''; }}>
                                            <label class="form-check-label" for="confirmed_sms">{{ __('home.SMS') }}</label>
                                        </div>
                                        <!-- <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="Completebooking3" value="option2">
                                            <label class="form-check-label" for="Completebooking3">Push</label>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="setting-notification-check-row d-flex align-items-center">
                                    <img src="{{asset('/assets/images/')}}/structure/notification-circle.svg" alt="" class="s-n-Icon">
                                    <h6 class="h6 mb-0">{{ __('home.Completed') }} {{ __('home.booking') }}</h6>
                                    <div class="ml-auto">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="completed_email" name="completed_email" value="1" {{ (isset($setting->booking_completed_email) && $setting->booking_completed_email == 1)?'checked':''; }}>
                                            <label class="form-check-label" for="completed_email">{{ __('home.email') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="completed_sms" name="completed_sms" value="1" {{ (isset($setting->booking_completed_sms) && $setting->booking_completed_sms == 1)?'checked':''; }}>
                                            <label class="form-check-label" for="completed_sms">{{ __('home.SMS') }}</label>
                                        </div>
                                        <!-- <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="Completebooking3" value="option2">
                                            <label class="form-check-label" for="Completebooking3">Push</label>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="setting-notification-check-row d-flex align-items-center">
                                    <img src="{{asset('/assets/images/')}}/structure/notification-circle.svg" alt="" class="s-n-Icon">
                                    <h6 class="h6 mb-0">{{ __('home.cancelBooking') }}</h6>
                                    <div class="ml-auto">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="cancelled_email" name="cancelled_email" value="1" {{ (isset($setting->booking_cancelled_email) && $setting->booking_cancelled_email == 1)?'checked':''; }}>
                                            <label class="form-check-label" for="cancelled_sms">{{ __('home.email') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="cancelled_sms" name="cancelled_sms" value="1" {{ (isset($setting->booking_cancelled_sms) && $setting->booking_cancelled_sms == 1)?'checked':''; }}>
                                            <label class="form-check-label" for="cancelled_sms">{{ __('home.SMS') }}</label>
                                        </div>
                                        <!-- <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="Cancelbooking3" value="option2">
                                            <label class="form-check-label" for="Cancelbooking3">Push</label>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="setting-notification-check-row d-flex align-items-center">
                                    <img src="{{asset('/assets/images/')}}/structure/notification-circle.svg" alt="" class="s-n-Icon">
                                    <h6 class="h6 mb-0">{{ __('home.refunded') }}</h6>
                                    <div class="ml-auto">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="refund_email" name="refund_email" value="1" {{ (isset($setting->booking_refund_email) && $setting->booking_refund_email == 1)?'checked':''; }}>
                                            <label class="form-check-label" for="refund_email">{{ __('home.email') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="refund_sms" name="refund_sms" value="1" {{ (isset($setting->booking_refund_sms) && $setting->booking_refund_sms == 1)?'checked':''; }}>
                                            <label class="form-check-label" for="refund_sms">{{ __('home.SMS') }}</label>
                                        </div>
                                        <!-- <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="Refunded3" value="option2">
                                            <label class="form-check-label" for="Refunded3">Push</label>
                                        </div> -->
                                    </div>
                                </div>
                                <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                <button class="btn form_submit" type="button">{{ __('home.Submit') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="alertDialog">
            <p class="mb-0 alertmsinner-box alertDanger"><img src="{{asset('/assets/images/')}}/structure/warning.svg" class="alertIcn"> Something went wrong please try again.</p>
        </div> -->
        <!-- <div class="alertDialog">
        <p class="mb-0 alertmsinner-box alertSuccess"><img src="{{asset('/assets/images/')}}/structure/check-circle-green.svg" class="alertIcn"> Bank details updated successfully.</p>
    </div> -->
<!-- common models -->
@include('common_modal')
@include('frontend.layout.footer_script')
@endsection
<!-- JS section  -->   
@section('js-script')
<script>
    $(document).ready(function(){
        $(document).on('click','.form_submit',function(){
            $('#savetype').val($(this).attr('data-btntype'));
            form_submit();
        });
        function form_submit()
        { 
            var token=true; 
            if(token)
            {
                $(".form_submit").prop("disabled",true); 
                loading();
                let formdata = $( "#notification_form" ).serialize();
                $.post("{{ route('save-notification-setting') }}", formdata, function( data ) {
                    if(data.status==1){
                        $(".form_submit").prop("disabled",false);
                        $("#commonSuccessMsg").text(data.message);
                        $("#commonSuccessBox").css('display','block');
                        setTimeout(function() {
                            $("#commonSuccessBox").hide();
                        }, 3000);
                    } 
                    else
                    {
                        $(".form_submit").prop("disabled",false);
                        unloading();
                        $("#commonErrorMsg").text(data.message);
                        $("#commonErrorBox").css('display','block');
                        setTimeout(function() {
                            $("#commonErrorBox").hide();
                        }, 3000); 
                    }                           
                    unloading();
                });             
            }
        }
    });
</script>
@endsection