<?php

namespace App\Http\Livewire\TemanPengurus\Dapukan;

use App\Models\TemanPengurus\Dapukan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $nama_dapukan;
    public $deskripsi;

    protected $listeners = [
        'DapukanCreate',
    ];

    public function DapukanCreate()
    {
        $this->resetInput();
        $this->resetValidation();
    }

    protected function rules()
    {
        return [
            'nama_dapukan' => 'required|string|max:100|unique:ms_dapukan,nama_dapukan',
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

    public function save()
    {
        $validated = $this->validate();

        DB::beginTransaction();

        try {

            Dapukan::create([
                'nama_dapukan' => $this->nama_dapukan,
                'deskripsi' => $this->deskripsi,
            ]);

            DB::commit();

            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'Berhasil menambah dapukan'
            ]);

            $this->dispatchBrowserEvent('hide-modal', [
                'modalId' => 'DapukanCreate'
            ]);

            $this->emit('DapukanIndex');

            $this->resetInput();
        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Terjadi kesalahan : ' . $e->getMessage()
            ]);
        }
    }

    public function resetInput()
    {
        $this->nama_dapukan = '';
        $this->deskripsi = '';
    }

    public function render()
    {
        return view('livewire.teman-pengurus.dapukan.create');
    }
}
