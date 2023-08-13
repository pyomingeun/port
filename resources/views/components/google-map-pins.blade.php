<div class="hotelMapBox">
  {{-- map --}}
  <div id="map" style='height:800px'></div>
  {{-- hotel block --}}
  <div class="productListCard onmapHotelDetailList no-display" id="showHotelBox">
    <span id="product-pop-block"></span>
  </div>
</div>

<script type="text/javascript">
  const jsonparse = [];
  let params = [];
  @foreach ($locations as $location)
    jsonparse.push({
      'label': "{{ $location['label'] }}",
      'lat': "{{ $location['lat'] }}",
      'lng': "{{ $location['lng'] }}",
      'hotelurl': "{{ $location['hotelurl'] }}"
    })
  @endforeach
  @foreach (Request::all() as $key => $value)
    params.push("{{ $key }}={{ $value }}");
  @endforeach
  
  
  function closeProductBlock() {
    const productPopBlock = document.getElementById('product-pop-block');
    productPopBlock.style.display = 'none';
    productPopBlock.innerHTML = '';
    }

  function initializeMap() {
    const locations = jsonparse;
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 12,
    });
    var infowindow = new google.maps.InfoWindow();
    var bounds = new google.maps.LatLngBounds();
    for (var location of locations) {
      var marker = new google.maps.Marker({
        title: location.label,
        position: new google.maps.LatLng(location.lat, location.lng),
        map: map,
      });
      bounds.extend(marker.position);
      google.maps.event.addListener(marker, 'click', (function(marker, location) {
        return async function() {
          let response = await fetch(location.hotelurl + '?' + params.join('&'));
          let data = await response.json();
          let reviews = '';
          if (data.hotel.reviews > 0) {
            reviews = `
            <div class="onlist-rat-review d-flex align">
              <span class="rat-chips"><i class="fa fa-star" aria-hidden="true"></i> ${data.hotel.rating}</span>
              <span class="p2 mb-0">${data.hotel.reviews} {{ __('home.Reviews') }}</span>
            </div>
            `;
          } else {
            reviews = `<div class="onlist-rat-review d-flex align"><span class="p2 mb-0">{{ __('home.NoReview') }}</span></div>`;
          }

          function showProductBlock(data) {
          const productPopBlock = document.getElementById('product-pop-block');
          productPopBlock.innerHTML = `
            <div class="productListImg-block">
              <div class="close-btn-container">
                <button type="button" class="close-btn" onclick="closeProductBlock()">&times;</button>
              </div>
              <div class="overlay"></div>
              <a href="${data.redirect_url}" >
                <img src="${data.hotelImage}" alt="" class="productListImg">
              </a>
              ${reviews}
            </div>
            <div class="productListDetailinMap">
              <a href="${data.redirect_url}">
                <h5 class="mb-2" style="text-align: center;">${data.hotel.hotel_name}</h5>  
                <p class="p2 mb-3" style="text-align: center;">${data.hotel.sido}/ ${data.hotel.sigungu}</p>
                <p class="p2 mb-0" style="text-align: right;">1박 요금 시작가  <h6 class="h6 mb-0" style="text-align: right;">${data.price}</h6><p class="p2 mb-0" style="text-align: right;">({{ __('home.IncludeTax') }})</p></p> 
              </a>
            </div>
          `;
          
          productPopBlock.style.display = 'block'; // Show the block
          }
          showProductBlock(data);
          document.getElementById('showHotelBox').classList.remove('no-display')
        }
      })(marker, location));
    }
    map.fitBounds(bounds);
    const maxZoom = 12;
    google.maps.event.addListener(map, 'zoom_changed', function() {
      if (map.getZoom() > maxZoom) map.setZoom(maxZoom);
    });
  }
  initializeMap();
</script>
