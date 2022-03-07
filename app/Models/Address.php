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

    public function sgetFullNameAttribute()
    {
        return $this->street . " " . $this->city . " " . $this->state . " " .$this->zip;
    }

}
