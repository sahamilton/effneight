<div>
    <script src="//maps.googleapis.com/maps/api/js?key={{config('app.google_api')}}"
          
        ></script>
    <h2>Maps {{$limit}}</h2>
   
    <x-form-select wire:model='limit' name="limit" :options="$limits" />
   
    

    <div x-data="{
        markers: {!! $markers !!}
        init() {
            const myLatLng = { lat: 38.22632, lng: -122.638035 }
            const markers = this.markers
            function initialize() {
              let map = new google.maps.Map(
                document.getElementById('map'), {
                  center: myLatLng,
                  zoom: 10,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
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
        }
    }">
    
    <div wire:ignore x-ref='map' id="map" style="width: 60%; height: 600px;"></div>
</div>
