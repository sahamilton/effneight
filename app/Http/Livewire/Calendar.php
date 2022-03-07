<?php

namespace App\Http\Livewire;
use App\Models\Activity;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\PeriodSelector;
class Calendar extends Component
{
    use PeriodSelector;
    public $events = [];
    public $branch_id =1522;
    public $branches;
    public $type = '0';
    public $status = '0';
    public $startdate ='2020-04-01';
    public $setPeriod = 'thisMonth';
    
    public $statuses = ['0'=>'All',
                        '1'=>'Completed',
                        '2'=>'Not Completed',];
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
    public function updatedSetPeriod()
    {
        
        $this->_setPeriod();
        ray($this->startdate);
        $this->emit("refreshCalendar");
    }
    public function updatedStartDate()
    {
        $this->emit("refreshCalendar");

    }
    public function updatedStatus()
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
        $this->_setPeriod();
        $this->startdate = $this->period['from']->format('Y-m-d');
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
                'activity_date'=>Carbon::parse($event['start']), 
                'completed'=>$completed,
            ]
        );
        
        $this->emit("refreshCalendar");
    }
    public function render()
    {
        $this->_setPeriod();
        
       
        return view('livewire.calendar');
    }

    /**
     * [_setPeriod description]
     *
     * @return setPeriod
     */
    private function _setPeriod()
    {
        
        $this->livewirePeriod($this->setPeriod);
        $this->startdate = $this->period['from']->format('Y-m-d');     
        
    }
}
