<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
class UserAutocomplete extends Autocomplete
{
    protected $listeners = ['valueSelected'];

    public function valueSelected(User $user)
    {
        $this->emitUp('userSelected', $user);
    }

    public function query() {
        if ($this->search !='') {
            ddd($this->search);
        }
        return User::where('name', 'like', '%'.$this->search.'%')->orderBy('name');
    }
}