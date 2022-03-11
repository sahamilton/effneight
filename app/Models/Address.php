<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Geocode;
class Address extends Model
{
    use HasFactory, Geocode;
    public $table = 'addresses';
    public $fillable = ['lat', 'lng'];

    public function getFullAddressAttribute()
    {
        return $this->street . " <br />" . $this->city . " " . $this->state . " " .$this->zip;
    }

    public function scopeSearch($query, $search)
    {

        return  $query->where('businessname', 'like', "%{$search}%")
            ->Orwhere('street', 'like', "%{$search}%")
            ->Orwhere('city', 'like', "%{$search}%");
    }

}
