<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Address;
use Livewire\WithPagination;
use App\Transformers\AddressMarkerTransformer;
class MapView extends Component
{
    
    public $limit = 25;
    public $perPage;
    public $findaddress;
    public Address $me;

    public function updatedLimit()
    {
       
        $this->emit("refreshMap");
    }
    public function mount()
    {
        
        
    }
    public function render()
    {
        
       
        $this->_getMarkers();
        return view(
            'livewire.map-view', [
                
                'limits'=>[1=>1,5=>5,10=>10,25=>25,50=>50],
                'addresses' => Address::nearby($this->me, $this->limit)
                ->orderBy('distance')
                            ->paginate($this->perPage),
                'lat'=>$this->me->lat, 
                'lng'=> $this->me->lng,
            ]
        );
    }

    private function _getMarkers()
    {
        $this->me = new Address(['lat'=>38.232471, 'lng'=> -122.636848]);
        $addresses = Address::nearby($this->me, $this->limit)->orderBy('distance')
                            ->get();
        
        $markers =  \Fractal::create()->collection($addresses)
            ->transformWith(AddressMarkerTransformer::class)
            ->toArray();
        $this->markers =   json_encode($markers['data']);

    }
}
