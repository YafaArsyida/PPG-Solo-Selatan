<div wire:ignore.self class="offcanvas offcanvas-top border-0" id="offcanvasLaporan"
    aria-labelledby="offcanvasLaporanLabel" style="min-height:100vh; background:#f8fafc;">

    {{-- HEADER --}}
    <div class="offcanvas-header border-bottom bg-white px-4 py-3 shadow-sm">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="avatar-xs">
                    <div class="avatar-title rounded-circle bg-soft-success text-success">
                        <i class="ri-file-chart-line"></i>
                    </div>
                </div>

                <span class="badge bg-soft-success text-success fw-semibold px-3 py-2">
                    Laporan Kehadiran
                </span>
            </div>

            <h4 class="offcanvas-title fw-bold mb-0" id="offcanvasLaporanLabel">
                Kegiatan Generus Desa {{ $nama_desa }}
            </h4>

            <div class="text-muted fs-13 mt-1">
                Rekap kehadiran, izin, dan alfa peserta kegiatan generus
            </div>
        </div>

        <button type="button"
            class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center"
            style="width:42px;height:42px" data-bs-dismiss="offcanvas">
            <i class="ri-close-line fs-18"></i>
        </button>
    </div>

    {{-- BODY --}}
    <div class="offcanvas-body p-4">

        @if($kegiatan)

        <div class="card border-0 shadow-sm">
        
            <div class="card-body">
        
                {{-- HEADER --}}
                <div class="text-center mb-4">
        
                    <h4 class="fw-bold mb-1 text-uppercase">
                        {{ $kegiatan->nama_kegiatan }}
                    </h4>
        
                    <div class="text-muted">
                        {{ $kegiatan->lokasi_final['tempat'] ?? '-' }}
                        {{-- {{ $kegiatan->alamat }} --}}
                    </div>
        
                </div>
        
                <div class="table-responsive">
        
                    <table class="table table-bordered align-middle text-center">
        
                        <thead class="table-light">
        
                            <tr>
                                <th rowspan="2">NO</th>
                                <th rowspan="2">KELOMPOK</th>
        
                                <th colspan="3">
                                    JUMLAH JAMAAH
                                </th>
        
                                <th colspan="5">
                                    KEHADIRAN
                                    {{
                                    strtoupper(
                                    \App\Http\Controllers\HelperController::formatTanggalIndonesia(
                                    $kegiatan->tanggal,
                                    'd F Y'
                                    )
                                    )
                                    }}
                                </th>
                            </tr>
        
                            <tr>
        
                                <th>Putra</th>
                                <th>Putri</th>
                                <th>Jumlah</th>
        
                                <th>Putra</th>
                                <th>Putri</th>
                                <th>Jumlah</th>
                                <th>Infaq</th>
                                <th>%</th>
        
                            </tr>
        
                        </thead>
        
                        <tbody>
        
                            @foreach($laporanRows as $row)
        
                            <tr>
        
                                <td>
                                    {{ $loop->iteration }}
                                </td>
        
                                <td class="text-start fw-semibold">
                                    {{ strtoupper($row['kelompok']) }}
                                </td>
        
                                <td>{{ $row['target_l'] }}</td>
                                <td>{{ $row['target_p'] }}</td>
                                <td class="fw-bold">
                                    {{ $row['target_total'] }}
                                </td>
        
                                <td>{{ $row['hadir_l'] }}</td>
                                <td>{{ $row['hadir_p'] }}</td>
        
                                <td class="fw-bold">
                                    {{ $row['hadir_total'] }}
                                </td>
        
                                <td>
                                    Rp{{ number_format($row['infaq'], 0, ',', '.') }}
                                </td>
        
                                <td class="fw-bold">
                                    {{ $row['presentase'] }}%
                                </td>
        
                            </tr>
        
                            @endforeach
        
                        </tbody>
        
                        {{-- FOOTER --}}
                        <tfoot class="table-light fw-bold">
        
                            <tr>
        
                                <td colspan="2" class="text-center">
                                    JUMLAH
                                </td>
        
                                <td>{{ $grandTotal['target_l'] }}</td>
                                <td>{{ $grandTotal['target_p'] }}</td>
                                <td>{{ $grandTotal['target_total'] }}</td>
        
                                <td>{{ $grandTotal['hadir_l'] }}</td>
                                <td>{{ $grandTotal['hadir_p'] }}</td>
                                <td>{{ $grandTotal['hadir_total'] }}</td>
        
                                <td>
                                    Rp{{ number_format($grandTotal['infaq'], 0, ',', '.') }}
                                </td>
        
                                <td>
                                    {{ $grandTotal['target_total'] > 0
                                    ? round(($grandTotal['hadir_total'] / $grandTotal['target_total']) * 100)
                                    : 0 }}%
                                </td>
        
                            </tr>
        
                        </tfoot>
        
                    </table>
        
                </div>
        
            </div>
        
        </div>

        {{-- CONTENT --}}
        <div class="row g-4">

            {{-- PRESENSI --}}
            <div class="col-xxl-7 col-lg-7">

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    <div class="card-header bg-white border-0 py-3 px-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ri-team-line text-success fs-18"></i>

                            <h5 class="card-title mb-0 fw-bold">
                                Rekap Kehadiran
                            </h5>
                        </div>
                    </div>

                    <div class="card-body bg-light-subtle">
                        @livewire('laporan.desa.kegiatan-event.report.attendance', [
                        'kegiatanId' => $kegiatanId
                        ])
                    </div>

                </div>

            </div>

            {{-- ALFA --}}
            <div class="col-xxl-5 col-lg-5">

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    <div class="card-header bg-white border-0 py-3 px-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ri-user-unfollow-line text-danger fs-18"></i>

                            <h5 class="card-title mb-0 fw-bold">
                                Tanpa Keterangan / Alfa
                            </h5>
                        </div>
                    </div>

                    <div class="card-body bg-light-subtle">
                        @livewire('laporan.desa.kegiatan-event.report.alfa', [
                        'kegiatanId' => $kegiatanId
                        ])
                    </div>

                </div>

            </div>

        </div>

        @endif

    </div>

</div>