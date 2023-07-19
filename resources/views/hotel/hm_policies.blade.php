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
                            <form id="hm_policies_form" method="post">
                                <div class="hotelManageform-Content">
                                    <div class="grayBox-w">
                                        <div class="hotelmanageFormInrcnt">
                                            <h5 class="hd5 h5">{{ __('home.HotelTime') }}</h5>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating timepicker" id="check_in_validate">
                                                        <img src="{{asset('/assets/images/')}}/structure/clock-gray.svg" alt="" class="timepickerIcon">
                                                        <input type="text" class="form-control chekinclockpicker rightClickDisabled keyBoardFalse" id="check_in" autocomplete="off" name="check_in" value="{{$hotel->check_in ?: '11:00AM'}}" style="text-align: center;">
                                                        <label for="check_in">{{ __('home.CheckIn') }}<span class="required-star">*</span></label>
                                                        <p class="error-inp" id="check_in_err_msg"></p>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating timepicker" id="check_out_validate">
                                                        <img src="{{asset('/assets/images/')}}/structure/clock-gray.svg" alt="" class="timepickerIcon">
                                                        <input type="text" class="form-control chekoutclockpicker rightClickDisabled keyBoardFalse" id="check_out" autocomplete="off" name="check_out" value="{{ $hotel->check_out ?: '03:00PM' }}" style="text-align: center;">
                                                        <label for="check_out">{{ __('home.CheckOut') }}<span class="required-star">*</span></label>
                                                        <p class="error-inp" id="check_out_err_msg"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grayBox-w">
                                        <div class="hotelmanageFormInrcnt">
                                            <h5 class="hd5 h5 mb-2">{{ __('home.OpenPeriodForBooking') }}</h5>
                                            <p class="p3">{{ __('home.DescOfOpenPeriod') }}</p>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating"  id="min_advance_reservation_validate">
                                                        <input type="text" class="form-control only_integer rightClickDisabled setmaxval setminval" autocomplete="off"  data-maxval="365" data-minval="1" placeholder="{{ __('home.MinAdvanceReservation') }}" value="{{  $hotel->min_advance_reservation ?: '0' }}" name="min_advance_reservation" id="min_advance_reservation" style="text-align: center;">
                                                        <label for="min_advance_reservation">{{ __('home.StartBooking') }}<span class="required-star">*</span></label>
                                                        <p class="error-inp" id="min_advance_reservation_err_msg"></p>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating"  id="max_advance_reservation_validate">
                                                        <input type="text" class="form-control only_integer rightClickDisabled setmaxval setminval" autocomplete="off"  data-maxval="365"  data-minval="1" placeholder="{{ __('home.MaxAdvanceReservation') }}"  value="{{ $hotel->max_advance_reservation ?: '180' }}" name="max_advance_reservation" id="max_advance_reservation" style="text-align: center;">
                                                        <label for="max_advance_reservation">{{ __('home.EndBooking') }} <span class="required-star">*</span></label>
                                                        <p class="error-inp" id="max_advance_reservation_err_msg"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grayBox-w">
                                        <div class="d-flex align-items-center mb-4">
                                            <h5 class="h5">{{ __('Home.HotelPolicy') }}</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-floating mb-0 editorField" id="hotel_policy_validate">
                                                    <textarea placeholder="hotelPolicy"  name="hotel_policy" id="hotel_policy">{{$hotel->hotel_policy}}</textarea>
                                                    <p class="mb-0 max-char-limit" id="hotel_policy_max_char">최대 2000 자</p>
                                                    <p class="error-inp" id="hotel_policy_err_msg"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grayBox-w">
                                        <div class="hotelmanageFormInrcnt">
                                            <h5 class="hd5 h5">{{ __('home.CancellationPolicy') }}</h5>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <h6 style="font-size: 16px; font-weight: bold;">{{ __('home.CancellationCutoff') }}</h6>
                                                    <div class="form-floating timepicker">
                                                        <img src="{{asset('/assets/images/')}}/structure/clock-gray.svg" alt="" class="timepickerIcon">
                                                        <input type="text" class="form-control clockpicker" id="day_counter" autocomplete="off" value="12:00 AM" style="text-align: center; line-height: normal; padding-top: 9px; padding-bottom: 9px;">
                                                    </div>
                                                </div>
                                            </div>
                                            </br>
                                            <h6 style="font-size: 16px; font-weight: bold;">{{ __('home.RefundPolicy') }}</h6>
                                            <div class="cancalPloicyInpGroupRow d-flex flex-wrap">
                                                <div class="cancalPloicyInpGroupCol d-flex">
                                                    <div class="textCol p2 d-flex align-items-center">
                                                    {{ __('home.TheDay') }} {{ __('home.Cancel') }}
                                                    </div>
                                                    <div class="InpCol">
                                                        <div class="input-group inpWtCaption-Rt">
                                                            <input type="text" class="form-control only_integer rightClickDisabled setmaxval" value="{{ ($hotel->same_day_refund !=0)?$hotel->same_day_refund:'' }}" name="same_day_refund" id="same_day_refund" data-maxval="100" placeholder="0">
                                                            <span class="input-group-text" id="basic-addon_same_day_refund">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancalPloicyInpGroupCol d-flex">
                                                    <div class="textCol p2 d-flex align-items-center">
                                                        1{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}
                                                    </div>
                                                    <div class="InpCol">
                                                        <div class="input-group inpWtCaption-Rt">
                                                            <input type="text" class="form-control only_integer rightClickDisabled setmaxval" value="{{ ($hotel->b4_1day_refund !=0)?$hotel->b4_1day_refund:''}}"  name="b4_1day_refund" id="b4_1day_refund" data-maxval="100" placeholder="0"> 
                                                            <span class="input-group-text" id="basic-addon_b4_1day">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancalPloicyInpGroupCol d-flex">
                                                    <div class="textCol p2 d-flex align-items-center">
                                                        2{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}
                                                    </div>
                                                    <div class="InpCol">
                                                        <div class="input-group inpWtCaption-Rt">
                                                            <input type="text" class="form-control only_integer rightClickDisabled setmaxval" value="{{($hotel->b4_2days_refund !=0)?$hotel->b4_2days_refund:''}}"  name="b4_2days_refund" id="b4_2days_refund"  data-maxval="100" placeholder="0">
                                                            <span class="input-group-text" id="basic-addon_b4_2day">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancalPloicyInpGroupCol d-flex">
                                                    <div class="textCol p2 d-flex align-items-center">
                                                        3{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}
                                                    </div>
                                                    <div class="InpCol">
                                                        <div class="input-group inpWtCaption-Rt">
                                                            <input type="text" class="form-control only_integer rightClickDisabled setmaxval" value="{{($hotel->b4_3days_refund !=0)?$hotel->b4_3days_refund:''}}"  name="b4_3days_refund" id="b4_3days_refund"  data-maxval="100" placeholder="0">
                                                            <span class="input-group-text" id="basic-addon_b4_3day">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancalPloicyInpGroupCol d-flex">
                                                    <div class="textCol p2 d-flex align-items-center">
                                                        4{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}
                                                    </div>
                                                    <div class="InpCol">
                                                        <div class="input-group inpWtCaption-Rt">
                                                            <input type="text" class="form-control only_integer rightClickDisabled setmaxval" value="{{($hotel->b4_4days_refund !=0)?$hotel->b4_4days_refund:''}}" name="b4_4days_refund" id="b4_4days_refund"  data-maxval="100" placeholder="0">
                                                            <span class="input-group-text" id="basic-addon_b4_4day">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancalPloicyInpGroupCol d-flex">
                                                    <div class="textCol p2 d-flex align-items-center">
                                                        5{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}
                                                    </div>
                                                    <div class="InpCol">
                                                        <div class="input-group inpWtCaption-Rt">
                                                            <input type="text" class="form-control  only_integer rightClickDisabled setmaxval" value="{{($hotel->b4_5days_refund !=0)?$hotel->b4_5days_refund:''}}" name="b4_5days_refund" id="b4_5days_refund"  data-maxval="100" placeholder="0">
                                                            <span class="input-group-text" id="basic-addon_b4_5day">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancalPloicyInpGroupCol d-flex">
                                                    <div class="textCol p2 d-flex align-items-center">
                                                        6{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}
                                                    </div>
                                                    <div class="InpCol">
                                                        <div class="input-group inpWtCaption-Rt">
                                                            <input type="text" class="form-control  only_integer rightClickDisabled setmaxval" value="{{($hotel->b4_6days_refund !=0)?$hotel->b4_6days_refund:''}}" name="b4_6days_refund" id="b4_6days_refund"  data-maxval="100" placeholder="0">
                                                            <span class="input-group-text" id="basic-addon_b4_6day">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancalPloicyInpGroupCol d-flex">
                                                    <div class="textCol p2 d-flex align-items-center">
                                                        7{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}
                                                    </div>
                                                    <div class="InpCol">
                                                        <div class="input-group inpWtCaption-Rt">
                                                            <input type="text" class="form-control  only_integer rightClickDisabled setmaxval" value="{{($hotel->b4_7days_refund !=0)?$hotel->b4_7days_refund:''}}" name="b4_7days_refund" id="b4_7days_refund"  data-maxval="100" placeholder="0">
                                                            <span class="input-group-text" id="basic-addon_b4_7day">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancalPloicyInpGroupCol d-flex">
                                                    <div class="textCol p2 d-flex align-items-center">
                                                        8{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}
                                                    </div>
                                                    <div class="InpCol">
                                                        <div class="input-group inpWtCaption-Rt">
                                                            <input type="text" class="form-control  only_integer rightClickDisabled setmaxval" value="{{($hotel->b4_8days_refund !=0)?$hotel->b4_8days_refund:''}}" name="b4_8days_refund" id="b4_8days_refund"  data-maxval="100" placeholder="0">
                                                            <span class="input-group-text" id="basic-addon_b4_8day">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancalPloicyInpGroupCol d-flex">
                                                    <div class="textCol p2 d-flex align-items-center">
                                                    9{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}
                                                    </div>
                                                    <div class="InpCol">
                                                        <div class="input-group inpWtCaption-Rt">
                                                            <input type="text" class="form-control only_integer rightClickDisabled setmaxval" value="{{($hotel->b4_9days_refund !=0)?$hotel->b4_9days_refund:''}}" name="b4_9days_refund" id="b4_9days_refund"  data-maxval="100" placeholder="0">
                                                            <span class="input-group-text" id="basic-addon_b4_9day">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancalPloicyInpGroupCol d-flex">
                                                    <div class="textCol p2 d-flex align-items-center">
                                                        10{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}
                                                    </div>
                                                    <div class="InpCol">
                                                        <div class="input-group inpWtCaption-Rt">
                                                            <input type="text" class="form-control only_integer rightClickDisabled setmaxval" value="{{($hotel->b4_10days_refund !=0)?$hotel->b4_10days_refund:''}}" name="b4_10days_refund" id="b4_10days_refund"  data-maxval="100" placeholder="0">
                                                            <span class="input-group-text" id="basic-addon_b4_10day">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                    /*
                                    <div class="grayBox-w">
                                        <div class="hotelmanageFormInrcnt">
                                            <h5 class="h5">{{ __('home.ServiceNPrivacyAct') }}</h5>
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="form-floating editorField" id="terms_and_conditions_validate">
                                                        <textarea  placeholder="Write here..."  name="terms_and_conditions" id="terms_and_conditions">{{$hotel->terms_and_conditions}}</textarea>
                                                        <p class="mb-0 max-char-limit" id="terms_and_conditions_max_char">max 2000 characters</p>
                                                        <p class="error-inp" id="terms_and_conditions_err_msg"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    */ 
                                    @endphp
                                </div>
                                <div class="res-sub-btn-rw d-flex justify-content-end align-items-center pl-2">
                                   <a href="{{route('hm_addressNAttractions',$hotel->hotel_id)}}" class="btn-back btnPrevious">{{ __('home.Back') }}</a>
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                                    <input type="hidden" value="next" name="savetype" id="savetype">
                                    <input type="hidden" value="{{$hotel->hotel_id}}" name="h" id="h">
                                    <a class="btn bg-gray1" href="{{ route('hm_cancel') }}" >{{ __('home.Cancel') }}</a>
                                    <button type="button" class="btn outline-blue form_submit" data-btntype="save_n_exit" >{{ __('home.SaveExit') }}</button>
                                    <button type="button" class="btn btnNext tab3 form_submit" data-btntype="next">{{ __('home.Next') }}</button>
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
<script src="https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.js"></script>
<!-- <script src="//cdn.ckeditor.com/4.14.1/full-all/ckeditor.js"></script> -->
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script src="https://rawgit.com/kottenator/jquery-circle-progress/1.2.2/dist/circle-progress.js"></script>
<!-- <script type="text/javascript">
				   CKEDITOR.replace( 'hotel_policy',
            {   toolbar:'MA'    }
         );
				CKEDITOR.config.toolbar_MA=[ ['Source','-','Cut','Copy','Paste','-','Undo','Redo','RemoveFormat','-','Link','Unlink','Anchor','-','Table','HorizontalRule','SpecialChar'], '/', ['Format','Templates','Bold','Italic','Underline','-','Superscript','-',['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],'-','NumberedList','BulletedList','-','Outdent','Indent'] ];
                 CKEDITOR.config.removeButtons = 'Image';
  </script> -->
  <script type="text/javascript">
       CKEDITOR.replace( 'hotel_policy', {
});
   CKEDITOR.config.removePlugins = 'Save,Print,Preview,image,Find,About,Maximize,ShowBlocks';
  </script>
<script>
$(document).ready(function() {
    //editor
    // $(document).ready(function () { $('.ckeditor').ckeditor(); });
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        $('.chekoutclockpicker').clockpicker({
            'default': '15:00',
            twelvehour: true,
            autoclose: true
        });
        $('.chekinclockpicker').clockpicker({
            'default': '11:00',
            twelvehour: true,
            autoclose: true
        });
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
    $(document).ready(function(){
        $(document).on('click','.clockpicker-button',function(){
            $(".clockpicker-button").removeClass("active");
            $(this).addClass("active");
        });
        $(document).on('click','.form_submit',function(){
            $('#savetype').val($(this).attr('data-btntype'));
            form_submit();
        });
        $(document).on('click','.chekinclockpicker',function(){
            unsetErrorAndErrorBox('check_in');
            // field_required('check_in','check_in',"Check-in time is required");
        });
        $(document).on('click','.chekoutclockpicker',function(){
            unsetErrorAndErrorBox('check_out');
            //  field_required('check_out','check_out',"Check-out time is required");
        });
        $(document).on('keyup','#min_advance_reservation',function(){
            // $("#hm_server_err_msg").text('');
            if(field_required('min_advance_reservation','min_advance_reservation',"Minimum Advance Reservation is required"))
            if(!checkMinVal($('#min_advance_reservation').val(),0)) 
                setErrorAndErrorBox('min_advance_reservation','Minimum Advance Reservation should be greter than or equal 1.'); 
            else
                unsetErrorAndErrorBox('min_advance_reservation');
        });
        $(document).on('keyup','#max_advance_reservation',function(){
            // $("#hm_server_err_msg").text('');
            if(field_required('max_advance_reservation','max_advance_reservation',"Maximum Advance Reservation is required"))
            if(!checkMaxVal($('#max_advance_reservation').val(),366 )) 
                setErrorAndErrorBox('max_advance_reservation','Maximum Advance Reservation should be less than or equal 365.'); 
            else
                unsetErrorAndErrorBox('max_advance_reservation');
        });
        CKEDITOR.instances.hotel_policy.on('change', function() { 
        let texlen = CKEDITOR.instances.hotel_policy.getData().length; 
        $("#hotel_policy_max_char").text(texlen+'/2000');
        if(CKEDITOR.instances.hotel_policy.getData() === '') {
            setErrorAndErrorBox('hotel_policy','Hotel Policy is required.');
        }
        else if(texlen >2000) 
        {
            setErrorAndErrorBox('hotel_policy','Hotel Policy should be less than 2000 letters.');
        }
        else
        unsetErrorAndErrorBox('hotel_policy');
        });
        /* CKEDITOR.instances.terms_and_conditions.on('change', function() { 
        let texlen = CKEDITOR.instances.terms_and_conditions.getData().length; 
        $("#terms_and_conditions_max_char").text(texlen+'/2000');
        if(CKEDITOR.instances.terms_and_conditions.getData() === '') {
            setErrorAndErrorBox('terms_and_conditions','Terms and conditions is required.');
        }
        else if(texlen >2000) 
        {
            setErrorAndErrorBox('terms_and_conditions','Terms and conditions should be less than 2000 letters.');
        }
        else
        unsetErrorAndErrorBox('terms_and_conditions');
        }); */
        function form_submit()
        { 
            var token=true; 
            CKEDITOR.instances.hotel_policy.updateElement();
            // CKEDITOR.instances.terms_and_conditions.updateElement();
            let formdata = $( "#hm_policies_form" ).serialize();
            if(!field_required('check_in','check_in',"Check-in time is required"))
                token = false;
            if(!field_required('check_out','check_out',"Check-out time is required"))
                token = false;
            if(!field_required('hotel_policy','hotel_policy',"Hotel Policy is required"))
                token = false;
            else if(!checkMaxLength($('#hotel_policy').val(),2000 )) 
            {
                setErrorAndErrorBox('hotel_policy','Hotel Policy should be less than 2000 letters.');
                token = false;
            }
            /* if(!field_required('terms_and_conditions','terms_and_conditions',"Terms and conditions is required"))
                token = false;
            else if(!checkMaxLength($('#terms_and_conditions').val(),2000 )) 
            {
                setErrorAndErrorBox('terms_and_conditions','Terms and conditions should be less than 2000 letters.');
                token = false;
            } */
            if(!field_required('min_advance_reservation','min_advance_reservation',"Minimum Advance Reservation is required"))
                token = false;
            else if(!checkMinVal($('#min_advance_reservation').val(),0 )) 
            {
                token = false;
                setErrorAndErrorBox('min_advance_reservation','Minimum Advance Reservation should be greter than or equal 1.');
            }
            if(!field_required('max_advance_reservation','max_advance_reservation',"Maximum Advance Reservation is required"))
                token = false;
            else if(!checkMaxVal($('#max_advance_reservation').val(),366 )) 
            {
                setErrorAndErrorBox('max_advance_reservation','Maximum Advance Reservation should be less than or equal 365.');
                token = false;
            }
            if(token)
            {
                $(".form_submit").prop("disabled",true); 
                loading();
                // let formdata = $( "#hm_policies_form" ).serialize();
                // formdata.hotel_description = CKEDITOR.instances.hotel_description.getData()
                //  let senddata = {hotel_name:$('#hotel_name').val(),hotel_description:CKEDITOR.instances.hotel_description.getData(),h:$('#h').val(),_token:$('#tk').val(),savetype:$('#savetype').val()};
                $.post("{{ route('hm_policies_submit') }}",  formdata, function( data ) {
                            console.log(data);
                            // unloading();
                            if(data.status==1){
                                window.location.href = data.nextpageurl; 
                                unloading();
                            } 
                            else
                            {
                                $(".form_submit").prop("disabled",false); 
                                $('#hm_hm_server_err_msg').text(data.message);
                                unloading();
                            }                      
                });             
            }
        }
    });
</script>
@endsection       