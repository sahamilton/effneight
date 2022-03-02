<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Address;
class MapView extends Component
{
    
    public $limit = 25;

    public function render()
    {
        return view(
            'livewire.map-view', [
                'markers'=>Address::select('id', 'businessname', 'lat', 'lng')
                    ->limit($this->limit)
                    ->get()
                    ->toJson(),
                'limits'=>[1=>1,10=>10,25=>25,50=>50],
            ]
        );
    }
}
