<div class="card border-0 shadow-sm rounded-4 overflow-hidden">

    <div class="card-body d-flex flex-column p-4">

        {{-- HEADER --}}
        <div class="d-flex align-items-center mb-4">
            <div class="avatar-sm flex-shrink-0">
                <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-3 shadow-sm">
                    <i class="ri-file-chart-line"></i>
                </span>
            </div>

            <div class="ms-3">
                <h5 class="fw-bold mb-1">
                    Laporan Kegiatan
                </h5>

                <span class="badge bg-primary-subtle text-primary fw-medium">
                    Rekap & Kehadiran
                </span>
            </div>
        </div>

        {{-- DESCRIPTION --}}
        <div class="mb-4">

            <p class="text-muted mb-3">
                Lihat rekap pelaksanaan kegiatan dan perkembangan kehadiran
                generus dalam periode tertentu secara terstruktur.
            </p>

            {{-- FEATURES --}}
            <div class="d-flex flex-column gap-2">

                <div class="d-flex align-items-start gap-2">
                    <i class="ri-calendar-check-fill text-primary mt-1"></i>
                    <span class="text-muted fs-14">
                        Rekap jumlah dan pelaksanaan kegiatan
                    </span>
                </div>

                <div class="d-flex align-items-start gap-2">
                    <i class="ri-pie-chart-2-fill text-warning mt-1"></i>
                    <span class="text-muted fs-14">
                        Persentase keaktifan dan tingkat kehadiran
                    </span>
                </div>

                <div class="d-flex align-items-start gap-2">
                    <i class="ri-user-follow-fill text-success mt-1"></i>
                    <span class="text-muted fs-14">
                        Rekap presensi hadir, izin, dan alfa
                    </span>
                </div>

            </div>
        </div>

        {{-- CTA --}}
        <div class="mt-auto">

            <a href="{{ route('operasional.laporan-kegiatan') }}" class="btn btn-primary w-100 rounded-pill">
                <i class="ri-file-chart-line me-1"></i>
                Buka Laporan Kegiatan
                <i class="ri-arrow-right-line ms-1"></i>
            </a>

        </div>

    </div>
</div>