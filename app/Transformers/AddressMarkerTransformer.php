<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Address;
class AddressMarkerTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Address $address)
    {
        
        $type = $this->_getAddressType($address);
        return [
            'id' => (int) $address->id,
            'type' => $type,
            'businessname' => $address->businessname, 
            
            'lat' => $address->lat, 
            'lng' => $address->lng, 
            'distance' => $address->distance,
            'url' => route('address.show', $address->id),
           
        ];
    }

    private function _getAddressType(Address $address)
    {
        return '';
    }
}
