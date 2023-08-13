@extends('frontend.layout.head')
@section('body-content')
@include('frontend.layout.header')
<script>
    const currentPage = 'home'; // Set the current page to 'home'
</script>
<section class="search-bar">
  <div class="container bannerSearchContainer">
    <div class="row">
      @php
        $hotelName = null;                        
      @endphp
      <x-search-hotel-form :hotelName="$hotelName" />
    </div>
  </div>
</section>
<section class="home-sec1">
  <div id="slideControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="d-block w-100" src="https://www.stayfolio.com/_next/image?url=http%3A%2F%2F%2F%2Fimages.stayfolio.com%2Fsystem%2Fpictures%2Fimages%2F000%2F189%2F618%2Foriginal%2Fcc2f4339b81a7dc714ecfe9be1ed47ff4b0c4ac8.jpg%3F1690766999&w=1920&q=75" alt="First slide">
        <div class="carousel-caption">
          <h5>First slide label</h5>
          <p>Some representative placeholder content for the first slide.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="https://www.stayfolio.com/_next/image?url=http%3A%2F%2F%2F%2Fimages.stayfolio.com%2Fsystem%2Fpictures%2Fimages%2F000%2F189%2F599%2Foriginal%2Fe8dbf1066b38f29e02f2d956869a3c56041db8f5.jpg%3F1690539716&w=1920&q=75" alt="Second slide">
        <div class="carousel-caption">
          <h5>Second slide label</h5>
          <p>Some representative placeholder content for the second slide.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="https://www.stayfolio.com/_next/image?url=http%3A%2F%2F%2F%2Fimages.stayfolio.com%2Fsystem%2Fpictures%2Fimages%2F000%2F189%2F599%2Foriginal%2Fe8dbf1066b38f29e02f2d956869a3c56041db8f5.jpg%3F1690539716&w=1920&q=75" alt="Third slide">
        <div class="carousel-caption">
          <h5>Third slide label</h5>
          <p>Some representative placeholder content for the third slide.</p>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" type="button" data-bs-target="#slideControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" type="button" data-bs-target="#slideControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
    </a>
  </div>
</section>

<section class="home-sec2">
  <div class="container">
    <div class="headingRw" >
      <h5 class="letterspacing"> {{ __('home.EditorPick') }} </h5>
    </div>
    <div class="row">
      <div class="col-xl-12 col-ld-12 col-md-12 col-sm-12 col-12">
        <div class="editorPickslider sliderArrow">
          @foreach ($pickedHotel as $hotel)
          <div class="editorPickslides">
            <div class="productListCard">
              <div class="productListImg-block">
                <div class="overlay"></div>
                @php
                  $queryParams = Request::all();
                  $queryParams['hname'] = $hotel->hotel_name;
                @endphp
                <a href="{{ route('hotel-detail', [$hotel->slug]) . getQueryParams($queryParams) }}">
                  <img src="{{asset('/hotel_images/')}}/{{ $hotel->featured_img }}" onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';" alt="" class="productListImg">
                  <div class="onlist-rat-review d-flex align">
                    @if ($hotel->reviews > 0)
                      <span class="rat-chips"><i class="fa fa-star" aria-hidden="true"></i> {{ $hotel->rating }}</span>
                      <span class="p-r-light mb-0">{{ $hotel->reviews }} {{ __('home.Reviews') }}</span>
                    @else
                      <span class="p-r-light mb-0" style="color:#fff">{{ __('home.NoReview') }}</span>
                    @endif
                  </div>
                </a>
              </div>
              <a href="{{route('hotel-detail', ['slug' => $hotel->slug, 'identifier' => 'recommended']) }}" class="productListDetail">
                <p class="p-l-regular mb-2" style="text-align: center;">{{ $hotel->hotel_name; }}</p> 
                <div class="p-container d-flex justify-content-center">
                  <p class="p-s-light mb-2" style="display: inline-block; ">{{ $hotel->sido }} / {{ $hotel->sigungu }} , </p>
                  <p class="p-s-light mb-2" style="display: inline-block; ">₩ {{ ($hotel->min_room_price != '') ? number_format($hotel->min_room_price) : 0 }}~</p>
                  <p class="p-s-light mb-2" style="display: inline-block; ">₩ {{ ($hotel->max_room_price != '') ? number_format($hotel->max_room_price) : 0 }}</p>
                </div>
                <div class="productLstFtr flex-wrap d-flex">
                  @if(isset($hotel->features[0]->feature_name) )
                    <span class="chips chips-gray h-24">{{ $hotel->features[0]->feature_name }}</span>
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
    <div class="headingRw" >
      <h5 class="letterspacing"> {{ __('home.TopRatedHotels') }} </h5>
    </div>
    <div class="row">
      <div class="col-xl-12 col-ld-12 col-md-12 col-sm-12 col-12">
        <div class="editorPickslider sliderArrow">
          @foreach ($topRatedHotel as $tophotel)
          <div class="editorPickslides">
            <div class="productListCard">
              <div class="productListImg-block">
                <div class="overlay"></div>
                @php
                  $queryParams = Request::all();
                  $queryParams['hname'] = $tophotel->hotel_name;
                @endphp
                <a href="{{ route('hotel-detail', [$hotel->slug]) . getQueryParams($queryParams) }}">
                  <img src="{{asset('/hotel_images/')}}/{{ $hotel->featured_img }}" onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';" alt="" class="productListImg">
                  <div class="onlist-rat-review d-flex align">
                    @if ($hotel->reviews > 0)
                      <span class="rat-chips"><i class="fa fa-star" aria-hidden="true"></i> {{ $tophotel->rating }}</span>
                      <span class="p-r-light mb-0">{{ $hotel->reviews }} {{ __('home.Reviews') }}</span>
                    @else
                      <span class="p-r-light mb-0" style="color:#fff">{{ __('home.NoReview') }}</span>
                    @endif
                  </div>
                </a>
              </div>
              <a href="{{route('hotel-detail', ['slug' => $hotel->slug, 'identifier' => 'recommended']) }}" class="productListDetail">
                <p class="p-l-regular mb-2" style="text-align: center;">{{ $tophotel->hotel_name; }}</p> 
                <div class="p-container d-flex justify-content-center">
                  <p class="p-s-light mb-2" style="display: inline-block; ">{{ $tophotel->sido }} / {{ $tophotel->sigungu }} , </p>
                  <p class="p-s-light mb-2" style="display: inline-block; ">₩ {{ ($tophotel->min_room_price != '') ? number_format($tophotel->min_room_price) : 0 }}~</p>
                  <p class="p-s-light mb-2" style="display: inline-block; ">₩ {{ ($tophotel->max_room_price != '') ? number_format($tophotel->max_room_price) : 0 }}</p>
                </div>
                <div class="productLstFtr flex-wrap d-flex">
                  @if(isset($tophotel->features[0]->feature_name) )
                    <span class="chips chips-gray h-24">{{ $tophotel->features[0]->feature_name }}</span>
                  @endif
                  @if((count($tophotel->features)) > 3)
                    <span class="chips chips-gray h-24">+ {{ (count($tophotel->facilities) + count($tophotel->features)) - 3   }} </span>
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

