<div id="map" style='height:400px'></div>
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
      zoom: 4
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
  }
  initializeMap();
</script>
