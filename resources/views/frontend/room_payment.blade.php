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
                        <li class="breadcrumb-item"><a href="{{ route('hotel-list').'?h='.$hotel->slug.'&r='.$room_slug.'&checkout_dates='.$check_out_date.'&checkin_dates='.$check_in_date.'&adult='.$adult.'&child='.$child.'&childs_below_nyear='.$childs_below_nyear.'&childs_plus_nyear='.$childs_plus_nyear; }}">Hotels {{ (isset($request->city) && $request->city !='')?'in '.$request->city:''; }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('hotel-detail',$hotel->slug).'?h='.$hotel->slug.'&r='.$room_slug.'&checkout_dates='.$check_out_date.'&checkin_dates='.$check_in_date.'&adult='.$adult.'&child='.$child.'&childs_below_nyear='.$childs_below_nyear.'&childs_plus_nyear='.$childs_plus_nyear; }}">{{ $hotel->hotel_name; }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('room-checkout').'?h='.$hotel->slug.'&r='.$room_slug.'&checkout_dates='.$check_out_date.'&checkin_dates='.$check_in_date.'&adult='.$adult.'&child='.$child.'&childs_below_nyear='.$childs_below_nyear.'&childs_plus_nyear='.$childs_plus_nyear; }}">{{ __('home.checkOut') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('home.payment') }}</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-xl-8 col-ld-9 col-md-9 col-sm-12 col-12 checkoutLeftCol payment">
                        <div class="checkout-left-box">
                            <div class="checkoutHtlDtlBox">
                                <div class="d-flex">
                                    <div class="checkoutHtimgBox">
                                        <img
                                            src="{{ asset('/hotel_images/'.$hotel->featured_img); }}" alt=""
                                            onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';"
                                            class="checkoutHtimg">
                                    </div>
                                    <div class="checkoutHtDesBox">
                                        <h5 class="h5 mb-0">{{ $hotel->hotel_name; }}</h5>
                                        <p class="p2 mb-0">{{ $check_in_date; }} - {{ $check_out_date; }} <span class="dotgray"></span> {{ $adult; }} {{ __('home.adult') }}, {{ $child; }} {{ __('home.child') }}</p>
                                    </div>
                                </div>
                            </div>
                            <form>
                                <div class="paymentOptionBox mt-5">
                                    <h5 class="h5 hd5">{{ __('home.paymentOptions') }}</h5>
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 paymenrRewardsCol">
                                            <div class="form-check mb-0">
                                                <input class="form-check-input" name="available_points" type="checkbox" value="{{ $myPoints }}" id="available_points" {{ ($myPoints < $min_required_points_for_redeem_points->value)?'disabled':''; }} >
                                                <label class="form-check-label" for="available_points">
                                                {{ __('home.rewards') }}
                                                </label>
                                                <div class="d-flex">
                                                    <p class="p2 mb-0">{{ __('home.availableRewards') }}: <span class="rewPriceblue">{{ $myPoints }} {{ __('home.points') }}</span> <span class="vertLine">|</span> <span class="rewPriceblack">₩ {{ $myPoints }} </span></p>
                                                    <div class="info-parent ms-2" style="margin-top: -2px;">
                                                        <img src="{{asset('/assets/images/')}}/structure/info-blue.svg" alt="" class="infoIcon" style="margin-bottom: 2px;"> 
                                                        <div class='info-box-new discounttooltip'> 
                                                            <p class='tltp-p'>  
                                                                <span class='normalfont' style="white-space: nowrap;margin: ;">  {{ __('home.Pointsconversionrate') }}  
                                                                    <small class='d-bloc ms-3 mediumfont'>₩ {{ number_format(round(($points_conversion_rate->value/100),2),2); }}</small>
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="rewardAlert">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('/assets/images/') }}/structure/info-orange.svg" class="info-orange"> <p class="p3 mb-0">>{{ $min_required_points_for_redeem_points->value }} {{ __('home.thenonlyrewardpointcanbesedforbookingpayment') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="divider mt-4 mb-4"></div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 directBankTransferCol">
                                            <div class="form-check radioCircl mb-0">
                                                <input class="form-check-input paymenttypeCs" type="radio" name="paymentTypeRadio" checked value="direct_bank_transfer" id="direct_bank_transfer_radio">
                                                <label class="form-check-label" for="direct_bank_transfer_radio">
                                                {{ __('home.directBankTransfer') }}
                                                </label>
                                            </div>
                                            <div class="directBankTransferBox mt-1" id="directBankTransferBox">
                                                <p class="p2 mb-4">{{ __('home.invoiceWillBeSendOnYourEmail') }}</p>
                                                <button class="btn" type="button" id="direct_bank_transfer_submit">{{ __('home.PayNow') }}</span> (₩ <span id="pb_total3">{{ siteNumberFormat($pbTotal); }}</span>)</button>
                                            </div>
                                            <div class="divider mt-4 mb-4"></div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 creditCardCol">
                                            <div class="form-check radioCircl mb-0">
                                                <input class="form-check-input paymenttypeCs" type="radio" name="paymentTypeRadio" value="credit_card" id="credit_card_radio">
                                                <label class="form-check-label" for="credit_card_radio">
                                                {{ __('home.creditCard') }}
                                                </label>
                                            </div>
                                            <div class="creditCardBox mt-1" id="creditCardBox" style="display:none;">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <p class="p2 mb-4">{{ __('home.invoiceWillBeSendOnYourEmail') }}</p>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target=".cardDetailDialog" class="btn pamentpayNow"><span class="PayNowspan">{{ __('home.PayNow') }}</span> (₩ <span id="pb_total2">{{ siteNumberFormat($pbTotal); }}</span>)</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="divider mt-4 mb-4"></div> -->
                                        </div>
                                    </div>
                                    @php /* 
                                    <div class="paymentOptionFooter d-flex align-items-center">
                                        <img src=" {{ asset('/assets/images/') }}/structure/verified-user.svg " alt=" " class="verified-user"> <span class="p3">100% {{ __('home.securePaymentsPoweredbyHankook') }}</span>
                                        <div class="ml-auto paymentCard d-flex">
                                            <img src="{{ asset('/assets/images/') }}/structure/amex.svg " alt=" " class="paymentCardIcon ">
                                            <img src="{{ asset('/assets/images/') }}/structure/mastercard.svg " alt=" " class="paymentCardIcon ">
                                            <img src="{{ asset('/assets/images/') }}/structure/visa.svg " alt=" " class="paymentCardIcon ">
                                            <img src="{{ asset('/assets/images/') }}/structure/rupay.svg " alt=" " class="paymentCardIcon ">
                                        </div>
                                    </div>
                                    */
                                    @endphp
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-4 col-ld-3 col-md-3 col-sm-12 col-12 checkoutRightCol ">
                        <div class="checkout-right-box ">
                            <div class="graybox-w price-statusbox-rgt ">
                                <h6 class="h6 ">{{ __('home.priceBreakup') }}</h6>
                                <div class="d-flex PriceBreakupRw ">
                                    <p class="p2 flex-fill PriceBreakupCl-lft ">1 {{ __('home.room') }} x {{ $numberOfNights; }} {{ __('home.Night') }} 
                                    @if($nightChargesInfo !='' )    
                                    <img src="{{ asset('/assets/images/') }}/structure/info-blue.svg" alt="" class="infoIcon" style="margin-bottom: 2px;" data-bs-toggle="tooltip" data-bs-html="true" title="{{ $nightChargesInfo; }}">
                                    @endif    
                                    </p>
                                    <p class="p2 flex-fill PriceBreakupCl-rgt ">₩ <span id="rsCharges">{{ siteNumberFormat($roomStandardCharges); }}</span></p>
                                </div>
                                @if(isset($noOfExtraGuest) && $noOfExtraGuest >0)
                                <div class="d-flex PriceBreakupRw ">
                                    <p class="p2 flex-fill PriceBreakupCl-lft ">{{ __('home.extraGuest') }} x {{ $noOfExtraGuest }} </p>
                                    <p class="p2 flex-fill PriceBreakupCl-rgt ">₩ <span id="egChares">{{ siteNumberFormat($ExtraGuestCharges); }}</span></p>
                                </div>
                                @endif
                                @if($es_charges >0)
                                <div class="d-flex PriceBreakupRw ">
                                    <p class="p2 flex-fill PriceBreakupCl-lft cursor-p" data-bs-toggle="modal" data-bs-target=".extraServicesDialog ">{{ __('home.extraService') }} <img src="{{ asset('/assets/images/') }}/structure/arrow-down.svg " alt=" "></p>
                                    <p class="p2 flex-fill PriceBreakupCl-rgt ">₩ <span id="pb_es_total">{{ siteNumberFormat($es_charges) }}</span</p>
                                </div>
                                @endif
                                @if(isset($lsdAmount) && $lsdAmount >0)
                                <div class="d-flex PriceBreakupRw">
                                    <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.longStayDiscount') }} </p>
                                    <p class="p2 flex-fill PriceBreakupCl-rgt" style="color: #008952;">- ₩ {{ siteNumberFormat($lsdAmount) }}</p>
                                </div>
                                @endif
                                <div class=" PriceBreakupRw " style="display:{{ (isset($coupon_code_name))?'flex':'none'; }} !important;">
                                    <p class="p2 flex-fill PriceBreakupCl-lft ">{{ __('home.couponCode') }}<br>
                                        <span class="dashed-chipt text-uppercase ">{{ (isset($coupon_code_name))?$coupon_code_name:''; }}</span>
                                        <!-- <img src="{{ asset('/assets/images/') }}/structure/close.svg " alt=" " class="cur closeIcon "> -->
                                    </p>
                                    <p class="p2 flex-fill PriceBreakupCl-rgt " style="color: #008952; ">- ₩ <span id="ccdAmount">{{ number_format($cpnAmount,2); }}</span></p>
                                </div>
                                <div class="subtotalRow" style="display:none;" id="subTotalBox">
                                    <div class="d-flex PriceBreakupRw flex-wrap mb-0">
                                        <p class="p1 flex-fill PriceBreakupCl-lft">{{ __('home.subtotal') }}</p>
                                        <p class="p1 flex-fill PriceBreakupCl-rgt">₩ <span id="pb_sub_total">{{ siteNumberFormat($pbTotal); }}</span></p>
                                    </div>
                                    <div class="d-flex PriceBreakupRw flex-wrap mb-0">
                                        <p class="p2 flex-fill PriceBreakupCl-lft">{{ __('home.rewardsPoints') }} | <span id="no_of_used_points">0</span></p>
                                        <p class="p2 flex-fill PriceBreakupCl-rgt" style="color: #008952;">- ₩ <id><span id="amount_of_ponts">0</span></p>
                                    </div>
                                </div>
                                <div class="d-flex PriceBreakupRw Total mb-0 ">
                                    <p class="p1 flex-fill PriceBreakupCl-lft ">{{ __('home.TotalPrice') }}</p>
                                    <p class="p1 flex-fill PriceBreakupCl-rgt ">₩ <span id="pb_total">{{ siteNumberFormat($pbTotal); }}</span></p>
                                </div>
                            </div>
                            <div class="graybox-w rewardPointBox ">
                                @if($points_earn_on_booking->value_type == 'percentage')
                                <p class="p2 mb-0"><img src="{{ asset('/assets/images/') }}/structure/confetti.svg" alt="" class="confetti"> {{ __('home.yayyYouWillEarnRewardPoints') }} <span class="rpPriceblue" id="poinstEarnper">{{ round(($pbTotal/100)*$points_earn_on_booking->value); }}</span> {{ __('home.rewardsPoints') }}.</p>
                                @else
                                <p class="p2 mb-0"><img src="{{ asset('/assets/images/') }}/structure/confetti.svg" alt="" class="confetti"> {{ __('home.yayyYouWillEarnRewardPoints') }} <span class="rpPriceblue">{{ $points_earn_on_booking->value; }}</span> {{ __('home.rewardsPoints') }}.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade extraServicesDialog " tabindex="-1 " aria-labelledby="extraServicesDialogLabel " aria-hidden="flase ">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content ">
                <div class="modal-body ">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads ">
                        <h4 class="h4 mb-4 ">{{ __('home.extraService') }}</h4>
                    </div>
                    <div class="table-responsive table-view ">
                        <table class="table align-middle ">
                            <thead>
                                <tr>
                                    <th>{{ __('home.subtotal') }}</th>
                                    <th>₩ {{ $es_charges }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $esCounter = 0;
                                    if($qty = $request->session()->get('es_qty') !='' && $qty = $request->session()->get('es_qty') !='null')
                                    $qtyArr = $request->session()->get('es_qty'); 
                                   // print_r($qtyArr); die; 
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
    <!-- card detail modeal -->
    <div class="modal fade cardDetailDialog " tabindex="-1 " aria-labelledby="cardDetailDialog " aria-hidden="true ">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content ">
                <div class="modal-body ">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads ">
                        <h3 class="h3 ">{{ __('home.cardInfo') }}</h3>
                        <p class="p2 ">{{ __('home.Enterthebelowcarddetailstomakepayment') }}</p>
                    </div>
                    <form action="post ">
                        <div class="form-floating ">
                            <input type="text " class="form-control " id="floatingInput " placeholder="Card Number*">
                            <label for="floatingInput ">{{ __('home.cardNumber') }}*<span class="required-star ">*</span></label>
                        </div>
                        <div class="form-floating ">
                            <input type="text " class="form-control " id="floatingInput " placeholder="Card Holder Name">
                            <label for="floatingInput ">{{ __('home.cardIncardHolderNamefo') }}<span class="required-star ">*</span></label>
                        </div>
                        <div class="form-floating ">
                            <input type="text " class="form-control " id="floatingInput " placeholder="Expiry Date">
                            <label for="floatingInput ">{{ __('home.expiryDate') }}<span class="required-star ">*</span></label>
                        </div>
                        <div class="form-floating ">
                            <input type="text " class="form-control " id="floatingInput " placeholder="CVV">
                            <label for="floatingInput ">CVV<span class="required-star ">*</span></label>
                        </div>
                        <p class="p2">{{ __('home.BycontinuingtopayIunderstandandagreewiththeprivacypolicyandtermsHankook') }}</p>
                        <div class="form-floating ">
                            <a href="thank-you-customer.html" type="button " class="btn w-100 ">{{ __('home.PayNow') }} (₩ 1600)</a>
                        </div>
                        @php 
                        /*
                        <p class="text-center p2">100% {{ __('home.securePaymentsPoweredbyHankook') }}</p>
                        <div class="ml-auto paymentCard d-flex justify-content-center">
                            <img src="{{ asset('/assets/images/') }}/structure/amex.svg " alt=" " class="paymentCardIcon ">
                            <img src="{{ asset('/assets/images/') }}/structure/mastercard.svg " alt=" " class="paymentCardIcon ">
                            <img src="{{ asset('/assets/images/') }}/structure/visa.svg " alt=" " class="paymentCardIcon ">
                            <img src="{{ asset('/assets/images/') }}/structure/rupay.svg " alt=" " class="paymentCardIcon ">
                        </div>
                        */ 
                        @endphp
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- newsletter -->
@include('frontend.layout.newsletter')
<!-- footer -->
@include('frontend.layout.footer')
<!-- common models -->
@include('common_models')
@include('frontend.layout.footer_script')
@endsection    
<!-- JS section  -->   
@section('js-script')
<script>
    $(document).ready(function(){
        $(document).on('change','#available_points',function(){
            var pbTotal = "{{ $pbTotal; }}";                 
            var available_points = "{{ $myPoints; }}";                 
            var zero =0; 
            pbTotal = parseFloat(pbTotal);                 
            available_points = parseInt(available_points);                 
            if($("#available_points").is(':checked'))
            {
                $('#subTotalBox').show();
                if(available_points > pbTotal)
                {
                    $("#amount_of_ponts").text(pbTotal); //.toFixed(2)
                    $("#pb_total").text(zero); // .toFixed(2)
                    $("#pb_total2").text(zero); // .toFixed(2)
                    $("#pb_total3").text(zero); // .toFixed(2)
                    $("#poinstEarnper").text(zero); // .toFixed(2)
                }
                else
                {
                    $("#amount_of_ponts").text(available_points); // .toFixed(2)
                    $("#pb_total").text((pbTotal-available_points)); // .toFixed(2)
                    $("#pb_total2").text((pbTotal-available_points)); // .toFixed(2)
                    $("#pb_total3").text((pbTotal-available_points)); // .toFixed(2)
                }
            }
            else
            {
                $('#subTotalBox').hide();
                $("#amount_of_ponts").text(zero); // .toFixed(2)
                $("#pb_total").text(pbTotal); // .toFixed(2) 
                $("#pb_total2").text(pbTotal); // .toFixed(2)
                $("#pb_total3").text(pbTotal); // .toFixed(2)
            }
            $("#no_of_used_points").text($("#amount_of_ponts").text()); 
        });
        // Direct bank transfer 
        $(document).on('click','#direct_bank_transfer_submit',function(){
            var used_points = $('#amount_of_ponts').text(); 
            var pb_total = $('#pb_total').text(); 
            $("#direct_bank_transfer_submit").prop("disabled",true); 
            loading();
            $.post("{{ route('direct-bank-transfer') }}",  {'_token':"{{ csrf_token() }}",'used_points':used_points,'pb_total':pb_total}, function( data ) {
                if(data.status==1){
                    window.location.href = data.nextpageurl; 
                    unloading();
                } 
                else
                {
                    $("#direct_bank_transfer_submit").prop("disabled",false); 
                    unloading();
                }                      
            }); 
        });
        $(document).on('click','#credit_card_radio',function(){ $('#creditCardBox').show(); $('#directBankTransferBox').hide();   });
        $(document).on('click','#direct_bank_transfer_radio',function(){ $('#directBankTransferBox').show(); $('#creditCardBox').hide();   });
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