<div class="card border-0 shadow-sm rounded-4 overflow-hidden">

    <div class="card-body d-flex flex-column p-4">

        {{-- HEADER --}}
        <div class="d-flex align-items-center mb-4">

            <div class="avatar-sm flex-shrink-0">
                <span class="avatar-title bg-success-subtle text-success rounded-circle fs-3 shadow-sm">
                    <i class="ri-calendar-check-line"></i>
                </span>
            </div>

            <div class="ms-3">
                <h5 class="fw-bold mb-1">
                    Laporan Kehadiran
                </h5>

                <span class="badge bg-success-subtle text-success fw-medium">
                    Matriks Kehadiran
                </span>
            </div>

        </div>

        {{-- DESCRIPTION --}}
        <div class="mb-4">

            <p class="text-muted mb-3">
                Pantau riwayat kehadiran generus pada berbagai kegiatan
                dalam satu periode secara ringkas dan mudah dipantau.
            </p>

            {{-- FEATURES --}}
            <div class="d-flex flex-column gap-2">

                <div class="d-flex align-items-start gap-2">
                    <i class="ri-user-line text-success mt-1"></i>
                    <span class="text-muted fs-14">
                        Rekap kehadiran setiap generus
                    </span>
                </div>

                <div class="d-flex align-items-start gap-2">
                    <i class="ri-calendar-event-line text-primary mt-1"></i>
                    <span class="text-muted fs-14">
                        Riwayat kehadiran berdasarkan kegiatan
                    </span>
                </div>

                <div class="d-flex align-items-start gap-2">
                    <i class="ri-table-line text-info mt-1"></i>
                    <span class="text-muted fs-14">
                        Matriks kehadiran antar kegiatan
                    </span>
                </div>

            </div>

        </div>

        {{-- CTA --}}
        <div class="mt-auto">

            <a href="{{ route('operasional.laporan-kehadiran') }}" class="btn btn-success w-100 rounded-pill">
                <i class="ri-calendar-check-line me-1"></i>
                Buka Laporan Kehadiran
                <i class="ri-arrow-right-line ms-1"></i>
            </a>

        </div>

    </div>
</div>