<script src="//maps.googleapis.com/maps/api/js?key={{config('app.google_api')}}"></script>
<div x-data='{
        markers: JSON.parse({{$markers}}),
        lat: {{$lat}},
        lng: {{$lng}},
        init() {
          alert(this.markers.length)
          const position = { lat: this.lat, lng: this.lng }
          new google.maps.Map(this.$refs.map, {
              zoom: 12,
              center: position,
            });
            
        }
    }'>
<div wire:ignore x-ref='map' id='map' style='width: 60%; height: 600px;'></div>
</div>


