<div x-data="{

    init() {

   
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function( position ){ 
                    console.log( position );
            });
        } else { 
            address.innerHTML = 'Geolocation is not supported by this browser.';
        }
    }

}">

<p id="address"></p>
</div>