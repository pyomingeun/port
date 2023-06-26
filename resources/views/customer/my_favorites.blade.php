@extends('frontend.layout.head')
@section('body-content')
@include('customer.header')
    <!-- include left bar here -->
    @include('customer.leftbar')
        <div class="content-box-right my-rewards-sec">
            <div class="container-fluid">
                @if(count($hoteles) >0 )
                <div class="row">
                    @foreach ($hoteles as $hotel)
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-4 col-md-12 col-sm-4 col-12 productListCardCol">
                        <div class="productListCard" id="favoriteBox_{{ $hotel->hotel_id }}">
                            <div class="productListImg-block">
                                <div class="overlay"></div>
                                <a href="{{route('hotel-detail', $hotel->slug)}}" class="product-a">
                                    <img src="{{asset('/hotel_images/')}}/{{ $hotel->featured_img }}"
                                    onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';"
                                    alt="" class="productListImg cursor-pointer">
                                </a>
                                <div class="onlist-rat-review d-flex align">
                                    <span class="rat-chips"><i class="fa fa-star" aria-hidden="true"></i> {{ $hotel->rating; }}</span>
                                    <span class="p2 mb-0">{{ $hotel->reviews; }} {{ __('home.Reviews') }}</span>
                                </div>
                                <div class="favoritlsstbock always-filed">
                                    <!-- <img src="{{asset('/assets/images/')}}/structure/heart-outline.svg" alt="" class="heart-outline"> -->
                                    <img src="{{asset('/assets/images/')}}/structure/heart-fill.svg" alt="" class="heart-fill markunmarkfavorite cursor-pointer" data-h="{{ $hotel->hotel_id }}">
                                </div>
                            </div>
                            <div class="productListDetail">
                                <a href="{{route('hotel-detail', $hotel->slug)}}" class="product-a">
                                    <!-- <h6 class="h6 mb-2">$200 <small class="pelTm">/per night</small></h6> -->
                                    <h5 class="mb-2 cursor-pointer">{{ $hotel->hotel_name; }}</h5>
                                    <p class="p2 mb-3">{{ $hotel->street }}{{ ($hotel->city !='' && $hotel->street !='')?', ':''; }} {{ $hotel->city }}{{ ($hotel->city !='' && $hotel->subrub !='')?', ':''; }}{{ $hotel->subrub  }} {{ ($hotel->pincode !='')?' - ':''; }}{{ $hotel->pincode }}</p>
                                    <div class="productLstFtr flex-wrap d-flex">
                                        @if(isset($hotel->facilities[0]->facilities_name) )
                                        <span class="chips chips-gray h-24">{{ $hotel->facilities[0]->facilities_name }}</span>
                                        @endif
                                        @if(isset($hotel->features[0]->features_name) )
                                        <span class="chips chips-gray h-24">{{ $hotel->features[0]->features_name }}</span>
                                        @endif
                                        @if((count($hotel->facilities)+ count($hotel->features)) > 2)
                                        <span class="chips chips-gray h-24">+ {{ (count($hotel->facilities) + count($hotel->features)) - 2   }} </span>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-9 col-sm-12 col-12 mx-auto empty-list-box text-center">
                        <img src="{{asset('/assets/images/')}}/structure/favorite-empty-img.png" alt="" class="empty-list-image">
                        <h6>{{ __('home.Yourfavoritelistisempty') }}</h6>
                        <p class="p3">{{ __('home.SavehotelsthatyoulikeinyourfavoritelistReviewthemeasilybookthem') }}</p>
                    </div>
                </div>
            @endif    
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
        // mark/unmark favorite    
        $(document).on('click','.markunmarkfavorite',function(){
            // delNTA
            var h = $(this).attr('data-h');
            $.post("{{ route('markunmarkfavorite') }}",{_token:"{{ csrf_token() }}",h:h}, function(data){
                if(data.status==1)
                {
                    // if(data.markstatus =='marked')
                    // { 
                    //     $("#markunmarkfavoriteicon").attr('src', "{{ asset('/assets/images/') }}/structure/heart-fill.svg"); 
                    // }
                    // else
                    // {
                    //     $('#markunmarkfavoriteicon').attr('src', "{{ asset('/assets/images/') }}/structure/heart-outline.svg");
                    // }
                    /* $('#favoriteBox_'+h).remove();
                    $("#commonSuccessMsg").text(data.message);
                    $("#commonSuccessBox").css('display','block');
                    setTimeout(function() {
                        $("#commonSuccessBox").hide();
                    }, 3000);*/ 
                    unloading();
                    location.reload();
                }
                else
                {
                    unloading();
                    $("#commonErrorMsg").text(data.message);
                    $("#commonErrorBox").css('display','block');
                    setTimeout(function() {
                        $("#commonErrorBox").hide();
                    }, 3000);
                }
            });
        });
        //__________________
    });
</script>
@endsection