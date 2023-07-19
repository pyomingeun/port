<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SearchHotelForm extends Component
{
    public $hotelName;
    
    public function __construct($hotelName)
    {
        $this->hotelName = $hotelName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.search-hotel-form');
    }
}
