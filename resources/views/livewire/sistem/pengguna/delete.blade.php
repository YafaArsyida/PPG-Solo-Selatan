<div wire:ignore.self class="modal fade zoomIn" id="ModalDeletePengguna" tabindex="-1"
    aria-labelledby="deletePenggunaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            {{-- HEADER --}}
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            {{-- BODY --}}
            <div class="modal-body px-4 pb-5 pt-0 text-center">
                {{-- ICON --}}
                <div class="mb-4">
                    <div class="avatar-xl mx-auto">
                        <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                colors="primary:#dc3545,secondary:#f06548" style="width:80px;height:80px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
                {{-- TITLE --}}
                <div class="mb-2">
                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill mb-3">
                        Konfirmasi Penghapusan
                    </span>
                    <h3 class="fw-bold mb-2" id="deleteKegiatanLabel">
                        Hapus Pengguna?
                    </h3>
                    <p class="text-muted mb-0 lh-lg px-lg-4">
                        Pengguna akan dihapus permanen dari sistem. Semua akses login dan hak
                        akses terkait juga akan dinonaktifkan.
                    </p>
                </div>
                {{-- WARNING BOX --}}
                <div
                    class="alert alert-danger-subtle border-danger-subtle d-flex align-items-start gap-2 text-start mb-4">
                    <i class="ri-error-warning-line fs-18 mt-1 text-danger">
                    </i>
                    <div>
                        <div class="fw-semibold text-danger mb-1">
                            Tindakan Tidak Dapat Dibatalkan
                        </div>
                        <small class="text-muted">
                            Pastikan data pengguna sudah benar sebelum melakukan penghapusan.
                        </small>
                    </div>
                </div>
                {{-- ACTION --}}
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    {{-- CANCEL --}}
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1">
                        </i>
                        Batal
                    </button>
                    {{-- DELETE --}}
                    <button type="button" class="btn btn-danger rounded-pill px-4 shadow-sm"
                        wire:click="ConfirmDeletePengguna">
                        <i class="ri-delete-bin-6-line me-1">
                        </i>
                        Ya, Hapus Pengguna
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>