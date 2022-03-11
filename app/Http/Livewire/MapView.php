<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Address;
use Livewire\WithPagination;
use App\Transformers\AddressMarkerTransformer;
class MapView extends Component
{
    
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
        
        $this->_getZoom();
        $addresses = $this->_getAddresses();
        return view(
            'livewire.map-view', [
                
                'limits'=>[1=>1,5=>5,10=>10,25=>25,50=>50],
                'addresses' => Address::nearby($this->me, $this->limit)
                    ->search($this->search)
                    ->orderBy('distance', 'ASC')
                    ->paginate($this->perPage),
                'markers' =>$this->_getMarkers($addresses),
                'lat'=>$this->me->lat, 
                'lng'=> $this->me->lng,
            ]
        );
    }

    private function _getMarkers($addresses)
    {
        
        $markers =  \Fractal::create()->collection($addresses)
            ->transformWith(AddressMarkerTransformer::class)
            ->toArray();
        $this->markers =   json_encode($markers['data']);

    }

    private function _getAddresses()
    {
        $this->me = new Address(['lat'=>38.232471, 'lng'=> -122.636848]);
        return Address::nearby($this->me, $this->limit)
            ->search($this->search)
            ->orderBy('distance')
            ->get();
    }

    private function _getZoom()
    {
        switch($this->limit) {
            case '1':
                $this->zoom = 14;
                break;
            case '5':
                $this->zoom = 12;
                break;

            case '10':
                $this->zoom = 10;
                break;

            case '25':
                $this->zoom = 8;
                break;

            case '50':
                $this->zoom = 8;
                break;
        }
    }
}
