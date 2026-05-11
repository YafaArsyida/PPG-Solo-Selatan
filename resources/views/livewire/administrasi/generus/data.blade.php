<div class="table-responsive">

    <table class="table table-hover align-middle mb-0">

        <thead class="table-light">

            <tr>

                <th width="60" class="text-center">
                    No
                </th>

                <th>
                    Generus
                </th>

                <th>
                    Kontak
                </th>

                <th>
                    Kelompok
                </th>

                <th class="text-center">
                    Gender
                </th>

                <th class="text-center">
                    Usia
                </th>

                <th>
                    Jenjang
                </th>

                <th>
                    Desa
                </th>

                <th width="170" class="text-center">
                    Aksi
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($listGenerus as $i => $row)

            <tr>

                {{-- NO --}}
                <td class="text-center text-muted fw-semibold">
                    {{ $loop->iteration }}
                </td>

                {{-- NAMA --}}
                <td>

                    <div class="d-flex align-items-center gap-3">

                        <div class="avatar-sm">

                            <div class="avatar-title rounded-circle
                                {{ $row->jenis_kelamin == 'perempuan'
                                    ? 'bg-danger-subtle text-danger'
                                    : 'bg-primary-subtle text-primary' }}">

                                <i class="ri-user-3-line fs-16"></i>

                            </div>

                        </div>

                        <div>

                            <h6 class="mb-1 fw-semibold">
                                {{ $row->nama_generus }}
                            </h6>

                            <span class="text-muted fs-12">
                                {{ $row->tempat_lahir ?? '-' }}
                            </span>

                        </div>

                    </div>

                </td>

                {{-- TELEPON --}}
                <td>

                    @if($row->nomor_telepon)

                    <div class="d-flex align-items-center text-success">

                        <i class="ri-whatsapp-line me-2 fs-16"></i>

                        <span class="fw-medium">
                            {{ $row->nomor_telepon }}
                        </span>

                    </div>

                    @else

                    <span class="text-muted">
                        -
                    </span>

                    @endif

                </td>

                {{-- KELOMPOK --}}
                <td>

                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">

                        <i class="ri-home-4-line me-1"></i>

                        {{ $row->ms_kelompok->nama_kelompok ?? '-' }}

                    </span>

                </td>

                {{-- GENDER --}}
                <td class="text-center">

                    @if($row->jenis_kelamin == 'laki-laki')

                    <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill">
                        L
                    </span>

                    @elseif($row->jenis_kelamin == 'perempuan')

                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">
                        P
                    </span>

                    @else

                    <span class="badge bg-light text-muted px-3 py-2 rounded-pill">
                        -
                    </span>

                    @endif

                </td>

                {{-- USIA --}}
                <td class="text-center">

                    @if($row->usia)

                    <div class="fw-semibold">
                        {{ $row->usia }}
                    </div>

                    <small class="text-muted">
                        Tahun
                    </small>

                    @else

                    <span class="text-muted">
                        -
                    </span>

                    @endif

                </td>

                {{-- JENJANG --}}
                <td>

                    @if($row->usia)

                    <div class="d-flex flex-wrap gap-1">

                        @foreach($row->jenjang_usia as $jenjang)

                        <span class="badge bg-light text-dark border">

                            {{ ucfirst(str_replace('_', ' ', $jenjang)) }}

                        </span>

                        @endforeach

                    </div>

                    @else

                    <span class="text-muted">
                        -
                    </span>

                    @endif

                </td>

                {{-- DESA --}}
                <td>

                    <div class="d-flex align-items-center text-muted">

                        <i class="ri-government-line text-primary me-2"></i>

                        <span class="fw-medium text-body">
                            {{ $row->ms_kelompok->ms_desa->nama_desa ?? '-' }}
                        </span>

                    </div>

                </td>

                {{-- AKSI --}}
                <td>

                    <div class="d-flex justify-content-center gap-2">

                        {{-- DETAIL --}}
                        <a href="#ModalDetailGenerus" data-bs-toggle="modal" class="btn btn-light btn-sm"
                            title="Detail Generus"
                            wire:click.prevent="$emit('GenerusDetail', {{ $row->ms_generus_id }})">

                            <i class="ri-eye-line text-primary"></i>

                        </a>

                        {{-- EDIT --}}
                        <a href="#ModalEditGenerus" data-bs-toggle="modal" class="btn btn-light btn-sm"
                            title="Edit Generus" wire:click.prevent="$emit('GenerusEdit', {{ $row->ms_generus_id }})">

                            <i class="ri-pencil-line text-warning"></i>

                        </a>

                        {{-- DELETE --}}
                        <a href="#ModalDeleteGenerus" data-bs-toggle="modal" class="btn btn-light btn-sm"
                            title="Hapus Generus"
                            wire:click.prevent="$emit('GenerusDelete', {{ $row->ms_generus_id }})">

                            <i class="ri-delete-bin-5-line text-danger"></i>

                        </a>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="9" class="text-center py-5">

                    <div class="d-flex flex-column align-items-center">

                        <div class="avatar-md mb-3">

                            <div class="avatar-title bg-light text-muted rounded-circle">

                                <i class="ri-user-search-line fs-2"></i>

                            </div>

                        </div>

                        <h6 class="fw-semibold mb-1">
                            Tidak Ada Data Generus
                        </h6>

                        <p class="text-muted mb-0 fs-13">
                            Data generus belum tersedia atau belum ditemukan.
                        </p>

                    </div>

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>