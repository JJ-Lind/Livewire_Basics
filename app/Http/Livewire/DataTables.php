<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class DataTables extends Component {

    use WithPagination;

    public $active = true;
    public $search;
    public $sort_asc = true;
    public $sort_field;
    protected $queryString = [
        'search' => ['except' => ''],
        'active' => ['except' => true],
        'sort_asc',
        'sort_field'
    ];

    public function sortBy($field)
    {
        if ($this->sort_field === $field) {
            $this->sort_asc = !$this->sort_asc;
        }
        else {
            $this->sort_asc = true;
        }
        $this->sort_field = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view("livewire.data-tables", [
            'users' => User::where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')->orWhere('email', 'like', '%' . $this->search . '%');
            })->where('active', $this->active)->when($this->sort_field, function ($query) {
                    $query->orderBy($this->sort_field, $this->sort_asc
                        ? 'asc'
                        : 'desc');
                })->paginate(10),
        ]);
    }
}
