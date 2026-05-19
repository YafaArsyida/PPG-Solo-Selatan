<div wire:ignore.self class="modal fade" id="ModalDetailGenerus" tabindex="-1" aria-labelledby="ModalDetailGenerusLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            {{-- HEADER --}}
            <div class="modal-header border-0 pb-0 p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-sm">
                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-20">
                            <i class="ri-user-3-line">
                            </i>
                        </div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1" id="ModalDetailGenerusLabel">
                            Detail Generus
                        </h5>
                        <small>
                            Informasi lengkap data generasi penerus
                        </small>
                    </div>
                </div>
                <button type="button" class="btn btn-light btn-icon rounded-circle" data-bs-dismiss="modal">
                    <i class="ri-close-line fs-18">
                    </i>
                </button>
            </div>
            <div class="modal-body p-4">
                @if($generus)
                <div class="card border-0 bg-light-subtle rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex flex-column flex-lg-row align-items-lg-start justify-content-between gap-4">
                            {{-- LEFT --}}
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="avatar-md">
                                        <div class="avatar-title rounded-circle bg-primary text-white fs-24 fw-bold">
                                            {{ strtoupper(substr($generus->nama_generus, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="fw-bold mb-1">
                                            {{ $generus->nama_generus }}
                                        </h3>
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                                <i class="ri-team-line me-1">
                                                </i>
                                                {{ $generus->ms_kelompok->nama_kelompok ?? '-' }}
                                            </span>
                                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                                <i class="ri-government-line me-1">
                                                </i>
                                                {{ $generus->ms_kelompok->ms_desa->nama_desa ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                {{-- DESKRIPSI --}}
                                <div class="bg-white rounded-3 p-3 border">
                                    <p class="text-muted small fw-semibold mb-2">
                                        Deskripsi
                                    </p>
                                    <p class="mb-0 text-body">
                                        {{ $generus->deskripsi ?? 'Tidak ada deskripsi tambahan.' }}
                                    </p>
                                </div>
                            </div>
                            {{-- RIGHT --}}
                            <div class="text-lg-end">
                                <div class="bg-white border rounded-3 px-4 py-3">
                                    <p class="text-muted small mb-1">
                                        Terakhir Diperbarui
                                    </p>
                                    <h6 class="fw-semibold mb-0">
                                        <i class="ri-time-line text-warning me-1">
                                        </i>
                                        {{ $generus->updated_at?->format('d M Y') ?? '-' }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- INFORMASI DETAIL --}}
                <div class="row g-4">
                    {{-- JENIS KELAMIN --}}
                    <div class="col-lg-4 col-md-6">
                        <div class="card border h-100 rounded-4 shadow-sm mb-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title rounded-circle bg-info-subtle text-info fs-20">
                                            <i class="ri-user-line">
                                            </i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 small">
                                            Jenis Kelamin
                                        </p>
                                        <h6 class="fw-bold mb-0">
                                            {{ ucfirst($generus->jenis_kelamin ?? '-') }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- TEMPAT LAHIR --}}
                    <div class="col-lg-4 col-md-6">
                        <div class="card border h-100 rounded-4 shadow-sm mb-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title rounded-circle bg-success-subtle text-success fs-20">
                                            <i class="ri-map-pin-line">
                                            </i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 small">
                                            Tempat Lahir
                                        </p>
                                        <h6 class="fw-bold mb-0">
                                            {{ $generus->tempat_lahir ?? '-' }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- TANGGAL LAHIR --}}
                    <div class="col-lg-4 col-md-6">
                        <div class="card border h-100 rounded-4 shadow-sm mb-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title rounded-circle bg-warning-subtle text-warning fs-20">
                                            <i class="ri-calendar-line">
                                            </i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 small">
                                            Tanggal Lahir
                                        </p>
                                        <h6 class="fw-bold mb-0">
                                            @if($generus->tanggal_lahir) {{
                                            \Carbon\Carbon::parse($generus->tanggal_lahir)->format('d
                                            M Y') }}
                                            <span class="text-muted fw-normal">
                                                ({{ \Carbon\Carbon::parse($generus->tanggal_lahir)->age }} Tahun)
                                            </span>
                                            @else - @endif
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- NOMOR TELEPON --}}
                    <div class="col-lg-6">
                        <div class="card border rounded-4 shadow-sm mb-0 h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title rounded-circle bg-primary-subtle text-primary fs-20">
                                            <i class="ri-smartphone-line">
                                            </i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 small">
                                            Nomor Telepon
                                        </p>
                                        <h6 class="fw-bold mb-0">
                                            {{ $generus->nomor_telepon ?? '-' }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ALAMAT --}}
                    <div class="col-lg-6">
                        <div class="card border rounded-4 shadow-sm mb-0 h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="avatar-sm flex-shrink-0">
                                        <div class="avatar-title rounded-circle bg-danger-subtle text-danger fs-20">
                                            <i class="ri-home-4-line">
                                            </i>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <p class="text-muted mb-1 small">
                                            Alamat
                                        </p>
                                        <h6 class="fw-semibold mb-0 lh-base">
                                            {{ $generus->alamat ?? '-' }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            {{-- FOOTER --}}
            <div class="modal-footer border-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1">
                    </i>
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>