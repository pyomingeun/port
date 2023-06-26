@extends('frontend.layout.head')
@section('body-content')
  @include('frontend.layout.header')
  <div class="main-wrapper">
  	<section class="event-detail-sec1">
  	  <div class="container">
  	    <nav aria-label="breadcrumb" class="breadcrumbNave">
  	      <ol class="breadcrumb">
  	        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('home.home') }}</a></li>
  	        <li class="breadcrumb-item active" aria-current="page">
                {{ $type == 'magazine'? 'Magazines' : 'Events' }}
            </li>
  	      </ol>
  	    </nav>
      </div>
    </section>
    <section class="event-detail-sec2">
      <div class="container event-detail-content">
        <h1 class="h1">{{ $type == 'magazine'? 'Magazines' : 'Events' }}</h1>
				<div class="row">
					@foreach ($posts as $post)
					<div class="col-xl-3 col-ld-3 col-md-4 col-sm-4 col-12">
						<a href="{{ route($type == 'magazine'?'magazine-detail': 'event-detail', $post->slug) }}">
							<div class="ratedHotelBox">
								<div class="ratedHotelImageBox">
									<img src="{{ asset($post->image) }}" alt="" class="ratedHotelImage">
								</div>
								<div class="ratedHotelDeatilBox">
									<h6 class="h6">{{ $post->title }}</h6>
									{{-- <p class="p3 d-flex align-items-center">
										<i class="fa fa-star" aria-hidden="true"></i>
										<span class="rate-span">4</span> | <span class="review-span">120 {{ __('home.Reviews') }}</span>
									</p> --}}
								</div>
							</div>
						</a>
					</div>
					@endforeach
					{{ $posts->links('pagination::bootstrap-4') }}
      	</div>
			</div>
    </section>
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
