<form method="get" action="{{ route('hotel-list') }}" id="form-submit">
  <div class="bannerSearchBox d-flex align-items-center">
    <div class="bannerSearchCol">
      <div class="form-floating">
        <img src="{{ asset('/assets/images/structure/location.svg') }}" alt="" class="searchFielsIcns" />
        <input type="text" class="form-control" id="street" name="street" placeholder="Location" value="{{ Request::get('street') ? Request::get('street') : 'Seoul' }}">
        <label for="floatingInput">{{ __('home.Location') }}</label>
        <span class="error-inp" id="localtionError"></span>
      </div>
      <input type="hidden" name="latitude" id="latitude"value="{{ Request::get('latitude') ? Request::get('latitude') : '' }}">
      <input type="hidden" name="longitude" id="longitude"value="{{ Request::get('longitude') ? Request::get('longitude') : '' }}">
      <input type="hidden" name="city" id="city" value="{{ Request::get('city') ? Request::get('city') : '' }}">
      <input type="hidden" name="checkin_dates" id="checkInDate" value="{{ Request::get('checkin_dates') ? Request::get('checkin_dates') : date('Y-m-d') }}">
      <input type="hidden" name="checkout_dates" id="checkOutDate" value="{{ Request::get('checkout_dates') ? Request::get('checkout_dates') : date('Y-m-d', strtotime("+1 days")) }}">
      <input type="hidden" name="child" id="child" value="{{ Request::get('child') ? Request::get('child') : 0 }}">
    </div>
    <div class="bannerSearchCol">
      <div class="checkinoutBox d-flex align-items-center date-picker">
        <img src="{{ asset('/assets/images/structure/calendar-green.svg') }}" alt="" class="searchFielsIcns" />
        <div class="form-floating bnrCheckin">
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
        <ul class="dropdown-menu guestdropdown" style="min-width: 300px">
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
                  <span class="minusMinZero d-flex align-items-center justify-content-center changeChild">
                    <img src="{{ asset('/assets/images/structure/minus-icon.svg') }}" class="plus-minus-icon" alt="">
                  </span>
                  <input type="text" name="childs_below_nyear" id="childChange" value="{{ Request::get('childs_below_nyear') ? Request::get('childs_below_nyear') : '0' }}" />
                  <span class="plus plusch d-flex align-items-center justify-content-center changeChild">
                    <img src="{{ asset('/assets/images/structure/plus-icon.svg') }}" class="plus-minus-icon" alt="">
                  </span>
                </div>
              </div>
              <div class="quantity-row d-flex align-items-center mb-3">
                <p class="p2 mb-0">{{ __('home.childAbove3') }}</p>
                <div class="quantity-box d-flex align-items-center ml-auto">
                  <span class="minusMinZero d-flex align-items-center justify-content-center changeChild">
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
        <label for="guestdd" class="label">{{ __('home.Select') }} {{ __('home.Guest') }}</label>
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
<style>
  td.off.off.disabled { background: #f3f0f0 !important; border-radius: unset !important; }
  .pac-container:after { background-image: none !important; height: 0px; }
</style>
<script>
  $(document).ready(function() {
    $(function() {
      const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
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
        `${(startDate1.getDate() < 10)?`0`+startDate1.getDate():startDate1.getDate()} <span class="dtSpan">${months[startDate1.getMonth()]}, ${startDate1.getFullYear()}</span>`
      );
      $('#checkOutDateBlock').html(
        `${(endDate1.getDate() < 10)?`0`+endDate1.getDate():endDate1.getDate()} <span class="dtSpan">${months[endDate1.getMonth()]}, ${endDate1.getFullYear()}</span>`
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
        locale: {format: 'DD MMM,YYYY'}
      }, (start, end) => {
        $('#checkInDate').val(start.format('YYYY-MM-DD'));
        $('#checkInDateBlock').html(`${start.format('DD')} <span class="dtSpan">${start.format('MMM, YYYY')}</span>`);
        $('#checkOutDate').val(end.format('YYYY-MM-DD'));
        $('#checkOutDateBlock').html(`${end.format('DD')} <span class="dtSpan">${end.format('MMM, YYYY')}</span>`);
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
        if ($('#street').val() === '') {
          $('#localtionError').text('Enter hotel name or City');
          return false;
        }
        if ($('#latitude').val() === '' && $('#longitude').val() === '' && $('#street').val() === '') {
          return false;
        }
      })
    });
    async function getlocations() {
      let lat = '';
      let long = '';
      if (navigator.geolocation) {
        await navigator.geolocation.getCurrentPosition(async (position) => {
          lat = position.coords.latitude;
          long = position.coords.longitude;
          let response = await fetch(
            `https://maps.googleapis.com/maps/api/place/textsearch/json?query=hotels&location=${lat},${long}&key={{ env('GOOGLE_MAPS_API_KEY') }}`
          );
          let data = await response.json();
        });
      } else {
        console.log('else');
      }
    }
    getlocations();
  });
  loadgoogle_map();
  function loadgoogle_map(id = 'street') {
    var options = {};
    var places = new google.maps.places.Autocomplete(document.getElementById(id), options);
    google.maps.event.addListener(places, 'place_changed', function() {
      var place = places.getPlace();
      $('#latitude').val(place.geometry.location.lat())
      $('#longitude').val(place.geometry.location.lng())
      place.address_components.map(element => {
        if (element.types.includes("administrative_area_level_1") || element.types.includes("locality")) {
          $('#city').val(element.long_name)
          return element.long_name
        }
      });
    });
  }
</script>
