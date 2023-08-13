@php 
  $check_in_date = new DateTime($request->checkin_dates);
  $check_out_date = new DateTime($request->checkout_dates);
//  $numberOfNights= $check_out_date->diff($check_in_date)->format("%a");
//   $numberOfNights = ($numberOfNights <=0)?1:$numberOfNights; 
@endphp
@if($check_in_date > $check_out_date)
   <script>window.location = "{{route('home')}}";</script>
@endif
@extends('frontend.layout.head')
@section('body-content')
@include('frontend.layout.header')
    <div class="main-wrapper">
        <img class="dotted-img-bd" src="{{ asset('/assets/images/') }}/structure/dotted-img.png" alt="">
        <section class="checkout-sec1">
            <div class="container">
                <nav aria-label="breadcrumb" class="breadcrumbNave">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home'); }}">{{ __('home.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('hotel-list'). getQueryParams(array_merge(Request::all())); }}">{{ __('home.Hoteles') }} {{ (isset($request->city) && $request->city !='')?'in '.$request->city:''; }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('hotel-detail',$hotel->slug). getQueryParams(array_merge(Request::all())); }}">{{ $hotel->hotel_name; }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('home.checkOut') }}</li>
                    </ol>
                </nav>
                <form action="javascript:void(0)" method="post" id="confirmBookingForm">
                <div class="row">
                    <div class="col-xl-8 col-ld-9 col-md-9 col-sm-12 col-12 checkoutLeftCol">
                        <div class="checkout-left-box">
                            <div class="checkoutHtlDtlBox">
                                <div class=" d-flex">
                                    <div class="checkoutHtimgBox">
                                        <img
                                            src="{{ asset('/hotel_images/'.$hotel->featured_img); }}"
                                            onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';"
                                            alt="" class="checkoutHtimg">
                                    </div>
                                    <div class="checkoutHtDesBox">
                                        <h5 class="h5 mb-0">{{ $hotel->hotel_name; }}</h5>
                                        <p class="p2 mb-0">{{ $hotel->street }}{{ ($hotel->city !='' && $hotel->street !='')?', ':''; }} {{ $hotel->city }}{{ ($hotel->city !='' && $hotel->subrub !='')?', ':''; }}{{ $hotel->subrub  }} {{ ($hotel->pincode !='')?' - ':''; }}{{ $hotel->pincode }}</p>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div class="hotel-check-in-out d-flex align-items-end ">
                                    <div class="checkin">
                                        <p class="p3 mb-1">{{ __('home.checkIn') }}</p>
                                        <div class="checkIOdtl d-flex align-items-center">
                                            <h3 class="blueDate mb-0">{{ date_format($check_in_date,"d"); }}</h3>
                                            <div>
                                                <p class="p3 mb-0">{{ date_format($check_in_date,"m-Y"); }}</p>
                                                <p class="p3 mb-0">{{ $hotel->check_in; }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nightsblock">
                                        <span class="chips chips-gray1 h-24">{{ $numberOfNights; }} {{ __('home.Nights') }}</span>
                                    </div>
                                    <div class="checkout">
                                        <p class="p3 mb-1">{{ __('home.checkOut') }}</p>
                                        <div class="checkIOdtl d-flex align-items-center">
                                            <h3 class="blueDate mb-0">{{ date_format($check_out_date,"d"); }}</h3>
                                            <div>
                                                <p class="p3 mb-0">{{ date_format($check_out_date,"m-Y"); }}</p>
                                                <p class="p3 mb-0"> {{ $hotel->check_out; }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="guest">
                                        <p class="p3 mb-1">{{ __('home.guests') }}</p>
                                        <div class="d-flex align-items-end">
                                            <h3 class="Gtsadlt-h3 mb-0">{{ $request->adult }}<span class="p3"> {{ __('home.adult') }} </span></h3>
                                            <h3 class="Gtsadlt-h3 mb-0">{{ $request->child }}<span class="p3"> {{ __('home.child') }}</span></h3>
                                            </script>
                                            @if($no_of_childs > 0)
                                            <img src="{{ asset('/assets/images/') }}/structure/info-blue.svg" alt="" class="infoIcon" style="margin-bottom: 2px;" data-bs-toggle="tooltip" data-bs-html="true" title="{{ $childInfo; }}">
                                            @endif                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="roombox d-flex align-items-center">
                                <div class="">
                                    <h6 class="mb-0">{{ $room->room_name }}</h6>
                                    <p class="p3 mb-0">{{ $request->adult }} {{ __('home.adult') }}, {{ $request->child }} {{ __('home.child') }}</p>
                                </div>
                                <a href="#" data-bs-toggle="modal" data-bs-target=".CancellationPolicyDialog" class="ViewCancellation-a p3 d-block ml-auto">{{ __('home.View') }} {{ __('home.cancellationPolicies') }}</a>
                            </div>
                            <form>
                                <div class="mt-5">
                                    <h5 class="h5 hd5">{{ __('home.GuestDetails') }}</h5>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-floating" id="full_name_validate">
                                                <input type="text" class="form-control" id="full_name" placeholder="{{ __('home.fullName') }}" value="{{ $customer_full_name; }}" name="full_name">
                                                <label for="full_name">{{ __('home.fullName') }}<span class="required-star">*</span></label>
                                                <p class="error-inp" id="full_name_err_msg"></p>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-floating" id="phone_validate">
                                                <input type="text" class="form-control onpress_enter phone_number_input rightClickDisabled" id="phone" placeholder="{{ __('home.phone') }}" value="{{ $customer_phone; }}" name="phone">
                                                <label for="phone">{{ __('home.phone') }}<span class="required-star">*</span></label>
                                                <p class="error-inp" id="phone_err_msg"></p>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-floating" id="email_validate">
                                                <input type="text" class="form-control" id="email" placeholder="{{ __('home.email') }}" value="{{ $customer_email; }}" name="email">
                                                <label for="email">{{ __('home.email') }}<span class="required-star">*</span></label>
                                                <p class="error-inp" id="email_err_msg"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(count($hotel->hasExtraServices) >0)
                                <div class="mt-4">
                                    <h5 class="h5 hd5">{{ __('home.extraServices') }}</h5>
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 d-flex flex-wrap checkboxTabCol">
                                            @foreach ($hotel->hasExtraServices as $es)
                                            @if($es->es_max_qty > 1)
                                            <div class="form-check checkboxTab">
                                                <input class="form-check-input select_es_chk" type="checkbox" value="{{ $es->id; }}" id="esCheckbox{{$es->id}}" name="extra_services[]" data-n="{{ $es->es_name; }}" data-p="{{ $es->es_price; }}">
                                                <label class="form-check-label" for="esCheckbox{{$es->id}}">
                                                    {{$es->es_name}}- ₩ {{$es->es_price}}/unit
                                                </label>
                                                <div class="quantity-box d-flex align-items-center ml-auto">
                                                    <span class="qty">Qty</span>
                                                    <span class="minusEs d-flex align-items-center justify-content-center" data="{{ $es->id; }}">-</span>
                                                    <input type="text" id="esqty_{{ $es->id; }}" value="1" name="es_qty[]" class="only_integer rightClickDisabled setmaxval setminval" data-maxval="{{ $es->es_max_qty }}" data-minval="1"  />
                                                    <span class="plusEs d-flex align-items-center justify-content-center" data="{{ $es->id; }}" >+</span>
                                                </div>
                                            </div>
                                            @else 
                                            <div class="form-check checkboxTab">
                                                <input class="form-check-input select_es_chk" type="checkbox" value="{{ $es->id; }}" id="esCheckbox{{$es->id}}" name="extra_services[]" data-n="{{ $es->es_name; }}" data-p="{{ $es->es_price; }}">
                                                <input type="hidden" id="esqty_{{ $es->id; }}" value="1" name="es_qty[]" class="only_integer rightClickDisabled setmaxval" data-maxval="{{ $es->es_max_qty }}"  />
                                                <label class="form-check-label" for="serCheckbox{{$es->id}}">
                                                {{$es->es_name}}- ₩ {{$es->es_price}}
                                                </label>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="mt-4">
                                    <h5 class="h5 hd5">{{ __('home.AnyOtherRequest') }}</h5>
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-floating" id="notes_validate">
                                                <textarea class="form-control" id="notes" placeholder="{{ __('home.notes') }}" value="{{ $customer_notes; }}" style="min-height: 106px;" name="notes">{{ $customer_notes; }}</textarea>
                                                <label for="notes">{{ __('home.notes') }}</label>
                                                <p class="mb-0 max-char-limit" id="notes_limit_msg">{{ __('home.max400characters') }}</p>
                                                <p class="error-inp" id="notes_err_msg"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> 
                    <div class="col-xl-4 col-ld-3 col-md-3 col-sm-12 col-12 checkoutRightCol">
                        <div class="checkout-right-box">
                            <div class="graybox-w price-statusbox-rgt">
                                <h6 class="h6">{{ __('home.priceBreakup') }}</h6>
                                 
                                <div class="d-flex PriceBreakupRw">
                                    <p class="p2 flex-fill PriceBreakupCl-lft">1 {{ __('home.room') }} x {{ $numberOfNights; }} {{ __('home.Night') }}
                                    @if($nightChargesInfo !='' )    
                                    <img src="{{ asset('/assets/images/') }}/structure/info-blue.svg" alt="" class="infoIcon" style="margin-bottom: 2px;" data-bs-toggle="tooltip" data-bs-html="true" title="{{ $nightChargesInfo; }}">
                                    @endif    
                                    </p>
                                    <p class="p2 flex-fill PriceBreakupCl-rgt">₩ <span id="rsCharges">{{ $roomStandardCharges; }}</span></p>
                                </div>
                                @php /* 
                                @if($no_of_week_days > 0)
                                <div class="d-flex PriceBreakupRw">
                                    <p class="p2 flex-fill PriceBreakupCl-lft">No. of week days x {{ $no_of_week_days; }} {{ __('home.Night') }}</p>
                                    <p class="p2 flex-fill PriceBreakupCl-rgt">₩ <span id="week_days_charges">{{ $standard_price_weekday*$no_of_week_days; }}</span></p>
                                </div>
                                @endif
                                @if($no_of_weekend_days > 0)
                                <div class="d-flex PriceBreakupRw">
                                    <p class="p2 flex-fill PriceBreakupCl-lft">No. of weekend days x {{ $no_of_weekend_days; }} {{ __('home.Night') }}</p>
                                    <p class="p2 flex-fill PriceBreakupCl-rgt">₩ <span id="weekend_days_charges">{{ $standard_price_weekend*$no_of_weekend_days; }}</span></p>
                                </div>
                                @endif
                                @if($no_of_peakseason_days > 0)
                                <div class="d-flex PriceBreakupRw">
                                    <p class="p2 flex-fill PriceBreakupCl-lft">No. of peak-season days x {{ $no_of_peakseason_days; }} {{ __('home.Night') }}</p>
                                    <p class="p2 flex-fill PriceBreakupCl-rgt">₩ <span id="peakseason_charges">{{ $standard_price_peakseason*$no_of_peakseason_days; }}</span></p>
                                </div>
                                @endif
                                */ @endphp
                                @if(isset($noOfExtraGuest) && $noOfExtraGuest >0)
                                <div class="d-flex PriceBreakupRw" id="pb_eg_row">
                                    <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.extraGuest') }} x {{ $noOfExtraGuest}}</p>
                                    <p class="p2 flex-fill PriceBreakupCl-rgt" >₩ <span id="egChares">{{ $ExtraGuestCharges; }}</span></p>
                                </div>
                                @endif 
                                <div class="{{ ($es_charges > 0 )?'d-flex':'d-none';  }} PriceBreakupRw" id="pb_es_row" >
                                    <p class="p2 flex-fill PriceBreakupCl-lft cursor-p" data-bs-toggle="modal" data-bs-target=".ExtraServicesDialog">{{ __('home.extraServices') }} <img src="{{ asset('/assets/images/') }}/structure/arrow-down.svg" alt=""></p>
                                    <p class="p2 flex-fill PriceBreakupCl-rgt" >₩ <span id="pb_es_total">{{ $es_charges }}</span></p>
                                </div>
                                @if(isset($lsd->lsd_discount_amount) && $lsd->lsd_discount_amount !='' && $lsd->lsd_discount_amount !=0)
                                <div class="d-flex PriceBreakupRw" id="pb_lsd_row">
                                    <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.longStayDiscount') }}<br>
                                    </p>
                                    <p class="p2 flex-fill PriceBreakupCl-rgt" style="color: #008952;" id="lsdAmount">- ₩ {{ $lsdAmount}}</p>
                                </div>
                                @endif
                                <div class=" PriceBreakupRw" id="couponAppliedBox" style="display:{{ ($request->session()->has('coupon_code_name'))?'flex':'none'; }} !important;">
                                    <p class="p2 flex-fill PriceBreakupCl-lft" id="pb_cpn_p">{{ __('home.couponCode') }}<br>
                                        <span class="dashed-chipt text-uppercase" id="pb_cpn">{{ $request->session()->get('coupon_code_name'); }}</span> <img src="{{ asset('/assets/images/') }}/structure/close.svg" alt="" class="cur
                                         closeIcon cursor-pointer" id="pb_cpn_remove">
                                    </p>
                                    <p class="p2 flex-fill PriceBreakupCl-rgt" style="color: #008952;">- ₩ <span id="ccdAmount">{{ $cpnAmount; }}</span></p>
                                </div>
                                <div class="d-flex PriceBreakupRw Total mb-0">
                                    <p class="p1 flex-fill PriceBreakupCl-lft">{{ __('home.TotalPrice') }}</p>
                                    <p class="p1 flex-fill PriceBreakupCl-rgt" >₩ <span id="pb_total">{{ $pbTotal; }}</span></p>
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" value="{{ $pbTotal }}" name="grand_total" id="grand_total">
                            <input type="hidden" value="{{ $es_charges }}" name="es_charges" id="es_charges">
                            <input type="hidden" value="{{ $cpnAmount }}" name="cpn_total" id="cpn_total">
                            <input type="hidden" value="{{ $lsdAmount }}" name="lsd_total" id="lsd_total">
                            <input type="hidden" value="{{ $ExtraGuestCharges }}" name="ExtraGuestCharges" id="ExtraGuestCharges">
                            <input type="hidden" value="{{ $noOfExtraGuest }}" name="noOfExtraGuest" id="noOfExtraGuest">
                            <input type="hidden" value="{{ $numberOfNights }}" name="numberOfNights" id="numberOfNights">
                            <input type="hidden" value="{{ $no_of_week_days; }}" name="no_of_week_days" id="no_of_week_days">
                            <input type="hidden" value="{{ $standard_price_weekday; }}" name="standard_price_weekday" id="standard_price_weekday">

                            <input type="hidden" value="{{ $no_of_weekend_days; }}" name="no_of_weekend_days" id="no_of_weekend_days">
                            <input type="hidden" value="{{ $standard_price_weekend; }}" name="standard_price_weekend" id="standard_price_weekend">

                            <input type="hidden" value="{{ $no_of_peakseason_days; }}" name="no_of_peakseason_days" id="no_of_peakseason_days">
                            <input type="hidden" value="{{ $standard_price_peakseason; }}" name="standard_price_peakseason" id="standard_price_peakseason">
                            <input type="hidden" value="{{ $roomStandardCharges }}" name="roomStandardCharges" id="roomStandardCharges">
                            <input type="hidden" value="{{ date_format($check_in_date,'Y-m-d'); }}" name="check_in_date" id="check_in_date">
                            <input type="hidden" value="{{ date_format($check_out_date,'Y-m-d'); }}" name="check_out_date" id="check_out_date">
                            <input type="hidden" value="{{ $request->adult }}" name="adults" id="adults">
                            <input type="hidden" value="{{ $request->child }}" name="childs" id="childs">
                            <input type="hidden" value="{{ $request->childs_plus_nyear }}" name="childs_plus_nyear" id="childs_plus_nyear">
                            <input type="hidden" value="{{ $request->childs_below_nyear }}" name="childs_below_nyear" id="childs_below_nyear">
                            <input type="hidden" value="{{ $request->cages }}" name="cages" id="cages">
                            <input type="hidden" value="{{ $request->h }}" name="h" id="h">
                            <input type="hidden" value="{{ $request->r }}" name="r" id="r">
                            <div class="graybox-w price-statusbox-rgt couponCodeBox" id="couponApplyBox" style="display:{{ (!$request->session()->has('coupon_code_name'))?'block':'none'; }} !important;">
                                <h6 class="h6">{{ __('home.couponCode') }}</h6>
                                <div class="d-flex align-items-center">
                                    <input type="text" placeholder="Enter coupon code" class="couponCodeInp" name="coupon_code" id="coupon_code">
                                    <button" class="btn h-36" id="applyCouponCode">{{ __('home.apply') }}</button>
                                </div>
                            </div>
                            <button type="button" class="btn w-100 checkoutBtn form_submit">{{ __('home.confirm') }} {{ __('home.booking') }}</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </section>
    </div>
    <div class="modal fade ExtraServicesDialog" tabindex="-1" aria-labelledby="ExtraServicesDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h4 class="h4 mb-4">{{ __('home.extraServices') }}</h4>
                    </div>
                    <div class="table-responsive table-view">
                        <table class="table align-middle">
                            <thead id="es_thead">
                                <tr>
                                    <th>{{ __('home.subtotal') }}</th>
                                    <th>₩ <span id="es_subtotal">{{ $es_charges }}</span></th>
                                </tr>
                            </thead>
                            <tbody id="selected_es">
                                @php
                                    $esCounter = 0;
                                    if($request->session()->get('es_qty') !='' && $request->session()->get('es_qty') !='null')
                                    $qtyArr = $request->session()->get('es_qty');
                                @endphp
                            @foreach($BookingExtraService as $key => $val)
                                @php
                                    $name = $val->es_name;
                                    $price = $val->es_price;
                                    $qty = $qtyArr[$esCounter]; // $val->es_max_qty;
                                    $es_total = $price * $qty;
                                @endphp
                                <tr id="seleted_es_{{ $val->id }}"><td><p class="p1 mb-1">{{ $name }} x {{ $qty }}</p><p class="p3 mb-0">₩ {{ $price }}</p></td><td class="verticle-top"><p class="p1 mb-0">₩ {{ $es_total }}</p></td></tr>
                                @php $esCounter++; @endphp
                            @endforeach    
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cancellation Policy -->
    <div class="modal fade CancellationPolicyDialog" tabindex="-1" aria-labelledby="CancellationPolicyLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h4 class="h4 mb-4">{{ __('home.cancellationPolicies') }}</h4>
                    </div>
                    <div class="cancellationPolicycnt-Row d-flex align-items-center">
                        <div class="circleBefor"></div>
                        <div class="cancellationPolicycnt d-flex align-items-center">
                            <span class="bgpink"></span>
                            <div class="cancellationPolicyCol1">
                                <p class="p2 mb-0">{{ __('home.theDay') }} </p>
                            </div>
                            <div class="cancellationPolicyCol2 d-flex align-items-center">
                                <p class="p2 mb-0">{{ ($hotel->same_day_refund == "100")?'Fully ':''; }}{{ ($hotel->same_day_refund == "0")?'No Refund':'Refundable'; }}</p>
                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->same_day_refund}}%</span> {{ __('home.Refund') }} )</p>
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
                                <p class="p2 mb-0">{{ ($hotel->b4_1day_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_1day_refund == "0")?'No Refund':'Refundable'; }}</p>
                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_1day_refund}}%</span> {{ __('home.Refund') }})</p>
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
                                <p class="p2 mb-0">{{ ($hotel->b4_2days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_2days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                <p class="p3 mb-0">({{ __('home.youWillGet') }}  <span class="cpPercent">{{ $hotel->b4_2days_refund}}%</span> {{ __('home.Refund') }})</p>
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
                                <p class="p2 mb-0">{{ ($hotel->b4_3days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_3days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_3days_refund}}%</span> {{ __('home.Refund') }})</p>
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
                                <p class="p2 mb-0">{{ ($hotel->b4_4days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_4days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_4days_refund}}%</span> {{ __('home.Refund') }})</p>
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
                                <p class="p2 mb-0">{{ ($hotel->b4_5days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_5days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_5days_refund}}%</span> {{ __('home.Refund') }})</p>
                            </div>
                        </div>
                    </div>
                    <div class="cancellationPolicycnt-Row d-flex align-items-center">
                        <div class="circleBefor"></div>
                        <div class="cancellationPolicycnt d-flex align-items-center">
                            <span class="bgpink"></span>
                            <div class="cancellationPolicyCol1">
                                <p class="p2 mb-0">{{ __('home.before') }} 6 {{ __('home.day') }} </p>
                            </div>
                            <div class="cancellationPolicyCol2 d-flex align-items-center">
                                <p class="p2 mb-0">{{ ($hotel->b4_6days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_6days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_6days_refund}}%</span> {{ __('home.Refund') }})</p>
                            </div>
                        </div>
                    </div>
                    <div class="cancellationPolicycnt-Row d-flex align-items-center">
                        <div class="circleBefor"></div>
                        <div class="cancellationPolicycnt d-flex align-items-center">
                            <span class="bgpink"></span>
                            <div class="cancellationPolicyCol1">
                                <p class="p2 mb-0">{{ __('home.before') }} 7 {{ __('home.day') }} </p>
                               @php /*  <p class="p2 mb-0">{{ ($hotel->b4_7days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_7days_refund == "0")?'No Refund':'Refundable'; }}</p> */ @endphp
                            </div>
                            <div class="cancellationPolicyCol2 d-flex align-items-center">
                                <p class="p2 mb-0">{{ __('home.refundable') }}</p>
                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_7days_refund}}%</span> {{ __('home.Refund') }})</p>
                            </div>
                        </div>
                    </div>
                    <div class="cancellationPolicycnt-Row d-flex align-items-center">
                        <div class="circleBefor"></div>
                        <div class="cancellationPolicycnt d-flex align-items-center">
                            <span class="bgpink"></span>
                            <div class="cancellationPolicyCol1">
                            <p class="p2 mb-0">{{ __('home.before') }} 8 {{ __('home.day') }} </p>
                            @php /* <p class="p2 mb-0">{{ ($hotel->b4_8days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_8days_refund == "0")?'No Refund':'Refundable'; }}</p> */ @endphp
                            </div>
                            <div class="cancellationPolicyCol2 d-flex align-items-center">
                                <p class="p2 mb-0">{{ __('home.refundable') }}</p>
                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_8days_refund}}%</span> {{ __('home.Refund') }})</p>
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
                                <p class="p2 mb-0">{{ ($hotel->b4_9days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_9days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_9days_refund}}%</span> {{ __('home.Refund') }})</p>
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
                                <p class="p2 mb-0">{{ ($hotel->b4_10days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_10days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                <p class="p3 mb-0">({{ __('home.youWillGet') }}  <span class="cpPercent">{{ $hotel->b4_10days_refund}}%</span> {{ __('home.Refund') }})</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- newsletter -->
@include('frontend.layout.newsletter')
<!-- footer -->
@include('frontend.layout.footer')
<!-- common models -->
@include('common_modal')
@include('frontend.layout.footer_script')
@endsection    
<!-- JS section  -->   
@section('js-script')
<script>
    $(document).ready(function(){
        var es_subtotal = 0;
        var es_charges = "{{ $es_charges }}";
        var pb_total = "{{ $pbTotal; }}";
        var numberOfNights = 1; // "{{ $numberOfNights; }}";
        $(document).on('click','.minusEs',function(){
            var id = $(this).attr('data');
            if($("#esCheckbox"+id).prop("checked") == true)
            {
                var $input = $(this).parent().find('input');
                var count = parseInt($input.val()) - 1;
                minusEServiceCalculation("#esCheckbox"+id);
                count = count < 1 ? 1 : count;
                $input.val(count);
                $input.change();
            }
            return false;
        });
        $(document).on('click','.plusEs',function(){
            var id = $(this).attr('data');
            if($("#esCheckbox"+id).prop("checked") == true)
            {
                var $input = $(this).parent().find('input');
                var maxVal = $input.attr('data-maxval');
                var newVal = parseInt($input.val()) + 1;
                if(newVal > maxVal ) 
                    $input.val(parseInt(maxVal));
                else
                {
                    plusEServiceCalculation("#esCheckbox"+id);
                    $input.val(parseInt(newVal));
                }  
                $input.change(); 
            }
            return false;
        });
        //  check/uncheck extra service  
        $(document).on('click','.select_es_chk',function(){
            extraServiceCalculation($(this));
        });
        function minusEServiceCalculation(id="")
        {
            val = $(id).val(); 
            name = $(id).attr('data-n'); 
            price = parseFloat($(id).attr('data-p')); 
            qty = $("#esqty_"+val).val(); 
            if(qty > 1)
            {
                es_total = (price*qty*numberOfNights);// .toFixed(2);
                // pb_total = parseFloat(pb_total);
                // $("#esqty_"+val).prop("disabled",true);
                // $("#esqtym_"+val).removeClass("minus");
                // $("#esqtyp_"+val).removeClass("plusEs");
                es_subtotal = es_subtotal - parseFloat(es_total);
                pb_total= pb_total - parseFloat(es_total);
                $('#pb_es_total').html(es_subtotal); // es_subtotal.toFixed(2)
                $('#pb_total').html(pb_total); // pb_total.toFixed(2)
                $('#grand_total').val(pb_total); // pb_total.toFixed(2)
                $('#es_charges').val(es_subtotal); // es_subtotal.toFixed(2)
                $("#seleted_es_"+val).remove();
                qty--; 
                es_total = (price*qty*numberOfNights);// .toFixed(2);
                es_subtotal = es_subtotal+ parseFloat(es_total);
                pb_total = pb_total + parseFloat(es_total);
                //  aert(pb_total);
                $('#pb_total').html(pb_total); //.toFixed(2)
                $('#grand_total').val(pb_total); // .toFixed(2)
                $('#es_subtotal').html(es_subtotal); // .toFixed(2)
                $('#pb_es_total').html(es_subtotal); // .toFixed(2)
                $('#es_charges').val(es_subtotal); // .toFixed(2)
                $("#selected_es").prepend('<tr id="seleted_es_'+val+'"><td><p class="p1 mb-1">'+name+' x '+qty+'</p><p class="p3 mb-0">₩ '+price+'</p></td><td class="verticle-top"><p class="p1 mb-0">₩ '+es_total+'</p></td></tr>');    
            }
        }
        function plusEServiceCalculation(id="")
        {
            val = $(id).val(); 
            name = $(id).attr('data-n'); 
            price = parseFloat($(id).attr('data-p')); 
            qty = $("#esqty_"+val).val(); 
            es_total = (price*qty*numberOfNights);// .toFixed(2);
            // pb_total = parseFloat(pb_total);
            // $("#esqty_"+val).prop("disabled",true);
            // $("#esqtym_"+val).removeClass("minus");
            // $("#esqtyp_"+val).removeClass("plusEs");
            es_subtotal = es_subtotal - parseFloat(es_total);
            pb_total= pb_total - parseFloat(es_total);
            $('#pb_es_total').html(es_subtotal); // .toFixed(2)
            $('#pb_total').html(pb_total); // .toFixed(2)
            $('#grand_total').val(pb_total); // .toFixed(2)
            $('#es_charges').val(es_subtotal); // .toFixed(2)
            $("#seleted_es_"+val).remove();
            qty++; 
            es_total = (price*qty*numberOfNights);// .toFixed(2);
            es_subtotal = es_subtotal+ parseFloat(es_total);
            pb_total = pb_total + parseFloat(es_total);
            //  aert(pb_total);
            $('#pb_total').html(pb_total); // .toFixed(2)
            $('#grand_total').val(pb_total); // .toFixed(2)
            $('#es_subtotal').html(es_subtotal); // .toFixed(2)
            $('#pb_es_total').html(es_subtotal); // .toFixed(2)
            $('#es_charges').val(es_subtotal); // .toFixed(2)
            $("#selected_es").prepend('<tr id="seleted_es_'+val+'"><td><p class="p1 mb-1">'+name+' x '+qty+'</p><p class="p3 mb-0">₩ '+price+'</p></td><td class="verticle-top"><p class="p1 mb-0">₩ '+es_total+'</p></td></tr>');
        }
        function extraServiceCalculation(id="")
        {
            val = $(id).val(); 
            name = $(id).attr('data-n'); 
            price = parseFloat($(id).attr('data-p')); 
            qty = $("#esqty_"+val).val(); 
            es_total = (price*qty*numberOfNights);// .toFixed(2);
            pb_total = parseFloat(pb_total);
            if($(id).prop("checked") == true)
            {
                $("#esqty_"+val).prop("disabled",false);
                // $("#esqtym_"+val).addClass("minus");
                // $("#esqtyp_"+val).addClass("plusEs");
                es_subtotal = es_subtotal+ parseFloat(es_total);
                pb_total = pb_total + parseFloat(es_total);
               //  aert(pb_total);
                $('#pb_total').html(pb_total); // .toFixed(2)
                $('#grand_total').val(pb_total); // .toFixed(2)
                $('#es_subtotal').html(es_subtotal); // .toFixed(2)
                $('#pb_es_total').html(es_subtotal); // .toFixed(2)
                $('#es_charges').val(es_subtotal); // .toFixed(2)
                $("#selected_es").prepend('<tr id="seleted_es_'+val+'"><td><p class="p1 mb-1">'+name+' x '+qty+'</p><p class="p3 mb-0">₩ '+price+'</p></td><td class="verticle-top"><p class="p1 mb-0">₩ '+es_total+'</p></td></tr>');
                // $('#pb_es_row').show();
                $("#pb_es_row").removeClass("d-none");
                $("#pb_es_row").addClass("d-flex");
            }     // console.log(val);
            else    
            {  
                $("#esqty_"+val).prop("disabled",true);
                // $("#esqtym_"+val).removeClass("minus");
                // $("#esqtyp_"+val).removeClass("plusEs");
                es_subtotal = es_subtotal - parseFloat(es_total);
                pb_total= pb_total - parseFloat(es_total);
                $('#pb_es_total').html(es_subtotal); // .toFixed(2)
                $('#es_subtotal').html(es_subtotal); // .toFixed(2)
                $('#pb_total').html(pb_total); // .toFixed(2)
                $('#grand_total').val(pb_total); // .toFixed(2)
                $('#es_charges').val(es_subtotal); // .toFixed(2)
                $("#seleted_es_"+val).remove(); $('#esCheckbox'+val).prop('checked', false); 
               //  $('#pb_es_row').hide();
               if(es_subtotal == 0)
               {
                    $("#pb_es_row").removeClass("d-flex");
                    $("#pb_es_row").addClass("d-none");
               }
            }
        }
        $(document).on('keyup','.onpress_enter_login',function(e){
                // console.log(e.keyCode);
                if(e.keyCode == 13)
                submit();
        });
        $(document).on('keyup','#full_name',function(){
            if(field_required('full_name','full_name',"Full name is required"))
            if(!checkMaxLength($('#full_name').val(),200 )) 
                setErrorAndErrorBox('full_name','Full name should be less than 200 letters.'); 
            else
                unsetErrorAndErrorBox('full_name');
        });
        $(document).on('keyup','#notes',function(){
            if(!checkMaxLength($('#notes').val(),400 )){
                $("#notes_limit_msg").text('max 400 characters');
                setErrorAndErrorBox('notes','Notes should be less than 400 letters.');
            } 
            else{
                let noteslen = $('#notes').val().length; 
				$("#notes_limit_msg").text(noteslen+'/400');
                unsetErrorAndErrorBox('notes');
            }               
        });
        $(document).on('keyup','#email',function(){
            if(field_required('email','email',"Email is required"))
                if(!isEmail($('#email').val())) 
                    setErrorAndErrorBox('email','Please enter a valid email.'); 
                else
                {
                    unsetErrorAndErrorBox('email'); 
                }
        });
        $(document).on('click','.form_submit',function(){
            $('#savetype').val($(this).attr('data-btntype')); 
            submit();
        });
        $('#phone').mask('000-0000-0000');
        $(document).on('keyup','#phone',function(){
            if(field_required('phone','phone',"Phone number is required"))
                if(!checkExactLength($("#phone").val(),13))
                        setErrorAndErrorBox('phone','Please enter a valid phone number.'); 
                    else
                        unsetErrorAndErrorBox('phone'); 
        });
        function submit()
        { 
            var token=true; 
            if(!field_required('full_name','full_name',"Full name is required"))
                token = false;
            else if(!checkMaxLength($('#full_name').val(),200 )) 
            {
                setErrorAndErrorBox('full_name','Full name should be less than 200 letters.');
                token = false;
            }
            if(!field_required('email','email',"Email is required"))
                token = false;
            else if(!isEmail($('#email').val())) 
            {   
                setErrorAndErrorBox('email','Please enter a valid email.');
                token = false;
            }
            if(!field_required('phone','phone',"Phone number is required"))
                token = false;
            else if(!checkExactLength($("#phone").val(),13))
            {   
                setErrorAndErrorBox('phone','Please enter a valid phone number.');
                token =false;  
            }
            else
                unsetErrorAndErrorBox('phone');
            if(!checkMaxLength($('#notes').val(),400 )) 
                setErrorAndErrorBox('notes','Notes should be less than 400 letters.'); 
            else
                unsetErrorAndErrorBox('notes');    
            if(token)
            {
                let formdata = $( "#confirmBookingForm" ).serialize();
                $(".form_submit").prop("disabled",true); 
                loading();
                // unloading();
                // window.location.href = "{{ route('room-payment') }}";
                $.post("{{ route('confirm-booking') }}",  formdata, function( data ) {
                    // console.log(data);
                    // unloading();
                    if(data.status==1){
                        window.location.href = data.nextpageurl; 
                        unloading();
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
                });         
            }
        }
        $(document).on('keyup','#coupon_code',function(e){
            if(e.keyCode == 13)
               apply_coupon();   
        });
        $(document).on('click','#applyCouponCode',function(){
            // alert('d');
            apply_coupon();
        });
        function apply_coupon()
        {
            var coupon_code = $('#coupon_code').val();
            coupon_code = coupon_code.trim();
            var roomStandardCharges = $('#roomStandardCharges').val();
            var ExtraGuestCharges = $('#ExtraGuestCharges').val();            
            var lsdAmount = $('#lsd_total').val();            
            var grand_total = ( parseFloat(roomStandardCharges) + parseFloat(ExtraGuestCharges) )  - parseFloat(lsdAmount);            
            if(coupon_code !='')
            {
                $("#applyCouponCode").prop("disabled",true); 
                loading();
                $.post("{{ route('apply-coupon') }}",  {'coupon_code':coupon_code,'h':"{{ $hotel->hotel_id }}",'_token':"{{ csrf_token() }}",'roomStandardCharges':roomStandardCharges,'ExtraGuestCharges':ExtraGuestCharges,'grand_total':grand_total}, function( data ) {
                    if(data.status==1)
                    {
                        // $("#esItemBoxdb_"+i).remove();
                        $('#couponApplyBox').hide();
                        $('#pb_cpn').text(data.coupon_code);
                        $('#ccdAmount').text(data.cpnAmount);
                        $('#cpn_total').val(data.cpnAmount);
                        $('#pb_total').text(data.grand_total);
                        $('#grand_total').val(data.grand_total);
                        $('#coupon_code').val('');
                        $('#couponAppliedBox').show(); 
                        $("#commonSuccessMsg").text(data.message);
                        $("#commonSuccessBox").css('display','block');
                        setTimeout(function() {
                            $("#commonSuccessBox").hide();
                        }, 1500);
                        unloading();
                    }
                    else
                    {
                        unloading();
                        $("#commonErrorMsg").text(data.message);
                        $("#commonErrorBox").css('display','block');
                        $("#applyCouponCode").prop("disabled",false); 
                        setTimeout(function() {
                            $("#commonErrorBox").hide();
                        }, 1500);
                    }
                });
            }
            else
            {
                $("#commonErrorMsg").text('Coupon code is required');
                $("#commonErrorBox").css('display','block');
                setTimeout(function() {
                    $("#commonErrorBox").hide();
                }, 1500);
            }
        }
        $(document).on('click','#pb_cpn_remove',function(){ 
                $("#pb_cpn_remove").prop("disabled",true); 
                loading();
                var roomStandardCharges = $('#roomStandardCharges').val();
                var ExtraGuestCharges = $('#ExtraGuestCharges').val();            
                var lsdAmount = $('#lsd_total').val();            
                var grand_total = ( parseFloat(roomStandardCharges) + parseFloat(ExtraGuestCharges) )  - parseFloat(lsdAmount);
                $.post("{{ route('remove-coupon') }}",  {'_token':"{{ csrf_token() }}",'roomStandardCharges':roomStandardCharges,'ExtraGuestCharges':ExtraGuestCharges,'grand_total':grand_total}, function( data ) {
                    if(data.status==1)
                    {
                        // $("#esItemBoxdb_"+i).remove();
                        $('#couponAppliedBox').hide();
                        $('#couponApplyBox').show();
                        $('#pb_cpn').text('');
                        $('#ccdAmount').text(data.cpnAmount);
                        $('#cpn_total').val(data.cpnAmount);
                        $('#pb_total').text(data.grand_total);
                        $('#grand_total').val(data.grand_total);
                        $('#coupon_code').val('');   
                        $("#commonSuccessMsg").text(data.message);
                        $("#commonSuccessBox").css('display','block');
                        setTimeout(function() {
                            $("#commonSuccessBox").hide();
                        }, 1500);
                        unloading();
                    }
                    else
                    {
                        unloading();
                        $("#commonErrorMsg").text(data.message);
                        $("#commonErrorBox").css('display','block');
                        $("#applyCouponCode").prop("disabled",false); 
                        setTimeout(function() {
                            $("#commonErrorBox").hide();
                        }, 1500);
                    }
                });
        });
    });  
</script>
<script>
    $(document).ready(function() {
        function disableBack() { window.history.forward() }
        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });
</script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection