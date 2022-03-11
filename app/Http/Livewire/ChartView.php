<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ChartView extends Component
{
    protected $listeners = ['branchUpdated'];
    public $branch_id;


    public function mount($branch_id)
    {
        $this->branch_id = $branch_id;
       
    }

    public function render()
    {
        return view('livewire.chart-view',
            [
                'labels'=>['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Apr'],
                'values'=> [200, 150, 350, 225, 125, 50],
            ]
        );
    }

    public function branchUpdated($branch_id)
    {
        $this->branch_id = $branch_id;
        
    }
}
