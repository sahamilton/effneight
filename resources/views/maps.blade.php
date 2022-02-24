<x-layout>



<div id="googleMap" style="width:100%;height:400px;"></div>

<script>
    function myMap() {
    var mapProp= {
      center:new google.maps.LatLng(38.232471,-122.636848),
      zoom:15,
    };
    var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_api')}}&callback=myMap"></script>

</x-layout>
