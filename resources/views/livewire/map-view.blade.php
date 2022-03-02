<div>
    
    <h2>New Maps {{$limit}}</h2>
   
    <x-form-select wire:model='limit' name="limit" :options="$limits" />
   
    <div id="map" style="width: 60%; height: 600px;"></div>

    <script>
        const myLatLng = { lat: 38.22632, lng: -122.638035 }
        const markers = {!! $markers !!}
        function initMap() {
            const map = new google.maps.Map(document.getElementById('map'), {
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
    </script>   
</div>
