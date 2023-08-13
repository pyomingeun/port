<div id="map" style='height:600px'></div>
<script type="text/javascript">
  const jsonparse = [];
  @foreach ($locations as $location)
    jsonparse.push({
      'label': "{{ $location['label'] }}",
      'lat': "{{ $location['lat'] }}",
      'lng': "{{ $location['lng'] }}",
    })
  @endforeach
  function initializeMap() {
    const locations = jsonparse;
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 12
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
        return function() {
          infowindow.setContent(location.label);
          infowindow.open(map, marker);
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