<section class="home-sec4">
  <div class="container">
    <div class="headingRw" >
      <h5 class="letterspacing" style="text-align: left;"> EVENT </h5>
    </div>
    <div class="row">
      <div class="col-xl-12 col-ld-12 col-md-12 col-sm-12 col-12">
        <div class="editorPickslider sliderArrow">
          @foreach ($events as $event)
          <div class="editorPickslides">
            <div class="productListCard">
              <div class="productListImg-block">
                <div class="overlay"></div>

                <a href="{{ route('event-contents', [$event->id]) }}">

                  <img src="{{asset('/event_contents/')}}/{{ $event->featured_img }}"  alt="" class="productListImg">

                </a>
              </div>
              <a href="{{ route('event-contents', [$hotel->slug]) }}" class="productListDetail">
                <p class="p-l-regular mb-2" style="text-align: center;">{{ $event->event_name; }}</p> 
                <div class="p-container d-flex justify-content-center">
                  <p class="p-s-light mb-2" style="display: inline-block; ">{{ $event->start_date }} ~ {{ $event->expiry_date }} , </p>
                  <p class="p-s-light mb-2" style="display: inline-block; ">₩ {{ ($event->hotel_name) }}</p>
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

<section class="home-sec5">
<div class="headingRw" >
      <h5 class="letterspacing" style="text-align: left;"> MAGAZINE </h5>
    </div>
  <div id="slideControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      @foreach ($magazines as $magazine)
      <div class="carousel-item active">
        <img class="d-block w-100" src="{{asset('/magazine_contents/')}}/{{ $magazine->cover_img }}" alt="{{$magazine->id}}">
        <div class="carousel-caption">
          <h5>{{ $magazine->magazine_title; }}</h5> 
          <p>{{ $magazine->hotel_name; }}</p>
        </div>
      </div>
      @endforeach
    </div>
    <a class="carousel-control-prev" type="button" data-bs-target="#slideControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" type="button" data-bs-target="#slideControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
    </a>
  </div>
</section>

