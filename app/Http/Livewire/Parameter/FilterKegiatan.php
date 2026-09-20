<?php

namespace App\Http\Livewire\Parameter;

use App\Models\Kelompok;
use Livewire\Component;

class FilterKegiatan extends Component
{
    public $ms_desa_id = null;

    public $scope = '';

    public $selectedJenjang = [];

    public $selectedKelompok = [];

    public $selectedTipeKegiatan = [];

    public $listKelompok = [];


    protected $listeners = [
        'parameterUpdated' => 'setParameterDesa',
        'applyFilters' => 'applyFilters',
        'clearFilters' => 'clearFilters',
    ];

    public function setParameterDesa($desaId)
    {
        $this->ms_desa_id = $desaId;
        $this->selectedKelompok = [];
        $this->loadKelompok();
    }

    public function loadKelompok()
    {
        if (!$this->ms_desa_id) {
            $this->listKelompok = [];

            return;
        }

        $this->listKelompok = Kelompok::query()
            ->where('ms_desa_id', $this->ms_desa_id)
            ->orderBy('nama_kelompok')
            ->get();
    }

    public function applyFilters($filters)
    {
        $this->scope = $filters['scope'] ?? '';
        $this->selectedJenjang = $filters['jenjang'] ?? [];
        $this->selectedKelompok = $filters['kelompok'] ?? [];
        $this->selectedTipeKegiatan = $filters['tipeKegiatan'] ?? [];

        // Jika bukan scope kelompok,
        // kelompok tidak relevan.
        if ($this->scope !== 'kelompok') {
            $this->selectedKelompok = [];
        }

        // Kirim hasil filter ke parent/report
        $this->emit('filterKegiatanUpdated',
            $this->scope,
            $this->selectedJenjang,
            $this->selectedKelompok,
            $this->selectedTipeKegiatan
        );
    }
    
    public function clearFilters()
    {
        $this->scope = '';

        $this->selectedJenjang = [];

        $this->selectedKelompok = [];

        $this->selectedTipeKegiatan = [];

        $this->emit('filterKegiatanUpdated',
            $this->scope,
            $this->selectedJenjang,
            $this->selectedKelompok,
            $this->selectedTipeKegiatan
        );
    }

    public function render()
    {
        return view('livewire.parameter.filter-kegiatan',[
            'listKelompok' => $this->listKelompok,
        ]);
    }
}
