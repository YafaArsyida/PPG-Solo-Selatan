<?php

namespace App\Http\Livewire\TemanPengurus\Dapukan;

use App\Models\TemanPengurus\Dapukan;
use Livewire\Component;

class Index extends Component
{
    public $search = '';

    protected $listeners = [
        'DapukanIndex' => '$refresh',
    ];

    public function getQueryProperty()
    {
        $query = Dapukan::query();

        if ($this->search) {
            $query->where('nama_dapukan', 'like', '%' . $this->search . '%');
        }

        return $query;
    }
    public function render()
    {
        return view('livewire.teman-pengurus.dapukan.index', [
            'data' => $this->query->paginate(10)
        ]);
    }
}
