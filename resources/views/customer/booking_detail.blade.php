@extends('frontend.layout.head')
@section('body-content')
@include('customer.header')
    <!-- include left bar here -->
    @include('customer.leftbar')    
@php
    $check_in_date = new DateTime($booking->check_in_date);
    $check_out_date = new DateTime($booking->check_out_date);
@endphp
        <div class="content-box-right bookings-detail-sec">
            <div class="container-fluid">
                <div class="whitebox-w mb-3 bookings-htl-dtl-box-w">
                    <div class="white-card-header d-flex align-items-center flex-wrap">
                        <div>
                            <p class="p2 mb-0 d-flex align-items-center dtl-wt-back-btn">
                                <a href="{{ route('my-bookings') }}"><img src="{{asset('/assets/images/')}}/structure/back-arrow.svg" alt="Back" class="backbtn cursor-p"></a> <small class="mb-0">Booking ID: <span>{{ $booking->slug }}</span>  <span>|</span>  Booking Date: <span>{{ date_format($booking->created_at,"Y-m-d"); }}</span></small> </p>
                        </div>
                        <div class="ml-auto">
                            <span class="chips chips-{{ $booking->booking_status; }} text-capitalize">{{ str_replace("_"," ",$booking->booking_status);  }}</span>
                        </div>
                    </div>
                    <div class="white-card-body">
                        <div class="booking-dtl-htl-dtl-mn-rw d-flex">
                            <div class="bk-htl-img-block">
                                <img
                                    src="{{ asset('/hotel_images/'.$booking->featured_img); }}"
                                    onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';"
                                    class="bk-htl-img"
                                />
                            </div>
                            <div class="bk-htl-dtl-rgt-block">
                                <div class="white-card-header d-flex flex-wrap">
                                    <div>
                                        <h5 class="h5">{{ $booking->hotel_name}}</h5>
                                        <p class="p2 mb-0">
                                            {{ $booking->phone}} {{ $booking->street }}{{ ($booking->city !='' && $booking->street !='')?', ':''; }} {{ $booking->city }}{{ ($booking->city !='' && $booking->subrub !='')?', ':''; }}{{ $booking->subrub  }} {{ ($booking->pincode !='')?' - ':''; }}{{ $booking->pincode }}
                                        </p>
                                    </div>
                                    @if($booking->booking_status == 'completed' && $booking->is_rated == 0)
                                    <a href="{{ route('rating-review',$booking->slug); }}" class="ml-auto">
                                        <p class="mb-0 rate-review-txt d-flex align-items-center">
                                            <img src="{{asset('/assets/images/')}}/structure/star-blue.svg" alt="">
                                            {{ __('home.rateAndReview') }}
                                        </p>
                                    </a>
                                    @endif
                                    @if($booking->booking_status =='cancelled' && $booking->payment_method =='direct_bank_transfer' && isset($BookingCancelDetail) && $BookingCancelDetail->refund_status == 'refund_pending')                                     
                                    <a href="#" data-bs-toggle="modal" data-bs-target=".cardDetailDialog" class="ml-auto">
                                    <p class="mb-1 rate-review-txt d-flex align-items-center mt-4"><img src="{{asset('/assets/images/')}}/structure/bank-blue.svg" alt=""> {{ __('home.AddBankDetails') }}</p>
                                    </a>
                                    @endif
                                    <!-- <a href="#" data-bs-toggle="modal" data-bs-target=".cardDetailDialog" class="btn pamentpayNow"><span class="PayNowspan">Pay Now</a> -->
                                </div>
                                <div class="hotel-check-in-out d-flex align-items-end mt-3">
                                    <div class="checkin">
                                        <p class="p3 mb-1">{{ __('home.checkIn') }}</p>
                                        <div class="checkIOdtl d-flex align-items-center">
                                            <h3 class="blueDate mb-0">{{ date_format($check_in_date,"d"); }}</h3>
                                            <div>
                                                <p class="p3 mb-0">{{ date_format($check_in_date,"m-Y"); }}</p>
                                                <p class="p3 mb-0">{{ $booking->check_in }} </p>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="nightsblock">
                                        <span class="chips chips-gray1 h-24">{{ $booking->no_of_nights;  }} {{ __('home.Nights') }}</span>
                                    </div>
                                    <div class="checkout">
                                        <p class="p3 mb-1">{{ __('home.checkOut') }} </p>
                                        <div class="checkIOdtl d-flex align-items-center">
                                            <h3 class="blueDate mb-0">{{ date_format($check_out_date,"d"); }}</h3>
                                            <div>
                                                <p class="p3 mb-0">{{ date_format($check_out_date,"m-Y"); }}</p>
                                                <p class="p3 mb-0"> {{ $booking->check_out }}</p>

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
                            <h6 class="h6">{{ __('home.Bookingdetails') }}</h6>
                            <!-- <div class="bookingDetailCheck-in-out-row d-flex flex-wrap">
                                <div class="bk-dtlCol1">
                                    <span class="chips chips-gray"><img src="{{asset('/assets/images/')}}/structure/nights.svg" alt="" class=""> 2 Nights</span>
                                </div>
                                <div class="bk-dtlCol2 row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <p class="p3 mb-2">Check-In</p>
                                        <p class="p1 mb-1">2022, Aug 20</p>
                                        <p class="p3 mb-0" style="color:#3B6470;">12:00 PM onwards</p>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
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
                                        <p class="p1 mb-1">{{ $booking->no_of_adults }} {{ __('home.adult') }}, {{ $booking->no_of_childs }} {{ __('home.child') }}</p>
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
                                        <p class="p3 mb-2">{{ __('home.child') }} {{ $childCouter+1 }} {{ __('home.age') }} </p>
                                        <p class="p1 mb-1"> {{ $child_age }} yrs</p>
                                    </div>
                                    @php $childCouter++; @endphp
                                    @endforeach
                                    @endif 
                                    <!-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 mt-4">
                    <p class="p3 mb-2">Child 2 Age</p>
                    <p class="p1 mb-1">5 yrs</p>
                  </div> -->
                                    <!-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 mt-4">
                    <p class="p3 mb-2">Child 2 Age</p>
                    <p class="p1 mb-1">5 yrs</p>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 mt-4">
                    <p class="p3 mb-2">Child 2 Age</p>
                    <p class="p1 mb-1">5 yrs</p>
                  </div> -->
                                </div>
                            </div>
                            <div class="bookingDetailCheck-in-out-row d-flex flex-wrap">
                                <div class="bk-dtlCol1">
                                    <span class="chips chips-gray"><img src="{{asset('/assets/images/')}}/structure/door-front.svg" alt="" class=""> 1 Room</span>
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
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($booking->customer_notes != '')
                            <p class="p2 guestNote mt-3">{{ __('home.guestNotes') }}: <span>{{ $booking->customer_notes }}</span></p>
                            @endif
                            @if($booking->host_notes != '')
                            <p class="p2 guestNote mt-2">{{ __('home.hostNotes') }}: <span>{{ $booking->host_notes; }}</span></p>
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
                                    <p class="p2 rtServicehd mb-3 d-flex align-items-center"><img src="{{asset('/assets/images/')}}/structure/cleaning-services.svg" alt="" class="ServicesIcon">{{ __('home.valueForMoney') }}</p>
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
                        @if($booking->cancellation_policy !='')
                        <div class="accordion" id="bookingDetail">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="bookingDetailTab1">
                                    <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#bookingDetail1" aria-expanded="true" aria-controls="bookingDetail1"> {{ __('home.cancellationPolicies') }}</button>
                                </h2>
                                <div id="bookingDetail1" class="accordion-collapse collapse show" aria-labelledby="bookingDetailTab1" data-bs-parent="#bookingDetail">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-xl-10 col-lg-11 col-md-12 col-sm-12 col-12">
                                                <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                    <div class="circleBefor"></div>
                                                    <div class="cancellationPolicycnt d-flex align-items-center">
                                                        <span class="bgpink"></span>
                                                        <div class="cancellationPolicyCol1">
                                                            <p class="p2 mb-0">{{ __('home.theDay') }}</p>
                                                        </div>
                                                        <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ ($cancellation_policy->same_day_refund == "100")?'Fully ':''; }}{{ ($cancellation_policy->same_day_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                            <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $cancellation_policy->same_day_refund}}%</span> {{ __('home.refund') }})</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                    <div class="circleBefor"></div>
                                                    <div class="cancellationPolicycnt d-flex align-items-center">
                                                        <span class="bgpink"></span>
                                                        <div class="cancellationPolicyCol1">
                                                            <p class="p2 mb-0">{{ __('home.before') }} 1 {{ __('home.day') }}</p>
                                                        </div>
                                                        <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ ($cancellation_policy->b4_1day_refund == "100")?'Fully ':''; }}{{ ($cancellation_policy->b4_1day_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                            <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $cancellation_policy->b4_1day_refund}}%</span> {{ __('home.refund') }})</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                    <div class="circleBefor"></div>
                                                    <div class="cancellationPolicycnt d-flex align-items-center">
                                                        <span class="bgpink"></span>
                                                        <div class="cancellationPolicyCol1">
                                                            <p class="p2 mb-0">{{ __('home.before') }} 2 {{ __('home.day') }}</p>
                                                        </div>
                                                        <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ ($cancellation_policy->b4_2days_refund == "100")?'Fully ':''; }}{{ ($cancellation_policy->b4_2days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                            <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $cancellation_policy->b4_2days_refund}}%</span> {{ __('home.refund') }})</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                    <div class="circleBefor"></div>
                                                    <div class="cancellationPolicycnt d-flex align-items-center">
                                                        <span class="bgpink"></span>
                                                        <div class="cancellationPolicyCol1">
                                                            <p class="p2 mb-0">{{ __('home.before') }} 3 {{ __('home.day') }}</p>
                                                        </div>
                                                        <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ ($cancellation_policy->b4_3days_refund == "100")?'Fully ':''; }}{{ ($cancellation_policy->b4_3days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                            <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $cancellation_policy->b4_3days_refund}}%</span> {{ __('home.refund') }})</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                    <div class="circleBefor"></div>
                                                    <div class="cancellationPolicycnt d-flex align-items-center">
                                                        <span class="bgpink"></span>
                                                        <div class="cancellationPolicyCol1">
                                                            <p class="p2 mb-0">{{ __('home.before') }} 4 {{ __('home.day') }}</p>
                                                        </div>
                                                        <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ ($cancellation_policy->b4_4days_refund == "100")?'Fully ':''; }}{{ ($cancellation_policy->b4_4days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                            <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $cancellation_policy->b4_4days_refund}}%</span> {{ __('home.refund') }})</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                    <div class="circleBefor"></div>
                                                    <div class="cancellationPolicycnt d-flex align-items-center">
                                                        <span class="bgpink"></span>
                                                        <div class="cancellationPolicyCol1">
                                                            <p class="p2 mb-0">{{ __('home.before') }} 5 {{ __('home.day') }}</p>
                                                        </div>
                                                        <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ ($cancellation_policy->b4_5days_refund == "100")?'Fully ':''; }}{{ ($cancellation_policy->b4_5days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                            <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $cancellation_policy->b4_5days_refund}}%</span> {{ __('home.refund') }})</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                    <div class="circleBefor"></div>
                                                    <div class="cancellationPolicycnt d-flex align-items-center">
                                                        <span class="bgpink"></span>
                                                        <div class="cancellationPolicyCol1">
                                                            <p class="p2 mb-0">{{ __('home.before') }} 6 {{ __('home.day') }}</p>
                                                        </div>
                                                        <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ ($cancellation_policy->b4_6days_refund == "100")?'Fully ':''; }}{{ ($cancellation_policy->b4_6days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                            <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $cancellation_policy->b4_6days_refund}}%</span> {{ __('home.refund') }})</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                    <div class="circleBefor"></div>
                                                    <div class="cancellationPolicycnt d-flex align-items-center">
                                                        <span class="bgpink"></span>
                                                        <div class="cancellationPolicyCol1">
                                                            <p class="p2 mb-0">{{ __('home.before') }} 7 {{ __('home.day') }}</p>
                                                        </div>
                                                        <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ ($cancellation_policy->b4_7days_refund == "100")?'Fully ':''; }}{{ ($cancellation_policy->b4_7days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                            <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $cancellation_policy->b4_7days_refund}}%</span> {{ __('home.refund') }})</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                    <div class="circleBefor"></div>
                                                    <div class="cancellationPolicycnt d-flex align-items-center">
                                                        <span class="bgpink"></span>
                                                        <div class="cancellationPolicyCol1">
                                                            <p class="p2 mb-0">{{ __('home.before') }} 8 {{ __('home.day') }}</p>
                                                        </div>
                                                        <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ ($cancellation_policy->b4_8days_refund == "100")?'Fully ':''; }}{{ ($cancellation_policy->b4_8days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                            <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $cancellation_policy->b4_8days_refund}}%</span> {{ __('home.refund') }})</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                    <div class="circleBefor"></div>
                                                    <div class="cancellationPolicycnt d-flex align-items-center">
                                                        <span class="bgpink"></span>
                                                        <div class="cancellationPolicyCol1">
                                                            <p class="p2 mb-0">{{ __('home.before') }} 9 {{ __('home.day') }}</p>
                                                        </div>
                                                        <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ ($cancellation_policy->b4_9days_refund == "100")?'Fully ':''; }}{{ ($cancellation_policy->b4_9days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                            <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $cancellation_policy->b4_9days_refund}}%</span> {{ __('home.refund') }})</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                    <div class="circleBefor"></div>
                                                    <div class="cancellationPolicycnt d-flex align-items-center">
                                                        <span class="bgpink"></span>
                                                        <div class="cancellationPolicyCol1">
                                                            <p class="p2 mb-0">{{ __('home.before') }} 10 {{ __('home.day') }}</p>
                                                        </div>
                                                        <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ ($cancellation_policy->b4_10days_refund == "100")?'Fully ':''; }}{{ ($cancellation_policy->b4_10days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                            <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $cancellation_policy->b4_10days_refund}}%</span> {{ __('home.refund') }})</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="bookingDetailTab2">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#bookingDetail2" aria-expanded="false" aria-controls="bookingDetail2">
                                   {{ __('home.hotelPolicies') }}
                                </button>
                                </h2>
                                <div id="bookingDetail2" class="accordion-collapse collapse" aria-labelledby="bookingDetailTab2" data-bs-parent="#bookingDetail">
                                {!!  $booking->hotel_policy !!}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                        <div class="whitebox-w price-statusbox-rgt mb-4">
                            <h6 class="h6"> {{ __('home.priceBreakup') }}</h6>
                            <div class="d-flex PriceBreakupRw">
                                <p class="p2 flex-fill PriceBreakupCl-lft">1 {{ __('home.room') }} x {{ $booking->no_of_nights;  }} {{ __('home.Night') }}
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
                                <p class="p2 flex-fill PriceBreakupCl-lft cursor-p" data-bs-toggle="modal" data-bs-target=".ExtraServicesDialog">{{ __('home.extraService') }}  <img src="{{asset('/assets/images/')}}/structure/arrow-down.svg" alt=""></p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt">₩ {{ $booking->extra_services_charges }} </p>
                            </div>
                            @endif
                            @if($booking->long_stay_discount_amount > 0)
                            <div class="d-flex PriceBreakupRw">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.longStayDiscount') }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt" style="color:#008952;">- ₩ {{ $booking->long_stay_discount_amount;  }}</p>
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
                                <p class="p2 flex-fill PriceBreakupCl-lft width60"> {{ __('home.discount') }}
                                    <div class="info-parent">
                                    <img src="{{asset('/assets/images/')}}/structure/info-blue.svg" alt="" class="infoIcon" style="margin-bottom: 2px;"> 
                                    <div class='info-box-new discounttooltip'> 
                                        @foreach($discounts as $discount)
                                        <p class='tltp-p'>  
                                            <span class='normalfont'>{{ $discount->reason }} 
                                                <small class='d-bloc ml-auto mediumfont'>₩ {{ siteNumberFormat($discount->effective_amount) }}</small>
                                            </span>
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
                                    <p class="p1 flex-fill PriceBreakupCl-lft"> {{ __('home.subtotal') }}</p>
                                    <p class="p1 flex-fill PriceBreakupCl-rgt">₩ {{ (((($booking->per_night_charges + $booking->extra_guest_charges)-$booking->long_stay_discount_amount)-$booking->coupon_discount_amount)- $booking->additional_discount)+$booking->extra_services_charges }}</p>
                                </div>
                                <div class="d-flex PriceBreakupRw flex-wrap mb-0">
                                    <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.rewardPoints') }} | {{ $booking->reward_points_used }}</p>
                                    <p class="p2 flex-fill PriceBreakupCl-rgt" style="color: #008952;">- ₩ {{ $booking->payment_by_points }}</p>
                                </div>
                            </div>
                            @endif
                            <div class="d-flex PriceBreakupRw Total mb-0">
                                <p class="p1 flex-fill PriceBreakupCl-lft">{{ __('home.TotalPrice') }}</p>
                                <p class="p1 flex-fill PriceBreakupCl-rgt">₩ {{ ((((($booking->per_night_charges + $booking->extra_guest_charges)-$booking->long_stay_discount_amount)-$booking->coupon_discount_amount)-$booking->payment_by_points) - $booking->additional_discount)+$booking->extra_services_charges }}</p>
                            </div>
                        </div>
                        <div class="whitebox-w price-statusbox-rgt mb-4">
                            <h6 class="h6">{{ __('home.paymentInfo') }}</h6>
                            <div class="d-flex PriceBreakupRw">
                                <p class="p2 flex-fill PriceBreakupCl-lft"> {{ __('home.paymentStatus') }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt">
                                    <span class="chips chips-{{ $booking->payment_status; }} text-capitalize">{{ $booking->payment_status; }}</span>
                                </p>
                            </div>
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft"> {{ __('home.paymentMode') }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt text-capitalize">{{ str_replace("_"," ", $booking->payment_method); }}</p>
                            </div>
                            @php 
                            /* 
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.cardInfo') }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt"><img src="{{asset('/assets/images/')}}/structure/visa.png" alt=""> (XXXX XXXX XXXX 0123)</p> 
                            </div>
                            */
                            @endphp
                        </div>
                        @if($booking->booking_status =='on_hold')
                        <div class="">
                            <button class="btn bg-white w-100" data-bs-toggle="modal" data-bs-target=".deleteDialog">{{ __('home.cancelBooking') }}</button>
                        </div>
                        @elseif($booking->booking_status =='confirmed')
                        <div class="grayBox-rgt">
                        <p class="p2 note"><img src="../images/structure/info-blue.svg" alt="" class="note-info-icon"> {{ __('home.note') }}: {{ __('home.Youhavetopaycancellationchargesreadcancellationpoliciesbeforecancelbooking') }}</p>
                        <button class="btn bg-white h-36 w-100" data-bs-toggle="modal" data-bs-target=".cancelBookingDialog">{{ __('home.cancelBooking') }}</button>
                        </div>
                        @endif
                        @if($booking->booking_status =='cancelled' && isset($BookingCancelDetail))
                        <div class="whitebox-w price-statusbox-rgt mb-4">
                            <h6 class="h6">{{ __('home.RefundInfo') }}</h6>
                            <div class="d-flex PriceBreakupRw">
                                <p class="p2 flex-fill PriceBreakupCl-lft">Payment Status</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt">
                                    <span class="chips chips-{{ $BookingCancelDetail->refund_status}}  text-capitalize">{{ str_replace("_"," ", $BookingCancelDetail->refund_status); }}</span>
                                </p>
                            </div>
                            @if($BookingCancelDetail->refund_status =='no_refund' && $BookingCancelDetail->refund_points !=0)
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.refund') }} {{ __('home.rewardsPoints') }} | {{ $BookingCancelDetail->refund_points}}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt" style="font-family: 'satoshi-bold';">₩ {{ $BookingCancelDetail->refund_amount_in_points}}</p>
                            </div>
                            @endif
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft"> {{ __('home.paymentMode') }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt  text-capitalize">{{ str_replace("_"," ", $booking->payment_method); }}</p>
                            </div>
                            @if($BookingCancelDetail->refund_status !='no_refund')            
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft">  {{ __('home.refundPrice') }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt" style="font-family: 'satoshi-bold';">₩ {{ $BookingCancelDetail->refund_amount_in_money}} </p>
                            </div>
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft"> {{ __('home.refund') }}  {{ __('home.rewardsPoints') }} | {{ $BookingCancelDetail->refund_points}}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt" style="font-family: 'satoshi-bold';">₩ {{ $BookingCancelDetail->refund_amount_in_points}}</p>
                            </div>
                            @if($booking->payment_by_currency != 0)
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.bankName') }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt">{{ ($BookingCancelDetail->bank_name !='')?$BookingCancelDetail->bank_name:'N.A.'; }}</p>
                            </div>
                            @endif
                            @if($booking->payment_by_currency != 0)
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.accountNo') }}.</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt">{{ ($BookingCancelDetail->account_number !='')?$BookingCancelDetail->account_number:'N.A.'; }}</p>
                            </div>
                            @endif
                            @if($booking->payment_by_currency != 0)
                            <div class="d-flex PriceBreakupRw mt-2">
                                <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.accountHolder') }}</p>
                                <p class="p2 flex-fill PriceBreakupCl-rgt">{{ ($BookingCancelDetail->account_holder_name !='')?$BookingCancelDetail->account_holder_name:'N.A.'; }}</p>
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
    <!--on-hold booking cancel confirmation Modal -->
    <div class="modal fade deleteDialog" tabindex="-1" aria-labelledby="DeleteDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h3 class="h3 mt-2">{{ __('home.cancelBooking') }}</h3>
                        <p class="p2 mb-4">{{ __('home.areYouSureYouWantToCancelThisBooking') }}</p>
                    </div>
                    <div class="d-flex btns-rw">
                        <button class="btn bg-gray flex-fill cancelBookingY" data-bs-dismiss="modal">{{ __('home.yes') }}</button>
                        <button class="btn flex-fill" data-bs-dismiss="modal">{{ __('home.no') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($booking->booking_status =='confirmed' && isset($refundDetails['total_refund_amount']))
    <!--on-hold booking cancel confirmation Modal -->
    <div class="modal fade cancelBookingDialog" tabindex="-1" aria-labelledby="cancelBookingDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
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
                            <p class="p2 mb-0 detailTxtLeft">{{ __('home.room') }}</p>
                            <p class="p2 detailTxtRight mb-0">{{ $booking->room_name; }}</p>
                        </div>
                        <div class="detailTxtRow d-flex mb-2">
                            <p class="p2 mb-0 detailTxtLeft">{{ __('home.TotalPrice') }}</p>
                            <p class="p2 detailTxtRight mb-0">₩ {{ (((($booking->per_night_charges + $booking->extra_guest_charges)-$booking->long_stay_discount_amount)-$booking->coupon_discount_amount)-$booking->payment_by_points)+$booking->extra_services_charges }}</p>
                        </div>
                        <div class="detailTxtRow d-flex mb-2">
                            <p class="p2 mb-0 detailTxtLeft"> {{ __('home.cancellationFee') }}</p>
                            <p class="p2 detailTxtRight mb-0">₩ {{ ((((($booking->per_night_charges + $booking->extra_guest_charges)-$booking->long_stay_discount_amount)-$booking->coupon_discount_amount)-$booking->payment_by_points)+$booking->extra_services_charges)-$refundDetails['total_refund_amount'] }}</p>
                        </div>
                        <div class="detailTxtRow d-flex mb-2">
                            <p class="p2 mb-0 detailTxtLeft"> {{ __('home.refund') }}  {{ __('home.rewardPoints') }} | {{$refundDetails['refund_points']}}</p>
                            <p class="p2 detailTxtRight mb-0">₩ {{$refundDetails['refund_amount_in_points']}}</p>
                        </div>
                        <div class="detailTxtRow d-flex mb-2">
                            <p class="p2 mb-0 detailTxtLeft">{{ __('home.refundPrice') }}</p>
                            <p class="p2 detailTxtRight mb-0">₩ {{$refundDetails['refund_amount_in_money']}}</p>
                        </div>
                        <div class="detailTxtRow d-flex mb-2">
                            <p class="p3">({{ __('home.cancellationBefore') }} {{$refundDetails['numberOfBeforeDays']}} days: <span class="p-blue">{{$refundDetails['refund_in_percentage']}}%</span> {{ __('home.refund') }})</p>
                        </div>
                        <div class="detailTxtRow d-flex mb-2">
                            <p class="p2 mb-0 detailTxtLeft"> {{ __('home.CancellationReason') }}</p>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control norTextarea" placeholder="{{ __('home.WriteHere') }}" style="min-height: 80px;" name="cancellation_reason" id="cancelReason" value=""></textarea>
                        </div>
                    </div>
                    <div class="modelFooter">
                        <button class="btn w-100 cancelBookingY">{{ __('home.Submit') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
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
                                    <th>{{ __('home.subtotal') }}</th>
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
    <div class="modal fade cardDetailDialog " tabindex="-1 " aria-labelledby="cardDetailDialog " aria-hidden="true ">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content ">
            <div class="modal-body ">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-heads ">
                    <h3 class="h3 ">{{ __('home.bankDetails') }}</h3>
                    <p class="p2 ">{{ __('home.enterTheBankAccountDetailsrefundwill') }}</p>
                </div>
                <form action="JavaScript:Void(0);" method="post" id="refundBankDetails">
                    <div class="form-floating" id="rbn_validate">
                        <input type="text" class="form-control onpress_enter_rbnsb" id="rbn" placeholder="{{ __('home.bankName') }}" name="rbn" value="{{ (isset($BookingCancelDetail->bank_name) && $BookingCancelDetail->bank_name !='')?$BookingCancelDetail->bank_name:''; }}">
                        <label for="rbn"> {{ __('home.bankName') }}<span class="required-star ">*</span></label>
                        <p class="error-inp" id="rbn_err_msg"></p>
                    </div>
                    <div class="form-floating" id="rachname_validate">
                        <input type="text" class="form-control onpress_enter_rbnsb" id="rachname" name="rachname" placeholder="{{ __('home.accountHolderName') }}" value="{{ (isset($BookingCancelDetail->account_holder_name) && $BookingCancelDetail->account_holder_name !='')?$BookingCancelDetail->account_holder_name:''; }}" >
                        <label for="rachname"> {{ __('home.accountHolderName') }}<span class="required-star ">*</span></label>
                        <p class="error-inp" id="rachname_err_msg"></p>
                    </div>
                    <div class="form-floating" id="rac_validate">
                        <input type="text" class="form-control onpress_enter_rbnsb only_integer" id="rac" placeholder="{{ __('home.accountNumber') }}" name="rac" value="{{ (isset($BookingCancelDetail->account_number) && $BookingCancelDetail->account_number !='')?$BookingCancelDetail->account_number:''; }}" >
                        <label for="rac">{{ __('home.accountNumber') }}<span class="required-star ">*</span></label>
                        <p class="error-inp" id="rac_err_msg"></p>
                    </div>
                    <input type="hidden" name="bs" value="{{ $booking->slug }}">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                    <div class="form-floating ">
                        <button type="button" class="btn w-100 submit-refund-bankinfo">{{ __('home.Submit') }}</button>
                    </div>
                </form>
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
            // cancel booking   
            $(document).on('click','.cancelBookingY',function(){
            var b = "{{ $booking->slug }}"; 
            var bstauts = "{{ $booking->booking_status }}"; 
            var cancellation_reason ='';
            if(bstauts =='confirmed' && $('#cancelReason').val() !=undefined && $('#cancelReason').val() !='')
            {
                cancellation_reason = $('body').find('#cancelReason').val();            
            }    
            // alert(bstauts+" "+cancellation_reason);
            $(".cancelBookingY").prop("disabled",true); 
            loading();
                $.post("{{ route('booking-cancel') }}",  {'_token':"{{ csrf_token() }}",'b':b,'cr':cancellation_reason}, function( data ) {
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
            // ________________________
        $(document).on('keyup','.onpress_enter_rbnsb',function(e){
            if(e.keyCode == 13)
            submit_refund_bankinfo();
        });
        $(document).on('keyup','#rac',function(){
            // $("#hm_server_err_msg").text('');
            if(field_required('rac','rac',"Account number is required"))
            if(!checkMaxLength($('#rac').val(),20 )) 
                setErrorAndErrorBox('rac','Account number be less than 20 letters.'); 
            else
                unsetErrorAndErrorBox('rac');
        });
        $(document).on('keyup','#rbn',function(){
            // $("#hm_server_err_msg").text('');
            if(field_required('rbn','rbn',"Bank Name is required"))
            if(!checkMaxLength($('#rbn').val(),200 )) 
                setErrorAndErrorBox('rbn','Bank Name be less than 200 letters.'); 
            else
                unsetErrorAndErrorBox('rbn');
        });
        $(document).on('keyup','#rachname',function(){
            // $("#hm_server_err_msg").text('');
            if(field_required('rachname','rachname',"Bank Name is required"))
            if(!checkMaxLength($('#rachname').val(),200 )) 
                setErrorAndErrorBox('rachname','Bank Name be less than 200 letters.'); 
            else
                unsetErrorAndErrorBox('rachname');
        });    
        $(document).on('click','.submit-refund-bankinfo',function(){
            // $('#hm_hm_server_err_msg').text('');
            // alert('dfsf');
            $('#savetype').val($(this).attr('data-btntype'));
            submit_refund_bankinfo();
        });
        function submit_refund_bankinfo()
        { 
            var token=true; 
            if(!field_required('rac','rac',"Account number is required"))
                token = false;
            else if(!checkMaxLength($('#rac').val(),20 )) 
            {
                setErrorAndErrorBox('rac','Account number be less than 20 letters.');
                token = false;
            }
            if(!field_required('rbn','rbn',"Bank Name is required"))
                token = false;
            else if(!checkMaxLength($('#rbn').val(),200 )) 
            {
                setErrorAndErrorBox('rbn','Bank Name be less than 200 letters.');
                token = false;
            }
            if(!field_required('rachname','rachname',"Account holder name is required"))
                token = false;
            else if(!checkMaxLength($('#rachname').val(),200 )) 
            {
                setErrorAndErrorBox('rachname','Account holder name be less than 200 letters.');
                token = false;
            }        
            if(token)
            {
                $(".submit-refund-bankinfo").prop("disabled",true); 
                loading();
                $.post("{{ route('save-refund-bankinfo') }}",  $( "#refundBankDetails" ).serialize(), function( data ) {
                            // console.log(data);
                            if(data.status==1){
                                // window.location.href = data.nextpageurl;
                                location.reload(); 
                                 unloading();
                                /*    
                                $("#refundBankDetails")[0].reset();
                                $(".cardDetailDialog").modal('hide'); 
                                $("#commonSuccessMsg").text(data.message);
                                $("#commonSuccessBox").css('display','block');
                                $(".submit-refund-bankinfo").prop("disabled",false); 
                                unloading();
                                setTimeout(function() {
                                    $("#commonSuccessBox").hide();
                                }, 3000);*/ 
                            } 
                            else
                            {
                                $("#commonErrorMsg").text(data.message);
                                $("#commonErrorBox").css('display','block');
                                $(".submit-refund-bankinfo").prop("disabled",false); 
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
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection