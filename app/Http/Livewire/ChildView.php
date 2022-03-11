<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ChildView extends Component
{
    public $branch_id;
    public function mount($branch_id)
    {
        @ray($branch_id);
        $this->branch_id = $branch_id;
    }
    public function render()
    {
        return view('livewire.child-view');
    }
}
