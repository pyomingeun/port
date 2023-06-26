<style>
  .hotelMapBox {
    position: relative;
    margin-top: 20px
  }

  .productListCard.onmapHotelDetailList {
    width: 360px;
    position: absolute;
    right: 20px;
    bottom: 20px;
  }

  .no-display {
    display: none;
  }
</style>
<div class="hotelMapBox">
  {{-- map --}}
  <div id="map" style='height:600px'></div>
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

  function initializeMap() {
    const locations = jsonparse;
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 20
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
          let feature_facility = '';
          feature_facility += (data.feature_facility.feature !== '') ?
            `<span class="chips chips-gray h-24">${data.feature_facility.feature}</span>` : '';
          feature_facility += (data.feature_facility.facility !== '') ?
            `<span class="chips chips-gray h-24">${data.feature_facility.facility}</span>` : '';
          feature_facility += (data.feature_facility.feature_facility_total > 0) ?
            `<span class="chips chips-gray h-24">+${data.feature_facility.feature_facility_total}</span>` :
            '';
          let reviews = '';
          if (data.hotel.reviews > 0) {
            reviews = `
            <div class="onlist-rat-review d-flex align">
              <span class="rat-chips"><i class="fa fa-star" aria-hidden="true"></i> ${data.hotel.rating}</span>
              <span class="p2 mb-0">${data.hotel.reviews} Reviews</span>
            </div>
            `;
          }
          // <div class="favoritlsstbock">
          //     <img src="../images/structure/heart-outline.svg" alt="" class="heart-outline">
          //     <img src="../images/structure/heart-fill.svg" alt="" class="heart-fill">
          //   </div>
          document.getElementById('product-pop-block').innerHTML = `
          <div class="productListImg-block">
            <div class="overlay"></div>
            <a href="${data.redirect_url}" >
              <img src="${data.hotelImage}" alt="" class="productListImg">
            </a>
            ${reviews}
          </div>
          <div class="productListDetail">
            <a href="${data.redirect_url}">
              <h6 class="h6 mb-2">${data.price} <small class="pelTm">/per night</small></h6>
              <h5 class="mb-2">${data.hotel.hotel_name}</h5>
              <p class="p2 mb-3">${data.hotel.street}</p>
              <div class="productLstFtr d-flex">
                ${feature_facility}
              </div>
            </a>
          </div>`;
          document.getElementById('showHotelBox').classList.remove('no-display')
        }
      })(marker, location));
    }
    map.fitBounds(bounds);
  }
  initializeMap();
</script>
