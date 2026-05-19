<?php

namespace App\Http\Livewire\TemanPengurus\Dapukan;

use App\Models\TemanPengurus\Dapukan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    public $ms_dapukan_id;

    public $nama_dapukan;
    public $deskripsi;

    protected $listeners = [
        'DapukanEdit',
    ];

    public function DapukanEdit($id)
    {
        $this->resetValidation();

        $data = Dapukan::findOrFail($id);

        $this->ms_dapukan_id = $data->ms_dapukan_id;
        $this->nama_dapukan = $data->nama_dapukan;
        $this->deskripsi = $data->deskripsi;
    }

    protected function rules()
    {
        return [
            'nama_dapukan' => 'required|string|max:100|unique:ms_dapukan,nama_dapukan,' . $this->ms_dapukan_id . ',ms_dapukan_id',
            'deskripsi' => 'nullable|string',
        ];
    }

    protected $messages = [
        'nama_dapukan.required' => 'Nama dapukan wajib diisi',
        'nama_dapukan.unique' => 'Nama dapukan sudah tersedia',
    ];

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function update()
    {
        $validated = $this->validate();

        DB::beginTransaction();

        try {

            $data = Dapukan::findOrFail(
                $this->ms_dapukan_id
            );

            $data->update([
                'nama_dapukan' => $this->nama_dapukan,
                'deskripsi' => $this->deskripsi,
            ]);

            DB::commit();

            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'Berhasil update dapukan'
            ]);

            $this->dispatchBrowserEvent('hide-modal', [
                'modalId' => 'DapukanEdit'
            ]);

            $this->emit('DapukanIndex');
        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Terjadi kesalahan : ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.teman-pengurus.dapukan.edit');
    }
}
