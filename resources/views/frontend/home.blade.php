@extends('frontend.layout.head')
@section('body-content')
@include('frontend.layout.header')
<script>
    const currentPage = 'home'; // Set the current page to 'home'
</script>

  <section class="home-sec1">
    <div style="position: relative;">
      <div class="overlay "></div>
      <div class=" homebannerslider ">
        <div class="banner-slide "><img src="{{ asset('/assets/images/structure/home-slide-img1.png') }}" class="bannerImage" alt="Banner Image"></div>
        <div class="banner-slide "><img src="{{ asset('/assets/images/structure/home-slide-img1.png') }}" class="bannerImage" alt="Banner Image"></div>
        <div class="banner-slide "><img src="{{ asset('/assets/images/structure/home-slide-img1.png') }}" class="bannerImage" alt="Banner Image"></div>
        <div class="banner-slide "><img src="{{ asset('/assets/images/structure/home-slide-img1.png') }}" class="bannerImage" alt="Banner Image"></div>
        <div class="banner-slide "><img src="{{ asset('/assets/images/structure/home-slide-img1.png') }}" class="bannerImage" alt="Banner Image"></div>
        <div class="banner-slide "><img src="{{ asset('/assets/images/structure/home-slide-img1.png') }}" class="bannerImage" alt="Banner Image"></div>
      </div>
      <div class="home-banner-cont">
        <h1 class="h1 mb-3">{{ __('home.AtTraveledge') }}</h1>
        <p class="p1 mb-0">{{ __('home.UnforgetableExperience') }}</p>
      </div>
    </div>
    <div class="container bannerSearchContainer">
      <div class="row">
        <div class="col-xl-11 col-lg-11 col-md-12 col-sm-12 col-12 mx-auto">          
          @php
            $hotelName = null;                        
          @endphp
          <x-search-hotel-form :hotelName="$hotelName" />
        </div>
      </div>
    </div>
  </section>
  <section class="home-sec2">
    <div class="container">
      <div class="headingRw">
        <h1 class="h1 heading1 d-flex align-items-center"> {{ __('home.EditorPick') }} </h1>
      </div>
      <div class="row">
        <div class="col-xl-11 col-ld-11 col-md-11 col-sm-12 col-12">
          <div class="editorPickslider sliderArrow">
            @foreach ($editorsHotels as $hotel)
            <div class="editorPickslides">
              <div class="productListCard">
                <div class="productListImg-block">
                  <a href="{{route('hotel-detail', ['slug' => $hotel->slug, 'identifier' => 'recommended']) }}" class="d-block">
                    <img src="{{asset('/hotel_images/')}}/{{ $hotel->featured_img }}" onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';" alt="" class="productListImg">
                    <div class="onlist-rat-review d-flex align">
                      @if ($hotel->reviews > 0)
                        <span class="rat-chips"><i class="fa fa-star" aria-hidden="true"></i> {{ $hotel->rating }}</span>
                        <span class="p2 mb-0">{{ $hotel->reviews }} {{ __('home.Reviews') }}</span>
                      @else
                        <span class="p2 mb-0">아직 등록된 리뷰가 없습니다.</span>
                      @endif
                    </div>
                  </a>
                </div>
                <a href="{{route('hotel-detail', ['slug' => $hotel->slug, 'identifier' => 'recommended']) }}" class="productListDetail">
                  <h6 class="h6 mb-2">₩ {{($hotel->room_price !='')?number_format($hotel->room_price):0;}} <small class="pelTm">/{{ __('home.perNight') }}</small></h6>
                  <h5 class="mb-2">{{ $hotel->hotel_name; }}</h5> 
                  <p class="p2 mb-3">{{ $hotel->sido }}, {{ $hotel->sigungu }} </p>
                 <div class="productLstFtr flex-wrap d-flex">
                    @if(isset($hotel->features[0]->features_name) )
                    <span class="chips chips-gray h-24">{{ $hotel->features[0]->features_name }}</span>
                    @endif
                    @if((count($hotel->features)) > 3)
                    <span class="chips chips-gray h-24">+ {{ (count($hotel->facilities) + count($hotel->features)) - 3   }} </span>
                    @endif
                </div>
              </a>
              </div>
            </div>
            @endforeach            
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="home-sec3">
    <div class="container">
      <div class="headingRw">
        <h1 class="h1 heading1"> {{ __('home.TopRatedHotels') }}</h1>
      </div>
      <div class="row">
        @foreach($topRatedHotels as $topRatedHotel)
        <div class="col-xl-3 col-ld-3 col-md-4 col-sm-4 col-12">
          <a href="{{route('hotel-detail', ['slug' => $topRatedHotel->slug, 'identifier' => 'top-rated']) }}">
            <div class="ratedHotelBox">
              <div class="ratedHotelImageBox">
                <img src="{{ asset('/hotel_images/'.$topRatedHotel->featured_img); }}" onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';" class="ratedHotelImage" alt=""/>
              </div>
              <div class="ratedHotelDeatilBox">
                <h6 class="h6">{{ $topRatedHotel->hotel_name }}</h6>
                <p class="p3 d-flex align-items-center">
                  @if ($topRatedHotel->reviews > 0)
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <span class="rate-span"> {{ $topRatedHotel->rating }} </span> |
                    <span class="review-span"> {{ $topRatedHotel->reviews }} {{ __('home.Reviews') }} </span>
                  @else
                    <span class="p2 mb-0">아직 등록된 리뷰가 없습니다.</span>
                  @endif
                </p>
              </div>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  @if (count(getTopEvent()) > 0)
  <section class="home-sec4">
    <img src="{{ asset('/assets/images/structure/leave-bg-img.png') }}" alt="" class="leave-bg-img-right">
    <div class="container">
      <div class="row">
        <div class="col-xl-9 col-ld-9 col-md-9 col-sm-9 col-12">
          <div class="headingRw">
            <h1 class="h1 heading1 mb-3">{{ __('home.Explore') }} <br> {{ __('home.HotelEvents') }} </h1>
            <p class="p1 mb-3">{{ __('home.HotelEventstextbelow') }}</p>
          </div>
        </div>
        <div class="col-xl-3 col-ld-3 col-md-3 col-sm-3 col-12"></div>
        <div class="col-xl-12 col-ld-12 col-md-12 col-sm-12 col-12">
          <h4>
            <a href="{{ route('see-all-post', 'events') }}" style="float: right; text-decoration: underline">{{ __('home.SeeAll') }}</a>
          </h4>
        </div>
      </div>
      <div class="hotelEventSlider sliderArrow">
        @foreach (getTopEvent() as $item)
        <diV class="hotelEventSlides">
          <a href="{{ route('event-detail', $item->slug) }}">
            <div class="hotelEventBox">
              <img src="{{ asset($item->image) }}" alt=""
                onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';"
                class="hotelEventImage"/>
              <div class="hotelEventTxt">
                <p class="p1 mb-0">{{ $item->title }}</p>
              </div>
            </div>
          </a>
        </diV>
        @endforeach
      </div>
    </div>
    <img src="{{ asset('/assets/images/structure/leave-bg-img1.png') }}" alt="" class="leave-bg-img-left"/>
  </section>
  @endif
  <section class="home-sec5">
    <div class="container">
      <div class="register-now-boxhome-sec5 text-center">
        <div class="row">
          <div class="col-xl-8 col-ld-8 col-md-12 col-sm-12 col-12 mx-auto">
            <h1 class="h1">{{ __('home.Dontmissthediscountifyouregistertoday') }}</h1>
            <p class="p1">{{ __('home.Letsspendyoursomemoneyandremoveyour') }}</p>
            <button class="btn bg-blue">{{ __('home.RegisterNow') }}</button>
          </div>
        </div>
      </div>
    </div>
  </section>
  @if (count(getTopMagazine()) > 0)
  <section class="home-sec6">
    <div class="container">
      <div class="headingRw text-center">
        <h1 class="h1 heading1 mb-3">{{ __('home.ExploreMagazine') }} </h1>
        <p class="p1">{{ __('home.ExploreMagazinetextbelow') }}</p>
      </div>
      <div class="row">
        <div class="col-xl-12 col-ld-12 col-md-12 col-sm-12 col-12">
          <h4>
            <a href="{{ route('see-all-post', 'magazine') }}" style="float: right; text-decoration: underline">See All</a>
          </h4>
        </div>
        <div class="col-xl-12 col-ld-12 col-md-12 col-sm-12 col-12">
          <div class="exploreMagazineSlider sliderArrow">
            @foreach (getTopMagazine() as $item)
            <div class="exploreMagazineSlides">
              <a href="{{ route('magazine-detail', $item->slug) }}">
                <div class="exploreMagazineBox">
                  <div class="exploreMagazineImageBox">
                    <img src="{{ asset($item->image) }}" alt=""
                      onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';"
                      class="exploreMagazineImage"/>
                  </div>
                  <h5 class="h5">{{ $item->title }}</h5>
                  <p class="p2">{{ __('home.ExploreMagazinedescpone') }}</p>
                </div>
              </a>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>
  @endif
  <!-- newsletter -->
  @include('frontend.layout.newsletter')
  <!-- footer -->
  @include('frontend.layout.footer')
  <!-- common models -->
  @include('common_models')
  @include('frontend.layout.footer_script')
@endsection
@section('page-js-include')
@endsection
<!-- JS section  -->
@section('js-script')
@endsection
