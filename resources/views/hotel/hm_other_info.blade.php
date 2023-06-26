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
                        <form id="hm_otherinfo_form" method="post" action="javaScript:Void(0);">
                            <div class="">
                                <div class="hotelManageform-Content">
                                    <div class="grayBox-w">
                                        <div class="d-flex align-items-center textWtaddBtn flex-wrap">
                                            <h5 class="h5">{{ __('home.extraService') }}</h5>
                                            <p class="p2 mb-0 addAttBtn ml-auto cursor-p addServiceBtn addNewes"><img src="{{asset('/assets/images/')}}/structure/add-circle.svg" alt="" class="add-circle"> {{ __('home.addService') }}</p>
                                        </div>
                                        <div class="row mt-4" id="es_list">
                                            @foreach ($hotel->hasExtraServices as $es)
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="esItemBoxdb_{{$es->id}}">
                                                <div class="extraServicefieldRow d-flex align-items-center">
                                                    <div class="extraServicefield1">
                                                        <div class="form-floating mb-0">
                                                            <input type="text" class="form-control" id="es_name_db_{{$es->id}}" placeholder="{{ __('home.serviceName') }}" value="{{$es->es_name}}" name="es_name[]">
                                                            <label for="es_name_db_{{$es->id}}">{{ __('home.serviceName') }}<span class="required-star">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="extraServicefield2">
                                                        <div class="inpWtTextRt d-flex">
                                                            <div class="form-floating mb-0">
                                                                <input type="text" class="form-control" id="es_price_db_{{$es->id}}" placeholder="{{ __('home.unitPrice') }}" value="{{$es->es_price}}" name="es_price[]">
                                                                <label for="es_price_db_{{$es->id}}">{{ __('home.unitPrice') }}<span class="required-star">*</span></label>
                                                            </div>
                                                            <span class="inpTextRt">₩</span>
                                                        </div>
                                                    </div>
                                                    <div class="extraServicefield3">
                                                        <div class="quantity-row d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ __('home.maxQty') }}<span class="required-star">*</span></p>
                                                            <div class="quantity-box d-flex align-items-center ml-auto">
                                                                <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                <input type="text" value="{{$es->es_max_qty}}" class="only_integer rightClickDisabled" name="es_max_qty[]" />
                                                                <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                            </div>
                                                            <img src="{{asset('/assets/images/')}}/structure/trash-red.svg" alt="" class="rmoveExtraSerIcon cursor-p ml-auto delesrowdb" id="delesrowdb_{{$es->id}}" data-i="{{$es->id}}">
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="esid[]" value="{{$es->id}}">
                                                </div>                                                
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="grayBox-w">
                                        <div class="d-flex align-items-center textWtaddBtn flex-wrap">
                                            <h5 class="h5 mb-0">{{ __('home.longStayDiscount') }} <span class="p2">({{ __('home.optional') }})</span></h5>
                                            <p class="p2 mb-0 addAttBtn ml-auto cursor-p addDiscountBtn addNewLSD"><img src="{{asset('/assets/images/')}}/structure/add-circle.svg" alt="" class="add-circle"> {{ __('home.addDiscount') }}</p>
                                        </div>
                                        <div class="mt-4" id="lsd_list">
                                            @foreach ($hotel->hasLongStayDiscount as $lsd)
                                            <div class="LongStayDiscountRow mb-4 d-flex align-items-center" id="lsdrowdb_{{$lsd->id}}">
                                                <div class="LongStayDiscountCol1">
                                                    <div class="quantity-row d-flex align-items-center">
                                                        <p class="p2 mb-0">{{ __('home.minDaysStays') }} <br><small class="p3">({{ __('home.Nights') }})</small></p>
                                                        <div class="quantity-box d-flex align-items-center ml-auto">
                                                            <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                            <input type="text" value="{{$lsd->lsd_min_days}}" name="lsd_min_days[]" class="only_integer rightClickDisabled"/>
                                                            <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="LongStayDiscountCol1">
                                                    <div class="quantity-row d-flex align-items-center">
                                                        <p class="p2 mb-0">{{ __('home.maxDaysStays') }} <br><small class="p3">({{ __('home.Nights') }} )</small></p>
                                                        <div class="quantity-box d-flex align-items-center ml-auto">
                                                            <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                            <input type="text" value="{{$lsd->lsd_max_days}}" name="lsd_max_days[]" class="only_integer rightClickDisabled"/>
                                                            <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="LongStayDiscountCol2">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control only_integer rightClickDisabled" name="lsd_discount_amount[]" value="{{$lsd->lsd_discount_amount}}" >
                                                        <div class="form-floating mb-0 capDropdown">
                                                            <button data-bs-toggle="dropdown" class="form-select">{{($lsd->lsd_discount_type == 'percentage')?'%':'Flat';}}</button>
                                                            <ul class="dropdown-menu">
                                                                <li class="radiobox-image">
                                                                    <input type="radio" id="lsd_dicount_optionp{{$lsd->id}}"  name="lsd_discount_type{{$lsd->id}}[]" value="percentage"  class="lsd_select_dtype" {{ ($lsd->lsd_discount_type == 'percentage')?'checked':''; }}  />
                                                                    <label for="lsd_dicount_optionp{{$lsd->id}}">%</label>
                                                                </li>
                                                                <li class="radiobox-image">
                                                                    <input type="radio" id="lsd_dicount_optionf{{$lsd->id}}"  name="lsd_discount_type{{$lsd->id}}[]" value="flat"  class="lsd_select_dtype" {{ ($lsd->lsd_discount_type == 'flat')?'checked':''; }}  />
                                                                    <label for="lsd_dicount_optionf{{$lsd->id}}">Flat</label>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="LongStayDiscountCol3 d-flex justify-content-end">
                                                    <img id="dellsdrowdb_{{$lsd->id}}"src="{{asset('/assets/images/')}}/structure/trash-red.svg" alt="" class="rmoveExtraSerIcon cursor-p ml-auto dellsdrowdb" data-i="{{$lsd->id}}">
                                                </div>
                                                <input type="hidden" name="lsdid[]" value="{{$lsd->id}}">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="grayBox-w">
                                        <div class="d-flex align-items-center textWtaddBtn flex-wrap">
                                            <div>
                                                <h5 class="h5 mb-1">{{ __('home.peakSAeason') }} <span class="p2">({{ __('home.optional') }})</span></h5>
                                                <p class="p3 mb-0" style="color: #717972;">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                            </div>
                                            <p class="p2 mb-0 addAttBtn ml-auto cursor-p addSeasonBtn addNewSeason addNewPS"><img src="{{asset('/assets/images/')}}/structure/add-circle.svg" alt="" class="add-circle"> {{ __('home.addSeason') }}</p>
                                        </div>
                                        <div class="mt-4" id="ps_list">
                                            @foreach ($hotel->hasPeakSeasont as $ps)
                                            @php
                                            $sdate=date_create($ps->start_date);
                                            $edate=date_create($ps->end_date);
                                            @endphp
                                            <div class="row PeakSeasonRow" id="peakseasondb_{{$ps->id}}">
                                                <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="form-floating datepickerField">
                                                        <input type="text" class="form-control" id="season_name{{$ps->id}}" name="season_name[]" value="{{$ps->season_name}}"  autocomplete="off" placeholder="seasonName">
                                                        <label for="floatingInput"> {{ __('home.seasonName') }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="form-floating datepickerField">
                                                        <img src="{{asset('/assets/images/')}}/structure/calendar1.svg" alt="" class="calendarIcon" />
                                                        <input type="text" class="form-control datepicker"  id="start_date{{$ps->id}}" name="start_date[]" value="{{ date_format($sdate,'Y-m-d') }}" autocomplete="off" placeholder="{{ __('home.startDate') }}">
                                                        <label for="floatingInput">{{ __('home.startDate') }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="form-floating datepickerField">
                                                        <img src="{{asset('/assets/images/')}}/structure/calendar1.svg" alt="" class="calendarIcon" />
                                                        <input type="text" class="form-control datepicker" autocomplete="off"  id="end_date{{$ps->id}}" name="end_date[]" value="{{ date_format($edate,'Y-m-d') }}"  placeholder="{{ __('home.endDate') }}">
                                                        <label for="floatingInput">{{ __('home.endDate') }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-1 col-lg-1 col-md-2 col-sm-2 col-2">
                                                    <img src="{{asset('/assets/images/')}}/structure/trash-red.svg" alt="" class="rmoveExtraSerIcon cursor-p mt-3 d-block m-auto delPsrowdb" data-i="{{$ps->id}}">
                                                </div>
                                                <input type="hidden" name="psid[]" value="{{$ps->id}}">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="res-sub-btn-rw d-flex">
                                    <a href="hotel-management-step4.html" class="btn-back btnPrevious">{{ __('home.Back') }}</a>
                                    <!-- <button class="btn bg-gray1">Cancel</button> -->
                                    <a class="btn bg-gray1" href="{{ route('hm_cancel') }}" >{{ __('home.cancel') }}</a>
                                    <a href="hotel-management-step6.html" class="btn btnNext tab5">{{ __('home.Next') }}</a>
                                </div>
                                <div class="res-sub-btn-rw d-flex justify-content-end align-items-center pl-2">
                                   <a href="{{route('hm_FeaturesNFacilities',$hotel->hotel_id)}}" class="btn-back btnPrevious">Back</a>
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                                    <input type="hidden" value="next" name="savetype" id="savetype">
                                    <input type="hidden" value="{{$hotel->hotel_id}}" name="h" id="h">
                                    <a class="btn bg-gray1" href="{{ route('hm_cancel') }}" >{{ __('home.cancel') }}</a>
                                    <button type="button" class="btn outline-blue form_submit" data-btntype="save_n_exit" >{{ __('home.SaveExit') }}</button>
                                    <button type="button" class="btn btnNext tab3 form_submit" data-btntype="next">{{ __('home.Next') }} & {{ __('home.continue') }}</button>
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
<script src="//cdn.ckeditor.com/4.14.1/full-all/ckeditor.js"></script>
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
            }
        });
    }
    animateElements();
    $(window).scroll(animateElements);
})
</script>
<script>
    $(document).ready(function(){
        $(document).on('click','.form_submit',function(){
            // $('#hm_hm_server_err_msg').text('');
            // alert('dfsf');
            $('#savetype').val($(this).attr('data-btntype'));
            form_submit();
        });
        function form_submit()
        { 
            var token=true; 
            let formdata = $( "#hm_otherinfo_form" ).serialize();
            if(token)
            {
                $(".form_submit").prop("disabled",true); 
                loading();
                $.post("{{ route('hm_otherInfo_submit') }}",  formdata, function( data ) {
                            console.log(data);
                            // unloading();
                            if(data.status==1){
                                window.location.href = data.nextpageurl; 
                                unloading();
                            } 
                            else
                            {
                                $(".form_submit").prop("disabled",false); 
                                // $('#hm_hm_server_err_msg').text(data.message);
                                unloading();
                            }                      
                });             
            }
        }
        // add new Extra services box 
        var es =1;
        $(document).on('click','.addNewes',function(){
            // console.log('addNewes');
            $('#es_list').prepend('<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="esItemBox_'+es+'"><div class="extraServicefieldRow d-flex align-items-center"><div class="extraServicefield1"><div class="form-floating mb-0"><input type="text" class="form-control" id="es_name_'+es+'" placeholder="Service Name" value="" name="es_name[]"><label for="es_name_'+es+'">Service Name<span class="required-star">*</span></label></div></div><div class="extraServicefield2"><div class="inpWtTextRt d-flex"><div class="form-floating mb-0"><input type="text" class="form-control" id="es_price_'+es+'" placeholder="Unit Price" value="" name="es_price[]"><label for="es_price_'+es+'">Unit Price<span class="required-star">*</span></label></div><span class="inpTextRt">₩</span></div></div><div class="extraServicefield3"><div class="quantity-row d-flex align-items-center"><p class="p2 mb-0">Max Qty<span class="required-star">*</span></p><div class="quantity-box d-flex align-items-center ml-auto"><span class="minus d-flex align-items-center justify-content-center"><img src="{{asset("/assets/images/")}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span><input type="text" value="1" class="only_integer rightClickDisabled" name="es_max_qty[]" /><span class="plus d-flex align-items-center justify-content-center"><img src="{{asset("/assets/images/")}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span></div><img src="{{asset("/assets/images/")}}/structure/trash-red.svg" alt="" class="rmoveExtraSerIcon cursor-p ml-auto delesrow" id="delesrow_'+es+'" data-i="'+es+'"></div></div><input type="hidden" name="esid[]" value="0"></div></div>');  
            es++;
        });
        // close 
        // del ES from db    
        $(document).on('click','.delesrowdb',function(){
            // delNTA
            var i = $(this).attr('data-i');
            $.post("{{ route('delES') }}",{_token:"{{ csrf_token() }}",h:"{{ $hotel->hotel_id}}",i:i}, function(data){
                if(data.status==1)
                {
                    $("#esItemBoxdb_"+i).remove();    
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
                    setTimeout(function() {
                        $("#commonErrorBox").hide();
                    }, 1500);
                }
            });
        });
        // Remove es new box
        $(document).on('click','.delesrow',function(){
            // console.log('delete_nta');
            var i = $(this).attr('data-i');
            // console.log(i);    
            $("#esItemBox_"+i).remove();            
        });
        // add new LSD box 
        var lsd =1;
        $(document).on('click','.addNewLSD',function(){
            // console.log('addNewes');
            $('#lsd_list').prepend('<div class="LongStayDiscountRow mb-4 d-flex align-items-center" id="lsdrow_'+lsd+'"> <div class="LongStayDiscountCol1"> <div class="quantity-row d-flex align-items-center"> <p class="p2 mb-0">Min Days Stays <br><small class="p3">(Nights)</small></p> <div class="quantity-box d-flex align-items-center ml-auto"> <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset("/assets/images/")}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span> <input type="text" value="1" name="lsd_min_days[]" class="only_integer rightClickDisabled"/> <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset("/assets/images/")}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span> </div> </div> </div> <div class="LongStayDiscountCol1"> <div class="quantity-row d-flex align-items-center"> <p class="p2 mb-0">Max Days Stays <br><small class="p3">(Nights)</small></p> <div class="quantity-box d-flex align-items-center ml-auto"> <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset("/assets/images/")}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span> <input type="text" value="1" name="lsd_max_days[]" class="only_integer rightClickDisabled"/> <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset("/assets/images/")}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span> </div> </div> </div> <div class="LongStayDiscountCol2"> <div class="input-group"> <input type="text" class="form-control only_integer rightClickDisabled" name="lsd_discount_amount[]" value="" > <div class="form-floating mb-0 capDropdown"> <button data-bs-toggle="dropdown" class="form-select">%</button> <ul class="dropdown-menu"> <li class="radiobox-image"> <input type="radio" id="lsd_dicount_optionnewp'+lsd+'" name="lsd_discount_typenew'+lsd+'[]" value="percentage" class="lsd_select_dtype" checked/> <label for="lsd_dicount_optionnewp'+lsd+'">%</label> </li> <li class="radiobox-image"> <input type="radio" id="lsd_dicount_optionnewf'+lsd+'" name="lsd_discount_typenew'+lsd+'[]" value="flat" class="lsd_select_dtype" /> <label for="lsd_dicount_optionnewf'+lsd+'">Flat</label> </li> </ul> </div> </div> </div> <div class="LongStayDiscountCol3 d-flex justify-content-end"> <img id="dellsdrow_'+lsd+'"src="{{asset("/assets/images/")}}/structure/trash-red.svg" alt="" class="rmoveExtraSerIcon cursor-p ml-auto dellsdrow" data-i="'+lsd+'"> </div><input type="hidden" name="lsdid[]" value="0"><input type="hidden" name="newrow[]" value="'+lsd+'"> </div>');  
            lsd++;
        });
        // close 
        // del LSD from db    
        $(document).on('click','.dellsdrowdb',function(){
            // delNTA
            var i = $(this).attr('data-i');
            $.post("{{ route('delLSD') }}",{_token:"{{ csrf_token() }}",h:"{{ $hotel->hotel_id}}",i:i}, function(data){
                if(data.status==1)
                {
                    $("#lsdrowdb_"+i).remove();    
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
                    setTimeout(function() {
                        $("#commonErrorBox").hide();
                    }, 1500);
                }
            });
        });
        // Remove lsd new box
        $(document).on('click','.dellsdrow',function(){
            // console.log('delete_nta');
            var i = $(this).attr('data-i');
            // console.log(i);    
            $("#lsdrow_"+i).remove();            
        });
        // add new PS box 
        var ps =1;
        $(document).on('click','.addNewPS',function(){
            console.log('addNewPS');
            $('#ps_list').prepend('<div class="row PeakSeasonRow"  id="peakseason_'+ps+'"> <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12"> <div class="form-floating datepickerField"> <input type="text" class="form-control" id="season_name'+ps+'" name="season_name[]" value="" autocomplete="off" placeholder="Season Name"> <label for="floatingInput">Season Name</label> </div> </div> <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12"> <div class="form-floating datepickerField"> <img src="{{asset("/assets/images/")}}/structure/calendar1.svg" alt="" class="calendarIcon" /> <input type="text" class="form-control datepicker" id="start_date'+ps+'" name="start_date[]" value="" autocomplete="off" placeholder="Start Date"> <label for="floatingInput">Start Date</label> </div> </div> <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12"> <div class="form-floating datepickerField"> <img src="{{asset("/assets/images/")}}/structure/calendar1.svg" alt="" class="calendarIcon" /> <input type="text" class="form-control datepicker" autocomplete="off" id="end_date'+ps+'" name="end_date[]" value="" placeholder="End Date"> <label for="floatingInput">End Date</label> </div> </div> <div class="col-xl-1 col-lg-1 col-md-2 col-sm-2 col-2"> <img src="{{asset("/assets/images/")}}/structure/trash-red.svg" alt="" class="rmoveExtraSerIcon cursor-p mt-3 d-block m-auto delPsrow" data-i="'+ps+'"> </div><input type="hidden" name="psid[]" value="0"> </div>');  
            ps++;
            // $(document).find('.datepicker').datepicker({
            //     format: 'yyyy-mm-dd'
            // });
        });
        // close 
        $(document).on('focus',".datepicker", function(){
            $(this).datepicker({format: 'yyyy-mm-dd'});
        });
        // del LSD from db    
        $(document).on('click','.delPsrowdb',function(){
            // delNTA
            var i = $(this).attr('data-i');
            $.post("{{ route('delPS') }}",{_token:"{{ csrf_token() }}",h:"{{ $hotel->hotel_id}}",i:i}, function(data){
                if(data.status==1)
                {
                    $("#peakseasondb_"+i).remove();    
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
                    setTimeout(function() {
                        $("#commonErrorBox").hide();
                    }, 1500);
                }
            });
        });
        // Remove lsd new box
        $(document).on('click','.delPsrow',function(){
            // console.log('delete_nta');
            var i = $(this).attr('data-i');
            // console.log(i);    
            $("#peakseason_"+i).remove();            
        });        
    });
</script>
@endsection       