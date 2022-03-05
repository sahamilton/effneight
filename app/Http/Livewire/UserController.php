<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;


class UserController extends Component
{
    use WithPagination;
    public User $user;
    public $perPage;
    public $search = '';
    public $sortField='name';
    public $sortAsc=true;

    public function render()
    {
        return view('livewire.user-controller',
            [

                'users'=>User::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage),
            ]);
    }
}
