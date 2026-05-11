<div class="card border-0 shadow-sm rounded-4 overflow-hidden" id="produkList">

    {{-- HEADER --}}
    <div class="card-header bg-white border-0 p-4">

        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">

            {{-- TITLE --}}
            <div>

                <div class="d-flex align-items-center gap-3 mb-2">

                    <div class="avatar-sm">

                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-20">
                            <i class="ri-community-line"></i>
                        </div>

                    </div>

                    <div>

                        <h4 class="fw-bold mb-1">
                            Administrasi Data Kelompok
                        </h4>

                        <p class="text-muted mb-0 fs-13">
                            Kelola data desa, kelompok, dan generus binaan
                        </p>

                    </div>

                </div>

            </div>

            {{-- ACTION --}}
            <div class="d-flex gap-2 flex-wrap">

                <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasDesa" aria-controls="offcanvasDesa">

                    <i class="ri-building-line me-1"></i>
                    Master Desa

                </button>

                <button type="button" class="btn btn-success rounded-pill px-4" data-bs-toggle="modal"
                    data-bs-target="#ModalKelompokCreate" wire:click="$emit('KelompokCreate')">

                    <i class="ri-add-line me-1"></i>
                    Tambah Kelompok

                </button>

            </div>

        </div>

    </div>

    {{-- FILTER --}}
    <div class="card-body border-top border-light p-4">

        <div class="row g-3 align-items-end">

            {{-- SEARCH --}}
            <div class="col-xxl-9 col-lg-8">

                <label class="form-label fw-semibold">
                    Pencarian Kelompok
                </label>

                <div class="position-relative">

                    <input type="text" class="form-control form-control-lg ps-5" wire:model.debounce.300ms="search"
                        placeholder="Cari nama kelompok, masjid, atau desa...">

                    <i
                        class="ri-search-line position-absolute top-50 start-0 translate-middle-y ms-3 text-muted fs-18"></i>

                </div>

            </div>

            {{-- MASTER DESA --}}
            <div class="col-xxl-3 col-lg-4">

                <button type="button" class="btn btn-light border w-100 btn-lg rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#ModalDesaCreate" wire:click="$emit('DesaCreate')">

                    <i class="ri-add-circle-line me-1 text-primary"></i>
                    Tambah Desa

                </button>

            </div>

        </div>

    </div>

    {{-- TABS --}}
    <div class="card-body pt-0 px-4 pb-4">

        <div class="border rounded-4 overflow-hidden">

            {{-- NAV TAB --}}
            <div class="bg-light px-3 pt-3">

                <ul class="nav nav-pills gap-2 flex-nowrap overflow-auto pb-3" role="tablist">

                    {{-- SEMUA --}}
                    <li class="nav-item flex-shrink-0">

                        <button type="button"
                            class="nav-link rounded-pill px-4 py-2 fw-medium {{ $activeTab === 'semua' ? 'active' : '' }}"
                            wire:click="setActiveTab('semua')">

                            <i class="ri-apps-2-line me-1"></i>
                            Semua Kelompok

                        </button>

                    </li>

                    {{-- DESA --}}
                    @foreach($desa as $item)

                    <li class="nav-item flex-shrink-0">

                        <button type="button"
                            class="nav-link rounded-pill px-4 py-2 fw-medium {{ $activeTab === 'desa-'.$item->ms_desa_id ? 'active' : '' }}"
                            wire:click="setActiveTab('desa-{{ $item->ms_desa_id }}')">

                            <i class="ri-map-pin-community-line me-1"></i>

                            {{ $item->nama_desa }}

                        </button>

                    </li>

                    @endforeach

                </ul>

            </div>

            {{-- CONTENT --}}
            <div class="p-3 p-lg-4 bg-white">

                <div class="tab-content">

                    {{-- SEMUA KELOMPOK --}}
                    <div class="tab-pane fade {{ $activeTab === 'semua' ? 'show active' : '' }}" id="tabAll"
                        role="tabpanel">

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">

                            <div>

                                <h5 class="fw-bold mb-1">
                                    Semua Kelompok
                                </h5>

                                <p class="text-muted mb-0 fs-13">
                                    Menampilkan seluruh data kelompok generus
                                </p>

                            </div>

                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">

                                {{ count($allKelompok) }} Kelompok

                            </span>

                        </div>

                        <div class="row g-4">

                            @include('livewire.administrasi.kelompok.data', [
                            'listKelompok' => $allKelompok
                            ])

                        </div>

                    </div>

                    {{-- PER DESA --}}
                    @foreach($desa as $kat)

                    <div class="tab-pane fade {{ $activeTab === 'desa-'.$kat->ms_desa_id ? 'show active' : '' }}"
                        id="tabDesa{{ $kat->ms_desa_id }}" role="tabpanel">

                        @php
                        $kelompokDesa = $allKelompok->where(
                        'ms_desa_id',
                        $kat->ms_desa_id
                        );
                        @endphp

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">

                            <div>

                                <h5 class="fw-bold mb-1">
                                    Desa {{ $kat->nama_desa }}
                                </h5>

                                <p class="text-muted mb-0 fs-13">
                                    Data kelompok berdasarkan desa binaan
                                </p>

                            </div>

                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">

                                {{ count($kelompokDesa) }} Kelompok

                            </span>

                        </div>

                        <div class="row g-4">

                            @include('livewire.administrasi.kelompok.data', [
                            'listKelompok' => $kelompokDesa
                            ])

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

</div>