<div class="card border-0 shadow-sm rounded-4 overflow-hidden">

    {{-- HEADER --}}
    <div class="card-header bg-white border-0 p-4">

        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">

            {{-- TITLE --}}
            <div>

                <div class="d-flex align-items-center gap-2 mb-1">

                    <div class="avatar-sm">

                        <div class="avatar-title bg-primary-subtle text-primary rounded-3 fs-20">
                            <i class="ri-file-chart-line"></i>
                        </div>

                    </div>

                    <div>
                        <h4 class="fw-bold mb-0">
                            Laporan Kegiatan Generus
                        </h4>

                        <p class="text-muted mb-0 fs-13">
                            Monitoring kehadiran dan aktivitas kegiatan generasi penerus
                        </p>
                    </div>

                </div>

            </div>

            {{-- ACTION --}}
            <div class="d-flex flex-wrap gap-2">

                <button data-bs-toggle="modal" data-bs-target="#ExportLaporanExcel"
                    class="btn btn-soft-success rounded-pill px-3">

                    <i class="ri-file-excel-2-line me-1"></i>
                    Export Excel

                </button>

            </div>

        </div>

    </div>

    {{-- FILTER --}}
    <div class="card-body border-top border-bottom bg-light-subtle">

        <div class="row g-3 align-items-end">

            {{-- SEARCH --}}
            <div class="col-12 col-lg-4">

                <label class="form-label fw-semibold  mb-2">
                    Pencarian
                </label>

                <div class="search-box">

                    <input type="text" class="form-control search" placeholder="Cari nama kegiatan..."
                        wire:model.debounce.500ms="search">

                    <i class="ri-search-line search-icon"></i>

                </div>

            </div>

            {{-- JENJANG --}}
            <div class="col-12 col-md-6 col-lg-2">

                <label class="form-label fw-semibold  mb-2">
                    Jenjang
                </label>

                <select class="form-select rounded-3" wire:model="jenjangUsia">

                    <option value="">Semua Generus</option>
                    <option value="caberawit">Caberawit (0–11)</option>
                    <option value="remaja">Remaja (12–30)</option>
                    <option value="gp">GP (12–23)</option>
                    <option value="pra_nikah">Pra Nikah (19–23)</option>
                    <option value="mandiri">Mandiri (23–25)</option>

                </select>

            </div>

            {{-- STATUS --}}
            <div class="col-12 col-md-6 col-lg-2">

                <label class="form-label fw-semibold  mb-2">
                    Status
                </label>

                <select class="form-select rounded-3" wire:model="status">

                    <option value="">Semua</option>
                    <option value="aktif">Aktif</option>
                    <option value="selesai">Selesai</option>

                </select>

            </div>

            {{-- PERIODE --}}
            <div class="col-12 col-lg-4">

                <label class="form-label fw-semibold  mb-2">
                    Periode
                </label>

                <div class="d-flex align-items-center gap-2">

                    <input type="date" class="form-control rounded-3" wire:model="startDate" value="{{ $startDate }}">

                    <span class="">—</span>

                    <input type="date" class="form-control rounded-3" wire:model="endDate" value="{{ $endDate }}">

                    <button type="button" class="btn btn-soft-secondary btn-icon rounded-circle flex-shrink-0"
                        wire:click="resetTanggal" title="Reset Tanggal">

                        <i class="ri-refresh-line"></i>

                    </button>

                </div>

            </div>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="card-body pt-3">

        <div class="table-responsive">

            <table id="Laporan" class="table table-hover align-middle table-nowrap mb-0">

                <thead class="bg-light-subtle">

                    <tr class="text-uppercase fs-12">

                        <th width="60" class="ps-4">#</th>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Peserta</th>
                        <th>Tingkat</th>
                        <th class="text-center">Target</th>
                        <th class="text-center text-primary">Hadir</th>
                        <th class="text-center">Izin</th>
                        <th class="text-center text-danger">Alfa</th>
                        <th class="text-center">% Hadir</th>
                        <th class="text-center">% Izin</th>
                        <th class="text-center">% Alfa</th>
                        <th class="text-center pe-4">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $index => $item)

                    <tr>

                        {{-- NO --}}
                        <td class="ps-4 fw-semibold text-muted">
                            {{ $data->firstItem() + $index }}
                        </td>

                        {{-- TANGGAL --}}
                        <td>

                            <div class="fw-semibold text-body">
                                {{ $item->tanggal
                                ? \App\Http\Controllers\HelperController::formatTanggalIndonesia($item->tanggal, 'd F
                                Y')
                                : '-' }}
                            </div>

                            <div class="fs-12 text-muted">
                                <i class="ri-time-line me-1"></i>
                                {{ $item->waktu }}
                            </div>

                        </td>

                        {{-- KEGIATAN --}}
                        <td>

                            <div class="fw-semibold text-dark">
                                {{ $item->nama_kegiatan }}
                            </div>

                            <div class="fs-12 text-muted mt-1">

                                @if($item->scope === 'daerah')

                                <span class="badge bg-primary-subtle text-primary rounded-pill">
                                    Daerah
                                </span>

                                @elseif($item->scope === 'desa')

                                <span class="badge bg-success-subtle text-success rounded-pill">
                                    Desa
                                </span>

                                @elseif($item->scope === 'kelompok')

                                <span class="badge bg-warning-subtle text-warning rounded-pill">
                                    Kelompok
                                </span>

                                @endif

                            </div>

                        </td>

                        {{-- PESERTA --}}
                        <td>

                            @php
                            if ($item->jenjang) {
                            [$jenjangLabel, $jenjangClass] = match($item->jenjang) {
                            'caberawit' => ['Caberawit', 'bg-info-subtle text-info'],
                            'remaja' => ['Remaja', 'bg-primary-subtle text-primary'],
                            'gp' => ['GP', 'bg-success-subtle text-success'],
                            'mandiri' => ['Mandiri', 'bg-danger-subtle text-danger'],
                            default => ['-', 'bg-light text-muted'],
                            };
                            } else {
                            [$jenjangLabel, $jenjangClass] = ['Semua Jenjang', 'bg-light text-muted'];
                            }
                            @endphp

                            <span class="badge {{ $jenjangClass }} rounded-pill px-3 py-2">
                                {{ $jenjangLabel }}
                            </span>

                        </td>

                        {{-- TINGKAT --}}
                        <td>

                            <div class="fw-medium">

                                @if($item->scope === 'daerah')
                                Daerah Solo Selatan

                                @elseif($item->scope === 'desa')
                                Desa {{ $item->ms_desa->nama_desa ?? '-' }}

                                @elseif($item->scope === 'kelompok')
                                Kelompok {{ $item->ms_kelompok->nama_kelompok ?? '-' }}

                                @endif

                            </div>

                        </td>

                        {{-- TARGET --}}
                        <td class="text-center">

                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                {{ $item->targetPeserta() }}
                            </span>

                        </td>

                        {{-- HADIR --}}
                        <td class="text-center">

                            <div class="fw-bold text-primary">
                                {{ $item->totalHadir() }}
                            </div>

                        </td>

                        {{-- IZIN --}}
                        <td class="text-center">

                            <div class="fw-bold text-secondary">
                                {{ $item->totalIzin() }}
                            </div>

                        </td>

                        {{-- ALFA --}}
                        <td class="text-center">

                            <div class="fw-bold text-danger">
                                {{ $item->totalAlfa() }}
                            </div>

                        </td>

                        {{-- % HADIR --}}
                        <td class="text-center">

                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                {{ $item->presentaseHadir() }}%
                            </span>

                        </td>

                        {{-- % IZIN --}}
                        <td class="text-center">

                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">
                                {{ $item->presentaseIzin() }}%
                            </span>

                        </td>

                        {{-- % ALFA --}}
                        <td class="text-center">

                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                {{ $item->presentaseAlfa() }}%
                            </span>

                        </td>

                        {{-- ACTION --}}
                        <td class="text-center pe-4">

                            <div class="d-flex justify-content-center gap-2">

                                {{-- DETAIL --}}
                                <a href="#ModalDetailKegiatan" data-bs-toggle="modal"
                                    wire:click.prevent="$emit('KegiatanDetail', {{ $item->ms_kegiatan_id }})"
                                    class="btn btn-soft-primary btn-icon rounded-circle" title="Detail Kegiatan">

                                    <i class="ri-eye-line"></i>

                                </a>

                                {{-- REPORT --}}
                                <a href="javascript:void(0)" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasLaporan" aria-controls="offcanvasLaporan"
                                    wire:click.prevent="$emit('KegiatanReport', {{ $item->ms_kegiatan_id }}, {{ $ms_desa_id }})"
                                    class="btn btn-soft-success btn-icon rounded-circle" title="Laporan Kehadiran">

                                    <i class="ri-file-chart-line"></i>

                                </a>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="13" class="text-center py-5">

                            <div class="d-flex flex-column align-items-center">

                                <div class="avatar-md mb-3">

                                    <div class="avatar-title bg-light text-muted rounded-circle fs-2">
                                        <i class="ri-inbox-2-line"></i>
                                    </div>

                                </div>

                                <h6 class="fw-semibold mb-1">
                                    Belum Ada Laporan
                                </h6>

                                <p class="text-muted mb-0 fs-13">
                                    Data kegiatan generus belum tersedia.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- PAGINATION --}}
    <div class="card-footer bg-white border-0 py-3">

        <div class="d-flex justify-content-end">
            {{ $data->links() }}
        </div>

    </div>

</div>