<section class="home-sec6">
  <div class="container">
    <div class="headingRw" >
      <h5 class="letterspacing"> FEATURED {{ __('home.SunSet') }} </h5>
    </div>
    <div class="row">
      <div class="col-xl-12 col-ld-12 col-md-12 col-sm-12 col-12">
        <div class="editorPickslider sliderArrow">
          @foreach ($featuredHotel1 as $featuredhotel)
          <div class="editorPickslides">
            <div class="productListCard">
              <div class="productListImg-block">
                <div class="overlay"></div>
                @php
                  $queryParams = Request::all();
                  $queryParams['hname'] = $featuredhotel->hotel_name;
                @endphp
                <a href="{{ route('hotel-detail', [$hotel->slug]) . getQueryParams($queryParams) }}">
                  <img src="{{asset('/hotel_images/')}}/{{ $hotel->featured_img }}" onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';" alt="" class="productListImg">
                  <div class="onlist-rat-review d-flex align">
                    @if ($featuredhotel->reviews > 0)
                      <span class="rat-chips"><i class="fa fa-star" aria-hidden="true"></i> {{ $featuredhotel->rating }}</span>
                      <span class="p-r-light mb-0">{{ $featuredhotel->reviews }} {{ __('home.Reviews') }}</span>
                    @else
                      <span class="p-r-light mb-0" style="color:#fff">{{ __('home.NoReview') }}</span>
                    @endif
                  </div>
                </a>
              </div>
              <a href="{{ route('hotel-detail', [$hotel->slug]) . getQueryParams($queryParams) }}" class="productListDetail">
                <p class="p-l-regular mb-2" style="text-align: center;">{{ $featuredhotel->hotel_name; }}</p> 
                <div class="p-container d-flex justify-content-center">
                  <p class="p-s-light mb-2" style="display: inline-block; ">{{ $featuredhotel->sido }} / {{ $featuredhotel->sigungu }} , </p>
                  <p class="p-s-light mb-2" style="display: inline-block; ">₩ {{ ($featuredhotel->min_room_price != '') ? number_format($featuredhotel->min_room_price) : 0 }}~</p>
                  <p class="p-s-light mb-2" style="display: inline-block; ">₩ {{ ($featuredhotel->max_room_price != '') ? number_format($featuredhotel->max_room_price) : 0 }}</p>
                </div>
                <div class="productLstFtr flex-wrap d-flex">
                  @if(isset($featuredhotel->features[0]->feature_name) )
                    <span class="chips chips-gray h-24">{{ $featuredhotel->features[0]->feature_name }}</span>
                  @endif
                  @if((count($featuredhotel->features)) > 3)
                    <span class="chips chips-gray h-24">+ {{ (count($featuredhotel->facilities) + count($featuredhotel->features)) - 3   }} </span>
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

<section class="home-sec7">
  <div class="container">
    <div class="headingRw" >
      <h5 class="letterspacing"> FEATURED {{ __('home.PetFriendly') }} </h5>
    </div>
    <div class="row">
      <div class="col-xl-12 col-ld-12 col-md-12 col-sm-12 col-12">
        <div class="editorPickslider sliderArrow">
          @foreach ($featuredHotel2 as $featuredhotel)
          <div class="editorPickslides">
            <div class="productListCard">
              <div class="productListImg-block">
                <div class="overlay"></div>
                @php
                  $queryParams = Request::all();
                  $queryParams['hname'] = $featuredhotel->hotel_name;
                @endphp
                <a href="{{ route('hotel-detail', [$hotel->slug]) . getQueryParams($queryParams) }}">
                  <img src="{{asset('/hotel_images/')}}/{{ $hotel->featured_img }}" onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';" alt="" class="productListImg">
                  <div class="onlist-rat-review d-flex align">
                    @if ($featuredhotel->reviews > 0)
                      <span class="rat-chips"><i class="fa fa-star" aria-hidden="true"></i> {{ $featuredhotel->rating }}</span>
                      <span class="p-r-light mb-0">{{ $featuredhotel->reviews }} {{ __('home.Reviews') }}</span>
                    @else
                      <span class="p-r-light mb-0" style="color:#fff">{{ __('home.NoReview') }}</span>
                    @endif
                  </div>
                </a>
              </div>
              <a href="{{ route('hotel-detail', [$hotel->slug]) . getQueryParams($queryParams) }}" class="productListDetail">
                <p class="p-l-regular mb-2" style="text-align: center;">{{ $featuredhotel->hotel_name; }}</p> 
                <div class="p-container d-flex justify-content-center">
                  <p class="p-s-light mb-2" style="display: inline-block; ">{{ $featuredhotel->sido }} / {{ $featuredhotel->sigungu }} , </p>
                  <p class="p-s-light mb-2" style="display: inline-block; ">₩ {{ ($featuredhotel->min_room_price != '') ? number_format($featuredhotel->min_room_price) : 0 }}~</p>
                  <p class="p-s-light mb-2" style="display: inline-block; ">₩ {{ ($featuredhotel->max_room_price != '') ? number_format($featuredhotel->max_room_price) : 0 }}</p>
                </div>
                <div class="productLstFtr flex-wrap d-flex">
                  @if(isset($featuredhotel->features[0]->feature_name) )
                    <span class="chips chips-gray h-24">{{ $featuredhotel->features[0]->feature_name }}</span>
                  @endif
                  @if((count($featuredhotel->features)) > 3)
                    <span class="chips chips-gray h-24">+ {{ (count($featuredhotel->facilities) + count($featuredhotel->features)) - 3   }} </span>
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
<!-- newsletter -->
@include('frontend.layout.newsletter')
<!-- footer -->
@include('frontend.layout.footer')
<!-- common models -->
@include('common_modal')
@include('frontend.layout.footer_script')
@endsection
@section('page-js-include')
@endsection
<!-- JS section  -->
@section('js-script')
@endsection
