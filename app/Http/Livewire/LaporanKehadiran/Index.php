<?php

namespace App\Http\Livewire\LaporanKehadiran;

use App\Models\Generus;
use App\Models\KegiatanGenerus;
use App\Models\Kelompok;
use App\Models\PresensiKegiatanGenerus;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;

class Index extends Component
{  
    public $ms_desa_id = null;

    public $search = '';
    public $ms_kelompok_id = '';
    public $gender = '';

    public $startDate = null;
    public $endDate = null;

    public $listKelompok = [];


    // filtering
    public $scope = '';
    public $selectedJenjang = [];
    public $selectedKelompok = [];
    public $selectedTipeKegiatan = [];
    // end filtering

    protected $listeners = [
        'parameterUpdated' => 'setParameterDesa',
        'filterKegiatanUpdated' => 'updateFilterKegiatan',
    ];

    public function updateFilterKegiatan($scope, $jenjang, $kelompok, $tipeKegiatan) {
        $this->scope = $scope;
        $this->selectedJenjang = $jenjang ?? [];
        $this->selectedKelompok = $kelompok ?? [];
        $this->selectedTipeKegiatan = $tipeKegiatan ?? [];

        $this->validatePeriode();
    }

    protected function validatePeriode()
    {
        if (!$this->startDate || !$this->endDate) {
            return;
        }

        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        if ($start->gt($end)) {
            $this->endDate = $this->startDate;

            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Tanggal akhir tidak boleh sebelum tanggal awal.',
            ]);

