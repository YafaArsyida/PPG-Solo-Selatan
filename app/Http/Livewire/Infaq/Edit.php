<?php

namespace App\Http\Livewire\Infaq;

use App\Models\TRInfaq;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    public $tr_infaq_id;

    public $ms_kegiatan_id;

    public $nama_kegiatan;

    public $nominal;

    public $tanggal;

    public $keterangan;

    protected $listeners = ['InfaqEdit'];

    public function InfaqEdit($ms_kegiatan_id)
    {
        $infaq = TRInfaq::where('ms_kegiatan_id', $ms_kegiatan_id)->first();

        if (!$infaq) {
            return;
        }

        $this->tr_infaq_id   = $infaq->tr_infaq_id;

        $this->ms_kegiatan_id = $infaq->ms_kegiatan_id;

        $this->nama_kegiatan = optional(
            $infaq->ms_kegiatan
        )->nama_kegiatan;

        $this->nominal = $infaq->nominal;
        $this->tanggal = $infaq->tanggal;
        $this->keterangan = $infaq->keterangan;

        $this->emitSelf('render');
    }

    protected $rules = [

        'nominal' => 'required|numeric|min:1000',
        'tanggal' => 'required|date',
        'keterangan' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'nominal.required' => 'Nominal wajib diisi.',
        'nominal.numeric'  => 'Nominal harus berupa angka.',
        'nominal.min'      => 'Minimal Rp 1.000.',

        'tanggal.required' => 'Tanggal wajib diisi.',

        'keterangan.max'   => 'Keterangan maksimal 500 karakter.',
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function update()
    {
        $validatedData = $this->validate();

        DB::beginTransaction();
        try {

            $infaq = TrInfaq::findOrFail(
                $this->tr_infaq_id
            );

            $infaq->update([

                'nominal'    => $this->nominal,
                'tanggal'    => $this->tanggal,
                'keterangan' => $this->keterangan,
            ]);

            DB::commit();

            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'Berhasil update infaq!'
            ]);

            $this->dispatchBrowserEvent('hide-modal', [
                'modalId' => 'ModalInfaqEdit'
            ]);

            $this->emit('KegiatanIndex');
        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Terjadi kesalahan : ' . $e->getMessage()
            ]);
        }
    }
    
    public function render()
    {
        return view('livewire.infaq.edit');
    }
}
