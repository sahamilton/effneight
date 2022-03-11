<script>
    document.addEventListener('livewire:load',function() {
       
        const myLatLng = { lat: 38.2, lng: -122.48 }
        initialize();
        function initialize() {
          let map = new google.maps.Map(
            document.getElementById('map'), {
              center: myLatLng,
              zoom: @this.zoom,
              mapTypeId: google.maps.MapTypeId.ROADMAP
          });
          let markers =  JSON.parse( @this.markers) 
          
          for (var i = 0, length = markers.length; i < length; i++) {
                var data = markers[i],
                latLng = new google.maps.LatLng(data.lat, data.lng); 
                var marker = new google.maps.Marker({
                      position: latLng,
                      map: map,
                      title: data.businessname,
                      
                    }

                );
                marker.addListener("click", toggleBounce);
            }

            
        }
        function toggleBounce() {
          if (marker.getAnimation() !== null) {
            marker.setAnimation(null);
          } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
          }
        }
        function getIcon(type) {
          switch(type) {
            case 'customer':
               var color ='green'
              break;
            case 'lead':
               var color = 'red'
              break;
            default:
              var color = 'green'
              break;
        }
          return "http://maps.google.com/mapfiles/ms/icons/" + color + "-dot.png"
        }
        
        @this.on(`refreshMap`, () => {
           
            initialize();
            
            
        });
    });
    //google.maps.event.addDomListener(window, 'load', initialize);
</script>