            return;
        }

        $hasRutin = in_array(
            'rutin', $this->selectedTipeKegiatan ?? []
        );

        $maxMonths = $hasRutin ? 1 : 6;

        if ($start->copy()->addMonthsNoOverflow($maxMonths)->lt($end)) {
            $this->endDate = $start
                ->copy()
                ->addMonthsNoOverflow($maxMonths)
                ->format('Y-m-d');

            $this->dispatchBrowserEvent('alertify-error', [
                'message' => $hasRutin
                        ? 'Kegiatan rutin maksimal 1 bulan.'
                        : 'Periode maksimal 6 bulan.',
            ]);
        }
    }

    public function mount()
    {
        $this->startDate = now()->startOfMonth()
            ->format('Y-m-d');

        $this->endDate = now()->endOfMonth()
            ->format('Y-m-d');
    }

    public function updatedStartDate()
    {
        $this->validatePeriode();
    }

    public function updatedEndDate()
    {
        $this->validatePeriode();
    }


    // public function updating($property)
    // {
    //     if ($property !== 'page') {
    //         $this->resetPage();
    //     }
    // }

    public function setParameterDesa($desaId)
    {
        $this->ms_desa_id = $desaId;
        $this->ms_kelompok_id = null;
        $this->loadKelompok();
    }

    public function loadKelompok()
    {
        if (!$this->ms_desa_id) {
            $this->listKelompok = [];

            return;
        }

        $this->listKelompok = Kelompok::query()
            ->where('ms_desa_id', $this->ms_desa_id)
            ->orderBy('nama_kelompok')
            ->get();
    }

    public function resetTanggal()
    {
        $this->startDate = now()->startOfMonth()
            ->format('Y-m-d');

        $this->endDate = now()->endOfMonth()
            ->format('Y-m-d');

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Periode diperbarui',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Query Generus
    |--------------------------------------------------------------------------
    |
    | Generus adalah sumber BARIS utama laporan.
    |
    | Jangan filter berdasarkan presensi di sini.
    | Generus yang tidak memiliki presensi tetap harus muncul
    | dan nantinya akan ditampilkan sebagai Alfa.
    |
    */

    protected function getGenerusQuery()
    {
        return Generus::query()
            ->with('ms_kelompok')
            ->sambung()

            ->whereHas('ms_kelompok', function ($q) {
                $q->where(
                    'ms_desa_id',
                    $this->ms_desa_id
                );
            })

            ->when($this->ms_kelompok_id,
                fn ($q) =>
                    $q->where(
                        'ms_kelompok_id',
                        $this->ms_kelompok_id
                    )
            )

            ->when($this->gender,
                fn ($q) =>
                    $q->where(
                        'jenis_kelamin',
                        $this->gender
                    )
            )

            ->when($this->search,
                fn ($q) =>
                    $q->where(
                        'nama_generus',
                        'like',
                        "%{$this->search}%"
                    )
            )

            ->orderBy('nama_generus');
    }


    /*
    |--------------------------------------------------------------------------
    | Query Kegiatan
    |--------------------------------------------------------------------------
    |
    | Kegiatan adalah sumber data untuk KOLOM laporan.
    |
    */

    protected function getKegiatanQuery()
    {
        $query = KegiatanGenerus::query();

        if (!$this->ms_desa_id) {
            return $query->whereRaw('1 = 0');
        }


        /*
        |--------------------------------------------------------------------------
        | Visibility Rule
        |--------------------------------------------------------------------------
        |
        | Daerah  → seluruh desa di daerah
        | Desa    → desa aktif
        | Kelompok → kelompok dalam desa aktif
        |
        */
        $query->where(function ($q) {
            if ($this->scope === 'daerah') {

                $q->where('scope', 'daerah');

            } elseif ($this->scope === 'desa') {

                $q->where('scope', 'desa')
                    ->where(
                        'ms_desa_id',
                        $this->ms_desa_id
                    );

            } elseif ($this->scope === 'kelompok') {

                $q->where('scope', 'kelompok')
                    ->whereIn(
                        'ms_kelompok_id',
                        function ($sub) {
                            $sub->select('ms_kelompok_id')
                                ->from('ms_kelompok')
                                ->where(
                                    'ms_desa_id',
                                    $this->ms_desa_id
                                );
                        }
                    );

            } else {

                $q->where('scope', 'daerah');

                // Desa aktif
                $q->orWhere(function ($qq) {
                    $qq->where('scope', 'desa')
                        ->where(
                            'ms_desa_id', $this->ms_desa_id
                        );
                });

                // Kelompok dalam desa aktif
                $q->orWhere(function ($qq) {
                    $qq->where('scope', 'kelompok')
                        ->whereIn(
                            'ms_kelompok_id',
                            function ($sub) {
                                $sub->select('ms_kelompok_id')
                                    ->from('ms_kelompok')
                                    ->where(
                                        'ms_desa_id',
                                        $this->ms_desa_id
                                    );
                            }
                        );
                });
            }
        });

        if ($this->scope === 'kelompok' && !empty($this->selectedKelompok)) 
        {
            $query->whereIn(
                'ms_kelompok_id', $this->selectedKelompok
            );
        }

        $query->when(
            !empty($this->selectedTipeKegiatan),
            fn ($q) => $q->whereIn(
                'tipe_kegiatan', $this->selectedTipeKegiatan
            )
        );

        $query->when(
            !empty($this->selectedJenjang),
            fn ($q) => $q->whereIn(
                'jenjang',
                $this->selectedJenjang
            )
        );

        return $query
            ->orderByRaw("
                CASE
                    WHEN tipe_kegiatan = 'rutin' THEN 0
                    WHEN tipe_kegiatan = 'khusus' THEN 1
                    WHEN tipe_kegiatan = 'sekali' THEN 2
                    ELSE 3
                END
            ")
            ->orderBy('nama_kegiatan');
    }

    protected function generateOccurrences($kegiatanList)
    {
        $occurrences = collect();

        if (!$this->startDate || !$this->endDate) {
            return $occurrences;
        }

        $startDate = Carbon::parse($this->startDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        // Mapping hari_rutin → Carbon dayOfWeek
        // Carbon: Minggu = 0, Senin = 1, ..., Sabtu = 6
        $hariMap = [
            'minggu' => Carbon::SUNDAY,
            'senin'  => Carbon::MONDAY,
            'selasa' => Carbon::TUESDAY,
            'rabu'   => Carbon::WEDNESDAY,
            'kamis'  => Carbon::THURSDAY,
            'jumat'  => Carbon::FRIDAY,
            'sabtu'  => Carbon::SATURDAY,
        ];

        foreach ($kegiatanList as $kegiatan) {

            /*
            |--------------------------------------------------------------------------
            | SEKALI
            |--------------------------------------------------------------------------
            */
            if ($kegiatan->tipe_kegiatan === 'sekali') {

                if (!$kegiatan->tanggal) {
                    continue;
                }

                $tanggal = Carbon::parse($kegiatan->tanggal);

                if ($tanggal->between(
                    $startDate->copy()->startOfDay(),
                    $endDate->copy()->startOfDay()
                )) {
                    $occurrences->push([
                        'ms_kegiatan_generus_id' => $kegiatan->ms_kegiatan_generus_id,
                        'nama_kegiatan'          => $kegiatan->nama_kegiatan,
                        'tanggal'                => $tanggal->format('Y-m-d'),
                        'waktu'                  => $kegiatan->waktu,
                        'tipe_kegiatan'          => $kegiatan->tipe_kegiatan,
                    ]);
                }

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | RUTIN
            |--------------------------------------------------------------------------
            */
            if ($kegiatan->tipe_kegiatan === 'rutin') {

                if (empty($kegiatan->hari_rutin)) {
                    continue;
                }

                $hariRutin = collect($kegiatan->hari_rutin)
                    ->map(fn ($hari) => strtolower(trim($hari)))
                    ->filter(fn ($hari) => isset($hariMap[$hari]))
                    ->map(fn ($hari) => $hariMap[$hari])
                    ->unique()
                    ->values();

                if ($hariRutin->isEmpty()) {
                    continue;
                }

                $tanggal = $startDate->copy()->startOfDay();

                while ($tanggal->lte($endDate->copy()->startOfDay())) {

                    if ($hariRutin->contains($tanggal->dayOfWeek)) {

                        $occurrences->push([
                            'ms_kegiatan_generus_id' => $kegiatan->ms_kegiatan_generus_id,
                            'nama_kegiatan'          => $kegiatan->nama_kegiatan,
                            'tanggal'                => $tanggal->format('Y-m-d'),
                            'waktu'                  => $kegiatan->waktu,
                            'tipe_kegiatan'          => $kegiatan->tipe_kegiatan,
                        ]);
                    }

                    $tanggal->addDay();
                }

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | KHUSUS
            |--------------------------------------------------------------------------
            */
            if ($kegiatan->tipe_kegiatan === 'khusus') {

                if (empty($kegiatan->jadwal_khusus)) {
                    continue;
                }

                foreach ($kegiatan->jadwal_khusus as $jadwal) {

                    if (empty($jadwal['tanggal'])) {
                        continue;
                    }

                    $tanggal = Carbon::parse($jadwal['tanggal']);

                    if (!$tanggal->between(
                        $startDate->copy()->startOfDay(),
                        $endDate->copy()->startOfDay()
                    )) {
                        continue;
                    }

                    $occurrences->push([
                        'ms_kegiatan_generus_id' => $kegiatan->ms_kegiatan_generus_id,
                        'nama_kegiatan'          => $kegiatan->nama_kegiatan,
                        'tanggal'                => $tanggal->format('Y-m-d'),
                        'waktu'                  => $jadwal['waktu'] ?? $kegiatan->waktu,
                        'tipe_kegiatan'          => $kegiatan->tipe_kegiatan,
                    ]);
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        | Urut berdasarkan tanggal → waktu → nama kegiatan
        |--------------------------------------------------------------------------
        */
        return $occurrences
            ->sortBy([
                ['tanggal', 'asc'],
                ['waktu', 'asc'],
                ['nama_kegiatan', 'asc'],
            ])
            ->values();
    }


    /*
    |--------------------------------------------------------------------------
    | Presensi Matrix
    |--------------------------------------------------------------------------
    |
    | Bentuk:
    |
    | $matrix[generus_id][ms_kegiatan_generus_id][tanggal] = status
    |
    */

    protected function getPresensiMatrix($generusList, $occurrences)
    {
        if ($generusList->isEmpty() || $occurrences->isEmpty()) {
            return [];
        }

        $generusIds = $generusList
            ->pluck('ms_generus_id')
            ->unique()
            ->values();

        $kegiatanIds = $occurrences
            ->pluck('ms_kegiatan_generus_id')
            ->unique()
            ->values();

        $presensis = PresensiKegiatanGenerus::query()
            ->whereIn('ms_generus_id', $generusIds)
            ->whereIn('ms_kegiatan_generus_id', $kegiatanIds)
            ->whereBetween('tanggal_presensi', [
                $this->startDate,
                $this->endDate,
            ])
            ->get();

        $matrix = [];

        foreach ($presensis as $presensi) {
            $tanggal = \Carbon\Carbon::parse(
                $presensi->tanggal_presensi
            )->format('Y-m-d');

            $matrix[
                $presensi->ms_generus_id
            ][
                $presensi->ms_kegiatan_generus_id
            ][
                $tanggal
            ] = $presensi->status_hadir;
        }


        return $matrix;
    }

    public function render()
    {
        $generusList = $this->getGenerusQuery()->get();

        $kegiatanList = $this->getKegiatanQuery()->get();

        $occurrences = $this->generateOccurrences(
            $kegiatanList
        );

        $presensiMatrix = $this->getPresensiMatrix(
            $generusList,
            $occurrences
        );

        return view('livewire.laporan-kehadiran.index', [
                'generusList' => $generusList,
                'kegiatanList' => $kegiatanList,
                'occurrences' => $occurrences,
                'presensiMatrix' => $presensiMatrix,
            ]
        );
    }
}
