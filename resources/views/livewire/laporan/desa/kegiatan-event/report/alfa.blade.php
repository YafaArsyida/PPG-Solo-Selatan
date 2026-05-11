<div class="card border-0 shadow-sm rounded-4 overflow-hidden">

    {{-- HEADER --}}
    <div class="card-header bg-white border-0 px-4 py-3">
    
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
    
            {{-- TITLE --}}
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
    
                    <div class="avatar-xs">
                        <div class="avatar-title rounded-circle bg-soft-success text-success">
                            <i class="ri-team-line"></i>
                        </div>
                    </div>
    
                    <span class="badge bg-soft-success text-success fw-semibold px-3 py-2">
                        Presensi Kehadiran
                    </span>
    
                </div>
    
                <h4 class="card-title fw-bold mb-1">
                    Generus Alfa/Tidak Hadir
                </h4>
    
                <p class="text-muted fs-13 mb-0">
                    Monitoring generus yang belum hadir pada kegiatan.
                </p>
            </div>
    
            {{-- ACTION --}}
            <div class="d-flex gap-2 flex-wrap">
    
                <button id="btnExportAttendance" class="btn btn-success rounded-pill px-4 shadow-sm">
    
                    <i class="ri-file-excel-2-line me-1"></i>
                    Export Excel
    
                </button>
    
            </div>
    
        </div>
    
    </div>

    {{-- FILTER --}}
    <div class="card-body border-top bg-light-subtle">

        <div class="row g-3 align-items-end">

            {{-- SEARCH --}}
            <div class="col-xxl-6 col-lg-6">

                <label class="form-label fw-semibold">
                    Cari Nama Generus
                </label>

                <div class="search-box">

                    <input type="text" class="form-control border-light shadow-sm rounded-3"
                        wire:model.debounce.400ms="search" placeholder="Ketik nama generus...">

                    <i class="ri-search-line search-icon"></i>

                </div>

            </div>

            {{-- KELOMPOK --}}
            <div class="col-xxl-3 col-lg-3 col-sm-6">

                <label class="form-label fw-semibold">
                    Kelompok
                </label>

                <select class="form-select rounded-3 shadow-sm border-light" wire:model="ms_kelompok_id" {{ !$ms_desa_id
                    ? 'disabled' : '' }}>

                    <option value="">Semua Kelompok</option>

                    @foreach($listKelompok as $k)
                    <option value="{{ $k->ms_kelompok_id }}">
                        Kelompok {{ $k->nama_kelompok }}
                    </option>
                    @endforeach

                </select>

            </div>

            {{-- GENDER --}}
            <div class="col-xxl-3 col-lg-3 col-sm-6">

                <label class="form-label fw-semibold">
                    Gender
                </label>

                <select class="form-select rounded-3 shadow-sm border-light" wire:model="gender">

                    <option value="">Semua Generus</option>
                    <option value="laki-laki">Laki-laki</option>
                    <option value="perempuan">Perempuan</option>

                </select>

            </div>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="card-body p-0">

        <div class="table-responsive">

            <table id="Alfa" class="table align-middle table-hover mb-0">

                <thead class="bg-light text-muted">
                    <tr>
                        <th style="width: 60px">#</th>
                        <th>Nama Generus</th>
                        <th>Kelompok</th>
                        <th>Status Kehadiran</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($alfa as $i => $g)
                    <tr>

                        {{-- NO --}}
                        <td class="text-muted fw-semibold">
                            {{ ($alfa->currentPage() - 1) * $alfa->perPage() + $loop->iteration }}
                        </td>

                        {{-- NAMA --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">

                                <div class="avatar-xs">
                                    <div class="avatar-title rounded-circle bg-soft-danger text-danger fw-semibold">
                                        {{ strtoupper(substr($g->nama_generus, 0, 1)) }}
                                    </div>
                                </div>

                                <div>
                                    <h6 class="mb-0 fw-semibold">
                                        {{ $g->nama_generus }}
                                    </h6>

                                    <small class="text-muted">
                                        {{ ucfirst($g->jenis_kelamin) }}
                                    </small>
                                </div>

                            </div>
                        </td>

                        {{-- KELOMPOK --}}
                        <td>
                            <div class="fw-semibold">
                                Kelompok {{ $g->ms_kelompok->nama_kelompok ?? '-' }}
                            </div>

                            <small class="text-muted">
                                {{ $g->ms_kelompok->ms_desa->nama_desa ?? '-' }}
                            </small>
                        </td>

                        {{-- STATUS --}}
                        <td>
                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2 fw-semibold">
                                <i class="ri-close-circle-line me-1"></i>
                                Alfa
                            </span>
                        </td>

                    </tr>
                    @empty

                    {{-- EMPTY --}}
                    <tr>
                        <td colspan="4" class="text-center py-5">

                            <div class="d-flex flex-column align-items-center">

                                <div class="avatar-md mb-3">
                                    <div class="avatar-title bg-light text-muted rounded-circle fs-24">
                                        <i class="ri-inbox-archive-line"></i>
                                    </div>
                                </div>

                                <h6 class="fw-semibold mb-1">
                                    Belum Ada Data Alfa
                                </h6>

                                <p class="text-muted mb-0 fs-13">
                                    Semua generus hadir atau belum ada data presensi.
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
    @if($alfa->hasPages())
    <div class="card-footer bg-white border-0 pt-3">
        {{ $alfa->links() }}
    </div>
    @endif

</div>