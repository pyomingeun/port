@extends('frontend.layout.head')
@section('body-content')
@include('hotel.header')
    <div class="main-wrapper-gray">
    @if(auth()->user()->access == 'admin')
             @include('admin.leftbar')        
         @else
             @include('hotel.leftbar')
         @endif
        <div class="content-box-right hotel-management-sec">
            <div class="container-fluid">
                <div class="hotel-management-row d-flex flex-wrap">
                    <div class="hotel-management-left-col">
                        <div class="hotel-tabs-rw">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link tab1 active" role="tab" data-bs-toggle="tab" href="#step1">
                                        <span class="stepcircle">1 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
                                        <div class="tabCnt">
                                            <p class="p3">{{ __('home.Step') }} 1</p>
                                            <p class="p1">{{ __('home.couponCodeInfo') }}</p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hotel-management-right-col">
                        <div class="tab-content stepsContent">
                            <div class="tab-pane active" id="step1">
                                <form id="coupon_input" action="javaScript:void(0);" method="post">
                                    <div class="create-coupon-code-sec">
                                        <div class="grayBox-w">
                                            <div class="hotemmanageFormInrcnt">
                                                <h5 class="hd5 h5">{{ __('home.couponCodeInfo') }}</h5>
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-floating" id="coupon_code_name_validate">
                                                            <input type="text" class="form-control" id="coupon_code_name" placeholder="{{ __('home.couponCodeName') }}" name="coupon_code_name" value="{{ (isset($coupon->coupon_code_name))?$coupon->coupon_code_name:''; }}" >
                                                            <label for="coupon_code_name">{{ __('home.couponCodeName') }}<span class="required-star">*</span></label>
                                                            <p class="error-inp" id="coupon_code_name_err_msg"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-floating mb-3" id="discount_type_validate">
                                                            <button id="selectDiscount" data-bs-toggle="dropdown" class="form-select text-capitalize" aria-expanded="false">{{ (isset($coupon->discount_type) && $coupon->discount_type !='')?str_replace("_"," ",$coupon->discount_type):'';  }}</button>
                                                            <ul class="dropdown-menu dropdown-menu-start">
                                                                <li class="radiobox-image">
                                                                    <input type="radio" class="select_dtype" id="fixed_amount" name="discount_type" value="fixed_amount" {{ (isset($coupon->discount_type) && $coupon->discount_type=='fixed_amount' )?'checked':''; }} />
                                                                    <label for="fixed_amount">{{ __('home.fixedAmount') }}</label>
                                                                </li>
                                                                <li class="radiobox-image">
                                                                    <input type="radio"  class="select_dtype" id="percentage" name="discount_type" value="percentage" {{ (isset($coupon->discount_type) && $coupon->discount_type=='percentage' )?'checked':''; }} />
                                                                    <label for="percentage">{{ __('home.percentage') }}</label>
                                                                </li>
                                                            </ul>
                                                            <label for="selectDiscount" class="label {{ (isset($coupon->discount_type) && $coupon->discount_type !='')?'label_add_top':'';  }}">{{ __('home.discountType') }}<span class="required-star">*</span></label>
                                                            <p class="error-inp" id="discount_type_err_msg"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="inpWtTextRtbg d-flex">
                                                            <div class="form-floating" id="discount_amount_validate">
                                                                <input type="text" class="form-control only_integer rightClickDisabled" id="discount_amount" name="discount_amount" placeholder="{{ __('home.discountAmount') }}" value="{{ (isset($coupon->discount_amount))?$coupon->discount_amount:''; }}">
                                                                <label for="discount_amount">{{ __('home.discountAmount') }}<span class="required-star">*</span></label>
                                                                <p class="error-inp" id="discount_amount_err_msg"></p>
                                                            </div>
                                                            <span class="inpTextRtbg" id="dtypeSymbol">{{ (isset($coupon->discount_type) && $coupon->discount_type=='percentage' )?'%':'₩'; }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="inpWtTextRtbg d-flex">
                                                            <div class="form-floating" id="max_discount_amount_validate">
                                                                <input type="text" class="form-control only_integer rightClickDisabled" id="max_discount_amount" placeholder="{{ __('home.maximumDiscountAmount') }}" name="max_discount_amount" value="{{ (isset($coupon->max_discount_amount))?$coupon->max_discount_amount:''; }}" >
                                                                <label for="max_discount_amount">{{ __('home.maximumDiscountAmount') }}<span class="required-star">*</span></label>
                                                                <p class="error-inp" id="max_discount_amount_err_msg"></p>
                                                            </div>
                                                            <span class="inpTextRtbg">₩</span>
                                                        </div>
                                                    </div>
                                                    @php
                                                        if(isset($coupon->expiry_date) && $coupon->expiry_date !='' )
                                                        {    
                                                            $edate=date_create($coupon->expiry_date);
                                                            $expiry_date= date_format($edate,"Y-m-d");
                                                        }
                                                        else
                                                            $expiry_date='';
                                                    @endphp
                                                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-floating datepickerField" id="expiry_date_validate">
                                                            <img src="{{asset('/assets/images/')}}/structure/calendar1.svg" alt="" class="calendarIcon" />
                                                            <input type="text" class="form-control datepicker" id="expiry_date" name="expiry_date" placeholder="{{ __('home.expiryDate') }}" value="{{ $expiry_date; }}">
                                                            <label for="expiry_date">{{ __('home.expiryDate') }}<span class="required-star">*</span></label>
                                                            <p class="error-inp" id="expiry_date_err_msg"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="quantity-row row mb-4">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ __('home.usLimitsPerGuest') }}</p>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                <div class="quantity-box d-flex align-items-center ml-auto">
                                                                    <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                    <input type="text" value="{{ (isset($coupon->limit_per_user))?$coupon->limit_per_user:'1'; }}" name="limit_per_user" id="limit_per_user" class="only_integer rightClickDisabled" />
                                                                    <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="quantity-row row mb-4">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 d-flex align-items-center">
                                                                <p class="p2 mb-0"> {{ __('home.noOfCouponToBeUsed') }}</p>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                <div class="quantity-box d-flex align-items-center ml-auto">
                                                                    <span class="minusMinZero d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                    <input type="text" value="{{ (isset($coupon->available_no_of_coupon_to_use))?$coupon->available_no_of_coupon_to_use:'0'; }}" name="available_no_of_coupon_to_use" id="available_no_of_coupon_to_use" class="only_integer rightClickDisabled"/>
                                                                    <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if(auth()->user()->access == 'admin')
                                                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-floating mb-3" id="h_validate">
                                                            <button id="selectHotel" data-bs-toggle="dropdown" class="form-select text-capitalize" aria-expanded="false">{{ (isset($hotel_name) && $hotel_name !='')?$hotel_name:'';  }}</button>
                                                            <ul class="dropdown-menu dropdown-menu-start">
                                                                <li class="radiobox-image">
                                                                    <input type="radio" class="select_hotel" id="h0" name="h" value="0" {{ (isset($coupon->hotel_id) && $coupon->hotel_id==0)?'checked':''; }} />
                                                                    <label for="h0">ALL</label>
                                                                </li>
                                                                @foreach ($hotels as $hotel)
                                                                <li class="radiobox-image">
                                                                    <input type="radio" class="select_hotel" id="h{{ $hotel->slug }}" name="h" value="{{ $hotel->hotel_id }}" {{ (isset($coupon->hotel_id) && $coupon->hotel_id==$hotel->hotel_id )?'checked':''; }} />
                                                                    <label for="h{{ $hotel->slug }}">{{ $hotel->hotel_name }}</label>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                            <label for="selectHotel" class="label {{ (isset($hotel_name) && $hotel_name !='' )?'label_add_top':'';  }}">Select Hotel<span class="required-star">*</span></label>
                                                            <p class="error-inp" id="h_err_msg"></p>
                                                        </div>
                                                    </div>
                                                    @endif 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="res-sub-btn-rw d-flex justify-content-end">
                                        <input type="hidden" value="{{ $slug }}" name="slug" id="slug">
                                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                                        @if(auth()->user()->access == 'hotel_manager')
                                        <input type="hidden" value="{{ auth()->user()->id; }}" name="h" id="h">
                                        @endif
                                        <a href="{{ route('coupon-list'); }}" class="btn bg-gray1">{{ __('home.cancel') }}</a>
                                        <button class="btn form_submit" type="submit">Save</button>
                                        <!-- <a class="btn" data-bs-toggle="modal" data-bs-target=".thankyouDialog">Create</a> -->
                                    </div>
                                </form>
                            </div>
                        </div>
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
                            <h3 class="h3 mt-2">Thank You!</h3>
                            <p class="p2 mb-4">Your new coupon code has been created successfully.</p>
                        </div>
                        <a href="{{ route('coupon-list'); }}" class="btn w-100">Continue</a>
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
    $(document).on('keyup','.onpress_enter_bnsb',function(e){
        // $("#server_err_msg").text('');
        // console.log(e.keyCode);
        if(e.keyCode == 13)
            form_submit();
    });
    var a = "{{  auth()->user()->access; }}";
    $(document).on('keyup','#coupon_code_name',function(){
        // $("#hm_server_err_msg").text('');
        if(field_required('coupon_code_name','coupon_code_name',"Coupon code is required"))
        if(!checkMaxLength($('#coupon_code_name').val(),200 )) 
            setErrorAndErrorBox('coupon_code_name','Coupon code be less than 200 letters.'); 
        else
            unsetErrorAndErrorBox('coupon_code_name');
    });
    // $(document).on('keyup','#cac',function(){
    //     // $("#hm_server_err_msg").text('');
    //     if(field_required('cac','cac',"Confirm Account number is required"))
    //     {
    //         if(!checkIsEqual($('#ac').val(),$('#cac').val()))
    //             setErrorAndErrorBox('cac','A/c number & confirm A/c should be same.'); 
    //         else
    //             unsetErrorAndErrorBox('cac');        
    //     }
    // });
    $(document).on('change','#expiry_date',function(){
        field_required('expiry_date','expiry_date',"Expiry date is required")
    });    
    $(document).on('keyup','#discount_amount',function(){
        // $("#hm_server_err_msg").text('');
        var dtypeVal = $("input[name='discount_type']:checked").val();
            if(dtypeVal !='percentage')
                $('#max_discount_amount').val($('#discount_amount').val());
        if(field_required('discount_amount','discount_amount',"Discount Amount is required"))
        if(!checkMaxLength($('#discount_amount').val(),200 )) 
            setErrorAndErrorBox('discount_amount','Discount Amount be less than 200 letters.'); 
        else
            unsetErrorAndErrorBox('discount_amount');
    });
    $(document).on('keyup','#max_discount_amount',function(){
        // $("#hm_server_err_msg").text('');
        if(field_required('max_discount_amount','max_discount_amount',"Discount Amount is required"))
        if(!checkMaxLength($('#max_discount_amount').val(),200 )) 
            setErrorAndErrorBox('max_discount_amount','Discount Amount be less than 200 letters.'); 
        else
            unsetErrorAndErrorBox('max_discount_amount');
    });
    $(document).on('click','.select_dtype',function(){                
        if(!($('input:radio[name=discount_type]:checked').val()))
            setErrorAndErrorBox('discount_type','Please select any Discount Type form list.');
        else
        {
            unsetErrorAndErrorBox('discount_type');
            var dtypeVal = $("input[name='discount_type']:checked").val();
            if(dtypeVal =='percentage')
                $('#dtypeSymbol').text('%');
            else
                $('#dtypeSymbol').text('₩');
        }                     
    });    
    $(document).on('click','.select_hotel',function(){                
        if(!($('input:radio[name=h]:checked').val()))
            setErrorAndErrorBox('h','Please select any hotel form hotel-list.');
        else
            unsetErrorAndErrorBox('h');         
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
        if(!field_required('coupon_code_name','coupon_code_name',"Coupon code is required"))
            token = false;
        else if(!checkMaxLength($('#coupon_code_name').val(),200 )) 
        {
            setErrorAndErrorBox('coupon_code_name','Coupon ocde be less than 200 letters.');
            token = false;
        }
        if(!($('input:radio[name=discount_type]:checked').val()))
        {
            token =false; 
            setErrorAndErrorBox('discount_type','Please select any Discount Type form list.'); 
        }
        if(!field_required('discount_amount','discount_amount',"Discount Amount is required"))
            token = false;
        else if(!checkMaxLength($('#discount_amount').val(),200 )) 
        {
            setErrorAndErrorBox('discount_amount','Discount Amount be less than 200 letters.');
            token = false;
        }
        if(!field_required('expiry_date','expiry_date',"Expiry Date is required"))
            token = false;
        else if(!checkMaxLength($('#expiry_date').val(),200 )) 
        {
            setErrorAndErrorBox('expiry_date','Expiry Date be less than 200 letters.');
            token = false;
        }
        var dtypeVal = $("input[name='discount_type']:checked").val();
        if(dtypeVal =='percentage' && $('#discount_amount').val() > 100)
        {
            setErrorAndErrorBox('discount_amount','Discount amount should be less then or equal 100%');
            token = false;
        }
        else if(dtypeVal =='fixed_amount' && ( $('#discount_amount').val() != $('#max_discount_amount').val() ) )
        {
            setErrorAndErrorBox('max_discount_amount','Max discount amount & discount amount should be same ');
            token = false;
        }    
        if(a =='admin'){
            if(!($('input:radio[name=h]:checked').val()))
            {
                token =false; 
                setErrorAndErrorBox('h','Please select any hotel form hotel-list.'); 
            }
        }
        if(token)
        {
            $(".form_submit").prop("disabled",true); 
            loading();
            $.post("{{ route('coupon-input-submit') }}",  $( "#coupon_input" ).serialize(), function( data ) {
                        // console.log(data);
                        if(data.status==1){
                            unloading();
                            $(".form_submit").prop("disabled",false);
                            $('.thankyouDialog').modal('show'); 
                            // window.location.href = data.nextpageurl; 
                            /* $("#commonSuccessMsg").text(data.message);
                            $("#commonSuccessBox").css('display','block');
                            $(".form_submit").prop("disabled",false); 
                            unloading();
                            setTimeout(function() {
                                $("#commonSuccessBox").hide();
                            }, 3000); */
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
