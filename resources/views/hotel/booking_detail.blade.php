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
        <div class="content-box-right bookings-detail-sec bookings-detail-hotel-manager-sec">
            <div class="container-fluid">
                <div class="whitebox-w mb-3 bookings-htl-dtl-box-w">
                    <div class="white-card-header d-flex align-items-center flex-wrap">
                        <div>
                            <p class="p2 mb-0 d-flex align-items-center dtl-wt-back-btn">
                                <a href="{{ route('bookings'); }}"><img src="{{asset('/assets/images/')}}/structure/back-arrow.svg" alt="Back" class="backbtn cursor-p" ></a> <small class="mb-0">{{ __('home.bookingID') }}: <span>{{ $booking->slug }}</span>  <span>|</span>  {{ __('home.bookingDate') }}: <span> {{ date_format($booking->created_at,"Y-m-d"); }} </span></small>
                            </p>
                        </div>
                        <div class="ml-auto"> 
                        @if($booking->booking_status !='cancelled' && $booking->booking_status !='completed' && auth()->user()->access != 'admin' )
                            <a href="{{ route('edit-booking',$booking->slug) }}"><img src="{{asset('/assets/images/')}}/structure/edit-sq-blue.svg" alt="" class="editIcon"></a> @endif<span class="chips chips-{{ $booking->booking_status; }} text-capitalize">{{ str_replace("_"," ",$booking->booking_status);  }}</span>
                        </div>
                    </div>
                    <div class="white-card-body">
                        <div class="booking-dtl-htl-dtl-mn-rw d-flex">
                            <div class="bk-htl-dtl-rgt-block">
                                <div class="white-card-header d-flex align-items-center">
                                    <div>
                                        <h5 class="h5">{{ $booking->hotel_name}}</h5>
                                        <p class="p2 mb-0">{{ $booking->email }}</p>
                                    </div>
                                    @if($booking->booking_status =='on_hold' && auth()->user()->access != 'admin')
                                    <div class="ml-auto">
                                        <button class="btn outline-blue h-36" data-bs-toggle="modal" data-bs-target=".confirmPaymentDialog"><img src="{{asset('/assets/images/')}}/structure/check-green.svg" alt="" class="btnCheckIcn"> {{ __('home.confirm') }} </button>
                                    </div>
                                    @endif
                                    @if($booking->booking_status =='cancelled' && $booking->payment_method =='direct_bank_transfer' && isset($BookingCancelDetail) && $BookingCancelDetail->refund_status == 'refund_pending' && auth()->user()->access != 'admin')
                                    <div class="ml-auto">
                                        <button class="btn outline-blue h-36" data-bs-toggle="modal" data-bs-target=".refundtDialog"><img src="{{asset('/assets/images/')}}/structure/autopay.svg" alt="" class="btnCheckIcn">{{ __('home.Refund') }}</button>
                                    </div>
                                    @endif
                                </div>
                                <div class="hotel-check-in-out d-flex align-items-end mt-3">
                                    <div class="checkin">
                                        <p class="p3 mb-1">{{ __('home.checkIn') }}</p>
                                        <div class="checkIOdtl d-flex align-items-center">
                                            <h3 class="blueDate mb-0">{{ date_format($check_in_date,"d"); }}</h3>
                                            <div>
                                                <p class="p3 mb-0">{{ date_format($check_in_date,"m-Y"); }}</p>
                                                <p class="p3 mb-0">{{ $booking->check_in }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nightsblock">
                                        <span class="chips chips-gray1 h-24">{{ $booking->no_of_nights}} {{ __('home.Nights') }}</span>
                                    </div>
                                    <div class="checkout">
                                        <p class="p3 mb-1">{{ __('home.checkOut') }}</p>
                                        <div class="checkIOdtl d-flex align-items-center">
                                            <h3 class="blueDate mb-0">{{ date_format($check_out_date,"d"); }}</h3>
                                            <div>
                                                <p class="p3 mb-0">{{ date_format($check_out_date,"m-Y"); }}</p>
                                                <p class="p3 mb-0">{{ $booking->check_out }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                        <div class="whitebox-w BookingDetails-box mb-3">
                            <h6 class="h6">{{ __('home.bankDetails') }}</h6>
                            <!-- <div class="bookingDetailCheck-in-out-row d-flex flex-wrap">
                                <div class="bk-dtlCol1">
                                    <span class="chips chips-gray"><img src="{{asset('/assets/images/')}}/structure/nights.svg" alt="" class=""> 2 Nights</span>
                                </div>
                                <div class="bk-dtlCol2 row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <p class="p3 mb-2">Check-In</p>
                                        <p class="p1 mb-1">2022, Aug 20</p>
                                        <p class="p3 mb-0" style="color:#3B6470;">12:00 PM onwards</p>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <p class="p3 mb-2">Check-Out</p>
                                        <p class="p1 mb-1">2022, Aug 22</p>
                                        <p class="p3 mb-0" style="color:#3B6470;">Till 11:00 AM</p>
                                    </div>
                                </div>
                            </div> -->
                            <div class="bookingDetailCheck-in-out-row d-flex flex-wrap">
                                <div class="bk-dtlCol1">
                                    <span class="chips chips-gray"><img src="{{asset('/assets/images/')}}/structure/user-nights.svg" alt="" class=""> {{ $booking->no_of_adults + $booking->no_of_childs }} {{ __('home.guests') }}</span>
                                </div>
                                <div class="bk-dtlCol2 row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <p class="p3 mb-2">{{ __('home.totalGuests') }}</p>
                                        <p class="p1 mb-1">{{ $booking->no_of_adults }} Adult, {{ $booking->no_of_childs }} {{ __('home.child') }}</p>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <p class="p3 mb-2">{{ __('home.primaryGuest') }}</p>
                                        <p class="p1 mb-1">{{ $booking->customer_full_name }}| {{ $booking->customer_phone }}</p>
                                        <p class="p3 mb-0" style="color:#3B6470;">{{ $booking->customer_email }}</p>
                                    </div>
                                    @if($booking->childs_below_nyear >0)
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 mt-4">
                                        <p class="p3 mb-2">Child < 3 yrs</p>
                                        <p class="p1 mb-1">{{ $booking->childs_below_nyear }} </p>
                                    </div>
                                    @endif
                                    @if($booking->childs_plus_nyear >0)
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 mt-4">
                                        <p class="p3 mb-2">Child > 3 yrs</p>
                                        <p class="p1 mb-1">{{ $booking->childs_plus_nyear}}</p>
                                    </div>
                                    @endif
                                    @if($booking->child_ages !='')
                                    @php
                                        $child_ages = explode(',',$booking->child_ages);
                                        $childCouter=0; 
                                    @endphp
                                    @foreach($child_ages as $key => $child_age)
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 mt-4">
                                        <p class="p3 mb-2">{{ __('home.child') }} {{ $childCouter+1 }} age</p>
                                        <p class="p1 mb-1"> {{ $child_age }} yrs</p>
                                    </div>
                                    @php $childCouter++; @endphp
                                    @endforeach
                                    @endif 
                                </div>
                            </div>
                            <div class="bookingDetailCheck-in-out-row d-flex flex-wrap">
                                <div class="bk-dtlCol1">
                                    <span class="chips chips-gray"><img src="{{asset('/assets/images/')}}/structure/door-front.svg" alt="" class=""> 1 {{ __('home.room') }}</span>
                                </div>
                                <div class="bk-dtlCol2 row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <p class="p3 mb-2"> {{ __('home.roomName') }}</p>
                                        <p class="p1 mb-1">{{ $booking->room_name; }}</p>
                                    </div>
                                </div>
                            </div>
                            @if(count($bookingExtraService) > 0)
                            <div class="bookingDetailCheck-in-out-row d-flex flex-wrap">
                                <div class="bk-dtlCol1">
                                    <span class="chips chips-gray"><img src="{{asset('/assets/images/')}}/structure/dashboard-customize.svg" alt="" class=""> {{ count($bookingExtraService) }} {{ __('home.extras') }}</span>
                                </div>
                                <div class="bk-dtlCol2 row">
                                    <div class="col-xl-12">
                                        <p class="p3 mb-2">{{ __('home.serviceName') }}</p>
                                        <p class="p1 mb-1">
                                        @php
                                            $esCounter =0;
                                        @endphp
                                        @foreach($bookingExtraService as $extraService)
                                            @if($esCounter ==0)
                                            {{ $extraService->es_name }} x {{ $extraService->qty }}
                                            @else
                                            , {{ $extraService->es_name }} x {{ $extraService->qty }}
                                            @endif
                                            @php
                                            $esCounter++;
                                            @endphp
                                        @endforeach  
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($booking->customer_notes != '')
                            <p class="p2 guestNote mt-3">{{ __('home.guestNotes') }}: <span>{{ $booking->customer_notes }}</span></p>
                            @endif
                            @if($booking->host_notes != '')
                            <p class="p2 guestNote mt-3">{{ __('home.hostNotes') }}: <span>{{ $booking->host_notes; }}</span></p>
                            @endif
                        </div>
                        @if($booking->booking_status == 'completed' && $booking->is_rated == 1)
                        <div class="whitebox-w boking-deatil-rating-review-box mb-3">
                            <h6 class="h6 mb-4">{{ __('home.ratingReview') }}</h6>
                            <h6 class="rt-sub-h6">{{ __('home.rating') }}</h6>
                            <div class="row mt-1">
                                @if(isset($ratingReview->cleanliness))
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
                                    <p class="p2 rtServicehd mb-3 d-flex align-items-center"><img src="{{asset('/assets/images/')}}/structure/cleaning-services.svg" alt="" class="ServicesIcon"> {{ __('home.cleanliness') }}</p>
                                    <p class="rt-start-dv d-flex mb-0">
                                        @for ($c = 1; $c <=5; $c++)
                                            @if($c<=$ratingReview->cleanliness)
                                            <img src="{{asset('/assets/images/')}}/structure/star-orange.svg" alt="" class="StarIcon">
                                            @else
                                            <img src="{{asset('/assets/images/')}}/structure/star-gray.svg" alt="" class="StarIcon">
                                            @endif
                                        @endfor
                                    </p>
                                </div>
                                @endif
                                @if(isset($ratingReview->service))
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
                                    <p class="p2 rtServicehd mb-3 d-flex align-items-center"><img src="{{asset('/assets/images/')}}/structure/cleaning-services.svg" alt="" class="ServicesIcon"> {{ __('home.service') }}</p>
                                    <p class="rt-start-dv d-flex mb-0">
                                    @for ($s = 1; $s <=5; $s++)
                                        @if($s<=$ratingReview->service)
                                            <img src="{{asset('/assets/images/')}}/structure/star-orange.svg" alt="" class="StarIcon">
                                        @else
                                            <img src="{{asset('/assets/images/')}}/structure/star-gray.svg" alt="" class="StarIcon">
                                        @endif
                                    @endfor
                                    </p>
                                </div>
                                @endif
                                @if(isset($ratingReview->facilities))
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
                                    <p class="p2 rtServicehd mb-3 d-flex align-items-center"><img src="{{asset('/assets/images/')}}/structure/cleaning-services.svg" alt="" class="ServicesIcon"> {{ __('home.facility') }}</p>
                                    <p class="rt-start-dv d-flex mb-0">
                                    @for ($f = 1; $f <=5; $f++)
                                        @if($f<=$ratingReview->facilities)
                                            <img src="{{asset('/assets/images/')}}/structure/star-orange.svg" alt="" class="StarIcon">
                                        @else
                                            <img src="{{asset('/assets/images/')}}/structure/star-gray.svg" alt="" class="StarIcon">
                                        @endif
                                    @endfor
                                    </p>
                                </div>
                                @endif
                                @if(isset($ratingReview->value_for_money))
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
                                    <p class="p2 rtServicehd mb-3 d-flex align-items-center"><img src="{{asset('/assets/images/')}}/structure/cleaning-services.svg" alt="" class="ServicesIcon"> {{ __('home.valueForMoney') }}</p>
                                    <p class="rt-start-dv d-flex mb-0">
                                    @for ($v = 1; $v <=5; $v++)
                                        @if($v<=$ratingReview->value_for_money)
                                            <img src="{{asset('/assets/images/')}}/structure/star-orange.svg" alt="" class="StarIcon">
                                        @else
                                            <img src="{{asset('/assets/images/')}}/structure/star-gray.svg" alt="" class="StarIcon">
                                        @endif
                                    @endfor
                                    </p>
                                </div>
                                @endif
                            </div>
                            <div class="divider mt-4 mb-4"></div>
                            <h6 class="rt-sub-h6">{{ __('home.review') }}</h6>
                            <p class="p2">{{ isset($ratingReview->review)?$ratingReview->review:''; }}</p>
                        </div>
                        @endif
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                        <div class="whitebox-w price-statusbox-rgt mb-4">
                            <h6 class="h6">{{ __('home.priceBreakup') }}</h6>
                            <div class="d-flex PriceBreakupRw">
                                <p class="p2 flex-fill PriceBreakupCl-lft">1 {{ __('home.room') }} x {{ $booking->no_of_nights;  }} Night
                                @if($nightChargesInfo !='' )    
                                <img src="{{ asset('/assets/images/') }}/structure/info-blue.svg" alt="" class="infoIcon" style="margin-bottom: 2px;" data-bs-toggle="tooltip" data-bs-html="true" title="{{ $nightChargesInfo; }}">
                                @endif 
                                </p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt">₩ {{ $booking->per_night_charges;  }}</p>
                            </div>
                            @if($booking->no_of_extra_guest > 0)
                            <div class="d-flex PriceBreakupRw">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.extraGuest') }} x {{ $booking->no_of_extra_guest;  }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt">₩ {{ $booking->extra_guest_charges;  }}</p>
                            </div>
                            @endif
                            @if(count($bookingExtraService) > 0)
                            <div class="d-flex PriceBreakupRw">
                                <p class="p2 flex-fill PriceBreakupCl-lft cursor-p" data-bs-toggle="modal" data-bs-target=".ExtraServicesDialog">{{ __('home.extraService') }} <img src="{{asset('/assets/images/')}}/structure/arrow-down.svg" alt=""></p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt">₩ {{ $booking->extra_services_charges }}</p>
                            </div>
                            @endif
                            @if($booking->long_stay_discount_amount > 0)
                            <div class="d-flex PriceBreakupRw">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.longStayDiscount') }}<br>
                                </p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt" style="color: #008952;">- ₩ {{ $booking->long_stay_discount_amount;  }}</p>
                            </div>
                            @endif
                            @if($booking->coupon_code !='')
                            <div class="d-flex PriceBreakupRw">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.couponCode') }}<br>
                                    <span class="dashed-chipt text-uppercase">{{ $booking->coupon_code }}</span>
                                </p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt" style="color: #008952;">- ₩ {{ $booking->coupon_discount_amount }}</p>
                            </div>
                            @endif
                            @if(count($discounts) >0 )
                            <div class="d-flex PriceBreakupRw">
                                <p class="p2 flex-fill PriceBreakupCl-lft width60">{{ __('home.discount') }} 
                                    <div class="info-parent">
                                    <img src="{{asset('/assets/images/')}}/structure/info-blue.svg" alt="" class="infoIcon" style="margin-bottom: 2px;"> 
                                    <div class='info-box-new discounttooltip'> 
                                        @foreach($discounts as $discount)
                                        <p class='tltp-p'>  
                                            <span class='normalfont'>{{ $discount->reason }} 
                                                <small class='d-bloc ml-auto mediumfont'>₩ {{ ($discount->effective_amount) }}</small>
                                            </span>
                                            <span class='redb3 cursor-pointer removeAD' data-ad="{{ $discount->id }}">×</span>
                                         </p>
                                         @endforeach
                                    </div>
                                </div>
                                </p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt" style="color: #008952;">- ₩ {{ $booking->additional_discount }}</p>
                            </div>
                            @endif
                            @if($booking->reward_points_used !=0)
                            <div class="subtotalRow">
                                <div class="d-flex PriceBreakupRw flex-wrap mb-0">
                                    <p class="p1 flex-fill PriceBreakupCl-lft">{{ __('home.subtotal') }}</p>
                                    <p class="p1 flex-fill PriceBreakupCl-rgt">₩ {{ (((($booking->per_night_charges + $booking->extra_guest_charges)-$booking->long_stay_discount_amount)-$booking->coupon_discount_amount)- $booking->additional_discount)+$booking->extra_services_charges }}</p>
                                </div>
                                <div class="d-flex PriceBreakupRw flex-wrap mb-0">
                                    <p class="p2 flex-fill PriceBreakupCl-lft">rewardsPoints | {{ $booking->reward_points_used }}</p>
                                    <p class="p2 flex-fill PriceBreakupCl-rgt" style="color: #008952;">- ₩ {{ $booking->payment_by_points }}</p>
                                </div>
                            </div>
                            @endif
                            <div class="d-flex PriceBreakupRw flex-wrap Total mb-0">
                                <p class="p1 flex-fill PriceBreakupCl-lft">{{ __('home.TotalPrice') }}</p>
                                <p class="p1 flex-fill PriceBreakupCl-rgt">₩ {{ ((((($booking->per_night_charges + $booking->extra_guest_charges)-$booking->long_stay_discount_amount)-$booking->coupon_discount_amount)-$booking->payment_by_points) - $booking->additional_discount)+$booking->extra_services_charges }}</p>
                                @if($booking->booking_status == 'on_hold' && auth()->user()->access != 'admin')
                                <button class="btn outline-blue w-100 h-36 mt-4" data-bs-toggle="modal" data-bs-target=".additionalDiscountDialog" id="addAD">{{ __('home.additionalDiscount') }}</button>
                                @endif
                            </div>
                        </div>
                        <div class="whitebox-w price-statusbox-rgt mb-4">
                            <h6 class="h6">{{ __('home.paymentInfo') }}</h6>
                            <div class="d-flex PriceBreakupRw">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.paymentStatus') }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt">
                                    <span class="chips chips-{{ $booking->payment_status; }} text-capitalize">{{ $booking->payment_status; }}</span>
                                </p>
                            </div>
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.paymentMode') }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt text-capitalize">{{ str_replace("_"," ", $booking->payment_method); }}</p>
                            </div>
                        </div>
                        @if($booking->booking_status =='on_hold' && auth()->user()->access != 'admin')
                        <div class="">
                            <button class="btn bg-white w-100" data-bs-toggle="modal" data-bs-target=".deleteDialog">{{ __('home.cancelBooking') }}</button>
                        </div>
                        @elseif($booking->booking_status =='confirmed')
                        <div class="">
                            <button class="btn bg-white w-100" data-bs-toggle="modal" data-bs-target=".cancelBookingDialog">{{ __('home.cancelBooking') }}</button>
                        </div>
                        @endif
                        @if($booking->booking_status =='cancelled' && isset($BookingCancelDetail))
                        <div class="whitebox-w price-statusbox-rgt mb-4">
                            <h6 class="h6">{{ __('home.RefundInfo') }}</h6>
                            <div class="d-flex PriceBreakupRw">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.paymentStatus') }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt">
                                    <span class="chips chips-{{ $BookingCancelDetail->refund_status}}  text-capitalize">{{ str_replace("_"," ", $BookingCancelDetail->refund_status); }}</span>
                                </p>
                            </div>
                            @if($BookingCancelDetail->refund_status =='no_refund' && $BookingCancelDetail->refund_points !=0)
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.Refund') }} {{ __('home.rewardsPoints') }} | {{ $BookingCancelDetail->refund_points}}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt" style="font-family: 'satoshi-bold';">₩ {{ $BookingCancelDetail->refund_amount_in_points}}</p>
                            </div>
                            @endif 
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.paymentMode') }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt  text-capitalize">{{ str_replace("_"," ", $booking->payment_method); }}</p>
                            </div>
                            @if($BookingCancelDetail->refund_status !='no_refund')            
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.refundPrice') }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt" style="font-family: 'satoshi-bold';">₩ {{ $BookingCancelDetail->refund_amount_in_money}}</p>
                            </div>
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.Refund') }} {{ __('home.rewardsPoints') }} | {{ $BookingCancelDetail->refund_points}}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt" style="font-family: 'satoshi-bold';">₩ {{ $BookingCancelDetail->refund_amount_in_points}}</p>
                            </div>
                            @if($booking->payment_by_cash != 0)
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.bankName') }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt text-capitalize">{{ ($BookingCancelDetail->bank_name !='')?$BookingCancelDetail->bank_name:'N.A.'; }}</p>
                            </div>
                            @endif
                            @if($booking->payment_by_cash != 0)
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.accountNo') }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt">{{ ($BookingCancelDetail->account_number !='')?$BookingCancelDetail->account_number:'N.A.'; }}</p>
                            </div>
                            @endif
                            @if($booking->payment_by_cash != 0)
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.accountHolderName') }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt text-capitalize">{{ ($BookingCancelDetail->account_holder_name !='')?$BookingCancelDetail->account_holder_name:'N.A.'; }}</p>
                            </div>
                            @endif
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Delete Modal -->
    <div class="modal fade deleteDialog" tabindex="-1" aria-labelledby="DeleteDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h4 class="h4 mt-2">{{ __('home.cancelBooking') }}</h4>
                        <p class="p2 mb-4">{{ __('home.areYouSureYouWantToCancelThisBooking') }}</p>
                    </div>
                    <div class="d-flex btns-rw">
                        <button class="btn bg-gray flex-fill" data-bs-dismiss="modal" id="cancelBookingY">{{ __('home.yes') }}</button>
                        <button class="btn flex-fill" data-bs-dismiss="modal">{{ __('home.no') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade confirmPaymentDialog" tabindex="-1" aria-labelledby="confirmPaymenDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h4 class="h4 mt-2">{{ __('home.confirmPayment') }}</h4>
                        <p class="p2 mb-4">Have you received <span class="p2">₩ {{ ((((($booking->per_night_charges + $booking->extra_guest_charges)-$booking->long_stay_discount_amount)-$booking->coupon_discount_amount)-$booking->payment_by_points)-$booking->additional_discount)+$booking->extra_services_charges }}</span> {{ __('home.for') }} {{ __('home.booking') }}  <span class="p2">{{ $booking->slug; }}?</span></p>
                    </div>
                    <div class="d-flex btns-rw">
                        <button class="btn bg-gray flex-fill" data-bs-dismiss="modal">{{ __('home.no') }}</button>
                        <button class="btn flex-fill" id="paymentConfirmedY">{{ __('home.confirm') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade ExtraServicesDialog" tabindex="-1" aria-labelledby="ExtraServicesDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h4 class="h4 mb-4">{{ __('home.extraService') }}</h4>
                    </div>
                    <div class="table-responsive table-view">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>subtotal</th>
                                    <th>₩ {{ $booking->extra_services_charges }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookingExtraService as $extraService)
                                <tr>
                                    <td>
                                        <p class="p1 mb-1">{{ $extraService->es_name }} x {{ $extraService->qty }}</p>
                                        <p class="p3 mb-0">₩ {{ $extraService->price }}</p>
                                    </td>
                                    <td class="verticle-top">
                                        <p class="p1 mb-0">₩ {{ $extraService->es_row_total }}</p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade additionalDiscountDialog" tabindex="-1" aria-labelledby="additionalDiscountDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h4 class="h4 mb-4"> {{ __('home.additionalDiscount') }}</h4>
                    </div>
                    <div class="detailTxtRow d-flex mb-2">
                        <p class="p2 mb-0 detailTxtLeft">{{ __('home.totalBasePrice') }}</p>
                        <p class="p2 detailTxtRight mb-0">₩ {{ $booking->per_night_charges+ $booking->extra_guest_charges;  }} </p>
                    </div>
                    <p class="p3 mb-2">{{ __('home.discount') }}</p>
                    <div class="detailTxtRow d-flex mb-2">
                        <p class="p2 mb-0 detailTxtLeft">{{ __('home.coupon') }}</p>
                        <p class="p2 detailTxtRight priceBlue mb-0">- ₩ {{ $booking->coupon_discount_amount }}</p>
                    </div>
                    <div class="detailTxtRow d-flex mb-2">
                        <p class="p2 mb-0 detailTxtLeft">{{ __('home.longStay') }}</p>
                        <p class="p2 detailTxtRight priceBlue mb-0">- ₩  {{ $booking->long_stay_discount_amount;  }}</p>
                    </div>
                    <div class="divider mt-3 mb-3"></div>
                    <div class="detailTxtRow d-flex mb-2">
                        <p class="p2 mb-0 detailTxtLeft">{{ __('home.totalSalesPrice') }}</p>
                        <p class="p2 detailTxtRight mb-0">₩ {{ (((($booking->per_night_charges + $booking->extra_guest_charges)-$booking->long_stay_discount_amount)-$booking->coupon_discount_amount)-$booking->payment_by_points) - $booking->additional_discount }}</p>
                    </div>
                    <div class="divider mt-3 mb-3"></div>
                    <div class="detailTxtRow d-flex mb-2">
                        <p class="p2 mb-0 detailTxtLeft">{{ __('home.additionalDiscount') }}</p>
                        <div class="input-group">
                            <input type="text" name="ad_amount" id="ad_amount" class="form-control decimal adInputs" value="" placeholder="0">
                            <div class="form-floating mb-0 capDropdown">
                                <button data-bs-toggle="dropdown" class="form-select" id="adSelectedType">₩</button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li class="radiobox-image">
                                        <input type="radio" id="adflat" class="select_ad_type" name="ad_type" value="flat"  />
                                        <label for="adflat">₩</label>
                                    </li>
                                    <li class="radiobox-image">
                                        <input type="radio" id="adpercentage" class="select_ad_type" name="ad_type" value="percentage" />
                                        <label for="adpercentage">%</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="detailTxtRow flex-wrap d-flex mb-2">
                        <p class="p2 mb-2 detailTxtLeft">{{ __('home.reason') }}</p>
                        <div class="w-100">
                            <input type="text" name="ad_reason" id="ad_reason" class="form-control adInputs" placeholder="{{ __('home.write') }}">
                        </div>
                    </div>
                    <div class="divider mt-3 mb-3"></div>
                    <div class="detailTxtRow d-flex mb-4">
                        <p class="p2 mb-0 detailTxtLeft">{{ __('home.adjustedTotalSalesPrice') }}</p>
                        <p class="p2 detailTxtRight mb-0">₩ <span id="adAdjusted">00</span></p>
                    </div>
                    <button type="button" class="btn w-100" id="adSubmit" disabled>{{ __('home.Submit') }}</button>
                </div>
            </div>
        </div>
    </div>
@if($booking->booking_status =='cancelled' && isset($BookingCancelDetail) && $BookingCancelDetail->refund_status == 'refund_pending' && auth()->user()->access != 'admin')    
<div class="modal fade refundtDialog" tabindex="-1" aria-labelledby="confirmPaymenDialogLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-heads">
                    <h4 class="h4 mt-2">{{ __('home.Refund') }} </h4>
                </div>
                <div>
                    <div class="detailTxtRow d-flex mb-2">
                        <p class="p2 mb-0 detailTxtLeft">{{ __('home.Refund') }} {{ __('home.rewardPoints') }} | {{ $BookingCancelDetail->refund_points }}</p>
                        <p class="p2 detailTxtRight mb-0">₩ {{ $BookingCancelDetail->refund_amount_in_points }}</p>
                    </div>
                    <div class="detailTxtRow d-flex mb-2">
                        <p class="p2 mb-0 detailTxtLeft">{{ __('home.refundPrice') }}</p>
                        <p class="p2 detailTxtRight mb-0">₩ {{ $BookingCancelDetail->refund_amount_in_money }}</p>
                    </div>
                    <div class="detailTxtRow d-flex mb-2">
                        <p class="p3">(cancellationBefore {{ $BookingCancelDetail->cancellation_before_n_days }} days: <span class="p-blue">{{ $BookingCancelDetail->refund_percentage }}%</span> refund)</p>
                    </div>
                    <div class="detailTxtRow d-flex align-items-center mb-3">
                        <p class="p2 mb-0">{{ __('home.bankName') }}</p>
                        <input type="text" class="form-control norInput h-40" placeholder="{{ __('home.Enter') }} {{ __('home.bankName') }} " value="{{ $BookingCancelDetail->bank_name }}" disabled>
                    </div>
                    <div class="detailTxtRow d-flex align-items-center mb-3">
                        <p class="p2 mb-0">{{ __('home.accountNo') }}</p>
                        <input type="text" class="form-control norInput h-40" placeholder="{{ __('home.Enter') }} {{ __('home.accountNo') }} " value="{{ $BookingCancelDetail->account_number }}" disabled>
                    </div>
                    <div class="detailTxtRow d-flex align-items-center mb-4">
                        <p class="p2 mb-0">{{ __('home.accountHolderName') }}</p>
                        <input type="text" class="form-control norInput h-40" placeholder="{{ __('home.Enter') }} {{ __('home.accountHolderName') }} " value="{{ $BookingCancelDetail->account_holder_name }}" disabled>
                    </div>
                    <button class="btn w-100" type="button" id="refundAmount">{{ __('home.Submit') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>  
@endif  
@if($booking->booking_status =='confirmed' && isset($refundDetails['total_refund_amount']))
<div class="modal fade cancelBookingDialog" tabindex="-1" aria-labelledby="cancelBookingDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="bookingCancelFrm" action="JavaScript:Void(0);" method="post">
                <div class="modal-body p-0">
                   <div class="modelHeader">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-heads">
                            <h3 class="h3 mt-2">{{ __('home.cancelBooking') }}</h3>
                            <p class="p2 mb-3">{{ __('home.areYouSureYouWantToCancelThisBooking') }}</p>
                        </div>
                        <div class="divider mb-3"></div>
                   </div>
                    <div class="modelScrollBody">
                        <div class="detailTxtRow d-flex mb-2">
                            <p class="p2 mb-0 detailTxtLeft">{{ __('home.Room') }}</p>
                            <p class="p2 detailTxtRight mb-0">{{ $booking->room_name; }}</p>
                        </div>
                        <div class="detailTxtRow d-flex mb-2">
                            <p class="p2 mb-0 detailTxtLeft">{{ __('home.TotalPrice') }}</p>
                            <p class="p2 detailTxtRight mb-0">₩ {{ (((($booking->per_night_charges + $booking->extra_guest_charges)-$booking->long_stay_discount_amount)-$booking->coupon_discount_amount)-$booking->payment_by_points)+$booking->extra_services_charges }}</p>
                        </div>
                        <div class="detailTxtRow d-flex mb-2">
                            <p class="p2 mb-0 detailTxtLeft">{{ __('home.CancellationFee') }}</p>
                            <p class="p2 detailTxtRight mb-0">₩ {{ ((((($booking->per_night_charges + $booking->extra_guest_charges)-$booking->long_stay_discount_amount)-$booking->coupon_discount_amount)-$booking->payment_by_points)+$booking->extra_services_charges)-$refundDetails['total_refund_amount'] }}</p>
                        </div>
                        <div class="detailTxtRow d-flex mb-2">
                            <p class="p2 mb-0 detailTxtLeft">{{ __('home.Refund') }} {{ __('home.RewardsPoints') }} | {{$refundDetails['refund_points']}}</p>
                            <p class="p2 detailTxtRight mb-0">₩ {{$refundDetails['refund_amount_in_points']}}</p>
                        </div>
                        <div class="detailTxtRow d-flex mb-2">
                            <p class="p2 mb-0 detailTxtLeft">{{ __('home.refundPrice') }}</p>
                            <p class="p2 detailTxtRight mb-0">₩ {{ $refundDetails['refund_amount_in_money'] }}</p>
                        </div>
                        <div class="detailTxtRow d-flex mb-2">
                            <p class="p3">({{ __('home.cancellationBefore') }} {{$refundDetails['numberOfBeforeDays']}} days: <span class="p-blue">{{$refundDetails['refund_in_percentage']}}%</span> refund)</p>
                        </div>
                        <div class="detailTxtRow d-flex mb-2">
                            <p class="p2 mb-0 detailTxtLeft">{{ __('home.CancellationReason') }}</p>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control norTextarea" id="txtarea" placeholder="{{ __('home.WriteHere') }}" style="min-height: 80px;" value="" name="cancellation_reason" id="cancelReason"></textarea>
                        </div>
                        <div class="divider mt-3 mb-3"></div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="1" id="want_to_adjust" name="want_to_adjust">
                            <label class="form-check-label" for="want_to_adjust">
                            {{ __('home.wantToAdjustRefundPrice') }}
                            </label>
                        </div>
                        <div id="want_to_adjustdiv" style="display:none;">
                        <div class="detailTxtRow d-flex mb-2">
                            <p class="p2 mb-0 detailTxtLeft">{{ __('home.adjustedRefundPrice') }}</p>
                        </div>
                        <div class="d-flex mb-4">
                            <div class="InpCol" style="padding-right:10px;">
                                <div class="input-group inpWtCaption-Rt">
                                    <input type="text" class="form-control decimal" value="" name="adjusted_refund_price" id="adjusted_refund_price" placeholder="{{ __('home.refundPrice') }}">
                                    <span class="input-group-text" id="basic-addon2">₩</span>
                                </div>
                            </div>
                            <div class="InpCol">
                                <div class="input-group inpWtCaption-Rt">
                                    <input type="text" class="form-control only_integer rightClickDisabled setmaxval" value="" placeholder="{{ __('home.Refund') }}" name="adjusted_refund_percentage" id="adjusted_refund_percentage" data-maxval="100" >
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="detailTxtRow d-flex mb-2">
                            <p class="p2 mb-0 detailTxtLeft">{{ __('home.adjustedRefundPrice') }}</p>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control norTextarea" id="txtarea" placeholder="{{ __('home.WriteHere') }}" style="min-height: 80px;" value="" name="adjusted_reason" id="adjustedReason"></textarea>
                        </div>
                        </div>
                    </div>
                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                    <input type="hidden" value="{{ $booking->slug; }}" name="b">
                    <div class="modelFooter">
                        <button class="btn w-100" type="button" id="cancelBookingSubmit">{{ __('home.Submit') }}</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endif
<!-- common models -->
@include('common_modal')
@include('frontend.layout.footer_script')
@endsection
<!-- JS section  -->   
@section('js-script')
<script>
    $(document).ready(function() {
        var refund_amount_in_money=  "{{ (isset($refundDetails['refund_amount_in_money']))?$refundDetails['refund_amount_in_money']:0; }}";
        $(document).on('click','#want_to_adjust',function(){
            if($("#want_to_adjust").prop('checked') == true){
               $('#want_to_adjustdiv').show();  
            }
            else
                $('#want_to_adjustdiv').hide();  
        });
        $(document).on('keyup','#adjusted_refund_price',function(){
            var adjusted_refund_price = $(this).val();
            //  console.log(adjusted_refund_price);
            if(refund_amount_in_money != 0){
                var onePercent = refund_amount_in_money/100;
                var adjusted_refund_percentage = adjusted_refund_price/onePercent; 
                $('#adjusted_refund_percentage').val(adjusted_refund_percentage.toFixed(2));  
            }
            else
                $('#adjusted_refund_percentage').val(0);  
        });
        $(document).on('keyup','#adjusted_refund_percentage',function(){
            var adjusted_refund_percentage = $(this).val();
            //  console.log(adjusted_refund_price);
            if(refund_amount_in_money != 0){
                var onePercent = refund_amount_in_money/100;
                var adjusted_refund_price = adjusted_refund_percentage*onePercent; 
                $('#adjusted_refund_price').val(adjusted_refund_price.toFixed(2));  
            }
            else
                $('#adjusted_refund_price').val(0);  
        });
        // cancel booking  after confirmation 
        $(document).on('click','#cancelBookingSubmit',function(){
            $("#cancelBookingSubmit").prop("disabled",true); 
            loading();
                $.post("{{ route('booking-cancel') }}",  $("#bookingCancelFrm" ).serialize(), function( data ) {
                    if(data.status==1){
                        location.reload(); 
                        unloading();
                    } 
                    else
                    {
                        unloading();
                        $("#commonErrorMsg").text(data.message);
                        $("#commonErrorBox").css('display','block');
                        $("#paymentConfirmedY").prop("disabled",false); 
                        setTimeout(function() {
                            $("#commonErrorBox").hide();
                        }, 1500);
                    }                      
                }); 
        });
        function resetADForm()
        {
            $('#adSelectedType').text('₩');
            $('#ad_reason').val('');
            $('#ad_amount').val('');
            $('#adflat').prop('checked', false); 
            $('#adpercentage').prop('checked', false); 
        }    
        $(document).on('click','#addAD',function(){
            resetADForm();
        });    
        $(document).on('click','.removeAD',function(){
            var ad_id = $(this).attr('data-ad');
            $(".removeAD").prop("disabled",true); 
            loading();
            $.post("{{ route('remove-additional-discount') }}",  {'_token':"{{ csrf_token() }}",'b':"{{ $booking->slug}}",'ad_id':ad_id}, function( data ) {
                if(data.status==1){
                    location.reload(); 
                    unloading();
                } 
                else
                {
                    unloading();
                    $("#commonErrorMsg").text(data.message);
                    $("#commonErrorBox").css('display','block');
                    $("#paymentConfirmedY").prop("disabled",false); 
                    setTimeout(function() {
                        $("#commonErrorBox").hide();
                    }, 1500);
                }       
            });
        });    
        $(document).on('click','.select_ad_type',function(){
            var ad_type = $(this).val();
            calculate_ad();
            if(ad_type=='flat'){
                $('#adSelectedType').text('₩');
            }else{
                $('#adSelectedType').text('%');
            }
        });    
        $(document).on('keyup','.adInputs',function(e){
            var ad_reason = $('#ad_reason').val();
            var ad_amount = $('#ad_amount').val();
            calculate_ad();
            if(ad_reason!='' && ad_amount!=''){
                $('#adSubmit').prop('disabled',false);
            }else{
                $('#adSubmit').prop('disabled',true);
            }
            if (e.keyCode == 13)
                applyAditionalDiscount();
        });
        $(document).on('click','#adSubmit',function(){
            applyAditionalDiscount();
        });
        function calculate_ad(){
            var ad_type = $('input[name=ad_type]:checked').val();
            var ad_amount = $('#ad_amount').val();
            if(ad_type == undefined){
                ad_type = 'flat';
            }
            if(ad_amount == '' || ad_amount == undefined){
                ad_amount = 0;
            }
            // alert(ad_type);
            // var ad_reason = $('#ad_reason').val();
            var total_sales_price = "{{ (((($booking->per_night_charges + $booking->extra_guest_charges)-$booking->long_stay_discount_amount)-$booking->coupon_discount_amount)-$booking->payment_by_points) - $booking->additional_discount }}";
            if(ad_type=='flat'){
                var adAdjusted = total_sales_price - ad_amount;
            }else{
                var adAdjusted = total_sales_price - (total_sales_price * ad_amount / 100);
            }
            $('#adAdjusted').text(adAdjusted);
        }
        function applyAditionalDiscount()
        {
            var token =true; 
            var b = "{{ $booking->slug }}"; 
            var ad_type = $('input[name=ad_type]:checked').val();
            var ad_amount = $('#ad_amount').val();
            var ad_reason = $('#ad_reason').val();
            var adAdjusted = $('#adAdjusted').text();
            if(ad_type == undefined){
                ad_type = 'flat';
            }
            if(ad_amount == '' || ad_amount == undefined){
                ad_amount = 0;
            }
            if(adAdjusted == '' || adAdjusted == undefined || adAdjusted < 0)
            {
                token = false;    
                unloading();
                $("#commonErrorMsg").text('Adjusted Total Sales Price should be greater or equal to 0 ');
                $("#commonErrorBox").css('display','block');
                $("#adSubmit").prop("disabled",false); 
                setTimeout(function() {
                    $("#commonErrorBox").hide();
                }, 1500);
            }
            else if(token)
            {
                if(ad_amount !=0  && ad_reason != '')
                {
                    $("#adSubmit").prop("disabled",true); 
                    loading();
                    $.post("{{ route('apply-additional-discount') }}",  {'_token':"{{ csrf_token() }}",'b':b,'ad_type':ad_type,'ad_amount':ad_amount,'ad_reason':ad_reason}, function( data ) {
                        if(data.status==1){
                            resetADForm();
                            location.reload(); 
                            unloading();
                        } 
                        else
                        {
                            unloading();
                            $("#commonErrorMsg").text(data.message);
                            $("#commonErrorBox").css('display','block');
                            $("#adSubmit").prop("disabled",false); 
                            setTimeout(function() {
                                $("#commonErrorBox").hide();
                            }, 1500);
                        }       
                    });
                }
                else
                { return false;}
            }
            else
            {
                unloading();
                $("#commonErrorMsg").text('something went wrong');
                $("#commonErrorBox").css('display','block');
                $("#adSubmit").prop("disabled",false); 
                setTimeout(function() {
                    $("#commonErrorBox").hide();
                }, 1500);
            }
        }
        // payment confirm  
        $(document).on('click','#paymentConfirmedY',function(){
        var b = "{{ $booking->slug }}"; 
        $("#paymentConfirmedY").prop("disabled",true); 
        loading();
            $.post("{{ route('payment-make-confirm') }}",  {'_token':"{{ csrf_token() }}",'b':b}, function( data ) {
                if(data.status==1){
                    location.reload(); 
                    unloading();
                } 
                else
                {
                    unloading();
                    $("#commonErrorMsg").text(data.message);
                    $("#commonErrorBox").css('display','block');
                    $("#paymentConfirmedY").prop("disabled",false); 
                    setTimeout(function() {
                        $("#commonErrorBox").hide();
                    }, 1500);
                }                      
            }); 
        });
        // cancel booking   
        $(document).on('click','#cancelBookingY',function(){
        var b = "{{ $booking->slug }}"; 
        $("#cancelBookingY").prop("disabled",true); 
        loading();
            $.post("{{ route('booking-cancel') }}",  {'_token':"{{ csrf_token() }}",'b':b}, function( data ) {
                if(data.status==1){
                    location.reload(); 
                    unloading();
                } 
                else
                {
                    unloading();
                    $("#commonErrorMsg").text(data.message);
                    $("#commonErrorBox").css('display','block');
                    $("#paymentConfirmedY").prop("disabled",false); 
                    setTimeout(function() {
                        $("#commonErrorBox").hide();
                    }, 1500);
                }                      
            }); 
        });
        $(document).on('click','#refundAmount',function(){
            var b = "{{ $booking->slug }}"; 
            $("#refundAmount").prop("disabled",true); 
            loading();
            $.post("{{ route('refund-booking-amount') }}",  {'_token':"{{ csrf_token() }}",'b':b}, function( data ) {
                if(data.status==1){
                    location.reload(); 
                    unloading();
                } 
                else
                {
                    unloading();
                    $("#commonErrorMsg").text(data.message);
                    $("#commonErrorBox").css('display','block');
                    $("#paymentConfirmedY").prop("disabled",false); 
                    setTimeout(function() {
                        $("#commonErrorBox").hide();
                    }, 1500);
                }                      
            }); 
        });
    });
</script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection