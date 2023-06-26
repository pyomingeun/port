@extends('frontend.layout.head')
@section('body-content')
  @include('frontend.layout.header')
  <div class="main-wrapper">
  	<section class="event-detail-sec1">
  	  <div class="container">
  	    <nav aria-label="breadcrumb" class="breadcrumbNave">
  	      <ol class="breadcrumb">
  	        <li class="breadcrumb-item"><a href="{{ route('home') }}">home</a></li>
  	        <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
  	      </ol>
  	    </nav>
				<div class="topBannerBox" style="background-image: url({{ asset($post->image) }});"></div>
      </div>
    </section>
    <section class="event-detail-sec2">
      <div class="container event-detail-content">
        <h1 class="h1">{{ $post->title }}</h1>
				<div class="row">
          <div class="col-sm-12 col-12">
						{!! $post->content !!}
					</div>
				@foreach ($post->hasImages as $post_images)
				<div class="col-xl-3 col-ld-3 col-md-4 col-sm-4 col-12">
          <div class="ratedHotelBox">
            <div class="ratedHotelImageBox">
              <img src="{{ asset($post_images->image) }}" alt="" class="ratedHotelImage">
            </div>
          </div>
        </div>
				@endforeach
      	</div>
			</div>
    </section>
		@if (count($posts) > 0)
    <section class="home-sec4">
      <img src="{{ asset('/images/structure/leave-bg-img.png') }}" alt="" class="leave-bg-img-right">
      <div class="container">
        <div class="row">
          <div class="col-xl-9 col-ld-9 col-md-9 col-sm-9 col-12">
            <div class="headingRw">
              <h1 class="h1 heading1 mb-3">{{ __('home.Explore') }} <br> {{ __('home.HotelEvents') }}  </h1>
            </div>
          </div>
          <div class="col-xl-3 col-ld-3 col-md-3 col-sm-3 col-12"></div>
        </div>
        <div class="hotelEventSlider sliderArrow">
					@foreach ($posts as $post)
          <diV class="hotelEventSlides">
            <a href="{{ route('event-detail', $post->slug) }}">
              <div class="hotelEventBox">
                <img src="{{ asset($post->image) }}" alt="" class="hotelEventImage">
                <div class="hotelEventTxt">
                  <p class="p1 mb-0">{{ $post->title }}</p>
                </div>
              </div>
            </a>
          </diV>
					@endforeach
        </div>
      </div>
      <img src="{{ asset('/images/structure/leave-bg-img1.png') }}" alt="" class="leave-bg-img-left">
    </section>
		@endif
  </div>
	@include('frontend.layout.newsletter')
  @include('frontend.layout.footer')
  @include('common_models')
  @include('frontend.layout.footer_script')
@endsection
@section('page-js-include')
@endsection
<!-- JS section  -->
@section('js-script')
@endsection
