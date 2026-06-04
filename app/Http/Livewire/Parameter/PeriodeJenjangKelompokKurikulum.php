<?php

namespace App\Http\Livewire\Parameter;

use App\Models\JenjangKurikulum;
use App\Models\Kelompok;
use App\Models\PeriodeKurikulum;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PeriodeJenjangKelompokKurikulum extends Component
{
    public $selectedPeriode = null;
    public $selectedJenjang = null;
    public $selectedKelompok = null;

    private function getKelompokQuery()
    {
        $user = Auth::user();

        // SUPERADMIN lihat semua
        if ($user->peran === 'SUPERADMIN') {
            return Kelompok::query();
        }

        $aksesPengguna = $user->ms_akses_pengguna;

        if ($aksesPengguna->isEmpty()) {
            return Kelompok::query()->whereRaw('1 = 0');
        }

        $query = Kelompok::query();

        $query->where(function ($q) use ($aksesPengguna) {

            foreach ($aksesPengguna as $akses) {
                switch ($akses->scope_type) {
                    case 'kelompok':
                        $q->orWhere('ms_kelompok_id', $akses->scope_id);
                        break;

                    case 'desa':
                        $q->orWhere('ms_desa_id', $akses->scope_id);
                        break;

                    case 'daerah':

                        $q->orWhereIn(
                            'ms_desa_id', Desa::query()
                                ->where('ms_daerah_id', $akses->scope_id)
                                ->pluck('ms_desa_id')
                        );

                        break;
                }
            }
        });

        return $query;
    }

    public function mount()
    {
        // PERIODE DEFAULT
        $this->selectedPeriode = PeriodeKurikulum::query()
            ->where('status', 'aktif')
            ->value('ms_periode_kurikulum_id');

        // JENJANG DEFAULT
        $this->selectedJenjang = JenjangKurikulum::query()
            ->value('ms_jenjang_kurikulum_id');

        $this->selectedKelompok = $this->getKelompokQuery()
            ->orderBy('nama_kelompok')
            ->value('ms_kelompok_id');
    }

    public function updatedSelectedPeriode()
    {
        $this->checkAndEmitParameters();
    }

    public function updatedSelectedJenjang()
    {
        $this->checkAndEmitParameters();
    }

    public function updatedSelectedKelompok()
    {
        $this->checkAndEmitParameters();
    }

    private function checkAndEmitParameters()
    {
        if (
            $this->selectedPeriode &&
            $this->selectedJenjang &&
            $this->selectedKelompok
        ) {

            $this->emit('parameterKurikulumUpdated', [

                'periode' => $this->selectedPeriode,

                'jenjang' => $this->selectedJenjang,

                'kelompok' => $this->selectedKelompok,

            ]);

            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'Memperbarui kurikulum...'
            ]);
        }
    }
    public function refreshParameters()
    {
        $this->selectedPeriode = null;
        $this->selectedJenjang = null;
        $this->selectedKelompok = null;

        $this->emit('parameterKurikulumUpdated', null);
    }


    public function render()
    {
        $user = Auth::user();

        return view('livewire.parameter.periode-jenjang-kelompok-kurikulum',[
            'select_periode' => PeriodeKurikulum::query()
                ->orderByDesc('tanggal_mulai')
                ->get(),

            'select_jenjang' => JenjangKurikulum::query()
                ->orderBy('nama_jenjang')
                ->get(),

            'select_kelompok' => $this->getKelompokQuery()
                ->orderBy('nama_kelompok')
                ->get(),
        ]);
    }
}
