<div wire:ignore.self class="offcanvas offcanvas-top border-0" id="KegiatanReport"
    aria-labelledby="KegiatanReportLabel" style="min-height:100vh; background:#f8fafc;">
    {{-- HEADER --}}
    <div class="offcanvas-header border-bottom bg-white px-4 py-3 shadow-sm">
        <div class="d-flex align-items-center gap-3">
            <div class="avatar-sm">
                <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-18">
                    <i class="ri-file-chart-line">
                    </i>
                </div>
            </div>
            <div>
                <h5 class="fw-bold mb-1">
                    Kegiatan Pengurus
                </h5>
                <small>
                    Rekap kehadiran, izin, dan alfa peserta kegiatan generus
                </small>
            </div>
        </div>
        <button type="button" class="btn btn-light btn-icon rounded-circle shadow-none" data-bs-dismiss="offcanvas">
            <i class="ri-close-line fs-18">
            </i>
        </button>
    </div>
    {{-- BODY --}}
    <div class="offcanvas-body">
        @if($kegiatan)
        {{-- HEADER --}}
        <div class="text-center mb-2">
            <h5 class="fw-bold mb-1 text-uppercase">
                {{ $kegiatan->nama_kegiatan }}
            </h5>
            <small class="text-muted">
                {{ $kegiatan->tempat }} {{-- {{ $kegiatan->alamat
                }} --}}
            </small>
        </div>
        {{-- CONTENT --}}
        <div class="row g-4">
            {{-- PRESENSI --}}
            <div class="col-xxl-12 col-lg-12">
                @livewire('teman-pengurus.operasional.kegiatan-pengurus.attendance', [ 'kegiatanId' => $kegiatanId ])
            </div>
        </div>
        @endif
    </div>
</div>