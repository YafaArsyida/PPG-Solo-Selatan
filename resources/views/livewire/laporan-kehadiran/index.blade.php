<div class="card border-0 shadow-sm rounded-4 overflow-hidden" id="kegiatanGenerusList">
    {{-- HEADER --}}
    <div class="card-header bg-white border-0 p-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">
            {{-- TITLE --}}
            <div>
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-sm">
                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-20">
                            <i class="ri-calendar-event-line">
                            </i>
                        </div>
                    </div>
    
                    <div>
                        <h5 class="fw-bold mb-1">
                            Laporan Kehadiran Generasi Penerus
                        </h5>
                        <small>
                            Kelola laporan kehadiran generus 
                        </small>
                    </div>
                </div>
            </div>
    
            {{-- ACTION --}}
            <div class="d-flex gap-2 flex-wrap">
                <button type="button" class="btn rounded-pill px-4 btn-primary d-inline-flex align-items-center gap-1"
                    data-bs-toggle="offcanvas" data-bs-target="#filterKegiatan" aria-controls="filterKegiatan">
                    <i class="ri-filter-3-line"></i>
                    Filter
                </button>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="card-body border-top border-bottom bg-light-subtle">
        <div class="row g-3 align-items-end">
            {{-- SEARCH --}}
            <div class="col-12 col-lg-6 col-xxl-5">
                <label class="form-label fw-semibold">
                    Cari Generus
                </label>
                <div class="search-box">
                    <input type="text" class="form-control" placeholder="Cari nama generus..."
                        wire:model.debounce.500ms="search">
                    <i class="ri-search-line search-icon">
                    </i>
                </div>
            </div>
            {{-- KELOMPOK --}}
            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <label class="form-label fw-semibold">
                    Kelompok
                </label>
                <select class="form-select" wire:model="ms_kelompok_id">
                    <option value="">
                        Semua Kelompok
                    </option>
                    @foreach($listKelompok as $k)
                    <option value="{{ $k->ms_kelompok_id }}">
                        {{ $k->nama_kelompok }}
                    </option>
                    @endforeach
                </select>
            </div>
            {{-- JENJANG --}}
            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <label class="form-label  fw-semibold">
                    Gender
                </label>
                <select class="form-select" wire:model="gender">
                    <option value="">
                        Semua Generus
                    </option>
                    <option value="laki-laki">
                        Laki-laki
                    </option>
                    <option value="perempuan">
                        Perempuan
                    </option>
                </select>
            </div>
            {{-- PERIODE --}}
            <div class="col-12 col-xl-8 col-xxl-3">
                <label class="form-label fw-semibold">
                    Periode
                </label>
                <div class="d-flex align-items-center gap-2">
                    <input type="date" class="form-control rounded-3" wire:model="startDate" value="{{ $startDate }}">
                    <div class="text-muted flex-shrink-0">
                        —
                    </div>
                    <input type="date" class="form-control rounded-3" wire:model="endDate" value="{{ $endDate }}">
                    <button type="button" class="btn btn-soft-secondary btn-icon rounded-circle flex-shrink-0"
                        wire:click="resetTanggal" title="Reset Tanggal">
                        <i class="ri-refresh-line">
                        </i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card-body pt-3">
        <div class="table-responsive">
            <table id="AttendanceKehadiran" class="table table-hover align-middle table-nowrap mb-0">
                <thead class="table-light text-center align-middle">
                    <tr>
                        {{-- NO --}}
                        <th style="width:70px">
                            No
                        </th>

                        {{-- GENERUS --}}
                        <th class="sticky-generus text-start">
                            Nama Generus
                        </th>
                        {{-- KELOMPOK --}}
                        <th class="text-start">
                            Kelompok
                        </th>
                        {{-- =================================================
                            KEGIATAN / OCCURRENCE
                        ================================================== --}}
                        @foreach($occurrences as $occurrence)
                            <th style="min-width:160px; max-width:180px;">
                                <div class="fw-semibold text-wrap">
                                    {{ $occurrence['nama_kegiatan'] }}
                                </div>

                                <small class="text-muted fw-normal">
                                    {{
                                        \App\Http\Controllers\HelperController::formatTanggalIndonesia(
                                            $occurrence['tanggal'],
                                            'l, d F Y'
                                        )
                                    }}
                                </small>
                            </th>
                        @endforeach
                        {{-- TOTAL --}}
                        <th class="bg-success-subtle text-success">
                            Hadir
                        </th>

                        <th class="bg-warning-subtle text-warning">
                            Izin
                        </th>

                        <th class="bg-danger-subtle text-danger">
                            Alfa
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($generusList as $index => $generus)
                        @php

                            $generusId = $generus->ms_generus_id;
                            $hadir = 0;
                            $izin  = 0;
                            $alfa  = 0;

                        @endphp

                        <tr>
                            <td class="text-center text-muted fw-semibold">
                                {{ $index + 1 }}
                            </td>

                            <td class="sticky-generus align-middle">
                                <div class="d-flex align-items-center gap-3">
                                    {{-- AVATAR --}}
                                    <div class="avatar-xs flex-shrink-0">
                                        <div class="avatar-title
                                                {{ $generus->jenis_kelamin === 'perempuan'
                                                    ? 'bg-danger-subtle text-danger'
                                                    : 'bg-primary-subtle text-primary'
                                                }}
                                                rounded-circle fw-semibold"
                                        >
                                            {{ strtoupper(substr($generus->nama_generus, 0, 1)) }}
                                        </div>
                                    </div>

                                    {{-- IDENTITAS --}}
                                    <div>
                                        <div class="fw-semibold text-nowrap">
                                            {{ $generus->nama_generus }}
                                        </div>
                                        <small class="text-muted">
                                            {{ strtoupper($generus->jenis_kelamin) }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td class="fw-semibold">
                                {{ $generus->ms_kelompok->nama_kelompok ?? '-' }}
                            </td>

                            @foreach($occurrences as $occurrence)
                            @php
                                $kegiatanId = $occurrence['ms_kegiatan_generus_id'];
                                $tanggal    = $occurrence['tanggal'];

                                $status = $presensiMatrix[$generusId][$kegiatanId][$tanggal]
                                    ?? 'alfa';

                                /*
                                |--------------------------------------------------------------------------
                                | Hitung total
                                |--------------------------------------------------------------------------
                                */
                                if ($status === 'hadir') {
                                    $hadir++;
                                } elseif ($status === 'izin') {
                                    $izin++;
                                } else {
                                    $alfa++;
                                }
                            @endphp
                            <td class="text-center align-middle">
                                @php
                                    $tooltip = \App\Http\Controllers\HelperController::formatTanggalIndonesia(
                                            $occurrence['tanggal'],
                                            'l, d F Y'
                                        ) .
                                        ' • ' .
                                        ($occurrence['nama_kegiatan'] ?? 'Kegiatan');
                                @endphp

                                @if($status === 'hadir')
                                    <span class="fw-semibold text-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $tooltip }}">
                                        <i class="ri-checkbox-circle-line me-1"></i>Hadir
                                    </span>
                                @elseif($status === 'izin')
                                    <span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $tooltip }}">
                                        <i class="ri-information-line me-1"></i>Izin
                                    </span>
                                @else
                                    <span class="text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $tooltip }}">
                                        <i class="ri-close-circle-line me-1"></i>Alfa
                                    </span>
                                @endif
                            </td>

                            @endforeach

                            <td class="text-center fw-bold text-success bg-success-subtle">
                                {{ $hadir }}
                            </td>

                            <td class="text-center fw-bold text-warning bg-warning-subtle">
                                {{ $izin }}
                            </td>

                            <td class="text-center fw-bold text-danger bg-danger-subtle">
                                {{ $alfa }}
                            </td>
                        </tr>
                    @empty

                        <tr>
                            <td colspan="{{ 3 + $occurrences->count() + 3 }}" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="ri-user-search-line fs-2 d-block mb-2"></i>
                                    <div class="fw-semibold">
                                        Tidak ada data generus
                                    </div>

                                    <small>
                                        Coba ubah filter atau periode laporan.
                                    </small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>  