<?php

namespace App\Http\Livewire;
use App\Models\Activity;
use Livewire\Component;

class Calendar extends Component
{
  
    public $events = [];
    public $branch_id =1522;
    public $branches;
    public $type = '0';
    public $types = [
        '0'=>'All',
        '4'=> 'Sales Appointment',
        '5' => 'Stop By',
        '7' => 'Proposal',
        '10' => 'Site Visit',
        '13'=> 'Log a Call',
        '14' => 'In Person'];

    public function updatedBranchId()
    {
        $this->emit("refreshCalendar");
    }

    public function updatedType()
    {
        $this->emit("refreshCalendar");
    }
    public function mount()
    {
        $this->branches = [
            1506 => "1506 - Santa Rosa, CA",
            1516 => "1516 - Fairfield, CA",
            1518 => "1518 - Turlock, CA",
            1522 => "1522 - Stockton, CA",
            1525 => "1525 - Concord, CA",
            1552 => "1552 - Manteca, CA",
            1589 => "1589 - Modesto, CA", 

        ];
        $keys = array_keys($this->branches);
        //$this->branch_id = reset($keys);
    }

    
   
    public function eventDrop($event)
    {
        
        $activity = Activity::findOrFail($event['id']);
        if ($event['start'] > now()->endOfDay()) {
            $completed = null;  
           
        } else {
            $completed = $activity->completed;
        }
        $activity->update(
            [
                'activity_date'=>$event['start'], 
                'completed'=>$completed,
            ]
        );
        $this->emit("refreshCalendar");
    }
    public function render()
    {
        return view('livewire.calendar');
    }
}
