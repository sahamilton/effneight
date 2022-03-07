<script>
    document.addEventListener('livewire:load',function() {
       
        const myLatLng = { lat: 38.2, lng: -122.48 }
        initialize();
        function initialize() {
          let map = new google.maps.Map(
            document.getElementById('map'), {
              center: myLatLng,
              zoom: 10,
              mapTypeId: google.maps.MapTypeId.ROADMAP
          });
         let markers =  JSON.parse( @this.markers) 
        
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
        
        @this.on(`refreshMap`, () => {
           
            initialize();
            
            
        });
        });
        //google.maps.event.addDomListener(window, 'load', initialize);
    </script>