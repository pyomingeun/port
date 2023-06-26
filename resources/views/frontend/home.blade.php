@extends('frontend.layout.head')
@section('body-content')
  @include('frontend.layout.header')
  <section class="home-sec1">
    <div style="position: relative;">
      <div class="overlay "></div>
      <div class=" homebannerslider ">
        <div class="banner-slide ">
          <img src="{{ asset('/assets/images/structure/home-slide-img1.png') }}" class="bannerImage" alt="Banner Image">
        </div>
        <div class="banner-slide ">
          <img src="{{ asset('/assets/images/structure/home-slide-img2.png') }}" class="bannerImage" alt="Banner Image">
        </div>
        <div class="banner-slide ">
          <img src="{{ asset('/assets/images/structure/home-slide-img1.png') }}" class="bannerImage" alt="Banner Image">
        </div>
        <div class="banner-slide ">
          <img src="{{ asset('/assets/images/structure/home-slide-img1.png') }}" class="bannerImage" alt="Banner Image">
        </div>
        <div class="banner-slide ">
          <img src="{{ asset('/assets/images/structure/home-slide-img1.png') }}" class="bannerImage" alt="Banner Image">
        </div>
        <div class="banner-slide ">
          <img src="{{ asset('/assets/images/structure/home-slide-img1.png') }}" class="bannerImage" alt="Banner Image">
        </div>
      </div>
      <div class="home-banner-cont">
        <h1 class="h1 mb-3">{{ __('home.DiscoverBook') }}</h1>
        <p class="p1 mb-0">{{ __('home.DiscoverBookTextBelow') }}</p>
      </div>
    </div>
    <div class="container bannerSearchContainer">
      <div class="row">
        <div class="col-xl-11 col-lg-11 col-md-12 col-sm-12 col-12 mx-auto">
          <x-search-hotel-form />
        </div>
      </div>
    </div>
  </section>
  <section class="home-sec2">
    <div class="container">
      <div class="row">
        <div class="col-xl-9 col-ld-9 col-md-9 col-sm-9 col-12">
          <div class="headingRw">
            <h1 class="h1 heading1 d-flex align-items-center">
              <img src="{{ asset('/assets/images/structure/hd-icon1.svg') }}" alt="Editor Pick" class="hd-icon">
              {{ __('home.editorPick') }}
            </h1>
            <p class="p1"> {{ __('home.EditorPicktextBelow') }}</p>
          </div>
        </div>
        <div class="col-xl-3 col-ld-3 col-md-3 col-sm-3 col-12"></div>
      </div>
      <div class="row">
        <div class="col-xl-12 col-ld-12 col-md-12 col-sm-12 col-12">
          <div class="editorPickslider sliderArrow">
            @foreach ($editorsHotels as $hotel)
            <div class="editorPickslides">
              <div class="productListCard">
                <div class="productListImg-block">
                  <div class="overlay"></div>
                  <a href="{{route('hotel-detail', $hotel->slug)}}" class="d-block">
                  <img src="{{asset('/hotel_images/')}}/{{ $hotel->featured_img }}"
                    onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';"
                    alt="" class="productListImg">
                  <div class="onlist-rat-review d-flex align">
                    <span class="rat-chips"><i class="fa fa-star" aria-hidden="true"></i> {{ $hotel->rating; }}</span>
                    <span class="p2 mb-0">{{ $hotel->reviews; }} {{ __('home.Reviews') }}</span>
                  </div>
                  </a>
                  <a href="#2" class="favoritlsstbock">
                    @if(isset($hotel->is_marked_hotel) && $hotel->is_marked_hotel > 0)
                    <img src="{{ asset('/assets/images/structure/heart-fill.svg') }}" alt="" class="heart-fill">
                    @else
                    <img src="{{ asset('/assets/images/structure/heart-outline.svg') }}" alt=""
                      class="heart-outline">
                    @endif
                  </a>
                </div>
                <a href="{{route('hotel-detail', $hotel->slug)}}" class="productListDetail">
                  <h6 class="h6 mb-2">₩ {{($hotel->room_price !='')?$hotel->room_price:0;}} <small class="pelTm">/{{ __('home.perNight') }}</small></h6>
                  <h5 class="mb-2">{{ $hotel->hotel_name; }}</h5>
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
            @endforeach            
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="home-sec3">
    <div class="container">
      <div class="text-center headingRw">
        <h1 class="h1 heading1">
          <img src="{{ asset('/assets/images/structure/hd-icon2.svg') }}" alt="" class="hd-icon">
            {{ __('home.Explore') }} <br> {{ __('home.TopRatedHotels') }}
          </h1>
      </div>
      <div class="row">
        @foreach($topRatedHotels as $topRatedHotel)
        <div class="col-xl-3 col-ld-3 col-md-4 col-sm-4 col-12">
          <a href="{{route('hotel-detail', $topRatedHotel->slug)}}">
            <div class="ratedHotelBox">
              <div class="ratedHotelImageBox">
                <img src="{{ asset('/hotel_images/'.$topRatedHotel->featured_img); }}"
                onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';"
                class="ratedHotelImage" alt=""/>
              </div>
              <div class="ratedHotelDeatilBox">
                <h6 class="h6">{{ $topRatedHotel->hotel_name }}</h6>
                <p class="p3 d-flex align-items-center">
                  <i class="fa fa-star" aria-hidden="true"></i> 
                  <span class="rate-span"> {{ $topRatedHotel->rating }} </span> |
                  <span class="review-span"> {{ $topRatedHotel->reviews }} {{ __('home.Reviews') }} </span>
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
