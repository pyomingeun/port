<form method="get" action="{{ route('hotel-list') }}" id="form-submit">
  <div class="bannerSearchBox d-flex align-items-center">
    <div class="bannerSearchCol">
      <div class="form-floating">
        <img src="{{ asset('/assets/images/structure/location.svg') }}" alt="" class="searchFielsIcns" />
        <input type="text" class="form-control" id="search" name="search" placeholder="Destination" value="{{ isset($hotelName) ? $hotelName : (Request::get('search') ? Request::get('search') : '') }}">
        <label for="floatingInput">{{ __('home.Destination') }}</label>
        <span class="error-inp" id="localtionError"></span>
      </div>
      <input type="hidden" name="latitude" id="latitude"value="{{ Request::get('latitude') ? Request::get('latitude') : '' }}">
      <input type="hidden" name="longitude" id="longitude"value="{{ Request::get('longitude') ? Request::get('longitude') : '' }}">
      <input type="hidden" name="sido" id="sido" value="{{ Request::get('sido') ? Request::get('sido') : '' }}">
      <input type="hidden" name="sigungu" id="sigungu" value="{{ Request::get('sigungu') ? Request::get('sigungu') : '' }}">
      <input type="hidden" name="hname" id="hname" value="{{ Request::get('hname') ? Request::get('hname') : '' }}">
      <input type="hidden" name="checkin_dates" id="checkInDate" value="{{ Request::get('checkin_dates') ? Request::get('checkin_dates') : date('Y-m-d') }}">
      <input type="hidden" name="checkout_dates" id="checkOutDate" value="{{ Request::get('checkout_dates') ? Request::get('checkout_dates') : date('Y-m-d', strtotime("+1 days")) }}">
      <input type="hidden" name="child" id="child" value="{{ Request::get('child') ? Request::get('child') : 0 }}">
    </div>
    <div class="bannerSearchCol">
      <div class="checkinoutBox d-flex align-items-center date-picker">
        <div class="form-floating bnrCheckin">
          <img src="{{ asset('/assets/images/structure/calendar-green.svg') }}" alt="" class="searchFielsIcns" />
          <input type="text" class="form-control doubledatepicker onenter_sumbit_hml" placeholder="Check-In / Check-Out" name="start_dates" />
          <label for="floatingInput">{{ __('home.CheckIn') }}</label>
          <div class="customeDateBox" id="checkInDateBlock"></div>
        </div>
        <div class="form-floating bnrCheckout">
          <input type="text" class="form-control handleClick onenter_sumbit_hml" placeholder="Check-In / Check-Out" name="end_dates">
          <label for="floatingInput">{{ __('home.CheckOut') }}</label>
          <div class="customeDateBox" id="checkOutDateBlock"></div>
        </div>
      </div>
    </div>
    <div class="bannerSearchCol">
      <div class="form-floating">
        <img src="{{ asset('/assets/images/structure/user-green.svg') }}" alt="" class="searchFielsIcns" />
        <button type="button" class="form-select guestdropdownBtn" id="guestdd">
          <span class="guestNo" id="adultNo">{{ Request::get('adult') ? Request::get('adult') : '2' }}</span>
          <span class="guestTxt">{{ __('home.Adult') }}</span>
          <span class="guestNo" id="childNo">{{ Request::get('child') ? Request::get('child') : '0' }}</span>
          <span class="guestTxt">{{ __('home.Child') }}</span>
        </button>
        <ul class="dropdown-menu guestdropdown" style="min-width: 180px">
          <li class="">
            <div class="">
              <div class="quantity-row d-flex align-items-center mb-3">
                <p class="p2 mb-0">{{ __('home.Adult') }}</p>
                <div class="quantity-box d-flex align-items-center ml-auto">
                  <span class="minus d-flex align-items-center justify-content-center">
                    <img src="{{ asset('/assets/images/structure/minus-icon.svg') }}" class="plus-minus-icon" alt="">
                  </span>
                  <input type="text" name="adult" id="adultChange" value="{{ Request::get('adult') ? Request::get('adult') : '2' }}" />
                  <span class="plus d-flex align-items-center justify-content-center">
                    <img src="{{ asset('/assets/images/structure/plus-icon.svg') }}" class="plus-minus-icon" alt="">
                  </span>
                </div>
              </div>
              <div class="quantity-row d-flex align-items-center mb-3">
                <p class="p2 mb-0">{{ __('home.ChildBelow3') }}</p>
                <div class="quantity-box d-flex align-items-center ml-auto">
                  <span class="minus d-flex align-items-center justify-content-center changeChild">
                    <img src="{{ asset('/assets/images/structure/minus-icon.svg') }}" class="plus-minus-icon" alt="">
                  </span>
                  <input type="text" name="childs_below_nyear" id="childChange" value="{{ Request::get('childs_below_nyear') ? Request::get('childs_below_nyear') : '0' }}" />
                  <span class="plus plusch d-flex align-items-center justify-content-center changeChild">
                    <img src="{{ asset('/assets/images/structure/plus-icon.svg') }}" class="plus-minus-icon" alt="">
                  </span>
                </div>
              </div>
              <div class="quantity-row d-flex align-items-center mb-3">
                <p class="p2 mb-0">{{ __('home.ChildAbove3') }}</p>
                <div class="quantity-box d-flex align-items-center ml-auto">
                  <span class="minus d-flex align-items-center justify-content-center changeChild">
                    <img src="{{ asset('/assets/images/structure/minus-icon.svg') }}" class="plus-minus-icon" alt="">
                  </span>
                  <input type="text" name="childs_plus_nyear" id="childChange2" value="{{ Request::get('childs_plus_nyear') ? Request::get('childs_plus_nyear') : '0' }}" />
                  <span class="plus plusch d-flex align-items-center justify-content-center changeChild">
                    <img src="{{ asset('/assets/images/structure/plus-icon.svg') }}" class="plus-minus-icon" alt="">
                  </span>
                </div>
              </div>
            </div>
          </li>
        </ul>
        <label for="guestdd" class="label">{{ __('home.NoOfGuest') }}</label>
        <span id="month_error" class="error"></span>
      </div>
    </div>
    <div class="bannerSearchBtnBox">
      <button type="submit" class="btn">
        <img src="{{ asset('/assets/images/structure/search-w.svg') }}">
      </button>
    </div>
  </div>
