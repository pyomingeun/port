@extends('frontend.layout.head')
@section('body-content')
@include('hotel.header')
    <div class="main-wrapper-gray">
    @if(auth()->user()->access == 'admin')
             @include('admin.leftbar')        
         @else
             @include('hotel.leftbar')
         @endif
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
                                <li class="nav-item" style="visibility: hidden;">
                                    <a class="nav-link tab5" id="tab-id5" role="tab" aria-controls="step5" aria-selected="true" data-bs-step="5" data-bs-toggle="tab" href="#step5">
                                        <span class="stepcircle">5 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
                                        <div class="tabCnt">
                                            <p class="p3">{{ __('home.Step') }} 5</p>
                                            <p class="p1">{{ __('home.summary') }}</p>
                                        </div>
                                    </a>
                                </li> 
                            </ul>
                        </div>
                    </div>
                    <div class="hotel-management-right-col">
                    <form id="createBookingFrm" action="javaScript:Void(0);" method="post">   
                       <div class="tab-content stepsContent">
                            <div class="tab-pane active" id="step1" aria-labelledby="tab-id1">
                                    <div class="roomsManageform-Content">
                                        <div class="grayBox-w">
                                            <div class="hotemmanageFormInrcnt">
                                                <h5 class="hd5 h5">{{ __('home.bookingInfo') }}</h5>
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-floating  disabledInput disabledInput">
                                                            <input type="text" class="form-control" id="bs" placeholder="{{ __('home.bookingReferenceNumber') }}" value="{{ $slug }}" name="bs">
                                                            <label for="bs">{{ __('home.bookingReferenceNumber') }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-floating datepickerField">
                                                            <img src="{{asset('/assets/images/')}}/structure/calendar1.svg" alt="" class="calendarIcon" />
                                                            <input class="form-control  keyBoardFalse rightClickDisabled" id="checkin" name="checkin" autocomplete="off" value="" placeholder="{{ __('home.checkIn') }}">
                                                            <label for="checkin">{{ __('home.checkIn') }}<span class="required-star">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-floating datepickerField ">
                                                            <img src="{{asset('/assets/images/')}}/structure/calendar1.svg" alt="" class="calendarIcon" />
                                                            <input class="form-control   keyBoardFalse rightClickDisabled" id="checkout" name="checkout" autocomplete="off" value="" placeholder="{{ __('home.checkOut') }}">
                                                            <label for="checkout">{{ __('home.checkOut') }}<span class="required-star">*</span></label>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                        <div class="form-floating  ">
                                                            <input type="text" class="form-control" id="floatingInput" placeholder="Room" value="">
                                                            <label for="floatingInput">Room</label>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                        <div class="form-floating mb-3" id="discount_type_validate">
                                                            <button id="selectDiscount" data-bs-toggle="dropdown" class="form-select text-capitalize" aria-expanded="false"></button>
                                                            <ul class="dropdown-menu dropdown-menu-start">
                                                                @foreach($rooms as $room)
                                                                <li class="radiobox-image">
                                                                    <input type="radio" class="select_room" id="room{{ $room->slug }}" name="room" value="{{ $room->slug }}" {{ ($request->session()->get('selected_room') !='' && $request->session()->get('selected_room')==$room->id )?'checked':''; }} />
                                                                    <label for="room{{ $room->slug }}">{{ $room->room_name }}</label>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                            <label for="selectDiscount" class="label {{ $request->session()->get('selected_room') !=''?'label_add_top':'';  }}">{{ __('home.SelectRoom') }}<span class="required-star">*</span></label>
                                                            <p class="error-inp" id="room_err_msg"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grayBox-w">
                                            <div class="hotemmanageFormInrcnt StandardOccupancyBox">
                                                <h5 class="hd5 h5">{{ __('home.guest') }}</h5>
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                        <div class="quantity-row row">
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ __('home.adult') }} 12Y+</p>
                                                            </div>
                                                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                                                <div class="quantity-box d-flex align-items-center ml-auto">
                                                                    <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                    <input type="text" value="1" class="only_integer rightClickDisabled" name="adults" id="adults" />
                                                                    <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                        <div class="quantity-row row">
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ __('home.child') }} (bellow 3Y) </p>
                                                            </div>
                                                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                                                <div class="quantity-box d-flex align-items-center ml-auto">
                                                                    <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                    <input type="text" value="0" name="childs_bellow_nyear" id="childs" class="only_integer rightClickDisabled" />
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
                                                                    <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                    <input type="text" value="0" name="childs_plus_nyear" id="childs" class="only_integer rightClickDisabled" />
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
                                            <a href="{{ route('bookings'); }}" class="btn bg-gray1">{{ __('home.cancel') }}</a>
                                            <a class="btn tab1" id="next1">{{ __('home.Next') }}</a>
                                        </div>
                                    </div>
                            </div>
                            <div class="tab-pane fade" id="step2" aria-labelledby="tab-id2">
                                <div class="roomsManageform-Content">
                                    <div class="grayBox-w">
                                        <div class="hotemmanageFormInrcnt">
                                            <h5 class="hd5 h5">{{ __('home.primaryGuestDetails') }}</h5>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating ">
                                                        <input type="text" class="form-control" id="guest_fullname" placeholder="{{ __('home.fullName') }}" value="" >
                                                        <label for="guest_fullname">{{ __('home.fullName') }}<span class="required-star">*</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating ">
                                                        <input type="text" class="form-control" id="guest_phone" placeholder="{{ __('home.phone') }}" value="">
                                                        <label for="guest_phone">{{ __('home.phone') }}<span class="required-star">*</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating ">
                                                        <input type="text" class="form-control" id="guest_email" placeholder="{{ __('home.email') }}" value="">
                                                        <label for="guest_email">{{ __('home.email') }}<span class="required-star">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="res-sub-btn-rw d-flex justify-content-end">
                                    <button class="btn-back btnPrevious" style="background: transparent !important;">{{ __('home.Back') }}</button>
                                    <a href="{{ route('bookings'); }}" class="btn bg-gray1">{{ __('home.cancel') }}</a>
                                    <a class="btn tab2" id="next2">{{ __('home.Next') }}</a>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="step3" aria-labelledby="tab-id3">
                                <div class="roomsManageform-Content">
                                    <div class="grayBox-w">
                                        <div class="hotemmanageFormInrcnt RoomFeaturesFacilitiesBox">
                                            <h5 class="hd5 h5">{{ __('home.guestNotes') }}</h5>
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="form-floating">
                                                        <textarea itemid="txtarea" class="form-control" id="floatingInput" placeholder="{{ __('home.guestNotes') }}" style="min-height:106px;" name="customer_notes"></textarea>
                                                        <label for="floatingInput">{{ __('home.guestNotes') }}</label>
                                                        <p class="mb-0 max-char-limit" id="guest_notes_msg">{{ __('home.max400characters') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grayBox-w">
                                        <div class="hotemmanageFormInrcnt RoomFeaturesFacilitiesBox">
                                            <h5 class="hd5 h5">{{ __('home.hostNotes') }}</h5>
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="form-floating">
                                                        <textarea itemid="txtarea" class="form-control" id="floatingInput" placeholder="{{ __('home.hostNotes') }}" style="min-height:106px;" name="host_notes" ></textarea>
                                                        <label for="floatingInput">{{ __('home.hostNotes') }}</label>
                                                        <p class="mb-0 max-char-limit" id="host_notes_msg">{{ __('home.max400characters') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="res-sub-btn-rw d-flex justify-content-end">
                                    <button class="btn-back btnPrevious" style="background: transparent !important;">{{ __('home.Back') }}</button>
                                    <a href="{{ route('bookings'); }}" class="btn bg-gray1">{{ __('home.cancel') }}</a>
                                    <a class="btn tab3" id="next3">{{ __('home.Next') }}</a>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="step4" aria-labelledby="tab-id4">
                                <div class="roomsManageform-Content">
                                    <div class="grayBox-w">
                                        <div class="bookingextarServices">
                                            <h5 class="hd5 h5 mb-4">{{ __('home.extraService') }}</h5>
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    @foreach($extra_services as $es)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="{{$es->id}}"  name="es[]" id="es{{$es->id}}">
                                                        <label class="form-check-label " for="es{{$es->id}}">
                                                        <div class="row bookingServicesCheckbox">
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                                                <p class="p1">{{ $es->es_name }}</p>
                                                                <p class="p3 mb-0">₩ {{ $es->es_price }}/unit</p>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                                                <div class="quantity-row">
                                                                    <div class="quantity-box d-flex align-items-center justify-content-center">
                                                                        <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                        <input type="text" value="1" class="only_integer rightClickDisabled" name="es_qty[]" id="es_qty{{$es->id}}" disabled/>
                                                                        <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 txtRight">
                                                                <p class="p2 mb-0">₩ <span id="es_row_total_{{$es->id}}">0</span></p>
                                                            </div>
                                                        </div>
                                                    </label>
                                                    </div>
                                                    <input type="hidden" name="es_price[]" id="es_price{{ $es->id }}" disabled>
                                                    <input type="hidden" name="es_name[]" id="es_name{{ $es->id }}" disabled>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="res-sub-btn-rw d-flex justify-content-end">
                                    <button class="btn-back btnPrevious" style="background: transparent !important;">{{ __('home.Back') }}</button>
                                    <a href="{{ route('bookings'); }}" class="btn bg-gray1">{{ __('home.cancel') }}</a>
                                    <a class="btn tab4" id="next4">{{ __('home.Next') }}</a>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="step5" aria-labelledby="tab-id5">
                                <div class="roomsManageform-Content">
                                    <div class="row">
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                                            <div class="whiteBox-w roomsSummaryDetailBox">
                                                <div class="">
                                                    <h5 class="hd5 h5">{{ __('home.summary') }}</h5>
                                                    <div class="row">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <div class="d-flex mb-3">
                                                                <div class="sumDtlLeftTxt">{{ __('home.bookingReferenceNumber') }} :</div>
                                                                <div class="sumDtlRightTxt">{{ $slug }}</div>
                                                            </div>
                                                            <div class="d-flex mb-3">
                                                                <div class="sumDtlLeftTxt">{{ __('home.checkIn') }} - {{ __('home.checkOut') }} :</div>
                                                                <div class="sumDtlRightTxt">2022/09/08 - 2022/09/10</div>
                                                            </div>
                                                            <div class="d-flex mb-3">
                                                                <div class="sumDtlLeftTxt">{{ __('home.room') }} :</div>
                                                                <div class="sumDtlRightTxt">King Deluxe Room Garden View <img src="../images/structure/info-blue.svg" alt="" class="infoIcon" style="margin-bottom: 2px;" data-bs-toggle="tooltip" data-bs-html="true" title="<div class='tooltipbox'> <span class='normalfont'>Child 1: <small class='mediumfont'>2yrs</small></span> , <span class='normalfont'>Child 1: <small class='mediumfont'>3yrs</small></span> </div>"></div>
                                                            </div>
                                                            <div class="d-flex mb-3">
                                                                <div class="sumDtlLeftTxt">{{ __('home.GuestDetails') }} :</div>
                                                                <div class="sumDtlRightTxt">
                                                                    David Williamson
                                                                    <p class="p3 mb-0"><span>david_williamson@gmail.com</span> <span class="dotgray"></span> <span>010-9876-5432</span></p>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex mb-3">
                                                                <div class="sumDtlLeftTxt">{{ __('home.extraService') }} :</div>
                                                                <div class="sumDtlRightTxt">Bike Rental x 1, Blanket x 5</div>
                                                            </div>
                                                            <div class="d-flex mb-3 flex-wrap">
                                                                <div class="sumDtlLeftTxt">{{ __('home.guestNotes') }} :</div>
                                                                <div class="sumDtlRightTxt">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</div>
                                                            </div>
                                                            <div class="d-flex mb-3 flex-wrap">
                                                                <div class="sumDtlLeftTxt">{{ __('home.hostNotes') }} :</div>
                                                                <div class="sumDtlRightTxt">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 HotelImagesCl">
                                            <div class="whitebox-w price-statusbox-rgt mb-4">
                                                <h6 class="h6">{{ __('home.priceBreakup') }}</h6>
                                                <div class="d-flex PriceBreakupRw">
                                                    <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.price') }}</p>
                                                    <p class="p2 flex-fill PriceBreakupCl-rgt">₩ 1500</p>
                                                </div>
                                                <div class="d-flex PriceBreakupRw">
                                                    <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.ExtraFees') }}</p>
                                                    <p class="p2 flex-fill PriceBreakupCl-rgt">₩ 100</p>
                                                </div>
                                                <div class="d-flex PriceBreakupRw">
                                                    <p class="p2 flex-fill PriceBreakupCl-lft cursor-p" data-bs-toggle="modal" data-bs-target=".ExtraServicesDialog"> {{ __('home.extraService') }}<img src="../images/structure/arrow-down.svg" alt=""></p>
                                                    <p class="p2 flex-fill PriceBreakupCl-rgt">₩ 300</p>
                                                </div>
                                                <div class="d-flex PriceBreakupRw">
                                                    <p class="p2 flex-fill PriceBreakupCl-lft" style="color: #015AC3;">{{ __('home.longStayDiscount') }}</p>
                                                    <p class="p2 flex-fill PriceBreakupCl-rgt" style="color: #015AC3;">- ₩ 300</p>
                                                </div>
                                                <div class="d-flex PriceBreakupRw">
                                                    <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.couponCode') }}<br>
                                                        <span class="dashed-chipt text-uppercase">NEWBOOK1</span> <img src="../images/structure/close.svg" alt="" class="cursor-p">
                                                    </p>
                                                    <p class="p2 flex-fill PriceBreakupCl-rgt cursor-p" style="color: #015AC3;">
                                                        <a class="addCouponCode"><img src="../images/structure/add-circle.svg"> {{ __('home.Add') }}</a>
                                                        <a class="removeCouponCode"><img src="../images/structure/add-circle-gray.svg"></a>
                                                    </p>
                                                </div>
                                                <div class="couponCodApplyeBox">
                                                    <input type="text" class="form-control norInput h-40" value="NEWBOOK1">
                                                    <a class="a-text-green">{{ __('home.apply') }}</a>
                                                </div>
                                                <div class="d-flex PriceBreakupRw flex-wrap Total mb-0">
                                                    <p class="p1 flex-fill PriceBreakupCl-lft">{{ __('home.TotalPrice') }}</p>
                                                    <p class="p1 flex-fill PriceBreakupCl-rgt">₩ 1300</p>
                                                </div>
                                            </div>
                                            <div class="whitebox-w price-statusbox-rgt mb-4">
                                                <h6 class="h6">{{ __('home.paymentInfo') }}</h6>
                                                <div class="d-flex PriceBreakupRw">
                                                    <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.paymentStatus') }}</p>
                                                    <p class="p2 flex-fill PriceBreakupCl-rgt">
                                                        <span class="chips chips-orange">{{ __('home.waiting') }}</span>
                                                    </p>
                                                </div>
                                                <div class="d-flex PriceBreakupRw mt-2">
                                                    <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.paymentMode') }}</p>
                                                    <p class="p2 flex-fill PriceBreakupCl-rgt">{{ __('home.directTransfer') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="res-sub-btn-rw d-flex justify-content-end">
                                    <button class="btn-back btnPrevious" style="background: transparent !important;">{{ __('home.Back') }}</button>
                                    <a href="{{ route('bookings'); }}" class="btn bg-gray1">{{ __('home.cancel') }}</a>
                                    <button class="btn tab5" data-bs-toggle="modal" data-bs-target=".thankyouDialog" id="Save">Save</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Thank you Modal -->
    <div class="modal fade thankyouDialog successDialog" tabindex="-1" aria-labelledby="thankyouDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <div class="text-center">
                            <img src="{{asset('/assets/images/')}}/structure/checked-thankyou.svg" alt="" class="">
                            <h3 class="h3 mt-2">{{ __('home.thankYou') }}!</h3>
                            <p class="p2 mb-4">{{ __('home.YournewbookinghasbeencreatedsuccessfullyForfurtherinformationvisitbookingmanagement') }}</p>
                        </div>
                        <a href="room-management-hotel-manager.html" class="btn w-100">{{ __('home.continue') }}</a>
                    </div>
                </div>
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
    $(document).ready(function() {
        var date = new Date();
        date.setDate(date.getDate());
        $("#checkin").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            startDate: date
        });
        $("#checkout").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            startDate: date
        });
        // step-1 submit  
        $(document).on('click','.next1',function(){
            $("#next1").prop("disabled",true); 
            loading();
            $.post("{{ route('create-booking-step1') }}",  $("#createBookingFrm" ).serialize(), function( data ) {
                if(data.status==1){
                    $("#next1").prop("disabled",fasle); 
                    const nextTabLinkEl = $('.nav-tabs .active').closest('li').next('li').find('a')[0];
                    const nextTab = new bootstrap.Tab(nextTabLinkEl);
                    nextTab.show(); 
                    unloading();
                } 
                else
                {
                    unloading();
                    $("#commonErrorMsg").text(data.message);
                    $("#commonErrorBox").css('display','block');
                    $("#next").prop("disabled",false); 
                    setTimeout(function() {
                        $("#commonErrorBox").hide();
                    }, 1500);
                }                                  
            });
         });
        //$( "#checkout" ).datepicker({ efaultDate: "+1w",minDate: new Date()});
    });
</script>
<script type="text/javascript ">
        /* $('.btnNext').click(function() {
            const nextTabLinkEl = $('.nav-tabs .active').closest('li').next('li').find('a')[0];
            const nextTab = new bootstrap.Tab(nextTabLinkEl);
            nextTab.show();
        }); */
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