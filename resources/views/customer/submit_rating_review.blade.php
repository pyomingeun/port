
@extends('frontend.layout.head')
@section('body-content')

@include('customer.header')
<!-- include left bar here -->
        @include('customer.leftbar')
        <div class="content-box-right rate-and-review-sec">
            <div class="container-fluid">
                <div class="whitebox-w mb-3 bookings-htl-dtl-box-w">
                    <div class="white-card-header d-flex align-items-center flex-wrap">
                        <h6 class="h6">
                            <a href="{{ route('booking-detail',$booking->slug); }}"><img src="{{asset('/assets/images/')}}/structure/back-arrow.svg" alt="Back" class="backbtn cursor-p"></a> Rate and Review</h6>
                    </div>
                    <div class="white-card-body">
                        <div class="rate-and-review-des-block d-flex flex-wrap align-items-center">
                            <div class="rate-and-review-des-lft-cl">
                                <img src="{{ asset('/hotel_images/'.$hotel->featured_img); }}" class="bk-htl-img">
                            </div>
                            <div class="rate-and-review-des-rgt-cl">
                                <h5 class="h5 mb-2">{{ $hotel->hotel_name}}</h5>
                                <p class="p2 mb-0">{{ $hotel->phone }} | <span class="dotgray"></span>{{ $hotel->street }}{{ ($hotel->city !='' && $hotel->street !='')?', ':''; }} {{ $hotel->city }}{{ ($hotel->city !='' && $hotel->subrub !='')?', ':''; }}{{ $hotel->subrub  }} {{ ($hotel->pincode !='')?' - ':''; }}{{ $hotel->pincode }}</p>
                            </div>
                        </div>
                        <div class="divider mt-3 mb-3"></div>
                        <form id="rating_review_form" method="post" action="javascript:void(0)">
                        <div class="row">
                            <div class="col-xl-8 col-lg-8">
                                <div class="rate-and-form">
                                    <h4 class="mb-2">Rating<span class="required-star">*</span></h4>
                                    <p class="p2">Provide below ratings for all points.</p>

                                    <div>
                                        <div class="rating-field-row d-flex align-items-center">
                                            <span class="bgpink"></span>
                                            <p class="p1 rtServicehd mb-0 d-flex align-items-center"><img src="{{asset('/assets/images/')}}/structure/cleaning-services.svg" alt="" class="ServicesIcon"> Cleanliness</p>
                                            <fieldset class="rating cursor-pointer">
                                                <input type="radio" class="ratInput cursor-pointer" id="star_cleanliness5" name="cleanliness" value="5" checked /><label class="full" for="star_cleanliness5"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_cleanliness4half" name="cleanliness" value="4.5" /><label class="half" for="star_cleanliness4half"></label> -->
                                                <input type="radio" class="ratInput cursor-pointer" id="star_cleanliness4" name="cleanliness" value="4" /><label class="full" for="star_cleanliness4"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_cleanliness3half" name="cleanliness" value="3.5" /><label class="half" for="star_cleanliness3half"></label> -->
                                                <input type="radio" class="ratInput cursor-pointer" id="star_cleanliness3" name="cleanliness" value="3" /><label class="full" for="star_cleanliness3"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_cleanliness2half" name="cleanliness" value="2.5" /><label class="half" for="star_cleanliness2half"></label> -->
                                                <input type="radio" class="ratInput cursor-pointer" id="star_cleanliness2" name="cleanliness" value="2" /><label class="full" for="star_cleanliness2"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_cleanliness1half" name="cleanliness" value="1.5" /><label class="half" for="star_cleanliness1half"></label> -->
                                                <input type="radio" class="ratInput cursor-pointer" id="star_cleanliness1" name="cleanliness" value="1" /><label class="full" for="star_cleanliness1"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_cleanlinesshalf" name="cleanliness" value="0.5" /><label class="half" for="star_cleanlinesshalf"></label> -->
                                                <!-- <input type="radio" class="reset-option" name="cleanliness" value="reset" /> -->
                                            </fieldset>
                                        </div>
                                        <div class="rating-field-row d-flex align-items-center">
                                            <span class="bgpink"></span>
                                            <p class="p1 rtServicehd mb-0 d-flex align-items-center"><img src="{{asset('/assets/images/')}}/structure/cleaning-services.svg" alt="" class="ServicesIcon"> Facility</p>
                                            <fieldset class="rating">
                                                <input type="radio" class="ratInput cursor-pointer" id="star_facilities5" name="facilities" value="5" checked /><label class="full" for="star_facilities5"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_facilities4half" name="facilities" value="4.5" /><label class="half" for="star_facilities4half"></label> -->
                                                <input type="radio" class="ratInput cursor-pointer" id="star_facilities4" name="facilities" value="4" /><label class="full" for="star_facilities4"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_facilities3half" name="facilities" value="3.5" /><label class="half" for="v3half"></label> -->
                                                <input type="radio" class="ratInput cursor-pointer" id="star_facilities3" name="facilities" value="3" /><label class="full" for="star_facilities3"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_facilities2half" name="facilities" value="2.5" /><label class="half" for="star_facilities2half"></label> -->
                                                <input type="radio" class="ratInput cursor-pointer" id="star_facilities2" name="facilities" value="2" /><label class="full" for="star_facilities2"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_facilities1half" name="facilities" value="1.5" /><label class="half" for="star_facilities1half"></label> -->
                                                <input type="radio" class="ratInput cursor-pointer" id="star_facilities1" name="facilities" value="1" /><label class="full" for="star_facilities1"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_facilitieshalf0" name="facilities" value="0.5" /><label class="half" for="star_facilitieshalf0"></label> -->
                                                <!-- <input type="radio" class="reset-option" name="facilities" value="reset2" /> -->
                                            </fieldset>
                                        </div>

                                        <div class="rating-field-row d-flex align-items-center">
                                            <span class="bgpink"></span>
                                            <p class="p1 rtServicehd mb-0 d-flex align-items-center"><img src="{{asset('/assets/images/')}}/structure/cleaning-services.svg" alt="" class="ServicesIcon"> Service</p>
                                            <fieldset class="rating">
                                                <input type="radio" class="ratInput cursor-pointer" id="star_service5" name="service" value="5" checked /><label class="full" for="star_service5"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_service4half" name="service" value="4.5" /><label class="half" for="star_service4half"></label> -->
                                                <input type="radio" class="ratInput cursor-pointer" id="star_service4" name="service" value="4" /><label class="full" for="star_service4"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_service3half" name="service" value="3.5" /><label class="half" for="star_service3half"></label> -->
                                                <input type="radio" class="ratInput cursor-pointer" id="star_service3" name="service" value="3" /><label class="full" for="star_service3"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_service2half" name="service" value="2.5" /><label class="half" for="star_service2half"></label> -->
                                                <input type="radio" class="ratInput cursor-pointer" id="star_service2" name="service" value="2" /><label class="full" for="star_service2"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_service1half" name="service" value="1.5" /><label class="half" for="star_service1half"></label> -->
                                                <input type="radio" class="ratInput cursor-pointer" id="star_service1" name="service" value="1" /><label class="full" for="star_service1"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_servicehalf0" name="service" value="0.5" /><label class="half" for="star_servicehalf0"></label> -->
                                                <!-- <input type="radio" class="reset-option" name="service" value="reset3" /> -->
                                            </fieldset>
                                        </div>
                                        <div class="rating-field-row d-flex align-items-center">
                                            <span class="bgpink"></span>
                                            <p class="p1 rtServicehd mb-0 d-flex align-items-center"><img src="{{asset('/assets/images/')}}/structure/cleaning-services.svg" alt="" class="ServicesIcon"> Value for Money</p>
                                            <fieldset class="rating">
                                                <input type="radio" class="ratInput cursor-pointer" id="star_value_for_money5" name="value_for_money" value="5" checked /><label class="full" for="star_value_for_money5"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_value_for_money4half" name="value_for_money" value="4.5" /><label class="half" for="star_value_for_money4half"></label> -->
                                                <input type="radio" class="ratInput cursor-pointer" id="star_value_for_money4" name="value_for_money" value="4" /><label class="full" for="star_value_for_money4"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_value_for_money3half" name="value_for_money" value="3.5" /><label class="half" for="star_value_for_money3half"></label> -->
                                                <input type="radio" class="ratInput cursor-pointer" id="star_value_for_money3" name="value_for_money" value="3" /><label class="full" for="star_value_for_money3"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_value_for_money2half" name="value_for_money" value="2.5" /><label class="half" for="star_value_for_money2half"></label> -->
                                                <input type="radio" class="ratInput cursor-pointer" id="star_value_for_money2" name="value_for_money" value="2" /><label class="full" for="star_value_for_money2"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_value_for_money1half" name="value_for_money" value="1.5" /><label class="half" for="star_value_for_money1half"></label> -->
                                                <input type="radio" class="ratInput cursor-pointer" id="star_value_for_money1" name="value_for_money" value="1" /><label class="full" for="star_value_for_money1"></label>
                                                <!-- <input type="radio" class="ratInput cursor-pointer" id="star_value_for_moneyhalf0" name="value_for_money" value="0.5" /><label class="half" for="star_value_for_moneyhalf0"></label> -->
                                                <!-- <input type="radio" class="reset-option" name="value_for_money" value="reset4" /> -->
                                            </fieldset>
                                        </div>
                                    </div>
                                    <h4 class="mb-2">Review<span class="required-star">*</span></h4>
                                    <p class="p2">Write your experience for this booking.</p>
                                    <div class="form-floating" id="review_validate">
                                        <textarea itemid="txtarea" class="form-control" id="review" placeholder="Write review here..." style="min-height: 90px;" name="review"></textarea>
                                        <label for="review">Write review here...</label>
                                        <p class="mb-0 max-char-limit" id="review_limit_msg">max 500 characters</p>
                                        <p class="error-inp" id="review_err_msg"></p>
                                    </div>
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                    <input type="hidden" value="{{ $booking->slug }}" name="b">
                                    @if($booking->is_rated == 0)
                                    <button class="btn" id="rating_submit">Submit</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        </from>
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

        $(document).on('keyup','#review',function(){
            if(field_required('review','review',"Review is required"))
            if(!checkMaxLength($('#review').val(),500 )){
                $("#review_limit_msg").text('max 500 characters');
                setErrorAndErrorBox('review','Notes should be less than 500 letters.');
            } 
            else{
                let reviewlen = $('#review').val().length; 
				$("#review_limit_msg").text(reviewlen+'/500');
                unsetErrorAndErrorBox('review');
            }               

        });

        // mark/unmark favorite    
        $(document).on('click','#rating_submit',function(){
            
            var token=true; 
            
            if(!field_required('review','review',"Review is required"))
                token = false;
            else if(!checkMaxLength($('#review').val(),500 )) 
            {
                setErrorAndErrorBox('review','Review should be less than 500 letters.');
                token = false;
            }
            
            if(token)
            {
                $('#rating_submit').attr('disabled',true);
                $.post("{{ route('submit-rating-review') }}", $( "#rating_review_form" ).serialize(), function(data){
                    if(data.status==1)
                    {
                        $('#rating_submit').hide();
                        $("#commonSuccessMsg").text(data.message);
                        $("#commonSuccessBox").css('display','block');
                        
                        setTimeout(function() {
                            $("#commonSuccessBox").hide();
                        }, 1500);
                        unloading();
                    }
                    else
                    {
                        $('#rating_submit').attr('disabled',false);
                        unloading();
                        $("#commonErrorMsg").text(data.message);
                        $("#commonErrorBox").css('display','block');
                        setTimeout(function() {
                            $("#commonErrorBox").hide();
                        }, 3000);
                    }
                });
            }
            
        });
        //__________________
    });
</script>
<script>
    $(document).ready(function() {

        $(".ratInput").click(function() {
            var sim = $("input[type='radio']:checked").val();
            if (sim < 3) {
                $('.myratings').css('color', 'red');
                $(".myratings").text(sim);
            } else {
                $('.myratings').css('color', 'green');
                $(".myratings").text(sim);
            }
        });


    });
</script>
@endsection