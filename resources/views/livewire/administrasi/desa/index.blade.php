<div>

    {{-- TOPBAR --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body">

            <div class="row g-3 align-items-end">

                {{-- SEARCH --}}
                <div class="col-xxl-8 col-lg-7">

                    <label class="form-label fw-semibold">
                        Pencarian Desa
                    </label>

                    <div class="position-relative">

                        <input type="text" class="form-control form-control-lg ps-5" wire:model.debounce.300ms="search"
                            placeholder="Cari nama desa, masjid, atau informasi lainnya...">

                        <i class="ri-search-line position-absolute top-50 start-0 translate-middle-y ms-3 text-muted fs-18"></i>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="col-xxl-4 col-lg-5">

                    <button type="button" class="btn btn-primary btn-lg w-100 rounded-pill" data-bs-toggle="modal"
                        data-bs-target="#ModalDesaCreate" wire:click="$emit('DesaCreate')">

                        <i class="ri-add-line me-1"></i>
                        Tambah

                    </button>

                </div>

            </div>

        </div>

    </div>

    {{-- TABLE CARD --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        {{-- HEADER --}}
        <div class="card-header bg-white border-0 py-3">

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">

                <div>

                    <h5 class="fw-bold mb-1">
                        Data Desa
                    </h5>

                    <p class="text-muted mb-0 fs-13">
                        Daftar desa yang terdaftar dalam sistem
                    </p>

                </div>

                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                    Total : {{ count($data) }} Desa
                </span>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th width="70" class="text-center text-uppercase fw-semibold">
                            No
                        </th>

                        <th class="text-uppercase fw-semibold">
                            Informasi Desa
                        </th>

                        <th width="220" class="text-uppercase fw-semibold text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $index => $kat)

                    <tr>

                        {{-- NO --}}
                        <td class="text-center">

                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                {{ $index + 1 }}
                            </span>

                        </td>

                        {{-- INFORMASI --}}
                        <td>

                            <div class="d-flex align-items-center gap-3">

                                <div class="avatar-sm flex-shrink-0">

                                    <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-20">
                                        <i class="ri-community-line"></i>
                                    </div>

                                </div>

                                <div>

                                    <h6 class="fw-bold mb-1">
                                        {{ $kat->nama_desa }}
                                    </h6>

                                    <div class="text-muted fs-13">

                                        <i class="ri-building-2-line me-1"></i>

                                        {{ $kat->nama_masjid ?? 'Masjid belum tersedia' }}

                                    </div>

                                </div>

                            </div>

                        </td>

                        {{-- ACTION --}}
                        <td>

                            <div class="d-flex justify-content-center gap-2 flex-wrap">

                                {{-- DETAIL --}}
                                <a href="#ModalDetailDesa" data-bs-toggle="modal"
                                    class="btn btn-light btn-sm rounded-pill"
                                    wire:click.prevent="$emit('detailDesa', {{ $kat->ms_desa_id }})">

                                    <i class="ri-eye-line me-1"></i>
                                    Detail

                                </a>

                                {{-- EDIT --}}
                                <a href="#ModalEditDesa" data-bs-toggle="modal"
                                    class="btn btn-warning btn-sm rounded-pill text-white"
                                    wire:click.prevent="$emit('loadDataDesa', {{ $kat->ms_desa_id }})">

                                    <i class="ri-pencil-line me-1"></i>
                                    Edit

                                </a>

                                {{-- DELETE --}}
                                <a href="#ModalDeleteDesa" data-bs-toggle="modal"
                                    class="btn btn-danger btn-sm rounded-pill"
                                    wire:click.prevent="$emit('DesaDelete', {{ $kat->ms_desa_id }})">

                                    <i class="ri-delete-bin-5-line me-1"></i>
                                    Hapus

                                </a>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="3">

                            <div class="text-center py-5">

                                <div class="mb-3">
                                    <i class="ri-inbox-2-line text-muted" style="font-size: 48px;"></i>
                                </div>

                                <h5 class="fw-semibold mb-1">
                                    Data desa kosong
                                </h5>

                                <p class="text-muted mb-0">
                                    Belum ada data desa yang tersedia
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>