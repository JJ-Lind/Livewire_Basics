<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class SearchDropdown extends Component {

    public $search;
    public $search_results = [];

    public function updatedSearch($new_value)
    {
        if (strlen($this->search) < 3) {
            $this->search_results = [];

            return;
        }

        $response = Http::get('https://itunes.apple.com/search/?term=' . $this->search . '&limit=10');
        $this->search_results = $response->json()['results'];
    }

    public function render()
    {
        return view('livewire.search-dropdown');
    }
}
