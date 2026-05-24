<?php

namespace App\Http\Livewire\TemanPengurus\Operasional\KegiatanPengurus;

use App\Models\TemanPengurus\PresensiKegiatanPengurus;
use Livewire\Component;
use Livewire\WithPagination;

class Attendance extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $ms_kegiatan_pengurus_id;

    public $search = '';
    public $gender = '';

    protected $listeners = [
        'setKegiatan' => 'setKegiatan',
    ];

    public function mount($kegiatanId = null)
    {
        $this->ms_kegiatan_pengurus_id = $kegiatanId;
    }

    public function setKegiatan($kegiatanId)
    {
        $this->ms_kegiatan_pengurus_id = $kegiatanId;

        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingMsKelompokId()
    {
        $this->resetPage();
    }

    public function updatingGender()
    {
        $this->resetPage();
    }

    public function getPresensiProperty()
    {
        return PresensiKegiatanPengurus::with([
            'ms_pengurus.ms_kelompok.ms_desa'
        ])
            ->where('ms_kegiatan_pengurus_id', $this->ms_kegiatan_pengurus_id)

            ->when($this->search, function ($q) {
                $q->whereHas('ms_pengurus', function ($qq) {
                    $qq->where('nama_pengurus', 'like', '%' . $this->search . '%');
                });
            })

            ->when($this->gender, function ($q) {
                $q->whereHas('ms_pengurus', function ($qq) {
                    $qq->where('jenis_kelamin', $this->gender);
                });
            })

            ->orderBy('waktu_hadir', 'desc')
            ->paginate(50);
    }

    public function render()
    {
        return view('livewire.teman-pengurus.operasional.kegiatan-pengurus.attendance',[
            'presensi' => $this->presensi,
        ]);
    }
}
