@extends('frontend.layout.head')
@section('body-content')
  @include('frontend.layout.header')

  <section class="home-sec1 hotelilisting-bnr-sec">
    <div class="hotelilistingBanner" style="position: relative;">
      <div class="overlay"></div>
      <img src="{{ asset('assets/images/product/hotel-listing-banner.png') }}" class="bannerImage" alt=" ">
      <div class="home-banner-cont">
        <h1 class="h1 mb-3">{{ __('home.discoverBookTheBestHotel') }}</h1>
        <p class="p1 mb-0">{{ __('home.chooseFrom') }} 1000+ {{ __('home.bestHotelsAcrossTheWorld') }}</p>
      </div>
    </div>
    <div class="container bannerSearchContainer">
      <div class="row">
        <div class="col-xl-11 col-lg-12 col-md-12 col-sm-12 col-12 mx-auto">
          @php
            $hotelName = $request->has('hname') ? $request->input('hname') : null;                        
          @endphp
          <x-search-hotel-form :hotelName="$hotelName" />
        </div>
      </div>
    </div>
  </section>

  <section class="hotel-listing-sec2">
    <div class="container">
      <div class="row filter-horizontal-row">
        <div class="col-xl-6 col-ld-6 col-md-6 col-sm-6 col-12">
          <button type="button" class="btn bg-gray" data-bs-toggle="modal" data-bs-target=".sideFilterDialog"><img
              src="{{ asset('assets/images/structure/filter-alt.svg') }}" alt="" class="filter-alt">
              {{ __('home.filter') }}</button>
        </div>
        <div class="col-xl-6 col-ld-6 col-md-6 col-sm-6 col-12 d-flex flex-wrap justify-content-end align-items-center">
          <div class="form-floating mb-0 filterSortDrop">
            <img src="{{ asset('assets/images/structure/filter-sort.svg') }}" alt="" class="filter-alt">
            <button type="button" data-bs-toggle="dropdown" class="btn bg-gray form-select"> {{ __('home.sortBy') }}</button>
            <ul class="dropdown-menu dropdown-menu-start">
              <li class="radiobox-image">
                <a
                  href="{{ route('hotel-list') . getQueryParams(array_merge(Request::except(['sort']), ['sort' => 'plth'])) }}">
                  <label for="srt1">{{ __('home.Pricelowtohigh') }}</label>
                </a>
                {{-- <input type="radio" class="sort_by" id="srt1" name="sort" value="plth" /> --}}
              </li>
              <li class="radiobox-image">
                {{-- <input type="radio" class="sort_by" id="srt2" name="sort" value="phtl" /> --}}
                <a
                  href="{{ route('hotel-list') . getQueryParams(array_merge(Request::except(['sort']), ['sort' => 'phtl'])) }}">
                  <label for="srt2">{{ __('home.Pricehightolow') }}</label>
                </a>
              </li>
              <li class="radiobox-image">
                {{-- <input type="radio" class="sort_by" id="srt3" name="sort" value="rahtl" /> --}}
                <a
                  href="{{ route('hotel-list') . getQueryParams(array_merge(Request::except(['sort']), ['sort' => 'rahtl'])) }}">
                  <label for="srt3">{{ __('home.Ratinghightolow') }}</label>
                </a>
              </li>
              <li class="radiobox-image">
                {{-- <input type="radio" class="sort_by" id="srt4" name="sort" value="rvhtl" /> --}}
                <a
                  href="{{ route('hotel-list') . getQueryParams(array_merge(Request::except(['sort']), ['sort' => 'rvhtl'])) }}">
                  <label for="srt4">{{ __('home.Reviewshightolow') }}</label>
                </a>
              </li>
            </ul>
          </div>
          <div class="filterTabsBox">
            <ul class="nav nav-pills mb-0" id="pills-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <button type="button" class="nav-link active" id="tabl" data-bs-toggle="pill"
                  data-bs-target="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
                  <img src="{{ asset('assets/images/structure/filter-list-gray.svg') }}" alt=""
                    class="filterTabIcon filterTabIconGray">
                  <img src="{{ asset('assets/images/structure/filter-list-green.svg') }}" alt=""
                    class="filterTabIcon filterTabIconGreen">
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" id="tab2" data-bs-toggle="pill"
                  data-bs-target="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                  <img src="{{ asset('assets/images/structure/map-gray.svg') }}" alt=""
                    class="filterTabIcon filterTabIconGray">
                  <img src="{{ asset('assets/images/structure/map-green.svg') }}" alt=""
                    class="filterTabIcon filterTabIconGreen">
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row" id="listView">
        <div class="col-xl-12 col-ld-12 col-md-12 col-sm-12 col-12">
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="tabl">
              {{ view('frontend.subview.hotellist', ['hotels' => $hotels, 'dayofweek' => $dayofweek]) }}
              {{ $hotels->appends(Request::all())->links('pagination::bootstrap-4') }}
            </div>
          </div>
        </div>
      </div>
      <div class="row no-display" id="mapView">
        <x-google-map-pins :locations="$jsonLocations" />
      </div>
  </section>
  
  <div class="modal fade sideFilterDialog" tabindex="-1" aria-labelledby="sideFilterDialogLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-heads">
            <h4 class="h4 mb-3">{{ __('home.filter') }}</h4>
          </div>
          <form action="{{ route('hotel-list') }}">
            @foreach (Request::except(['min_price', 'max_price', 'rating', 'features', 'facilities']) as $key => $value)
              <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <div class="side-filterBody">
              <div class="rangeslider">
                <div class="row">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-floating h-40">
                      {{-- <button type="button" class="form-select"></button> --}}
                      <div style="height: 40px !important; padding: 8px 12px !important; border: 1px solid #717972; border-radius: 8px; margin-bottom:20px">
                        {{ __('home.price') }}
                      </div>
                      <div id="pmd-slider-value-range" class="pmd-range-slider"></div>
                      <div class="row">
                        <div class="range-value pricevalueleft col-sm-6">
                          <span class="priceCurrency">₩</span><span id="value-min"></span>
                          <input type="hidden" name="min_price" id="min_price"
                            value="{{ Request::get('min_price') ? Request::get('min_price') : 0 }}">
                        </div>
                        <div class="range-value pricevalueright col-sm-6">
                          <span class="priceCurrency">₩</span><span id="value-max"></span>
                          <input type="hidden" name="max_price" id="max_price"
                            value="{{ Request::get('max_price') ? Request::get('max_price') : 0 }}">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-floating h-40 checkboxDropdown">
                      <button type="button" data-bs-toggle="dropdown" class="form-select"
                        data-bs-auto-close="false">{{ __('home.rating') }}</button>
                      <input type="hidden" name="rating" id="rating"
                        value="{{ Request::get('rating') ? Request::get('rating') : '' }}">
                      @php
                        $ratingSelected = Request::get('rating') ? explode(',', Request::get('rating')) : [];
                      @endphp
                      <ul class="dropdown-menu">
                        <li class="radiobox-image">
                          <input type="checkbox" class="rating" {{ in_array('4.5', $ratingSelected) ? 'checked' : '' }}
                            value="4.5" />
                          <label for="rating1">
                            <p class="p2 mb-0">4.5 & {{ __('home.above') }} ({{ __('home.excellent') }} ) {{-- <span class="ml-auto">(20)</span> --}}</p>
                          </label>
                        </li>
                        <li class="radiobox-image">
                          <input type="checkbox" class="rating" {{ in_array('4', $ratingSelected) ? 'checked' : '' }}
                            value="4" />
                          <label for="rating2">
                            <p class="p2 mb-0">4 & {{ __('home.above') }} ({{ __('home.veryGood') }}) {{-- <span class="ml-auto">(10)</span> --}}</p>
                          </label>
                        </li>
                        <li class="radiobox-image">
                          <input type="checkbox" class="rating" {{ in_array('3', $ratingSelected) ? 'checked' : '' }}
                            value="3" />
                          <label for="rating2">
                            <p class="p2 mb-0">3 & {{ __('home.above') }} ({{ __('home.good') }}) {{-- <span class="ml-auto">(05)</span> --}}</p>
                          </label>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-floating h-40 checkboxDropdown">
                      <button type="button" data-bs-toggle="dropdown" class="form-select"
                        data-bs-auto-close="false">{{ __('home.hotelFeatures') }}</button>
                      <ul class="dropdown-menu">
                        <input type="hidden" name="features" id="features"
                          value="{{ Request::get('features') ? Request::get('features') : '' }}">
                        @php
                          $featureSelected = Request::get('features') ? explode(',', Request::get('features')) : [];
                        @endphp
                        @foreach ($features as $feature)
                          <li class="radiobox-image">
                            <input type="checkbox" class="features"
                              {{ in_array($feature->id, $featureSelected) ? 'checked' : '' }}
                              value="{{ $feature->id }}" />
                            <label for="rating1">
                              <p class="p2 mb-0">{{ $feature->features_name }} <span
                                  class="ml-auto">({{ $feature->has_hotels_count }})</span></p>
                            </label>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-floating h-40 checkboxDropdown">
                      <button type="button" data-bs-toggle="dropdown" class="form-select"
                        data-bs-auto-close="false">{{ __('home.hotelFacilities') }}</button>
                      <ul class="dropdown-menu">
                        <input type="hidden" name="facilities" id="facilities"
                          value="{{ Request::get('facilities') ? Request::get('facilities') : '' }}">
                        @php
                          $facilitySelected = Request::get('facilities') ? explode(',', Request::get('facilities')) : [];
                        @endphp
                        @foreach ($facilities as $facility)
                          <li class="radiobox-image">
                            <input type="checkbox" class="facilities"
                              {{ in_array($facility->id, $facilitySelected) ? 'checked' : '' }}
                              value="{{ $facility->id }}" />
                            <label for="rating1">
                              <p class="p2 mb-0">{{ $facility->facilities_name }} <span
                                  class="ml-auto">({{ $facility->has_hotels_count }})</span></p>
                            </label>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="side-filterFooter d-flex align-items-center justify-content-between">
              <a href="{{ route('hotel-list') .
                  getQueryParams(Request::except(['sort', 'facilities', 'features', 'rating', 'max_price', 'min_price'])) }}"
                class="linkgray">{{ __('home.reset') }}</a>
              <button type="submit" class="btn">{{ __('home.apply') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- newsletter -->
  {{-- @include('frontend.layout.newsletter') --}}
  <!-- newsletter -->
  <!-- footer -->
  @include('frontend.layout.footer')
  <!-- footer -->
  <!-- common models -->
  @include('common_models')
  <!-- common models -->
  @include('frontend.layout.footer_script')
@endsection
@section('page-js-include')
@endsection
<!-- JS section  -->
@section('js-script')
  <script src="https://opensource.propeller.in/components/range-slider/js/wNumb.js"></script>
  <script src="https://opensource.propeller.in/components/range-slider/js/nouislider.js"></script>
  <script>
    $(document).ready(function() {
      $('#tabl').click(function() {
        $('#listView').removeClass('no-display')
        $('#mapView').addClass('no-display')
      })
      $('#tab2').click(function() {
        $('#mapView').removeClass('no-display')
        $('#listView').addClass('no-display')
      })
    })
    // multiple handled with value 
    var pmdSliderValueRange = document.getElementById('pmd-slider-value-range');
    noUiSlider.create(pmdSliderValueRange, {
      start: [
        {{ Request::get('min_price') ? Request::get('min_price') : 0 }},
        {{ Request::get('max_price') ? Request::get('max_price') : getAllRoomMaxPrice($dayofweek) }}
      ], // Handle start position
      connect: true, // Display a colored bar between the handles
      tooltips: [wNumb({ decimals: 0 }), wNumb({ decimals: 0 })],
      format: wNumb({ decimals: 0, thousand: '', postfix: '', }),
      range: { 'min': 0, 'max': {{ getAllRoomMaxPrice($dayofweek) }} } // Slider can select '0' to '100'
    });
    var valueMax = document.getElementById('value-max'),
      valueMin = document.getElementById('value-min');
    // When the slider value changes, update the input and span
    pmdSliderValueRange.noUiSlider.on('update', function(values, handle) {
      if (handle) {
        valueMax.innerHTML = values[handle];
        document.getElementById('max_price').value = values[handle];
      } else {
        valueMin.innerHTML = values[handle];
        document.getElementById('min_price').value = values[handle];
      }
    });
    $(document).ready(function() {
      $('.rating').change(function() {
        const ratigs = ($('#rating').val() !== '') ? $('#rating').val().split(',') : [];
        if (ratigs.includes($(this).val())) {
          const remvoeindex = ratigs.indexOf($(this).val());
          ratigs.splice(remvoeindex, 1);
          $('#rating').val(ratigs.join(','));
        } else {
          ratigs.push($(this).val());
          $('#rating').val(ratigs.join(','));
        }
      });
      $('.features').change(function() {
        const ratigs = ($('#features').val() !== '') ? $('#features').val().split(',') : [];
        if (ratigs.includes($(this).val())) {
          const remvoeindex = ratigs.indexOf($(this).val());
          ratigs.splice(remvoeindex, 1);
          $('#features').val(ratigs.join(','));
        } else {
          ratigs.push($(this).val());
          $('#features').val(ratigs.join(','));
        }
      });
      $('.facilities').change(function() {
        const ratigs = ($('#facilities').val() !== '') ? $('#facilities').val().split(',') : [];
        if (ratigs.includes($(this).val())) {
          const remvoeindex = ratigs.indexOf($(this).val());
          ratigs.splice(remvoeindex, 1);
          $('#facilities').val(ratigs.join(','));
        } else {
          ratigs.push($(this).val());
          $('#facilities').val(ratigs.join(','));
        }
      });
    });
  </script>
@endsection
