<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    public $dates = ['activity_date'];

    public $fillable = ['activity_date', 'completed'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function type()
    {
        return $this->belongsTo(ActivityType::class, 'activitytype_id', 'id');
    }

    public function relatesToAddress()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }
}
