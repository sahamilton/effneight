<div>
    <script src="//maps.googleapis.com/maps/api/js?key={{config('app.google_api')}}"></script>
    <h2>New Maps {{$limit}}</h2>
   
    <x-form-select wire:model='limit' name="limit" :options="$limits" />

    <div wire:ignore id="map" style="width: 60%; height: 600px;"></div>
    <script>

    function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -34.397, lng: 150.644 },
        zoom: 8,
      });
    }
</script>
    
      
</div>
