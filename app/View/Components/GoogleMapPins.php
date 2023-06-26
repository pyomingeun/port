<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GoogleMapPins extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    protected $locations;
    public function __construct($locations)
    {
        $this->locations = $locations;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.google-map-pins', [
            'locations' => $this->locations
        ]);
    }
}
