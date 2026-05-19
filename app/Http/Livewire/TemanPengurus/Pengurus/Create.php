<?php

namespace App\Http\Livewire\TemanPengurus\Pengurus;

use App\Models\Desa;
use App\Models\Kelompok;
use App\Models\TemanPengurus\Pengurus;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $ms_desa_id;
    public $ms_kelompok_id;

    public $nama_pengurus;
    public $kode_pengurus;
    public $telepon;

    public $tempat_lahir;
    public $tanggal_lahir;

    public $jenis_kelamin;

    public $alamat;
    public $deskripsi;

    public $listDesa = [];
    public $listKelompok = [];

    protected $listeners = [
        'PengurusCreate',
    ];

    public function mount()
    {
        $this->loadDesa();
    }

    public function PengurusCreate()
    {
        $this->resetInput();
        $this->resetValidation();

        $this->loadDesa();
    }

    public function loadDesa()
    {
        $this->listDesa = Desa::orderBy(
            'nama_desa'
        )->get();
    }

    public function updatedMsDesaId($value)
    {
        $this->ms_kelompok_id = '';

        $this->listKelompok = Kelompok::where(
            'ms_desa_id',
            $value
        )
            ->orderBy('nama_kelompok')
            ->get();
    }

    protected function rules()
    {
        return [
            'ms_desa_id' => 'required',
            // 'ms_kelompok_id' => 'required',

            'nama_pengurus' => 'required|string|max:150',

            'kode_pengurus' => 'nullable|string|max:50|unique:ms_pengurus,kode_pengurus',

            'telepon' => 'nullable|string|max:20',

            'tempat_lahir' => 'nullable|string|max:100',

            'tanggal_lahir' => 'nullable|date',

            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',

            'alamat' => 'nullable|string',

            'deskripsi' => 'nullable|string',
        ];
    }

    protected $messages = [
        'ms_desa_id.required' => 'Desa wajib dipilih',
        // 'ms_kelompok_id.required' => 'Kelompok wajib dipilih',
        'nama_pengurus.required' => 'Nama pengurus wajib diisi',
        'kode_pengurus.unique' => 'Kode pengurus sudah digunakan',
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

            Pengurus::create([
                'ms_kelompok_id' => $this->ms_kelompok_id,

                'nama_pengurus' => $this->nama_pengurus,

                'kode_pengurus' => $this->kode_pengurus,

                'telepon' => $this->telepon,

                'tempat_lahir' => $this->tempat_lahir,

                'tanggal_lahir' => $this->tanggal_lahir,

                'jenis_kelamin' => $this->jenis_kelamin,

                'alamat' => $this->alamat,

                'deskripsi' => $this->deskripsi,
            ]);

            DB::commit();

            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'Berhasil menambah pengurus'
            ]);

            $this->dispatchBrowserEvent('hide-modal', [
                'modalId' => 'PengurusCreate'
            ]);

            $this->emit('PengurusIndex');

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
        $this->reset([
            'ms_desa_id',
            'ms_kelompok_id',

            'nama_pengurus',
            'kode_pengurus',
            'telepon',

            'tempat_lahir',
            'tanggal_lahir',

            'jenis_kelamin',

            'alamat',
            'deskripsi',
        ]);

        $this->listKelompok = [];
    }

    public function render()
    {
        return view('livewire.teman-pengurus.pengurus.create');
    }
}
