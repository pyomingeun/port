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
                                <form id="hm_feNfa_form" method="post">
                                <div class="hotelManageform-Content">
                                    <div class="grayBox-w">
                                        <div class="hotemmanageFormInrcnt">
                                            <h5 class="hd5 h5">{{ __('home.Hotel') }}  {{ __('home.Amenities') }}<span class="p2">({{ __('home.optional') }})</span></h5>
                                            <div class="row">
                                                <?php /*     
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating mb-3">
                                                        <button id="selectFeatures" data-bs-toggle="dropdown" class="form-select" aria-expanded="false"></button>
                                                        <ul class="dropdown-menu dropdown-menu-start">
                                                            @foreach ($features as $feature)
                                                            <li class="radiobox-image ">
                                                                <input type="radio" id="features_{{$feature->id}}" name="features" value="{{$feature->id}}"  data-t="{{ csrf_token() }}"  data-h="{{$hotel->hotel_id}}" class="select_features"/>
                                                                <label for="features_{{$feature->id}}">{{$feature->features_name}}</label>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                        <label for="selectFeatures" class="label">Select Features</label>
                                                    </div>
                                                </div>
                                                */ ?>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating mb-3 multiselectDropdownField">
                                                        <input id="selectFeatures" name="select_features"  value="" data-bs-toggle="dropdown" class="form-select" placeholder="Select Features" autocomplete="off" />
                                                        <ul class="dropdown-menu dropdown-menu-start">
                                                            @foreach ($features as $feature)
                                                            <li class="radiobox-image">
                                                                <input type="checkbox" id="features_{{$feature->id}}" name="features[]" data-n="{{$feature->features_name}}" value="{{$feature->id}}"   class="select_features_chk" {{ (in_array($feature->id, $features_ids))?'checked':''; }}  />
                                                                <label for="features_{{$feature->id}}">{{$feature->features_name}}</label>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="selectedTabsRw d-flex flex-wrap align-items-center" id="selected_features">
                                                        @if(count($hotel_features)>0)
                                                            @foreach ($hotel_features as $hotel_feature)
                                                            <p class="selectchip"  data-fi="{{$hotel_feature->features_id}}" id="feature_chip_{{$hotel_feature->features_id}}">{{$hotel_feature->features_name}}<span class="closechps delete_featuredb" data-fi="{{$hotel_feature->features_id}}" >×</span></p>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grayBox-w">
                                        <div class="hotemmanageFormInrcnt">
                                            <h5 class="hd5 h5">{{ __('home.hotelFacilities') }}  <span class="p2">({{ __('home.optional') }})</span></h5>
                                            <div class="row">
                                                <?php /*  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating mb-3">
                                                        <button id="selectFacilities" data-bs-toggle="dropdown" class="form-select" aria-expanded="false"></button>
                                                        <ul class="dropdown-menu dropdown-menu-start">
                                                            @foreach ($facilities as $facilitie)
                                                            <li class="radiobox-image">
                                                                <input type="radio" id="facility_{{$facilitie->id}}" name="facilities" value="{{$facilitie->id}}" data-t="{{ csrf_token() }}" class="select_facilities" data-h="{{$hotel->hotel_id}}" />
                                                                <label for="facility_{{$facilitie->id}}">{{$facilitie->facilities_name}}</label>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                        <label for="selectFacilities" class="label">Select Facilities</label>
                                                    </div>
                                                </div> */ ?>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating mb-3 multiselectDropdownField">
                                                        <input id="selectFacilities" name="select_facilities" value="" data-bs-toggle="dropdown" class="form-select" placeholder="Select Facilities" autocomplete="off" />
                                                        <ul class="dropdown-menu dropdown-menu-start">
                                                            @foreach ($facilities as $facilitie)
                                                            <li class="radiobox-image">
                                                                <input type="checkbox" id="facility_{{$facilitie->id}}" name="facilities[]" data-n="{{$facilitie->facilities_name}}" value="{{$facilitie->id}}"  class="select_facilities_chk"  {{ (in_array($facilitie->id, $facilities_ids))?'checked':''; }} />
                                                                <label for="facility_{{$facilitie->id}}">{{$facilitie->facilities_name}}</label>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="selectedTabsRw d-flex flex-wrap align-items-center" id="selected_facilities">
                                                        @foreach ($hotel_facilities as $hotel_facilitie)
                                                            <p class="selectchip "  data-fi="{{$hotel_facilitie->facilities_id}}" id="facilitie_chip_{{$hotel_facilitie->facilities_id}}">{{$hotel_facilitie->facilities_name}}<span class="closechps delete_facilitiedb" data-fi="{{$hotel_facilitie->facilities_id}}" >×</span></p>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="res-sub-btn-rw d-flex justify-content-end align-items-center pl-2">
                                   <a href="{{route('hm_policies',$hotel->hotel_id)}}" class="btn-back btnPrevious">Back</a>
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
    //  $(document).ready(function () { $('.ckeditor').ckeditor(); });
    $('#selectFacilities').val('');
    $('#selectFeatures').val('');
    setTimeout(function() {
        $('#selectFacilities').val('');
        $('#selectFeatures').val('');
    }, 250);
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
        /* $newFeatureCounter =1;
        $(document).on('click','.select_features_chk',function(){
            $("#selected_features").prepend('<p class="selectchip delete_feature_new" id="new_feature_chip_'+$newFeatureCounter+'">'+$newFeatureCounter+'<span class="closechps">×</span></p>');
            $newFeatureCounter++;
        }); */     
        //  check/uncheck feature 
        $(document).on('click','.select_features_chk',function(){
            val = $(this).val(); 
            name = $(this).attr('data-n'); 
            if($(this).prop("checked") == true)
            {
                $("#selected_features").prepend(' <p class="selectchip"  data-fi="'+val+'" id="feature_chip_'+val+'">'+name+'<span class="closechps delete_feature_tmp" data-fi="'+val+'">×</span></p>');
            }     // console.log(val);
            else    
               { $("#feature_chip_"+val).remove(); $('#features_'+val).prop('checked', false); } 
               // console.log('else '+val);
        });
        // remove feature 
        $(document).on('click','.delete_feature_tmp',function(){
            val = $(this).attr('data-fi'); 
            console.log(val);
            console.log("#rmfeature_chip_"+val);
            $("#feature_chip_"+val).remove();
            $('#features_'+val).prop('checked', false); 
        });
        //  check/uncheck fa 
        $(document).on('click','.select_facilities_chk',function(){
            val = $(this).val(); 
            name = $(this).attr('data-n'); 
            if($(this).prop("checked") == true)
            {
                $("#selected_facilities").prepend('<p class="selectchip "  data-fi="'+val+'" id="facilitie_chip_'+val+'">'+name+'<span class="closechps delete_facilitie_tmp" data-fi="'+val+'" >×</span></p>');
            }     // console.log(val);
            else    
               { $("#facilitie_chip_"+val).remove(); $('#facility_'+val).prop('checked', false); } 
               // console.log('else '+val);
        });
        // remove rmfacilitie 
        $(document).on('click','.delete_facilitie_tmp',function(){
            val = $(this).attr('data-fi'); 
            // console.log(val);
            // console.log("#rmfacilitie_chip_"+val);
            $("#facilitie_chip_"+val).remove();
            $('#facility_'+val).prop('checked', false); 
        });
            // Select Features
            $(document).on('click','.select_features',function(){
                // console.log('.select_features');
                var t = $(this).attr('data-t');  
                var h = $(this).attr('data-h');  
                var id = $(this).val();
                // console.log(h);
                // console.log(t);
                // console.log(id);
                $("#select_features").prop("disabled",true); 
                   loading();
                $.post("{{ route('select_features') }}",{i:id,_token:t,h:h}, function(data){
                        if(data.status==1)
                        {
                            $("#selected_features").prepend(data.chip);
                            $("#select_features").prop("disabled",false); 
                            unloading();
                        }
                        else
                        {
                            $("#select_features").prop("disabled",false); 
                            unloading();
                        } 
                });
            });
            //_________________________________________________
            // Delete Features
            $(document).on('click','.delete_featuredb',function(){
                //  $(this).hide();
                var t = "{{ csrf_token() }}"; //$(this).attr('data-t');  
                var h = "{{ $hotel->hotel_id }}"; //$(this).attr('data-h');  
                var id = $(this).attr('data-fi');
                $(".delete_feature").prop("disabled",true); 
                   loading();
                $.post("{{ route('delete_feature') }}",{fi:id,_token:t,h:h}, function(data){
                        if(data.status==1)
                        {
                            $("#feature_chip_"+id).hide(); 
                            $('#features_'+id).prop('checked', false);
                            $(".delete_feature").prop("disabled",false); 
                            unloading(); 
                        }
                        else
                        {
                            $(".delete_feature").prop("disabled",false); 
                            unloading();
                        } 
                });   
            });
            // Select Features
            $(document).on('click','.select_facilities',function(){
                // console.log('.select_features');
                var t = "{{ csrf_token() }}"; // $(this).attr('data-t');  
                var h = "{{ $hotel->hotel_id }}"; // $(this).attr('data-h');  
                var id = $(this).val();
                // console.log(h);
                // console.log(t);
                // console.log(id);
                $(".select_facilities").prop("disabled",true); 
                   loading();
                $.post("{{ route('select_facilities') }}",{i:id,_token:t,h:h}, function(data){
                         if(data.status==1)
                        {
                            $("#selected_facilities").prepend(data.chip);
                            $(".select_facilities").prop("disabled",false); 
                            unloading();
                        }
                        else
                        {
                            $(".select_facilities").prop("disabled",false); 
                            unloading();
                        }  
                });
            });
            //_________________________________________________
            // Delete Facilitie
            $(document).on('click','.delete_facilitiedb',function(){
                // $(this).hide(); 
                // console.log('.select_features');
                var t = "{{ csrf_token() }}"; // $(this).attr('data-t');  
                var h = "{{ $hotel->hotel_id }}";  // $(this).attr('data-h');  
                var id = $(this).attr('data-fi');
                // console.log(h);
                // console.log(t);
                // console.log(id);
                $(".delete_facilitiedb").prop("disabled",true); 
                   loading();
                $.post("{{ route('delete_facilitie') }}",{fi:id,_token:t,h:h}, function(data){
                        if(data.status==1)
                        {
                            $("#facilitie_chip_"+id).hide(); 
                            $('#facility_'+id).prop('checked', false);
                            $("#commonSuccessMsg").text(data.message);
                            $("#commonSuccessBox").css('display','block');
                            $(".delete_facilitiedb").prop("disabled",false); 
                            setTimeout(function() {
                                $("#commonSuccessBox").hide();
                            }, 1500);
                            unloading();
                        }
                        else
                        {
                            $(".delete_facilitiedb").prop("disabled",false);
                            $("#commonErrorMsg").text(data.message);
                            $("#commonErrorBox").css('display','block');
                            setTimeout(function() {
                                $("#commonErrorBox").hide();
                            }, 1500); 
                            unloading(); 
                        } 
                });
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
            let formdata = $( "#hm_feNfa_form" ).serialize();
            if(token)
            {
                $(".form_submit").prop("disabled",true); 
                loading();
                $.post("{{ route('hm_feNfa_submit') }}",  formdata, function( data ) {
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
    });
</script>
@endsection       