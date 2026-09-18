<?php

namespace App\Http\Livewire\LaporanKegiatan\KegiatanRutin;

use App\Models\KegiatanGenerus;
use App\Models\Kelompok;
use App\Models\PresensiKegiatanGenerus;
use App\Models\TRInfaq;
use Carbon\Carbon;
use Livewire\Component;

class Report extends Component
{
    public $kegiatan;
    public $kegiatanId;
    public $ms_desa_id;
    public $nama_desa = '-';

    public $search = '';
    public $listKelompok = [];

    public $targetTotal = 0;
    public $persentaseTotal = 0;
    public $totalInfaq = 0;

    public $startDate;
    public $endDate;

    public $laporanRows = [];
    public $tanggalMatrix = [];
    public $totalPerTanggal = [];

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate   = now()->endOfMonth()->format('Y-m-d');
    }

     public function resetTanggal()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate   = now()->endOfMonth()->format('Y-m-d');

        $this->generateTableReport();

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Periode diperbarui'
        ]);
    }

    public function updatedStartDate()
    {
        $this->generateTableReport();

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Periode diperbarui'
        ]);
    }

    public function updatedEndDate()
    {
       $this->generateTableReport();

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Periode diperbarui'
        ]);
    }

    public function updatedSearch()
    {
        $this->generateTableReport();
        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Memperbarui'
        ]);
    }

    protected $listeners = [
        'ReportRutin' => 'loadReport',
    ];

    public function loadReport($kegiatanId)
    {
        $this->resetReport();

        $this->kegiatanId = $kegiatanId;

        $this->kegiatan = KegiatanGenerus::with([
            'ms_desa',
        ])->find($kegiatanId);

        if (!$this->kegiatan) {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Data kegiatan tidak ditemukan'
            ]);

            return;
        }

        $this->ms_desa_id = $this->kegiatan->ms_desa_id;
        $this->nama_desa  = $this->kegiatan->ms_desa->nama_desa;

        // Tetap digunakan untuk kebutuhan filter/UI kelompok.
        $this->listKelompok = Kelompok::where(
            'ms_desa_id',
            $this->ms_desa_id
        )
            ->orderBy('nama_kelompok')
            ->get();

        $this->generateTableReport();

        $this->emitTo(
            'laporan-kegiatan.kegiatan-rutin.attendance',
            'setKegiatan',
            $kegiatanId,
        );

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Laporan kegiatan berhasil dimuat'
        ]);
    }

    private function resetReport()
    {
        $this->search = '';
        $this->kegiatan = null;
        $this->laporanRows = [];
        $this->tanggalMatrix = [];
        $this->totalPerTanggal = [];
    }

    private function generateTanggalMatrix()
    {
        $mapHari = [
            'minggu' => Carbon::SUNDAY,
            'senin'  => Carbon::MONDAY,
            'selasa' => Carbon::TUESDAY,
            'rabu'   => Carbon::WEDNESDAY,
            'kamis'  => Carbon::THURSDAY,
            'jumat'  => Carbon::FRIDAY,
            'sabtu'  => Carbon::SATURDAY,
        ];

        $hariRutin = $this->kegiatan->hari_rutin ?? [];

        $tanggal = [];

        $start = Carbon::parse($this->startDate);
        $end   = Carbon::parse($this->endDate);

        while ($start->lte($end)) {

            foreach ($hariRutin as $hari) {

                if (
                    isset($mapHari[$hari]) &&
                    $start->dayOfWeek === $mapHari[$hari]
                ) {
                    $tanggal[] = $start->format('Y-m-d');
                    break;
                }
            }

            $start->addDay();
        }

        return $tanggal;
    }

    private function generateTableReport()
    {
        if (
            !$this->kegiatanId ||
            !$this->startDate ||
            !$this->endDate ||
            Carbon::parse($this->endDate)->lt(
                Carbon::parse($this->startDate)
            )
        ) {
            return;
        }

        // --------------------------------------------------------------------------
        // TARGET PESERTA SESUAI SCOPE KEGIATAN
        // --------------------------------------------------------------------------

        $targetGenerus = $this->kegiatan
            ->targetPesertaQuery()
            ->with('ms_kelompok')
            ->get();

        // --------------------------------------------------------------------------
        // KELOMPOK TARGET
        // --------------------------------------------------------------------------

        $kelompoks = $targetGenerus
            ->filter(fn ($generus) => $generus->ms_kelompok)
            ->groupBy('ms_kelompok_id')
            ->map(function ($members) {

                $kelompok = $members->first()->ms_kelompok;

                // Jumlah target hanya dari generus yang termasuk
                // scope kegiatan ini.
                $kelompok->target_count = $members->count();

                return $kelompok;
            })
            ->filter(function ($kelompok) {

                if (!$this->search) {
                    return true;
                }

                return str_contains(
                    strtolower($kelompok->nama_kelompok),
                    strtolower($this->search)
                );
            })
            ->sortBy('nama_kelompok')
            ->values();

        // Total target keseluruhan
        $this->targetTotal = $kelompoks->sum('target_count');

        // --------------------------------------------------------------------------
        // TANGGAL PRESENSI (KOLOM TABEL)
        // --------------------------------------------------------------------------

        $this->tanggalMatrix = $this->generateTanggalMatrix();

        // --------------------------------------------------------------------------
        // SEMUA PRESENSI
        // --------------------------------------------------------------------------
        $presensis = PresensiKegiatanGenerus::query()
            ->with('ms_generus')
            ->where('ms_kegiatan_generus_id', $this->kegiatanId)
            ->where('status_hadir', 'hadir')
            ->whereIn(
                'tanggal_presensi',
                $this->tanggalMatrix
            )
            ->get();

        // --------------------------------------------------------------------------
        // PRESENSI MAP
        // --------------------------------------------------------------------------

        $presensiMap = $presensis
            ->groupBy(function ($item) {

                return
                    $item->ms_generus->ms_kelompok_id .
                    '|' .
                    Carbon::parse(
                        $item->tanggal_presensi
                    )->format('Y-m-d');
            });

        // --------------------------------------------------------------------------
        // TOTAL HADIR PER TANGGAL
        // --------------------------------------------------------------------------

        $hadirPerTanggal = $presensis
            ->groupBy(function ($item) {

                return Carbon::parse(
                    $item->tanggal_presensi
                )->format('Y-m-d');
            })
            ->map(fn ($items) => $items->count());

        // --------------------------------------------------------------------------
        // ROWS KELOMPOK
        // --------------------------------------------------------------------------

        $rows = [];

        foreach ($kelompoks as $kelompok) {

            $target = $kelompok->target_count;

            $row = [
                'kelompok' => strtoupper($kelompok->nama_kelompok),
                'target'   => $target,
                'tanggal'  => [],
                'persen'   => [],
            ];

            foreach ($this->tanggalMatrix as $tanggal) {

                $hadir = count(
                    $presensiMap[
                        $kelompok->ms_kelompok_id . '|' . $tanggal
                    ] ?? []
                );

                $persentase = $target > 0
                    ? round(($hadir / $target) * 100)
                    : 0;

                $row['tanggal'][$tanggal] = [
                    'hadir'      => $hadir,
                    'persentase' => $persentase,
                ];

                // Agar konsisten dengan report khusus
                // dan mudah dipanggil di Blade.
                $row['persen'][$tanggal] = $persentase;
            }

            $rows[] = $row;
        }

        $this->laporanRows = $rows;

        // --------------------------------------------------------------------------
        // FOOTER TOTAL PER TANGGAL
        // --------------------------------------------------------------------------

        foreach ($this->tanggalMatrix as $tanggal) {

            $hadirTotal = $hadirPerTanggal[$tanggal] ?? 0;

            $this->totalPerTanggal[$tanggal] = [
                'hadir' => $hadirTotal,

                'persentase' => $this->targetTotal > 0
                    ? round(($hadirTotal / $this->targetTotal) * 100)
                    : 0,

                'infaq' => 0,
            ];
        }

        // --------------------------------------------------------------------------
        // INFAQ PER TANGGAL
        // --------------------------------------------------------------------------

        $infaqs = TRInfaq::query()
            ->where(
                'ms_kegiatan_generus_id',
                $this->kegiatanId
            )
            ->whereBetween('tanggal', [
                $this->startDate,
                $this->endDate
            ])
            ->get()
            ->groupBy(function ($item) {

                return Carbon::parse(
                    $item->tanggal
                )->format('Y-m-d');
            });

        foreach ($this->tanggalMatrix as $tanggal) {

            $this->totalPerTanggal[$tanggal]['infaq'] =
                ($infaqs[$tanggal] ?? collect())
                    ->sum('nominal');
        }

        // --------------------------------------------------------------------------
        // TOTAL INFAQ
        // --------------------------------------------------------------------------

        $this->totalInfaq = collect(
            $this->totalPerTanggal
        )->sum('infaq');

        // --------------------------------------------------------------------------
        // PERSENTASE KESELURUHAN
        // --------------------------------------------------------------------------

        $totalHadir = collect(
            $this->totalPerTanggal
        )->sum('hadir');

        $totalTarget =
            $this->targetTotal *
            count($this->tanggalMatrix);

        $this->persentaseTotal = $totalTarget > 0
            ? round(($totalHadir / $totalTarget) * 100)
            : 0;
    }
    public function render()
    {
        return view('livewire.laporan-kegiatan.kegiatan-rutin.report');
    }
}
