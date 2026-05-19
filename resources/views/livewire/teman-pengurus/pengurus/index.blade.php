<div class="card border-0 shadow-sm rounded-4 overflow-hidden" id="kegiatanGenerusList">
    {{-- HEADER --}}
    <div class="card-header bg-white border-0 p-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">
            {{-- TITLE --}}
            <div>
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="avatar-sm">
                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-20">
                            <i class="ri-team-line"></i>
                        </div>
                    </div>

                    <div>
                        <h4 class="fw-bold mb-1">
                            Master Pengurus
                        </h4>
                        <p class="text-muted mb-0 fs-13">
                            Kelola data pengurus sesuai dapukannya
                        </p>
                    </div>
                </div>
            </div>

            {{-- ACTION --}}
            <div class="d-flex gap-2 flex-wrap">
                {{-- IMPORT --}}
                <button type="button" class="btn btn-light border rounded-pill px-4" data-bs-toggle="modal"
                    data-bs-target="#ExportLaporanExcel">
                    <i class="ri-database-2-line me-1 text-secondary"></i>
                    Export Data
                </button>
                {{-- Master dapukan --}}
                <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasDapukan" aria-controls="offcanvasDapukan">
                    <i class="ri-building-line me-1">
                    </i>
                    Master Dapukan
                </button>
                {{-- TAMBAH --}}
                <button type="button" class="btn btn-success rounded-pill px-4" data-bs-toggle="modal"
                    data-bs-target="#PengurusCreate"
                    wire:click.prevent="$emit('PengurusCreate')">
                    <i class="ri-add-line me-1"></i>Tambah Pengurus
                </button>
            </div>
        </div>
    </div>
    {{-- FILTER --}}
    <div class="card-body border-top border-bottom bg-light-subtle">
        <div class="row g-3 align-items-end">
            {{-- SEARCH --}}
            <div class="col-lg-4">
                <label class="form-label fw-semibold">
                    Cari Pengurus
                </label>
                <div class="search-box">
                    <input type="text" class="form-control" placeholder="Cari nama pengurus..."
                        wire:model.debounce.500ms="search">
                    <i class="ri-search-line search-icon">
                    </i>
                </div>
            </div>
            {{-- GENDER --}}
            <div class="col-lg-3">
                <label class="form-label fw-semibold">
                    Jenis Kelamin
                </label>
                <select class="form-select" wire:model="gender">
                    <option value="">
                        Semua Gender
                    </option>
                    <option value="laki-laki">
                        Laki-laki
                    </option>
                    <option value="perempuan">
                        Perempuan
                    </option>
                </select>
            </div>
            {{-- DAPUKAN --}}
            <div class="col-lg-3">
                <label class="form-label fw-semibold">
                    Dapukan
                </label>
                <select class="form-select" wire:model="ms_dapukan_id">
                    <option value="">
                        Semua Dapukan
                    </option>
                    @foreach($listDapukan as $item)
                    <option value="{{ $item->ms_dapukan_id }}">
                        {{ $item->nama_dapukan }}
                    </option>
                    @endforeach
                </select>
            </div>
            {{-- Dapukan --}}
            <div class="col-lg-2">
                <button type="button" class="btn btn-light border w-100 rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#DapukanCreate" wire:click="$emit('DapukanCreate')">
                    <i class="ri-add-circle-line me-1 text-primary">
                    </i>
                    Dapukan
                </button>
            </div>
        </div>
    </div>
    
    {{-- TABLE --}}
    <div class="card-body pt-3">
        <div class="table-responsive">
            <table id="Laporan" class="table table-hover align-middle table-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Pengurus</th>
                        <th>Telepon</th>
                        <th>Kelompok</th>
                        <th>Usia</th>
                        <th>Dapukan</th>
                        <th class="text-center" width="170">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $item)
                    <tr>
                        <tr>
                            {{-- NO --}}
                            <td>
                                {{ $data->firstItem() + $index }}
                            </td>
                            {{-- PENGURUS --}}
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold">
                                        {{ $item->nama_pengurus }}
                                    </span>
                                    <small class="text-muted">
                                        {{ ucfirst($item->jenis_kelamin ?? '-') }}
                                    </small>
                                </div>
                            </td>
                            {{-- TELEPON --}}
                            <td>
                                @if($item->telepon)
                                <a href="https://wa.me/{{ $item->telepon }}" target="_blank" class="text-decoration-none">
                                    {{ $item->telepon }}
                                </a>
                                @else - @endif
                            </td>
                            {{-- KELOMPOK --}}
                            <td>
                                <span class="badge bg-primary-subtle text-primary">
                                    {{ optional($item->ms_kelompok)->nama_kelompok ?? '-' }}
                                </span>
                            </td>
                            {{-- UMUR --}}
                            <td>
                                {{ $item->usia }} Tahun
                            </td>
                            <td>
                                @if($item->ms_penempatan_dapukan_count > 0)
                                <a href="#PenempatanDapukan" data-bs-toggle="modal"
                                    wire:click.prevent="$emit('PenempatanDapukan', {{ $item->ms_pengurus_id }})"
                                    class="btn btn-soft-primary rounded-pill px-3 position-relative">
                                    <i class="ri-shield-user-line me-1">
                                    </i>
                                    {{ $item->ms_penempatan_dapukan_count }} Dapukan
                                </a>
                                @else
                                <a href="#PenempatanDapukan" data-bs-toggle="modal"
                                    wire:click.prevent="$emit('PenempatanDapukan', {{ $item->ms_pengurus_id }})"
                                    class="btn btn-success rounded-pill px-3">
                                    <i class="ri-shield-user-line me-1">
                                    </i>
                                    Tambah Dapukan
                                </a>
                                @endif
                            </td>
                            {{-- AKSI --}}
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- DETAIL --}}
                                    <button class="btn btn-light btn-sm" title="Detail">
                                        <i class="ri-eye-line text-primary">
                                        </i>
                                    </button>
                                    {{-- EDIT --}}
                                    <button class="btn btn-light btn-sm" title="Edit">
                                        <i class="ri-pencil-line text-warning">
                                        </i>
                                    </button>
                                    {{-- DELETE --}}
                                    <button class="btn btn-light btn-sm" title="Hapus">
                                        <i class="ri-delete-bin-line text-danger">
                                        </i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center">
                                <div class="avatar-md mb-3">
                                    <div class="avatar-title bg-light text-muted rounded-circle fs-2">
                                        <i class="ri-team-line"></i>
                                    </div>
                                </div>
                                <h6 class="fw-semibold mb-1">
                                    Belum Ada Data Pengurus
                                </h6>
                                <p class="text-muted mb-0 fs-13">
                                    Data Pengurus akan tampil di sini
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    
        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $data->links() }}
        </div>
    
    </div>
</div>
