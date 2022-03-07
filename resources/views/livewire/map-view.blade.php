<div>
    <script src="//maps.googleapis.com/maps/api/js?key={{config('app.google_api')}}"
          
        ></script>
    <h2>Maps {{$limit}}</h2>
   <x-form-input type="text" wire:model="findaddress" name="findaddress" placeholder="Add an address" />

    <x-form-select wire:model='limit' name="limit" :options="$limits" />
      @push('scripts')
      <x-map-script :markers="$markers" />
    
    @endpush
    
    <div wire:ignore x-ref='map' id="map" style="width: 60%; height: 600px;"></div>
</div>
