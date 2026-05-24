<?php

namespace App\Http\Livewire\TemanPengurus\Operasional\KegiatanPengurus;

use App\Models\TemanPengurus\KegiatanPengurus;
use Livewire\Component;

class Report extends Component
{
    public $kegiatan;
    public $kegiatanId;

    protected $listeners = [
        'KegiatanReport' => 'loadReport'
    ];

    public function loadReport($kegiatanId)
    {
        $this->kegiatanId = $kegiatanId;

        // KEGIATAN
        $this->kegiatan = KegiatanPengurus::find($kegiatanId);

        if (!$this->kegiatan) {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Data kegiatan tidak ditemukan'
            ]);

            return;
        }

        // CHILD COMPONENT
        $this->emitTo(
            'teman-pengurus.operasional.kegiatan-pengurus.attendance',
            'setKegiatan',
            $kegiatanId
        );

        // SUCCESS
        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Laporan kegiatan berhasil dimuat'
        ]);
    }

    public function render()
    {
        return view('livewire.teman-pengurus.operasional.kegiatan-pengurus.report');
    }
}
