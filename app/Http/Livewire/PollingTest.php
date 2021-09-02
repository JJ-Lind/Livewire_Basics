<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class PollingTest extends Component {

    public $revenue;

    public function mount()
    {
        $this->getRevenue();
    }

    public function getRevenue()
    {
        $this->revenue = (new Order)->all()->sum('price');
    }

    public function render()
    {
        return view('livewire.polling-test');
    }
}
