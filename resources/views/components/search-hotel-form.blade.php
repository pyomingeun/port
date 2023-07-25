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
    </div>
    <div class="bannerSearchCol">
      <div class="checkinoutBox d-flex align-items-center date-picker">
        <div class="form-floating bnrCheckin">
          <img src="{{ asset('/assets/images/structure/calendar-green.svg') }}" alt="" class="searchFielsIcns" />
          <input type="text" class="form-control doubledatepicker" id="checkInDate" name="checkin_dates" />
          <label for="floatingInput">{{ __('home.CheckIn') }}</label>
          <div class="customeDateBox" id="checkInDateBlock"></div>
        </div>
        <div class="form-floating bnrCheckout">
          <input type="text" class="form-control handleClick" id="checkOutDate" name="checkout_dates">
          <label for="floatingInput">{{ __('home.CheckOut') }}</label>
          <div class="customeDateBox" id="checkOutDateBlock"></div>
        </div>
      </div>
    </div>
    <div class="bannerSearchCol">
      <div class="form-floating">
        <img src="{{ asset('/assets/images/structure/user-green.svg') }}" alt="" class="searchFielsIcns" />
        <button type="button" class="form-select guestdropdownBtn">
          <span class="guestNo" id="adultNo">{{ Request::get('adult') ? Request::get('adult') : '2' }}</span>
          <span class="guestTxt">{{ __('home.Adult') }}</span>
          <span class="guestNo" id="childNo">{{ Request::get('child') ? Request::get('child') : '0' }}</span>
          <span class="guestTxt">{{ __('home.Child') }}</span>
        </button>
        <ul class="dropdown-menu guestdropdown" style="min-width: 180px">
          <li class="">
              <div class="quantity-row d-flex align-items-center mb-3">
                <p class="p2 mb-0">{{ __('home.Adult') }}</p>
                <div class="quantity-box d-flex align-items-center ml-auto">
                  <span class="minus aminus d-flex align-items-center justify-content-center"> <img src="{{ asset('/assets/images/structure/minus-icon.svg') }}"> </span>
                  <input type="text" name="adult" id="noOfAdult" value="{{ Request::get('adult') ? Request::get('adult') : '2' }}" />
                  <span class="plus aplus d-flex align-items-center justify-content-center"> <img src="{{ asset('/assets/images/structure/plus-icon.svg') }}"> </span>
                </div>
              </div>
              <div class="quantity-row d-flex align-items-center mb-3">
                <p class="p2 mb-0">{{ __('home.Child') }}</p>
                <div class="quantity-box d-flex align-items-center ml-auto">
                  <span class="minus cminus d-flex align-items-center justify-content-center"> <img src="{{ asset('/assets/images/structure/minus-icon.svg') }}"> </span>
                  <input type="text" name="child" id="noOfChild" value="{{ Request::get('child') ? Request::get('child') : '0' }}" />
                  <span class="plus cplus d-flex align-items-center justify-content-center"> <img src="{{ asset('/assets/images/structure/plus-icon.svg') }}"></span>
                </div>
              </div>
          </li>
          <div class="dropdown-container" id="dropdownContainer"></>
            @php
              $childAgeCount = 0;
              foreach (request()->all() as $key => $value) {
                if (preg_match('/^childage\d+$/', $key)) {
                  $childAgeCount++;
                }
            }
            @endphp

            @for ($i = 1; $i <= $childAgeCount; $i++)
              <div> 
                <label style="font-size: 18px; color: black; margin-bottom: 1px;">{{ __('home.Child') }} {{ $i }} :</label>
                    <select class="dropdown" name="childage{{ $i }}">
                      @php
                        $selectedChildAge = Request::get('childage'.$i);
                      @endphp
                      @for ($j = 0; $j <= 17; $j++)
                        <option value="{{ $j }}" @if ($j == $selectedChildAge) selected @endif>{{ $j }}</option>
                      @endfor
                    </select>
              </div>
            @endfor
          </div>
          <div class="button-container" style="display: flex;  justify-content: flex-end;">
            <button type="button" class="btn btn-primary confirmDropdown" id="confirmDropdown">{{ __('home.Confirm') }}</button>
          </div>
        </ul>
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
//      $('#hname').val("");

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
        $('#checkInDateBlock').html(
        `${start.format('YYYY년 MM월 DD일')}`
        );
        $('#checkOutDateBlock').html(
        `${end.format('YYYY년 MM월 DD일')}`
        );
      });

      function convertKoreanDateToYmd(koreanDate) {
        const parts = koreanDate.match(/(\d+)/g);
        if (parts.length === 3) {
          const year = parts[0];
          const month = parts[1];
          const day = parts[2];
          return year + '-' + month + '-' + day;
          }
        return null;
      }

      function updateCheckinInputValue() {
        const checkinDateBlock = $('#checkInDateBlock').text().trim();
        const checkoutDateBlock = $('#checkOutDateBlock').text().trim();
        const checkinDate = convertKoreanDateToYmd(checkinDateBlock);
        const checkoutDate = convertKoreanDateToYmd(checkoutDateBlock);
        if (checkinDate) {
          $('input[name="checkin_dates"]').val(checkinDate);
        }
        if (checkoutDate) {
          $('input[name="checkout_dates"]').val(checkoutDate);
        }
      }

      $('.aminus').click(function () {
				var $input = $(this).parent().find('input');
				var count = parseInt($input.val()) - 1;
				count = count < 1 ? 1 : count;
				$input.val(count);
        $('#adultNo').text(count);
				return false;
			});

			$('.aplus').click(function () {
				var $input = $(this).parent().find('input');
				var count = parseInt($input.val()) + 1;
        $input.val(count); 
        $('#adultNo').text(count);
				return false;
			});

      let currentQuantity = parseInt($('#noOfChild').val());

      function generateDropdowns() {
        const input = document.getElementById("noOfChild");
        const quantity = parseInt(input.value);

        // Validate if the input is a valid positive integer
        if (Number.isInteger(quantity) && quantity >= 0 && quantity <= 17) {
          input.style.border = "1px solid #ced4da"; // Reset border to default
          const dropdownContainer = document.getElementById("dropdownContainer");

          while (currentQuantity < quantity) {
            addDropdown();
          }

          while (currentQuantity > quantity) {
            removeDropdown();
          }
        } else {
          input.style.border = "1px solid red"; // Invalid input, show red border
        }
      }

      function addDropdown() {
        const dropdownContainer = document.getElementById("dropdownContainer");
        const labelContainer = document.createElement("div");

        const label = document.createElement("label");
        const childIndex = currentQuantity + 1;
        label.innerHTML = "{{ __('home.Child') }} " + childIndex + " :";
        label.setAttribute("style", "font-size: 18px; color: black; margin-bottom: 1px;");
        labelContainer.appendChild(label);

        const dropdown = document.createElement("select");
        dropdown.className = "dropdown";
        dropdown.name = "childage" + childIndex;

        for (let j = 0; j <= 17; j++) {
          const option = document.createElement("option");
          option.text = j;
          option.value = j;
          dropdown.appendChild(option);
        }

        labelContainer.appendChild(dropdown);
        dropdownContainer.appendChild(labelContainer);

        currentQuantity++;
      }

      function removeDropdown() {
        const dropdownContainer = document.getElementById("dropdownContainer");
        if (currentQuantity > 0) {
          currentQuantity--;
          dropdownContainer.removeChild(dropdownContainer.lastElementChild);
        }
      }

      $('.cminus').click(function () {
				var $input = $(this).parent().find('input');
				var count = parseInt($input.val()) - 1;
				count = count < 0 ? 0 : count;
				$input.val(count);
        $('#childNo').text(count);
        generateDropdowns();
				return false;
			});

      $('.cplus').click(function () {
				var $input = $(this).parent().find('input');
				var count = parseInt($input.val()) + 1;
        $input.val(count); 
        $('#childNo').text(count);
        generateDropdowns();
				return false;
			});

      $('#form-submit').submit(function() {
        if ($('#search').val() === '') {
          $('#localtionError').text('{{ __('home.NoSearchData') }}');
          return false;
        }
        if ($('#latitude').val() === '' && $('#longitude').val() === '' && $('#search').val() === '') {
          return false;
        }
        updateCheckinInputValue();
      })
      
    $('#confirmDropdown').click(function() {
      $('.guestdropdown').hide();
    });
    
    $(".guestdropdownBtn").on("click", function(e) {
      $('.guestdropdown').show();
    });
      
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
