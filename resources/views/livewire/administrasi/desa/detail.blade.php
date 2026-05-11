<div wire:ignore.self class="modal fade" id="ModalDetailDesa" tabindex="-1" aria-labelledby="ModalDetailDesaLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            {{-- HEADER --}}
            <div class="modal-header border-0 pb-0 pt-4 px-4">

                <div class="d-flex align-items-center gap-3">

                    <div class="avatar-sm">
                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-20">
                            <i class="ri-community-line"></i>
                        </div>
                    </div>

                    <div>

                        <h4 class="modal-title fw-bold mb-1" id="ModalDetailDesaLabel">

                            Detail Desa

                        </h4>

                        <p class="text-muted mb-0 fs-13">
                            Informasi lengkap desa dan kelompok binaan
                        </p>

                    </div>

                </div>

                <button type="button" class="btn btn-light btn-icon rounded-circle" data-bs-dismiss="modal">

                    <i class="ri-close-line fs-18"></i>

                </button>

            </div>

            <div class="modal-body p-4">

                @if($desa)

                {{-- HERO SECTION --}}
                <div class="bg-light rounded-4 p-4 mb-4">

                    <div class="d-flex flex-column flex-lg-row justify-content-between gap-4">

                        <div class="flex-grow-1">

                            <div class="d-flex align-items-center gap-2 mb-2">

                                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                    Desa Binaan
                                </span>

                            </div>

                            <h2 class="fw-bold mb-2">
                                {{ $desa->nama_desa }}
                            </h2>

                            <div class="d-flex flex-wrap gap-3 text-muted fs-13 mb-3">

                                <div class="d-flex align-items-center gap-1">

                                    <i class="ri-building-2-line text-success"></i>

                                    <span class="fw-medium text-body">
                                        {{ $desa->nama_masjid ?? '-' }}
                                    </span>

                                </div>

                                <div class="d-flex align-items-center gap-1">

                                    <i class="ri-time-line text-primary"></i>

                                    <span class="fw-medium text-body">
                                        Update {{ $desa->updated_at?->format('d M Y') ?? '-' }}
                                    </span>

                                </div>

                            </div>

                            @if($desa->deskripsi)

                            <p class="text-muted mb-0 lh-lg">
                                {{ $desa->deskripsi }}
                            </p>

                            @endif

                        </div>

                    </div>

                </div>

                {{-- ALAMAT --}}
                <div class="card border-0 bg-light-subtle mb-4">

                    <div class="card-body">

                        <div class="d-flex align-items-start gap-3">

                            <div class="avatar-sm flex-shrink-0">

                                <div class="avatar-title bg-danger-subtle text-danger rounded-circle">

                                    <i class="ri-map-pin-line fs-18"></i>

                                </div>

                            </div>

                            <div class="flex-grow-1">

                                <div class="text-muted fs-12 mb-1">
                                    Alamat Desa
                                </div>

                                <div class="fw-medium text-body lh-lg">
                                    {{ $desa->alamat ?? '-' }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- INFORMATION BOX --}}
                <div class="row g-3">

                    {{-- JUMLAH KELOMPOK --}}
                    <div class="col-lg-4 col-sm-6">

                        <div class="card border-0 bg-light h-100 mb-0">

                            <div class="card-body text-center">

                                <div class="avatar-md mx-auto mb-3">

                                    <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-24">

                                        <i class="ri-group-line"></i>

                                    </div>

                                </div>

                                <h3 class="fw-bold mb-1">
                                    {{ $desa->ms_kelompok_count ?? 0 }}
                                </h3>

                                <p class="text-muted mb-0 fs-13">
                                    Total Kelompok
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="col-lg-4 col-sm-6">

                        <div class="card border-0 bg-light h-100 mb-0">

                            <div class="card-body text-center">

                                <div class="avatar-md mx-auto mb-3">

                                    <div class="avatar-title bg-success-subtle text-success rounded-circle fs-24">

                                        <i class="ri-file-text-line"></i>

                                    </div>

                                </div>

                                <h6 class="fw-bold mb-1 text-truncate" title="{{ $desa->deskripsi ?? '-' }}">

                                    {{ $desa->deskripsi ?? '-' }}

                                </h6>

                                <p class="text-muted mb-0 fs-13">
                                    Deskripsi
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- PETA --}}
                    <div class="col-lg-4 col-sm-6">

                        <div class="card border-0 bg-light h-100 mb-0">

                            <div class="card-body text-center">

                                <div class="avatar-md mx-auto mb-3">

                                    <div class="avatar-title bg-danger-subtle text-danger rounded-circle fs-24">

                                        <i class="ri-map-2-line"></i>

                                    </div>

                                </div>

                                @if($desa->peta)

                                <a href="{{ $desa->peta }}" target="_blank"
                                    class="fw-semibold text-primary text-decoration-none">

                                    Lihat Lokasi

                                </a>

                                @else

                                <div class="fw-semibold">
                                    -
                                </div>

                                @endif

                                <p class="text-muted mb-0 fs-13 mt-1">
                                    Google Maps
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                @endif

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0 px-4 pb-4 pt-0">

                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">

                    <i class="ri-close-line me-1"></i>
                    Tutup

                </button>

            </div>

        </div>

    </div>

</div>