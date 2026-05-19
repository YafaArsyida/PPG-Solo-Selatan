<?php

namespace App\Http\Livewire\TemanPengurus\Dapukan;

use App\Models\TemanPengurus\Dapukan;
use App\Models\TemanPengurus\Pengurus;
use Livewire\Component;

class Delete extends Component
{
    public $ms_dapukan_id;

    protected $listeners = [
        'DapukanDelete' => 'loadData'
    ];

    public function loadData($id)
    {
        $this->ms_dapukan_id = $id;
    }

    public function deleteDapukan()
    {
        if (!$this->ms_dapukan_id) {
            return;
        }

        // $used = Pengurus::whereHas('ms_dapukan', function ($q) {

        //     $q->where(
        //         'ms_dapukan.ms_dapukan_id',
        //         $this->ms_dapukan_id
        //     );
        // })->exists();

        // if ($used) {
        //     $this->dispatchBrowserEvent('alertify-error', [
        //         'message' => 'Gagal, dapukan sudah digunakan pengurus!'
        //     ]);

        //     return;
        // }

        Dapukan::where('ms_dapukan_id', $this->ms_dapukan_id)->delete();

        $this->dispatchBrowserEvent('hide-modal', [
            'modalId' => 'ModalDeleteDapukan'
        ]);

        $this->emit('DapukanIndex');

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Dapukan berhasil dihapus!'
        ]);
    }

    public function render()
    {
        return view('livewire.teman-pengurus.dapukan.delete');
    }
}
