<div>

       <script>
            function initialize() {
                let myLatLng = { lat: 38.22632, lng: -122.638035 }
                let markers = {!! $markers !!}
                let map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 10,
                    center: myLatLng,
                    mapTypeControl: false,
                });
                                  
                for (var i = 0, length = markers.length; i < length; i++) {
                    var data = markers[i],
                    latLng = new google.maps.LatLng(data.lat, data.lng); 
                    var marker = new google.maps.Marker({
                          position: latLng,
                          map: map,
                          title: data.businessname
                        }
                    );
                }
            }
            
            google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <h2>Maps {{$limit}}</h2>
   
    <x-form-select wire:model='limit' name="limit" :options="$limits" />

    <div wire:ignore x-ref="map" id="map" style="width: 60%; height: 600px;"></div>
</div>
