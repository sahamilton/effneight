<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Section extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return function ($componentData) {
            return <<<BLADE
                @section("{$componentData['attributes']->get('name')}")
                    {$componentData['slot']}
                @endsection
            BLADE;
        };
    }
}
