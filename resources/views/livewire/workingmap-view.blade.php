<div>
    <script
          src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_api')}}"
          async
        ></script>
    <h2>Maps {{$limit}}</h2>
   
    <x-form-select wire:model='limit' name="limit" :options="$limits" />
   
    

    <script>
        const myLatLng = { lat: 38.22632, lng: -122.638035 }
        const markers = {!! $markers !!}
        function initialize() {
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

        this.$watch('markers', () => {
            map.markers = this.markers
            map.initMap() 
        })
        
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <div wire:ignore id="map" style="width: 60%; height: 600px;"></div>
</div>
