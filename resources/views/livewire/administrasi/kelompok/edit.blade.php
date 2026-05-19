<div class="modal fade" id="ModalEditKelompok" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            {{-- HEADER --}}
            <div class="modal-header border-0 pb-0 p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-sm">
                        <div class="avatar-title bg-warning-subtle text-warning rounded-circle fs-20">
                            <i class="ri-edit-2-line">
                            </i>
                        </div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">
                            Edit Data Kelompok
                        </h5>
                        <small>
                            Perbarui informasi kelompok generus
                        </small>
                    </div>
                </div>
                <button type="button" class="btn btn-light btn-icon rounded-circle" data-bs-dismiss="modal">
                    <i class="ri-close-line fs-18">
                    </i>
                </button>
            </div>
            <form wire:submit.prevent="update">
                <div class="modal-body p-4">
                    {{-- SECTION : INFORMASI UTAMA --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill">
                                Informasi Utama
                            </div>
                        </div>
                        <div class="row g-4">
                            {{-- Desa --}}
                            <div class="col-lg-6">
                                <label class="form-label fw-semibold">
                                    Desa
                                    <span class="text-danger">
                                        *
                                    </span>
                                </label>
                                <select class="form-select" wire:model.defer="ms_desa_id">
                                    <option value="">
                                        Pilih Desa
                                    </option>
                                    @foreach($listDesa as $desa)
                                    <option value="{{ $desa->ms_desa_id }}">
                                        {{ $desa->nama_desa }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('ms_desa_id')
                                <small class="text-danger d-block mt-1">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                            {{-- Nama Kelompok --}}
                            <div class="col-lg-6">
                                <label class="form-label fw-semibold">
                                    Nama Kelompok
                                    <span class="text-danger">
                                        *
                                    </span>
                                </label>
                                <input type="text" class="form-control" wire:model.defer="nama_kelompok"
                                    placeholder="Masukkan nama kelompok">
                                @error('nama_kelompok')
                                <small class="text-danger d-block mt-1">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                            {{-- Nama Masjid --}}
                            <div class="col-lg-6">
                                <label class="form-label fw-semibold">
                                    Nama Masjid
                                </label>
                                <input type="text" class="form-control" wire:model.defer="nama_masjid"
                                    placeholder="Masukkan nama masjid">
                                @error('nama_masjid')
                                <small class="text-danger d-block mt-1">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                            {{-- Alamat --}}
                            <div class="col-lg-6">
                                <label class="form-label fw-semibold">
                                    Alamat
                                    <span class="text-danger">
                                        *
                                    </span>
                                </label>
                                <input type="text" class="form-control" wire:model.defer="alamat"
                                    placeholder="Masukkan alamat lengkap">
                                @error('alamat')
                                <small class="text-danger d-block mt-1">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- SECTION : LOKASI & DESKRIPSI --}}
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                Lokasi & Deskripsi
                            </div>
                        </div>
                        <div class="row g-4">
                            {{-- Peta --}}
                            <div class="col-lg-12">
                                <label class="form-label fw-semibold">
                                    Tautan Google Maps
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="ri-map-pin-line text-danger">
                                        </i>
                                    </span>
                                    <input type="text" class="form-control" wire:model.defer="peta"
                                        placeholder="https://maps.google.com/...">
                                </div>
                                <div class="form-text">
                                    Tambahkan tautan lokasi Google Maps jika tersedia
                                </div>
                                @error('peta')
                                <small class="text-danger d-block mt-1">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                            {{-- Deskripsi --}}
                            <div class="col-lg-12">
                                <label class="form-label fw-semibold">
                                    Deskripsi
                                </label>
                                <textarea class="form-control" rows="4" wire:model.defer="deskripsi"
                                    placeholder="Tambahkan deskripsi kelompok atau catatan tambahan">
                </textarea>
                                @error('deskripsi')
                                <small class="text-danger d-block mt-1">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                {{-- FOOTER --}}
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1">
                        </i>
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 text-white">
                        <i class="ri-save-3-line me-1">
                        </i>
                        Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>