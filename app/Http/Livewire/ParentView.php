<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ParentView extends Component
{
    public array $branches;
    public $branch_id = 1506;

    public function updatedBranchId()
    {
        $this->emit('branchUpdated', $this->branch_id);
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

    }


    public function render()
    {
        return view('livewire.parent-view');
    }
}
