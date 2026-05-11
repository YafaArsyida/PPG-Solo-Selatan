<div>
    <div wire:ignore.self class="modal fade" id="ModalImportGenerus" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg overflow-hidden">

                {{-- HEADER --}}
                <div class="modal-header bg-light border-0 px-4 py-3">

                    <div>
                        <h4 class="modal-title fw-bold mb-1">
                            <i class="ri-database-2-line text-success me-2"></i>
                            Import Data Generus
                        </h4>

                        <p class="text-muted mb-0 fs-13">
                            Upload file Excel untuk menambahkan data generus secara massal.
                        </p>
                    </div>

                    <div class="d-flex align-items-center gap-2">

                        <a href="{{ url('storage/template_import_excel/template_import_generus.xlsx') }}"
                            class="btn btn-soft-success btn-sm" download>

                            <i class="ri-file-excel-2-line me-1"></i>
                            Download Template

                        </a>

                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close">

                        </button>

                    </div>

                </div>

                <form wire:submit.prevent="importGenerus">

                    <div class="modal-body px-4 py-4">

                        {{-- TOP ICON --}}
                        <div class="text-center mb-4">

                            <div class="avatar-xl mx-auto mb-3">

                                <div class="avatar-title bg-success-subtle text-success rounded-circle">

                                    <lord-icon src="https://cdn.lordicon.com/fjvfsqea.json" trigger="loop"
                                        colors="primary:#198754,secondary:#198754" style="width:70px;height:70px">

                                    </lord-icon>

                                </div>

                            </div>

                            <h4 class="fw-bold mb-1">
                                Import Dokumen Excel
                            </h4>

                            <p class="text-muted mb-0">
                                Pastikan format file sesuai template yang telah disediakan.
                            </p>

                        </div>

                        {{-- FORM --}}
                        <div class="row g-4">

                            {{-- Upload File --}}
                            <div class="col-lg-6">

                                <div class="card border shadow-sm h-100 mb-0">

                                    <div class="card-body">

                                        <label for="file_import" class="form-label fw-semibold">
                                            Upload File Excel
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input type="file" wire:model="file_import" id="file_import"
                                            class="form-control">

                                        <div class="form-text">
                                            Format file yang didukung: .xlsx
                                        </div>

                                        @error('file_import')
                                        <small class="text-danger d-block mt-1">
                                            {{ $message }}
                                        </small>
                                        @enderror

                                    </div>

                                </div>

                            </div>

                            {{-- Kelompok --}}
                            <div class="col-lg-6">

                                <div class="card border shadow-sm h-100 mb-0">

                                    <div class="card-body">

                                        <label for="ms_kelompok_id" class="form-label fw-semibold">
                                            Penempatan Kelompok
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select id="ms_kelompok_id" wire:model="ms_kelompok_id" class="form-select">

                                            <option value="">
                                                Pilih Kelompok
                                            </option>

                                            @foreach ($select_kelompok as $item)
                                            <option value="{{ $item->ms_kelompok_id }}">
                                                {{ $item->nama_kelompok }}
                                            </option>
                                            @endforeach

                                        </select>

                                        <div class="form-text">
                                            Semua data generus akan ditempatkan ke kelompok ini.
                                        </div>

                                        @error('ms_kelompok_id')
                                        <small class="text-danger d-block mt-1">
                                            {{ $message }}
                                        </small>
                                        @enderror

                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- PREVIEW --}}
                        <div class="mt-4">

                            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">

                                <div>
                                    <h5 class="fw-semibold mb-1">
                                        Preview Data Import
                                    </h5>

                                    <p class="text-muted fs-13 mb-0">
                                        Pastikan data sudah benar sebelum diimport ke sistem.
                                    </p>
                                </div>

                                @if(!empty($newGenerusList) && is_array($newGenerusList))
                                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                    {{ count($newGenerusList) }} Data Ditemukan
                                </span>
                                @endif

                            </div>

                            <div class="table-responsive border rounded-3">

                                <table class="table table-hover align-middle mb-0">

                                    <thead class="table-light">

                                        <tr>
                                            <th width="60">No</th>
                                            <th>Nama Generus</th>
                                            <th>No. Telepon</th>
                                            <th>Tempat Lahir</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Jenis Kelamin</th>
                                        </tr>

                                    </thead>

                                    <tbody>

                                        @if(!empty($newGenerusList) && is_array($newGenerusList))

                                        @foreach($newGenerusList as $index => $generus)

                                        <tr>

                                            <td class="fw-semibold">
                                                {{ $index + 1 }}
                                            </td>

                                            <td>
                                                <div class="fw-medium">
                                                    {{ $generus['nama_generus'] ?? '-' }}
                                                </div>
                                            </td>

                                            <td>
                                                {{ $generus['nomor_telepon'] ?? '-' }}
                                            </td>

                                            <td>
                                                {{ $generus['tempat_lahir'] ?? '-' }}
                                            </td>

                                            <td>
                                                {{ $generus['tanggal_lahir'] ?? '-' }}
                                            </td>

                                            <td>

                                                @if(($generus['jenis_kelamin'] ?? '') == 'laki-laki')
                                                <span class="badge bg-primary-subtle text-primary">
                                                    Laki-laki
                                                </span>
                                                @elseif(($generus['jenis_kelamin'] ?? '') == 'perempuan')
                                                <span class="badge bg-danger-subtle text-danger">
                                                    Perempuan
                                                </span>
                                                @else
                                                <span class="badge bg-light text-muted">
                                                    -
                                                </span>
                                                @endif

                                            </td>

                                        </tr>

                                        @endforeach

                                        @else

                                        <tr>

                                            <td colspan="6" class="text-center py-5 text-muted">

                                                <div class="d-flex flex-column align-items-center">

                                                    <i class="ri-inbox-2-line fs-1 mb-2 text-muted"></i>

                                                    <h6 class="fw-semibold mb-1">
                                                        Belum Ada Data Import
                                                    </h6>

                                                    <p class="mb-0 fs-13">
                                                        Upload file Excel untuk menampilkan preview data generus.
                                                    </p>

                                                </div>

                                            </td>

                                        </tr>

                                        @endif

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div class="modal-footer border-0 px-4 pb-4 pt-0">

                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">

                            <i class="ri-close-line me-1"></i>
                            Tutup

                        </button>

                        <button type="submit" class="btn btn-primary rounded-pill px-4">

                            <i class="ri-upload-2-line me-1"></i>
                            Import Generus

                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>