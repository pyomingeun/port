<div class="row">
  @forelse ($hotels as $hotel)
    <div class="col-xl-4 col-ld-4 col-md-6 col-sm-12 col-12">
      <div class="productListCard">
        @if (count($hotel->hasLongStayDiscount) > 0)
          <div class="discountBadge">
            <span class="onbadgeText">{{ __('home.longStayDiscount') }} {{ __('home.applied') }}</span>
          </div>
        @endif
        <div class="productListImg-block">
          <div class="overlay"></div>
          <a href="{{ route('hotel-detail', [$hotel->slug]) . getQueryParams(Request::all()) }}">
            <img
              src="{{ $hotel->hasFeaturedImage != null ? asset('hotel_images/' . $hotel->hasFeaturedImage->image) : asset('assets/images/product/img1.png') }}"
              onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';"
              alt="" class="productListImg">
          </a>
          <div class="onlist-rat-review d-flex align">
            @if ($hotel->reviews > 0)
              <span class="rat-chips"><i class="fa fa-star" aria-hidden="true"></i> {{ $hotel->rating }}</span>
              <span class="p2 mb-0">{{ $hotel->reviews }} {{ __('home.Reviews') }}</span>
            @else
              <span class="p2 mb-0">{{ __('home.NoReview') }}</span>
            @endif
          </div>
          @auth
            <div class="favoritlsstbock markunmarkfavorite">
              <img src="{{ asset('assets/images/structure/heart-fill.svg') }}" alt=""
                data-h="{{ $hotel->hotel_id }}" class="markunmarkfavorite heart-fill">
              <img id="markunmarkfavoriteicon{{ $hotel->hotel_id }}"
                src="{{ $hotel->has_marked_hotel_count ? asset('assets/images/structure/heart-fill.svg') : asset('assets/images/structure/heart-outline.svg') }}"
                alt="" data-h="{{ $hotel->hotel_id }}" class="markunmarkfavorite heart-outline">
            </div>
          @endauth
        </div>
        <div class="productListDetail">
          <a href="{{ route('hotel-detail', [$hotel->slug]) . getQueryParams(Request::all()) }}" class="productListDetail">
            <h5 class="mb-2" >{{ $hotel->hotel_name }}</h5>  
            <p class="p2 mb-3" >{{ $hotel->sido }}, {{ $hotel->sigungu }} </p>
            <h6 class="h6 mb-2" style="text-align: right;">{!! getRoomPrice($dayofweek, $hotel->hasActiveRooms, $hotel->hasLongStayDiscount) !!}<small class="pelTm"> /{{ __('home.perNight') }}</small></h6>
            <p class="p2 mb-3" style="text-align: right;">({{ __('home.IncludeTax') }}) </p>
            <div class="productLstFtr d-flex">
              @if (count($hotel->hasFeatures) > 0)
                <span class="chips chips-gray h-24">{{ getFeaturename($hotel->hasFeatures[0]->features_id) }}</span>
              @endif
              @if (count($hotel->hasFacilities) > 0)
                <span class="chips chips-gray h-24">{{ getFacilityname($hotel->hasFacilities[0]->facilities_id) }}</span>
              @endif
              @php
                $ftotal = count($hotel->hasFeatures) - 1 + (count($hotel->hasFacilities) - 1);
              @endphp
              @if ($ftotal > 0)
                <span class="chips chips-gray h-24">+{{ $ftotal }}</span>
              @endif
            </div>
          </a>
        </div>
      </div>
    </div>
  @empty
    <div class="row">
      <div class="col-xl-5 col-lg-5 col-md-9 col-sm-12 col-12 mx-auto empty-list-box text-center">
        <img src="../images/structure/favorite-empty-img.png" alt="" class="empty-list-image">
        <h6>{{ __('home.Nohotelfound') }}</h6>
      </div>
    </div>
  @endforelse
</div>
<script>
  $(document).ready(function() {
    $('#markunmarkfavoriteicon').click(function() {
      console.log('asdkashdakjsh');
    })
  })
  $(document).on('click', '.markunmarkfavorite', function() {
    // delNTA
    var h = $(this).attr('data-h');
    $.post("{{ route('markunmarkfavorite') }}", {
      _token: "{{ csrf_token() }}",
      h: h
    }, function(data) {
      if (data.status == 1) {
        if (data.markstatus == 'marked') {
          $("#markunmarkfavoriteicon" + h).attr('src',
            "{{ asset('/assets/images/') }}/structure/heart-fill.svg");
        } else {
          $('#markunmarkfavoriteicon' + h).attr('src',
            "{{ asset('/assets/images/') }}/structure/heart-outline.svg");
        }
        $("#commonSuccessMsg").text(data.message);
        $("#commonSuccessBox").css('display', 'block');
        setTimeout(function() {
          $("#commonSuccessBox").hide();
        }, 3000);
        unloading();
      } else {
        unloading();
        $("#commonErrorMsg").text(data.message);
        $("#commonErrorBox").css('display', 'block');
        setTimeout(function() {
          $("#commonErrorBox").hide();
        }, 3000);
      }
    });
  });
</script>
