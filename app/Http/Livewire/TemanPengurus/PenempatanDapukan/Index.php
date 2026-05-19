<?php

namespace App\Http\Livewire\TemanPengurus\PenempatanDapukan;

use App\Models\TemanPengurus\Dapukan;
use App\Models\TemanPengurus\PenempatanDapukan;
use App\Models\TemanPengurus\Pengurus;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public $ms_pengurus_id;

    public $pengurus;

    public $listPenempatan = [];
    public $listDapukan = [];

    public $forms = [];

    public $editId = null;

    public $editForm = [];

    protected $listeners = [
        'PenempatanDapukan'
    ];

    public function mount()
    {
        $this->addForm();
        $this->loadDapukan();
    }

    public function PenempatanDapukan($id)
    {
        $this->resetValidation();

        $this->ms_pengurus_id = $id;

        $this->pengurus = Pengurus::with([
            'ms_kelompok'
        ])->findOrFail($id);

        $this->loadPenempatan();

        $this->forms = [];

        $this->addForm();

        $this->loadDapukan();
    }

    public function loadPenempatan()
    {
        $this->listPenempatan = PenempatanDapukan::with([
            'ms_dapukan'
        ])
            ->where(
                'ms_pengurus_id',
                $this->ms_pengurus_id
            )
            ->latest()
            ->get();
    }

    public function loadDapukan()
    {
        $this->listDapukan = Dapukan::orderBy(
            'nama_dapukan'
        )->get();
    }

    public function addForm()
    {
        $this->forms[] = [
            'ms_dapukan_id' => '',
            'nama_penempatan' => '',
            'status' => 'aktif',
            'deskripsi' => '',
        ];
    }

    public function edit($id)
    {
        $data = PenempatanDapukan::findOrFail($id);

        $this->editId = $id;

        $this->editForm = [
            'ms_dapukan_id' => $data->ms_dapukan_id,
            'nama_penempatan' => $data->nama_penempatan,
            'deskripsi' => $data->deskripsi,
        ];
    }

    public function removeForm($index)
    {
        unset($this->forms[$index]);

        $this->forms = array_values(
            $this->forms
        );
    }

    protected function rules()
    {
        return [
            'forms.*.ms_dapukan_id' => 'required',
            'forms.*.nama_penempatan' => 'required|string|max:150',
            'forms.*.status' => 'required|in:aktif,nonaktif',
            'forms.*.deskripsi' => 'nullable|string',
        ];
    }

    protected $messages = [
        'forms.*.ms_dapukan_id.required' => 'Dapukan wajib dipilih',
        'forms.*.nama_penempatan.required' => 'Nama penempatan wajib diisi',
    ];

    public function save()
    {
        $validated = $this->validate();

        DB::beginTransaction();

        try {

            foreach ($this->forms as $item) {

                $exists = PenempatanDapukan::where(
                    'ms_pengurus_id',
                    $this->ms_pengurus_id
                )
                    ->where(
                        'ms_dapukan_id',
                        $item['ms_dapukan_id']
                    )
                    ->exists();

                if ($exists) {
                    continue;
                }

                PenempatanDapukan::create([
                    'ms_pengurus_id' => $this->ms_pengurus_id,

                    'ms_dapukan_id' => $item['ms_dapukan_id'],

                    'nama_penempatan' => $item['nama_penempatan'],

                    'status' => $item['status'],

                    'deskripsi' => $item['deskripsi'],
                ]);
            }

            DB::commit();

            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'Berhasil ditambahkan'
            ]);

            $this->loadPenempatan();
            // $this->dispatchBrowserEvent('hide-modal', [
            //     'modalId' => 'PenempatanDapukan'
            // ]);

            $this->emit('PengurusIndex');
        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Terjadi kesalahan : ' . $e->getMessage()
            ]);
        }
    }

    public function update()
    {
        $edit = PenempatanDapukan::find($this->editId)
            ->update($this->editForm);

        $this->editId = null;

        $this->editForm = [];

        $this->loadPenempatan();
        $this->emit('PengurusIndex');

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Berhasil diperbarui'
        ]);
    }

    public function delete($id)
    {
        $data = PenempatanDapukan::find($id);

        if (!$data) {
            return;
        }

        $data->delete();

        if ($this->editId == $id) {

            $this->editId = null;
            $this->editForm = [];
        }

        $this->loadPenempatan();
        $this->emit('PengurusIndex');

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Berhasil dihapus'
        ]);
    }
    public function render()
    {
        return view('livewire.teman-pengurus.penempatan-dapukan.index');
    }
}
