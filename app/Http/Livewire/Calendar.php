<?php

namespace App\Http\Livewire;
use App\Models\Activity;
use Livewire\Component;

class Calendar extends Component
{
  
    public $events = [];
    
   

   
    public function eventDrop($event)
    {
        $activity = Activity::findOrFail($event['id']);
        $activity->update(['activity_date'=>$event['start']]);
        
    }
    public function render()
    {
        return view('livewire.calendar');
    }
}
