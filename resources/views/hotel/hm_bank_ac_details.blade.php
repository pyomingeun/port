@extends('frontend.layout.head')
@section('body-content')
@include('hotel.header')
<!-- include left bar here -->
<div class="main-wrapper-gray">
     @if(auth()->user()->access == 'admin')
         @include('admin.leftbar')        
     @else
         @include('hotel.leftbar')
     @endif
    <div class="content-box-right hotel-management-sec">
        @include('hotel.complete_percentage')
        <div class="container-fluid">
            <div class="hotel-management-row d-flex flex-wrap">
                @include('hotel.hotel_manage_stepbar')
                <div class="hotel-management-right-col">
                    <div class="tab-content stepsContent">
                        <div class="">
                            <form id="hm_bankinfo_form" method="post" action="javaScript:Void(0);">
                                <div class="hotelManageform-Content">
                                    <div class="grayBox-w">
                                        <div class="hotelmanageFormInrcnt">
                                            <h5 class="hd5 h5">{{ __('home.BankDetails') }} </h5>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating" id="ac_validate">
                                                        <input type="text" class="form-control  onpress_enter_bnsb only_integer" id="ac" placeholder="{{ __('home.AccountNo') }}" name="ac" value="{{ isset($hotel->hasHotelBankAcDetails->account_num)?$hotel->hasHotelBankAcDetails->account_num:''; }}">
                                                        <label for="ac">{{ __('home.AccountNo') }}<span class="required-star">*</span></label>
                                                        <p class="error-inp" id="ac_err_msg"></p>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating" id="cac_validate">
                                                        <input type="text" class="form-control  onpress_enter_bnsb only_integer" id="cac" placeholder="{{ __('home.ConfirmAccountNo') }}" name="cac" value="{{ isset($hotel->hasHotelBankAcDetails->account_num)?$hotel->hasHotelBankAcDetails->account_num:''; }}">
                                                        <label for="cac"> {{ __('home.ConfirmAccountNo') }}<span class="required-star">*</span></label>
                                                        <p class="error-inp" id="cac_err_msg"></p>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating" id="bn_validate">
                                                        <input type="text" class="form-control onpress_enter_bnsb" id="bn" placeholder=" {{ __('home.BankName') }}" name="bn" value="{{ isset($hotel->hasHotelBankAcDetails->bank_name)?$hotel->hasHotelBankAcDetails->bank_name:''; }}">
                                                        <label for="bn"> {{ __('home.BankName') }}<span class="required-star">*</span></label>
                                                        <p class="error-inp" id="bn_err_msg"></p>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating" id="achn_validate">
                                                        <input type="text" class="form-control onpress_enter_bnsb" id="achn" placeholder="{{ __('home.AccountHolder') }}"  name="achn" value="{{ isset($hotel->hasHotelBankAcDetails->ac_holder_name)?$hotel->hasHotelBankAcDetails->ac_holder_name:''; }}">
                                                        <label for="achn">{{ __('home.AccountHolder') }}<span class="required-star">*</span></label>
                                                        <p class="error-inp" id="achn_err_msg"></p>
                                                    </div>
                                                </div>
                                                <div class="res-sub-btn-rw d-flex justify-content-end align-items-center pl-2">
                                                   <a href="{{route('hm_otherInfo',$hotel->hotel_id)}}" class="btn-back btnPrevious">Back</a>
                                                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                                                    <input type="hidden" value="next" name="savetype" id="savetype">
                                                    <input type="hidden" value="{{$hotel->hotel_id}}" name="h" id="h">
                                                    <a class="btn bg-gray1" href="{{ route('hm_cancel') }}" >{{ __('home.Cancel') }}</a>
                                                    <button type="button" class="btn outline-blue form_submit" data-btntype="save_n_exit" >{{ __('home.SaveExit') }}</button>
                                                    <button type="button" class="btn btnNext tab3 form_submit" data-btntype="next">{{ __('home.Next') }} </button>
                                                </div>
                                            </div>
                                        </div>
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
                                            
@include('frontend.layout.footer_script')
@endsection
<!-- JS section  -->
@section('js-script')
<script src="https://rawgit.com/kottenator/jquery-circle-progress/1.2.2/dist/circle-progress.js"></script>
<script>
$(document).ready(function() {
    //editor
    // $(document).ready(function () { $('.ckeditor').ckeditor(); });
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    function animateElements() {
        $('.progressbar').each(function() {
            var elementPos = $(this).offset().top;
            var topOfWindow = $(window).scrollTop();
            var percent = $(this).find('.circle').attr('data-percent');
            var animate = $(this).data('animate');
            if (elementPos < topOfWindow + $(window).height() - 30 && !animate) {
                $(this).data('animate', true);
                $(this).find('.circle').circleProgress({
                    startAngle: -Math.PI / 2,
                    value: percent / 100,
                    size: 55,
                    thickness: 5,
                    fill: {
                        color: '#015AC3'
                    }
                }).on('circle-animation-progress', function(event, progress, stepValue) {
                    $(this).find('strong').text((stepValue * 100).toFixed(0) + "%");
                }).stop();
             
                if (percent == 100) {
                   $(this).siblings('.prog-des').find('h6').text("{{ __('home.CompletedProfile') }}");
                }
            }
        });
    }
    animateElements();
    $(window).scroll(animateElements);
})
</script>
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
            let formdata = $( "#hm_bankinfo_form ").serialize();
            $(".form_submit").prop("disabled",true);
            loading();
            $.post("{{ route('hm_bankinfo_submit') }}",  formdata, function( data ) {
                        if(data.status==1){
                            window.location.href = data.nextpageurl; 
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
