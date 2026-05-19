<?php

namespace App\Http\Livewire\Parameter;

use App\Models\AksesPengguna;
use App\Models\Desa as ModelsDesa;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Desa extends Component
{
    public $selectedDesa = null;

    public function updatedSelectedDesa()
    {
        $this->checkAndEmitParameters();
    }

    public function mount()
    {
        $user = Auth::user();
        // SUPERADMIN
        if ($user->peran === 'SUPERADMIN') {
            $firstDesa = ModelsDesa::first();
            $this->selectedDesa = $firstDesa?->ms_desa_id;
            return;
        }

        // USER BIASA
        $akses = AksesPengguna::where('ms_pengguna_id', $user->ms_pengguna_id)
            ->where('scope_type', 'desa')
            ->first();
        $this->selectedDesa = $akses?->scope_id;
    }

    private function checkAndEmitParameters()
    {
        if ($this->selectedDesa !== null) {
            $this->emit('parameterUpdated', $this->selectedDesa);
            $this->dispatchBrowserEvent('alertify-success', ['message' => 'Memperbarui...']);
        }
    }

    public function refreshParameters()
    {
        $this->selectedDesa = null;
        $this->emit('parameterUpdated', null);
    }

    public function render()
    {
        $user = Auth::user();

        // SUPERADMIN -> semua desa
        if ($user->peran === 'SUPERADMIN') {

            $selectDesa = ModelsDesa::get();
        } else {

            // USER BIASA -> hanya akses desa
            $selectDesa = ModelsDesa::whereIn(
                'ms_desa_id',

                AksesPengguna::where('ms_pengguna_id', $user->ms_pengguna_id)
                    ->where('scope_type', 'desa')
                    ->pluck('scope_id')

            )->get();
        }

        if ($this->selectedDesa) {
            $this->emit('parameterUpdated', $this->selectedDesa);
        }

        return view('livewire.parameter.desa', [
            'select_desa' => $selectDesa
        ]);
    }
}
