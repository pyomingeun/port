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
                            <li class="nav-item" role="presentation">
                                <a href="{{route('hm_bankinfo',$hotel->hotel_id); }}" class="nav-link {{ (Request::segment(1) =='hm_bankinfo')?'active':'' }}"><img src="{{asset('/assets/images/')}}/structure/bank-circle.svg" alt="" class="settingicon">  {{ __('home.bankDetails') }}</a>
                            </li>
                        </ul> 
                        <!-- <div class="informBox">
                            <p class="p3 mb-0"><img src="{{asset('/assets/images/')}}/structure/info-orange.svg" alt="" class="informicon"> Your listing will not be published unless bank details is provided.</p>
                        </div> -->
                    </div>
                    <div class="setting-nottification-right-col">
                        <div class="tab-content">
                            <div class="" >
                                <div class="set-not-booking-detail-Box">
                                    <h5 class="h5 md5">{{ __('home.bankDetails') }}</h5>
                                    <form id="hotel_bankinfo" method="post" action="javaScript:Void(0);">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-floating" id="ac_validate">
                                                    <input type="text" class="form-control  onpress_enter_bnsb only_integer" id="ac" placeholder="{{ __('home.accountNo') }}" name="ac" value="{{ isset($hotel->hasHotelBankAcDetails->account_num)?$hotel->hasHotelBankAcDetails->account_num:''; }}">
                                                    <label for="ac">{{ __('home.accountNo') }}<span class="required-star">*</span></label>
                                                    <p class="error-inp" id="ac_err_msg"></p>
                                                </div> 
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-floating" id="cac_validate">
                                                    <input type="text" class="form-control  onpress_enter_bnsb only_integer" id="cac" placeholder="{{ __('home.confirmAccountNumber') }}" name="cac" value="{{ isset($hotel->hasHotelBankAcDetails->account_num)?$hotel->hasHotelBankAcDetails->account_num:''; }}">
                                                    <label for="cac"> {{ __('home.confirmAccountNumber') }}<span class="required-star">*</span></label>
                                                    <p class="error-inp" id="cac_err_msg"></p>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-floating" id="bn_validate">
                                                    <input type="text" class="form-control onpress_enter_bnsb" id="bn" placeholder=" {{ __('home.bankName') }}" name="bn" value="{{ isset($hotel->hasHotelBankAcDetails->bank_name)?$hotel->hasHotelBankAcDetails->bank_name:''; }}">
                                                    <label for="bn"> {{ __('home.bankName') }}<span class="required-star">*</span></label>
                                                    <p class="error-inp" id="bn_err_msg"></p>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-floating" id="achn_validate">
                                                    <input type="text" class="form-control onpress_enter_bnsb" id="achn" placeholder="{{ __('home.accountHolderName') }}"  name="achn" value="{{ isset($hotel->hasHotelBankAcDetails->ac_holder_name)?$hotel->hasHotelBankAcDetails->ac_holder_name:''; }}">
                                                    <label for="achn">{{ __('home.accountHolderName') }}<span class="required-star">*</span></label>
                                                    <p class="error-inp" id="achn_err_msg"></p>
                                                </div>
                                            </div>
                                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                                            <input type="hidden" value="{{ (isset($hotel->hotel_id))?$hotel->hotel_id:''; }}" name="h" id="h">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-3">
                                                <button class="btn form_submit" type="button">{{ __('home.Save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
@include('frontend.layout.footer_script')
@endsection
<!-- JS section  -->   
@section('js-script')
<script>
$(document).ready(function() {
    $(document).on('keyup','.onpress_enter_bnsb',function(e){
        // $("#server_err_msg").text('');
        // console.log(e.keyCode);
        if(e.keyCode == 13)
            form_submit();
    });
    $(document).on('keyup','#ac',function(){
        // $("#hm_server_err_msg").text('');
        if(field_required('ac','ac',"Account number is required"))
        if(!checkMaxLength($('#ac').val(),20 )) 
            setErrorAndErrorBox('ac','Account number be less than 20 letters.'); 
        else
            unsetErrorAndErrorBox('ac');
    });
    $(document).on('keyup','#cac',function(){
        // $("#hm_server_err_msg").text('');
        if(field_required('cac','cac',"Confirm Account number is required"))
        {
            if(!checkIsEqual($('#ac').val(),$('#cac').val()))
                setErrorAndErrorBox('cac','A/c number & confirm A/c should be same.'); 
            else
                unsetErrorAndErrorBox('cac');        
        }
    });
    $(document).on('keyup','#bn',function(){
        // $("#hm_server_err_msg").text('');
        if(field_required('bn','bn',"Bank Name is required"))
        if(!checkMaxLength($('#bn').val(),200 )) 
            setErrorAndErrorBox('bn','Bank Name be less than 200 letters.'); 
        else
            unsetErrorAndErrorBox('bn');
    });
    $(document).on('keyup','#achn',function(){
        // $("#hm_server_err_msg").text('');
        if(field_required('achn','achn',"Bank Name is required"))
        if(!checkMaxLength($('#achn').val(),200 )) 
            setErrorAndErrorBox('achn','Bank Name be less than 200 letters.'); 
        else
            unsetErrorAndErrorBox('achn');
    });    
    $(document).on('click','.form_submit',function(){
        // $('#hm_hm_server_err_msg').text('');
        // alert('dfsf');
        $('#savetype').val($(this).attr('data-btntype'));
        form_submit();
    });
    function form_submit()
    { 
        var token=true; 
        if(!field_required('ac','ac',"Account number is required"))
            token = false;
        else if(!checkMaxLength($('#ac').val(),20 )) 
        {
            setErrorAndErrorBox('ac','Account number be less than 20 letters.');
            token = false;
        }
        if(!field_required('cac','cac',"Confirm Account Number is required"))
            token = false;
        else if(!checkIsEqual($('#ac').val(),$('#cac').val())) 
        {   
            setErrorAndErrorBox('cac','A/c number & confirm A/c should be same.');
            token = false;
        }
        if(!field_required('bn','bn',"Bank Name is required"))
            token = false;
        else if(!checkMaxLength($('#bn').val(),200 )) 
        {
            setErrorAndErrorBox('bn','Bank Name be less than 200 letters.');
            token = false;
        }
        if(!field_required('achn','achn',"Account holder name is required"))
            token = false;
        else if(!checkMaxLength($('#achn').val(),200 )) 
        {
            setErrorAndErrorBox('achn','Account holder name be less than 200 letters.');
            token = false;
        }        
        if(token)
        {
            $(".form_submit").prop("disabled",true); 
            loading();
            $.post("{{ route('hm_bankinfo_submit') }}",  $( "#hotel_bankinfo" ).serialize(), function( data ) {
                        // console.log(data);
                        if(data.status==1){
                            // window.location.href = data.nextpageurl; 
                            $("#commonSuccessMsg").text(data.message);
                            $("#commonSuccessBox").css('display','block');
                            $(".form_submit").prop("disabled",false); 
                            unloading();
                            setTimeout(function() {
                                $("#commonSuccessBox").hide();
                            }, 3000);
                        } 
                        else
                        {
                            $("#commonErrorMsg").text(data.message);
                            $("#commonErrorBox").css('display','block');
                            $(".form_submit").prop("disabled",false); 
                            unloading();
                            setTimeout(function() {
                                $("#commonSuccessBox").hide();
                            }, 3000);
                        }                           
                        // unloading();
            });             
        }
    }
    // close
});
</script>
@endsection