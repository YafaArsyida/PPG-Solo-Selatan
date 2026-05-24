<div>
    {{-- TOPBAR --}}
    <div class="row g-3 align-items-end">
        {{-- SEARCH --}}
        <div class="col-xxl-8 col-lg-7">
            <label class="form-label fw-semibold">
                Pencarian Dapukan
            </label>
            <div class="position-relative">
                <input type="text" class="form-control ps-5" wire:model.debounce.300ms="search"
                    placeholder="Cari nama dapukan...">
                <i class="ri-search-line position-absolute top-50 start-0 translate-middle-y ms-3 text-muted fs-18">
                </i>
            </div>
        </div>
        {{-- BUTTON --}}
        <div class="col-lg-4">
            <button type="button" class="btn btn-primary w-100 rounded-pill" data-bs-toggle="modal"
                data-bs-target="#DapukanCreate" wire:click="$emit('DapukanCreate')">
                <i class="ri-add-line me-1">
                </i>
                Tambah
            </button>
        </div>
    </div>
    {{-- TABLE CARD --}}
    <div class="row mt-3">
        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-uppercase fw-semibold">
                        <th width="60" class="text-center">No</th>
                        <th width="100" class="text-center">
                            Hapus
                        </th>
                        <th class="">
                            Informasi Dapukan
                        </th>
                        <th width="80" class="text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $item)
                    <tr>
                        <td class="text-center text-muted fw-semibold">
                            {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                        </td>
                        <td class="text-center">
                            {{-- {{ $index + 1 }} --}}
                            <a href="#ModalDeleteDapukan" data-bs-toggle="modal" class="btn btn-soft-danger btn-sm rounded-pill px-3"
                                wire:click.prevent="$emit('DapukanDelete', {{ $item->ms_dapukan_id }})">
                                <i class="ri-delete-bin-5-line"></i> Hapus
                            </a>
                        </td>
                        {{-- INFORMASI --}}
                        <td>
                            <div class="fw-semibold">
                                {{ $item->nama_dapukan }}
                            </div>
                            <small style="white-space: nowrap">
                                {{ $item->deskripsi ?? 'Tidak ada deskripsi' }}
                            </small>
                        </td>
                        {{-- ACTION --}}
                        <td>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                {{-- EDIT --}}
                                <a href="#DapukanEdit" data-bs-toggle="modal"
                                    class="btn btn-primary btn-sm rounded-pill text-white"
                                    wire:click.prevent="$emit('DapukanEdit', {{ $item->ms_dapukan_id }})">
                                    <i class="ri-pencil-line me-1">
                                    </i>
                                    Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="ri-inbox-2-line text-muted" style="font-size: 48px;">
                                    </i>
                                </div>
                                <h5 class="fw-semibold mb-1">
                                    Data dapukan kosong
                                </h5>
                                <p class="text-muted mb-0">
                                    Belum ada data dapukan tersedia
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- PAGINATION --}}
        <div class="card-footer bg-white border-0">
            {{ $data->links() }}
        </div>
    </div>
</div>