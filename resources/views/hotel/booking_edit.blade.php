@extends('frontend.layout.head')
@section('body-content')
@include('hotel.header')
    <div class="main-wrapper-gray">
    @if(auth()->user()->access == 'admin')
             @include('admin.leftbar')        
         @else
             @include('hotel.leftbar')
         @endif
@php
    $check_in_date = new DateTime($booking->check_in_date);
    $check_out_date = new DateTime($booking->check_out_date);
@endphp         
        <div class="content-box-right hotel-management-sec add-room-sec">
            <div class="container-fluid">
                <div class="hotel-management-row d-flex flex-wrap">
                    <div class="hotel-management-left-col">
                        <div class="hotel-tabs-rw">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link tab1 active" id="tab-id1" role="tab" aria-controls="step1" aria-selected="true" data-bs-step="1" data-bs-toggle="tab" href="#step1">
                                        <span class="stepcircle">1 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
                                        <div class="tabCnt">
                                            <p class="p3">{{ __('home.Step') }} 1</p>
                                            <p class="p1">{{ __('home.booking') }}</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link tab2" id="tab-id2" role="tab" aria-controls="step2" aria-selected="true" data-bs-step="2" data-bs-toggle="tab" href="#step2">
                                        <span class="stepcircle">2 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
                                        <div class="tabCnt">
                                            <p class="p3">{{ __('home.Step') }} 2</p>
                                            <p class="p1">{{ __('home.guest') }}</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link tab3" id="tab-id3" role="tab" aria-controls="step3" aria-selected="true" data-bs-step="3" data-bs-toggle="tab" href="#step3">
                                        <span class="stepcircle">3 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
                                        <div class="tabCnt">
                                            <p class="p3">{{ __('home.Step') }} 3</p>
                                            <p class="p1">{{ __('home.notes') }}</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link tab4" id="tab-id4" role="tab" aria-controls="step4" aria-selected="true" data-bs-step="4" data-bs-toggle="tab" href="#step4">
                                        <span class="stepcircle">4 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
                                        <div class="tabCnt">
                                            <p class="p3">{{ __('home.Step') }} 4</p>
                                            <p class="p1">{{ __('home.extraService') }}</p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hotel-management-right-col">
                        <form action="javaScript:void(0);" method="post" id="bookingEditFrm">
                            <div class="tab-content stepsContent">
                                <div class="tab-pane active" id="step1" aria-labelledby="tab-id1">
                                    <div class="roomsManageform-Content">
                                        <div class="grayBox-w">
                                            <div class="hotelmanageFormInrcnt">
                                                <h5 class="hd5 h5">{{ __('home.bookingInfo') }}</h5>
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-floating disabledInput disabledInput">
                                                            <input type="text" class="form-control" id="bs" placeholder="{{ __('home.bookingReferenceNumber') }}" name="bs" value="{{ $booking->slug }}">
                                                            <label for="bs">{{ __('home.bookingReferenceNumber') }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-floating datepickerField disabledInput">
                                                            <img src="{{asset('/assets/images/')}}/structure/calendar1.svg" alt="" class="calendarIcon" />
                                                            <input class="form-control datepicker" id="checkin" autocomplete="off" value="{{ date_format($check_in_date,'Y-m-d'); }}" placeholder="{{ __('home.checkIn') }}">
                                                            <label for="checkin">{{ __('home.checkIn') }}<span class="required-star">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-floating datepickerField disabledInput">
                                                            <img src="{{asset('/assets/images/')}}/structure/calendar1.svg" alt="" class="calendarIcon" />
                                                            <input class="form-control datepicker" id="checkout" autocomplete="off" value="{{ date_format($check_out_date,'Y-m-d'); }}" placeholder="{{ __('home.checkOut') }}">
                                                            <label for="checkout">{{ __('home.checkOut') }}<span class="required-star">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                        <div class="form-floating disabledInput disabledInput">
                                                            <input type="text" class="form-control" id="floatingInput" placeholder="{{ __('home.room') }}" value="{{ $booking->room_name; }}">
                                                            <label for="floatingInput">{{ __('home.room') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grayBox-w">
                                            <div class="hotelmanageFormInrcnt StandardOccupancyBox">
                                                <h5 class="hd5 h5">{{ __('home.guest') }}</h5>
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                        <div class="quantity-row row">
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ __('home.adult') }} 12Y+</p>
                                                            </div>
                                                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                                                <div class="quantity-box d-flex align-items-center ml-auto">
                                                                    <span class="minusMinZero d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                    <input type="text" value="{{ $booking->no_of_adults}}" name="adults" id="adults" class="only_integer rightClickDisabled" />
                                                                    <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                        <div class="quantity-row row">
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ __('home.child') }} ({{ __('home.bellow') }} 3Y)</p>
                                                            </div>
                                                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                                                <div class="quantity-box d-flex align-items-center ml-auto">
                                                                    <span class="minusMinZero d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                    <input type="text" value="{{ $booking->childs_below_nyear }}" name="childs_below_nyear" id="childs_below_nyear" class="only_integer rightClickDisabled" />
                                                                    <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                        <div class="quantity-row row">
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ __('home.child') }} <br>(3Y to 12Y)</p>
                                                            </div>
                                                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                                                <div class="quantity-box d-flex align-items-center ml-auto">
                                                                    <span class="minusMinZero d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                    <input type="text" value="{{ $booking->childs_plus_nyear }}" name="childs_plus_nyear" id="childs_plus_nyear" class="only_integer rightClickDisabled" />
                                                                    <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="row mt-4">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                                                        <p class="p2 mb-1">Child 1 Age</p>
                                                        <div class="form-floating h-40 mb-3">
                                                            <button id="selectAge1" data-bs-toggle="dropdown" class="form-select" aria-expanded="false"> Select</button>
                                                            <ul class="dropdown-menu dropdown-menu-start">
                                                                <li class="radiobox-image">
                                                                    <input type="radio" id="childage1" name="childage" value="" />
                                                                    <label for="childage1">01</label>
                                                                </li>
                                                                <li class="radiobox-image">
                                                                    <input type="radio" id="childage2" name="childage" value="" />
                                                                    <label for="childage2">02</label>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="res-sub-btn-rw d-flex justify-content-end">
                                        <div class="res-sub-btn-rw d-flex justify-content-end">
                                            <a href="{{ route('booking-detail',$booking->slug); }}" class="btn bg-gray1">{{ __('home.cancel') }}</a>
                                            <button class="btn outline-blue editBooking">{{ __('home.SaveExit') }}</button>
                                            <a class="btn btnNext tab1">{{ __('home.Next') }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="step2" aria-labelledby="tab-id2">
                                    <div class="roomsManageform-Content">
                                        <div class="grayBox-w">
                                            <div class="hotelmanageFormInrcnt">
                                                <h5 class="hd5 h5">{{ __('home.primaryGuestDetails') }}</h5>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                        <div class="form-floating disabledInput">
                                                            <input type="text" class="form-control" id="fullname" placeholder="{{ __('home.fullName') }}" value="{{ $booking->customer_full_name }}" >
                                                            <label for="fullname">{{ __('home.fullName') }}<span class="required-star">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                        <div class="form-floating disabledInput">
                                                            <input type="text" class="form-control" id="phone" placeholder="{{ __('home.phone') }}" value="{{ $booking->customer_phone }}">
                                                            <label for="phone">{{ __('home.phone') }}<span class="required-star">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                        <div class="form-floating disabledInput">
                                                            <input type="text" class="form-control" id="email" placeholder="{{ __('home.Email') }}" value="{{ $booking->customer_email }}">
                                                            <label for="email">{{ __('home.Email') }}<span class="required-star">*</span></label>
                                                        </div>
                                                    </div>
                                                    @php
                                                    /*
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-floating datepickerField disabledInput">
                                                            <img src="{{asset('/assets/images/')}}/structure/calendar1.svg" alt="" class="calendarIcon" />
                                                            <input class="form-control datepicker" id="floatingInput" placeholder="D.O.B." value="1996/11/12">
                                                            <label for="floatingInput">D.O.B.<span class="required-star">*</span></label>
                                                        </div>
                                                    </div>
                                                    */
                                                    @endphp
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="res-sub-btn-rw d-flex justify-content-end">
                                        <button class="btn-back btnPrevious" style="background: transparent !important;">{{ __('home.Back') }}</button>
                                        <a href="{{ route('booking-detail',$booking->slug); }}" class="btn bg-gray1">{{ __('home.cancel') }}</a>
                                        <button class="btn outline-blue editBooking">{{ __('home.SaveExit') }}</button>
                                        <a class="btn btnNext tab2">{{ __('home.Next') }}</a>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="step3" aria-labelledby="tab-id3">
                                    <div class="roomsManageform-Content">
                                        <div class="grayBox-w">
                                            <div class="hotelmanageFormInrcnt RoomFeaturesFacilitiesBox">
                                                <h5 class="hd5 h5">{{ __('home.guestNotes') }}</h5>
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-floating">
                                                            <textarea itemid="txtarea" class="form-control" id="customer_notes" placeholder="{{ __('home.guestNotes') }}"  name="customer_notes" style="min-height:106px;">{{ $booking->customer_notes; }}</textarea>
                                                            <label for="customer_notes">{{ __('home.guestNotes') }}</label>
                                                            <p class="mb-0 max-char-limit">max 400 characters</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grayBox-w">
                                            <div class="hotelmanageFormInrcnt RoomFeaturesFacilitiesBox">
                                                <h5 class="hd5 h5">{{ __('home.hostNotes') }}</h5>
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-floating">
                                                            <textarea itemid="txtarea" class="form-control" id="host_notes" placeholder=" {{ __('home.hostNotes') }}" name="host_notes" style="min-height:106px;">{{ $booking->host_notes; }}</textarea>
                                                            <label for="host_notes">{{ __('home.hostNotes') }}</label>
                                                            <p class="mb-0 max-char-limit">max 400 characters</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="res-sub-btn-rw d-flex justify-content-end">
                                    <button class="btn-back btnPrevious" style="background: transparent !important;">Back</button>
                                        <a href="{{ route('booking-detail',$booking->slug); }}" class="btn bg-gray1">{{ __('home.cancel') }}</a>
                                        <button class="btn outline-blue editBooking">{{ __('home.SaveExit') }}</button>
                                        <a class="btn btnNext tab3">{{ __('home.Next') }}</a>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="step4" aria-labelledby="tab-id4">
                                    <div class="roomsManageform-Content">
                                        <div class="grayBox-w">
                                            <div class="bookingextarServices">
                                                <h5 class="hd5 h5 mb-4">{{ __('home.extraService') }}</h5>
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                      @foreach($bookingExtraService as $es)
                                                        <div class="form-check">
                                                            <input class="form-check-input select_es_chk" type="checkbox" value="{{ $es->es_id }}" id="esCheckbox{{ $es->es_id }}" name="es[]" checked>
                                                            <label class="form-check-label " for="esCheckbox{{ $es->es_id }}">
                                                            <div class="row bookingServicesCheckbox">
                                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <p class="p1">{{ $es->es_name }}</p>
                                                                    <p class="p3 mb-0">₩ {{ $es->price }}/unit</p>
                                                                </div>
                                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="quantity-row">
                                                                        <div class="quantity-box d-flex align-items-center justify-content-center">
                                                                            <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                            <input type="text" value="{{ $es->qty }}" class="setmaxval only_integer rightClickDisabled" name="es_qty[]"  data-maxval="{{ $es->es_max_qty }}" id="esqty_{{ $es->es_id; }}" />
                                                                            <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 txtRight">
                                                                    <p class="p2 mb-0">₩ <span id="es_row_total_{{$es->es_id}}">{{ $es->price* $es->qty }}</span></p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <input type="hidden" name="es_price[]" value="{{ $es->price}}" id="esprice_{{ $es->es_id; }}">
                                                        </div>
                                                        @endforeach
                                                        @foreach($extra_services as $es)
                                                        <div class="form-check">
                                                            <input class="form-check-input select_es_chk" type="checkbox" value="{{ $es->id }}" id="esCheckbox{{ $es->id }}" name="es[]">
                                                            <label class="form-check-label " for="esCheckbox{{ $es->id }}">
                                                            <div class="row bookingServicesCheckbox">
                                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <p class="p1">{{ $es->es_name }}</p>
                                                                    <p class="p3 mb-0">₩ {{ $es->es_price }}/unit</p>
                                                                </div>
                                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="quantity-row">
                                                                        <div class="quantity-box d-flex align-items-center justify-content-center">
                                                                            <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                            <input type="text" value="1" class="only_integer rightClickDisabled setmaxval" name="es_qty[]" data-maxval="{{ $es->es_max_qty }}" id="esqty_{{ $es->id; }}" disabled />
                                                                            <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 txtRight">
                                                                    <p class="p2 mb-0">₩ <span id="es_row_total_{{$es->id}}">{{ $es->es_price  }}</span></p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <input type="hidden" name="es_price[]" value="{{ $es->es_price}}" id="esprice_{{ $es->id; }}" disabled>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                    <input type="hidden" value="{{ $booking->slug }}" name="b">
                                    <div class="res-sub-btn-rw d-flex justify-content-end">
                                        <button class="btn-back btnPrevious" style="background: transparent !important;">{{ __('home.Back') }}</button>
                                        <a href="{{ route('booking-detail',$booking->slug); }}" class="btn bg-gray1">{{ __('home.cancel') }}</a>
                                        <button class="btn outline-blue editBooking">{{ __('home.Save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
    $(document).ready(function() {
        $(document).on('click','.editBooking',function(){
            // $('#savetype').val($(this).attr('data-btntype')); 
            submit();
        });
        function submit()
        { 
            var token=true; 
            if(token)
            {
                let formdata = $( "#bookingEditFrm" ).serialize();
                $(".editBooking").prop("disabled",true); 
                loading();
                $.post("{{ route('edit-booking-submit') }}",  formdata, function( data ) {
                    if(data.status==1){
                        window.location.href = data.nextpageurl; 
                        unloading();
                    } 
                    else
                    {
                        unloading();
                        $("#commonErrorMsg").text(data.message);
                        $("#commonErrorBox").css('display','block');
                        $(".editBooking").prop("disabled",false); 
                        unloading();
                        setTimeout(function() {
                            $("#commonSuccessBox").hide();
                        }, 3000);
                    }                      
                });         
            }
        } 
        $(document).on('click','.select_es_chk',function(){
            extraServiceCalculation($(this));
        });
        function extraServiceCalculation(id="")
        {
            val = $(id).val(); 
            // name = $(id).attr('data-n'); 
            // price = parseFloat($(id).attr('data-p')); 
            // qty = $("#esqty_"+val).val(); 
            // es_total = (price*qty*numberOfNights).toFixed(2);
            // pb_total = parseFloat(pb_total);
            if($(id).prop("checked") == true)
            {
                $("#esqty_"+val).prop("disabled",false);
                $("#esprice_"+val).prop("disabled",false);
                // $("#esqtym_"+val).addClass("minus");
                // $("#esqtyp_"+val).addClass("plusEs");
                /* es_subtotal = es_subtotal+ parseFloat(es_total);
                pb_total = pb_total + parseFloat(es_total);
               //  aert(pb_total);
                $('#pb_total').html(pb_total.toFixed(2));
                $('#grand_total').val(pb_total.toFixed(2));
                $('#es_subtotal').html(es_subtotal.toFixed(2));
                $('#pb_es_total').html(es_subtotal.toFixed(2));
                $('#es_charges').val(es_subtotal.toFixed(2));
                $("#selected_es").prepend('<tr id="seleted_es_'+val+'"><td><p class="p1 mb-1">'+name+' x '+qty+'</p><p class="p3 mb-0">₩ '+price+'</p></td><td class="verticle-top"><p class="p1 mb-0">₩ '+es_total+'</p></td></tr>');
                // $('#pb_es_row').show();
                $("#pb_es_row").removeClass("d-none");
                $("#pb_es_row").addClass("d-flex");
                */
            }     // console.log(val);
            else    
            {  
                $("#esqty_"+val).prop("disabled",true);
                $("#esprice_"+val).prop("disabled",true);
                // $("#esqtym_"+val).removeClass("minus");
                // $("#esqtyp_"+val).removeClass("plusEs");
                /* es_subtotal = es_subtotal - parseFloat(es_total);
                pb_total= pb_total - parseFloat(es_total);
                $('#pb_es_total').html(es_subtotal.toFixed(2));
                $('#es_subtotal').html(es_subtotal.toFixed(2));
                $('#pb_total').html(pb_total.toFixed(2));
                $('#grand_total').val(pb_total.toFixed(2));
                $('#es_charges').val(es_subtotal.toFixed(2));
                $("#seleted_es_"+val).remove(); $('#esCheckbox'+val).prop('checked', false); 
               //  $('#pb_es_row').hide();
               if(es_subtotal == 0)
               {
                    $("#pb_es_row").removeClass("d-flex");
                    $("#pb_es_row").addClass("d-none");
               } */
            }
        }
    });
</script>
<script type="text/javascript ">
        $('.btnNext').click(function() {
            const nextTabLinkEl = $('.nav-tabs .active').closest('li').next('li').find('a')[0];
            const nextTab = new bootstrap.Tab(nextTabLinkEl);
            nextTab.show();
        });
        $('.btnPrevious').click(function() {
            const prevTabLinkEl = $('.nav-tabs .active').closest('li').prev('li').find('a')[0];
            const prevTab = new bootstrap.Tab(prevTabLinkEl);
            prevTab.show();
        });
        // Steps ja
        $(document).ready(function() {
            $('.tab1').click(function() {
                $('.tab1').addClass('activep');
                $('.tab2').removeClass('activep');
                $('.tab3').removeClass('activep');
                $('.tab4').removeClass('activep');
                $('.tab5').removeClass('activep');
            });
        });
        $(document).ready(function() {
            $('.tab2').click(function() {
                $('.tab1').addClass('activep');
                $('.tab2').addClass('activep');
                $('.tab3').removeClass('activep');
                $('.tab4').removeClass('activep');
                $('.tab5').removeClass('activep');
            });
        });
        $(document).ready(function() {
            $('.tab3').click(function() {
                $('.tab1').addClass('activep');
                $('.tab2').addClass('activep');
                $('.tab3').addClass('activep');
                $('.tab4').removeClass('activep');
                $('.tab5').removeClass('activep');
            });
        });
        $(document).ready(function() {
            $('.tab4').click(function() {
                $('.tab1').addClass('activep');
                $('.tab2').addClass('activep');
                $('.tab3').addClass('activep');
                $('.tab4').addClass('activep');
                $('.tab5').removeClass('activep');
            });
        });
        $(document).ready(function() {
            $('.tab5').click(function() {
                $('.tab1').addClass('activep');
                $('.tab2').addClass('activep');
                $('.tab3').addClass('activep');
                $('.tab4').addClass('activep');
                $('.tab5').addClass('activep');
            });
        });
        // Tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
            // Add service
        $(document).ready(function() {
            $(".addCouponCode").click(function() {
                $(".couponCodApplyeBox").show();
                $(".removeCouponCode").show();
                $(".addCouponCode").hide();
            });
            $(".removeCouponCode").click(function() {
                $(".couponCodApplyeBox").hide();
                $(".removeCouponCode").hide();
                $(".addCouponCode").show();
            });
        });
    </script>
@endsection