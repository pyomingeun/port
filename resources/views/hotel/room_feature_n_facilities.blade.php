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
                    <!-- Room stepbar open -->
                    @include('hotel.room_stepbar')
                    <!-- room stepbar close -->
                    <div class="hotel-management-right-col">
                        <div class="tab-content stepsContent">
                            <div>
                                <form action="javaScript:Void(0);" method="post" id="room_fnf_form">
                                <div class="roomsManageform-Content">
                                    <div class="grayBox-w">
                                        <div class="hotelmanageFormInrcnt RoomFeaturesFacilitiesBox">
                                            <h5 class="hd5 h5">{{ __('home.Room') }} {{ __('home.Amenities') }}</h5>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating mb-3 multiselectDropdownField">
                                                        <input id="selectFeatures" type="text" name="select_features"  value=""  data-bs-toggle="dropdown" class="form-select" placeholder="{{ __('home.SelectAmenity') }}" autocomplete="off" readonly />
                                                        <ul class="dropdown-menu dropdown-menu-start">
                                                            @foreach ($hotel_features as $feature)
                                                            <li class="radiobox-image">
                                                                <input type="checkbox" id="rmfeatures_{{$feature->features_id}}" name="features[]" value="{{$feature->features_id}}" data-n="{{$feature->feature_name}}"  class="rmselect_features_chk" {{ (in_array($feature->features_id, $features_ids))?'checked':''; }} />
                                                                <label for="rmfeatures_{{$feature->features_id}}">{{$feature->feature_name}}</label>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="selectedTabsRw d-flex flex-wrap align-items-center" id="selected_room_features">
                                                        @if( isset($room_features) && count($room_features)>0)
                                                            @foreach ($room_features as $room_feature)
                                                            <p class="selectchip" data-r="{{$room_feature->room_id}}" data-r="{{$room_feature->id}}" id="rmfeature_chip_{{$room_feature->features_id}}" data-f="{{$room_feature->features_id}}">{{$room_feature->feature_name}}<span class="closechps delete_rmfeature" data-f="{{$room_feature->features_id}}">×</span></p>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grayBox-w">
                                        <div class="hotelmanageFormInrcnt RoomFeaturesFacilitiesBox">
                                            <h5 class="hd5 h5">{{ __('home.Room') }} {{ __('home.Facility') }}</h5>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-floating mb-3 multiselectDropdownField">
                                                        <input id="selectFacilities" type="text" name="select_facilities" value="" data-bs-toggle="dropdown" class="form-select gray-color-inputvalue" placeholder="{{ __('home.SelectFacility') }}" autocomplete="off" readonly />
                                                        <ul class="dropdown-menu dropdown-menu-start">
                                                            @foreach ($room_facilities as $facility)
                                                            <li class="radiobox-image">
                                                                <input type="checkbox" id="rmfacility_{{$facility->facilities_id}}" name="facility[]" value="{{$facility->facilities_id}}"  class="rmselect_facilities_chk"  data-n="{{ $facility->facilities_name }}" {{ (in_array($facility->facilities_id, $facilities_ids))?'checked':''; }} />
                                                                <label for="rmfacility_{{$facility->facilities_id}}">{{$facility->facility_name}}</label>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="selectedTabsRw d-flex flex-wrap align-items-center" id="selected_rmfacilitie">
                                                        @if(isset($room_facilities) && count($room_facilities)>0)
                                                            @foreach ($room_facilities as $room_facilitie)
                                                            <p class="selectchip " data-r="{{$room_facilitie->room_id}}" data-r="{{$room_facilitie->id}}" id="rmfacilitie_chip_{{$room_facilitie->facilities_id}}" data-f="{{$room_facilitie->facilities_id}}">{{$room_facilitie->facilities_name}}<span class="closechps delete_rmfacilitie" data-f="{{$room_facilitie->facilities_id}}">×</span></p>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="res-sub-btn-rw d-flex">
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                                    <input type="hidden" value="next" name="savetype" id="savetype">
                                    <input type="hidden" value="{{$slug}}" name="slug" id="slug">
                                    <a href="{{route('room_beds_info',$slug )}}" class="btn-back btnPrevious">Back</a>
                                    <a class="btn bg-gray1" href="{{ route('rooms') }}">Cancel</a>
                                    <button class="btn outline-blue form_submit" type="button" data-btntype="save_n_exit" >Save & Exit</button>
                                    <button class="btn btnNext tab3  form_submit" type="button" data-btntype="next">Next</button>
                                </div>
                                <form>
                            </div>
                        </div>
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
    $(document).ready(function(){
        /* $('#selectFacilities').val('');
        $('#selectFeatures').val('');
        setTimeout(function() {
            $('#selectFacilities').val('Select Facilities');
            $('#selectFeatures').val('');
        }, 500);*/
        /* $(document).on('click','#selectFacilities',function(){
            $('#selectFacilities').val('');
            $('#selectFacilities').removeClass('gray-color-inputvalue');
            $("#selectFacilities").attr("autocomplete", "off");
        }); */
        $(document).on('click','.form_submit',function(){
            $('#savetype').val($(this).attr('data-btntype'));
            form_submit();
        });
        //  check/uncheck feature 
        $(document).on('click','.rmselect_features_chk',function(){
            val = $(this).val(); 
            name = $(this).attr('data-n'); 
            if($(this).prop("checked") == true)
            {
                $("#selected_room_features").prepend('<p class="selectchip"  id="rmfeature_chip_'+val+'" data-f="'+val+'">'+name+'<span class="closechps delete_rmfeature" data-f="'+val+'">×</span></p>');
            }     // console.log(val);
            else    
               { $("#rmfeature_chip_"+val).remove(); $('#rmfeatures_'+val).prop('checked', false); } 
               // console.log('else '+val);
        });
        // remove feature 
        $(document).on('click','.delete_rmfeature',function(){
            val = $(this).attr('data-f'); 
            console.log(val);
            console.log("#rmfeature_chip_"+val);
            $("#rmfeature_chip_"+val).remove();
            $('#rmfeatures_'+val).prop('checked', false); 
        });
        //  check/uncheck fa 
        $(document).on('click','.rmselect_facilities_chk',function(){
            val = $(this).val(); 
            name = $(this).attr('data-n'); 
            if($(this).prop("checked") == true)
            {
                $("#selected_rmfacilitie").prepend('<p class="selectchip " id="rmfacilitie_chip_'+val+'" data-f="'+val+'">'+name+'<span class="closechps delete_rmfacilitie" data-f="'+val+'">×</span></p>');
            }     // console.log(val);
            else    
               { $("#rmfacilitie_chip_"+val).remove(); $('#rmfacility_'+val).prop('checked', false); } 
               // console.log('else '+val);
        });
        // remove rmfacilitie 
        $(document).on('click','.delete_rmfacilitie',function(){
            val = $(this).attr('data-f'); 
            // console.log(val);
            // console.log("#rmfacilitie_chip_"+val);
            $("#rmfacilitie_chip_"+val).remove();
            $('#rmfacility_'+val).prop('checked', false); 
        });
        function form_submit()
        { 
            var token=true; 
            if(token)
            {
                $(".form_submit").prop("disabled",true); 
                loading();
                let formdata = $( "#room_fnf_form" ).serialize();
                $.post("{{ route('room_features_n_facilities_submit') }}", formdata, function( data ) {
                    if(data.status==1){
                        window.location.href = data.nextpageurl; 
                        unloading();
                    } 
                    else
                    {
                        $(".form_submit").prop("disabled",false); 
                    }                           
                    unloading();
                });             
            }
        }
    });
</script>
@endsection