</form>
<script>
  $(document).ready(function() {
    $(function() {
      $('#sido').val("");
      $('#sigungu').val("");
      $('#hname').val("");
      const months = ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'];
      let startDate1 = new Date();
      let endDate1 = new Date();
      endDate1.setDate(startDate1.getDate() + 1);
      @if (Request::get('checkin_dates'))
        startDate1 = new Date("{{ Request::get('checkin_dates') }}");
      @endif
      @if (Request::get('checkout_dates'))
        endDate1 = new Date("{{ Request::get('checkout_dates') }}");
      @endif
      $('#checkInDateBlock').html(
        `${startDate1.getFullYear()}년 ${months[startDate1.getMonth()]} ${(startDate1.getDate() < 10)?`0`+startDate1.getDate():startDate1.getDate()}일`
      );
      $('#checkOutDateBlock').html(
        `${endDate1.getFullYear()}년 ${months[endDate1.getMonth()]} ${(endDate1.getDate() < 10)?`0`+endDate1.getDate():endDate1.getDate()}일 `
      )
      $('.handleClick').click(function() {
        $('.doubledatepicker').click();
      });
      $('.doubledatepicker').daterangepicker({
        autoApply: true,
        minDate: new Date(),
        maxDate: new Date(new Date().setFullYear(new Date().getFullYear() + 1)),
        startDate: ($('#checkInDate').val() !== '') ? new Date($('#checkInDate').val()) : startDate1,
        endDate: ($('#checkOutDate').val() !== '') ? new Date($('#checkOutDate').val()) : endDate1,
        locale: {
          format: 'YYYY년 MM월 DD일',
          daysOfWeek: ['일', '월', '화', '수', '목', '금', '토'],
          monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
          firstDay: 0
        }
      }, (start, end) => {
        $('#checkInDate').val(start.format('YYYY-MM-DD'));
        $('#checkOutDate').val(end.format('YYYY-MM-DD'));
      });
      $('#adultChange').change(function() {
        $('#adultNo').text($('#adultChange').val());
      })
      $('#childChange').change(function() {
        const totalChild = parseInt($('#childChange').val()) + parseInt($('#childChange2').val());
        $('#childNo').text(totalChild);
        $('#child').val(totalChild);
      })
      $('#childChange2').change(function() {
        const totalChild = parseInt($('#childChange').val()) + parseInt($('#childChange2').val());
        $('#childNo').text(totalChild);
        $('#child').val(totalChild);
      })
      $('#form-submit').submit(function() {
        if ($('#search').val() === '') {
          $('#localtionError').text('{{ __('home.NoSearchData') }}');
          return false;
        }
        if ($('#latitude').val() === '' && $('#longitude').val() === '' && $('#search').val() === '') {
          return false;
        }
      })
      
      loadgoogle_map();


    });

    if (currentPage === 'home') {
      async function getlocations() {
        try {
          // Get user's geolocation
          const position = await new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(resolve, reject);
          });

          const latitude = position.coords.latitude;
          const longitude = position.coords.longitude;

          // Reverse geocoding using Google Maps Geocoding API
          const response = await fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key={{ env('GOOGLE_MAPS_API_KEY') }}`);
          const data = await response.json();

          // Extract the specific address components
          let adminLevel1 = '';
          let locality = '';

          if (data.results && data.results.length > 0) {
            const addressComponents = data.results[0].address_components;
            addressComponents.forEach(component => {
              if (component.types.includes('administrative_area_level_1')) {
                adminLevel1 = component.long_name;
              } else if (component.types.includes('locality')) {
                locality = component.long_name;
              } else if (component.types.includes('sublocality_level_1')) {
                locality = component.long_name;
              }
            });

            // Update the content of the respective divs
            const searchInput = document.getElementById('search');
            searchInput.value = adminLevel1 + ' ' + locality;
          } else {
            console.log('Address not found');
          }
        } catch (error) {
          console.error('Error retrieving geolocation or address:', error);
        }
      }
      getlocations();
    }
  });

  
  function loadgoogle_map(id = 'search') {
    var options = {};
    var places = new google.maps.places.Autocomplete(document.getElementById(id), options);
    google.maps.event.addListener(places, 'place_changed', function() {
      var place = places.getPlace();
      $('#latitude').val(place.geometry.location.lat())
      $('#longitude').val(place.geometry.location.lng())
      var country = '';
      var administrativeLevel1 = '';
      var locality = '';
      var hname = '';

      if (place.types.includes("lodging")) {
        hname = place.name;
      }

      for (var i = 0; i < place.address_components.length; i++) {
        var component = place.address_components[i];
        var componentType = component.types[0];

        switch (componentType) {
          case 'administrative_area_level_1':
            administrativeLevel1 = component.long_name;
          break;
          case 'locality':
            locality = component.long_name;
          break;
          case 'sublocality_level_1':
            locality = component.long_name;
          break;
          case 'country':
            country = component.long_name;
          break;
        }
      }
      $('#sido').val(administrativeLevel1);
      $('#sigungu').val(locality);
      $('#hname').val(hname);
    });
  }
</script>
