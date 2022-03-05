<x-layout>

<x-section name="scripts">
<style>
/* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
#map {
  height: 100%;
}

/* Optional: Makes the sample page fill the window. */
html,
body {
  height: 100%;
  margin: 0;
  padding: 0;
}

  </style>
</x-section>
<div id="googleMap" style="width: 100%; height: 480px;"></div>
  <div>
    
  </div>

<script>
const myLatLng = { lat: 38.363, lng: -122.044 };
function initMap() {
  const map = new google.maps.Map(document.getElementById("googleMap"), {
    zoom: 8,
    center: myLatLng,
    mapTypeControl: false,
  });
  new google.maps.Marker({
    position: myLatLng,
    map,
    title: "Hello World!",
  });
  let json = {!! $markers !!}
  for (var i = 0, length = json.length; i < length; i++) {
    var data = json[i],
        latLng = new google.maps.LatLng(data.lat, data.lng); 

    // Creating a marker and putting it on the map
    var marker = new google.maps.Marker({
      position: latLng,
      map: map,
      title: data.businessname
    });
  }
}
</script>

<script
      src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_api')}}&callback=initMap&v=weekly&channel=2"
      async
    ></script>
</x-layout>