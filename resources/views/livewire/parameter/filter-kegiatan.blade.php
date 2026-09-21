{{-- =========================================================
    OFFCANVAS FILTER KEGIATAN
========================================================= --}}
<div wire:ignore.self class="offcanvas offcanvas-end bg-light" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="filterKegiatan" aria-labelledby="filterKegiatanLabel">
    <div class="offcanvas-header border-bottom px-4 py-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-start w-100">
            {{-- KIRI --}}
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-sm">
                    <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-18">
                        <i class="ri-calendar-check-line"></i>
                    </div>
                </div>

                <div>
                    <h5 id="filterKegiatanLabel" class="fw-bold mb-1">
                        Filter Kegiatan
                    </h5>
                    <small class="text-muted">
                        Atur kriteria kegiatan yang ditampilkan
                    </small>
                </div>

            </div>

            {{-- KANAN --}}
            <button type="button" class="btn btn-light btn-icon rounded-circle shadow-none" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ri-close-line fs-18"></i>
            </button>
        </div>
    </div>


    <div class="offcanvas-body">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body">
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label for="PilihScopeKegiatan" class="form-label text-uppercase fw-semibold mb-0">
                            Scope Kegiatan
                        </label>
                        <i class="mdi mdi-information-outline fs-16 text-primary" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="Pilih cakupan kegiatan yang ingin ditampilkan." ></i>
                    </div>

                    <select id="PilihScopeKegiatan" wire:model="scope" class="form-select" style="cursor:pointer">
                        <option value="">
                            Semua Scope
                        </option>

                        <option value="daerah">
                            Kegiatan Daerah
                        </option>

                        <option value="desa">
                            Kegiatan Desa
                        </option>

                        <option value="kelompok">
                            Kegiatan Kelompok
                        </option>
                    </select>
                </div>

                {{-- KELOMPOK --}}
                <div id="filterKelompokKegiatan" class="mb-4 {{ $scope !== 'kelompok' ? 'd-none' : '' }}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label for="PilihKelompokKegiatan" class="form-label text-uppercase fw-semibold mb-0">
                            Kelompok
                        </label>
                        <i class="mdi mdi-information-outline fs-16 text-primary" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter kegiatan berdasarkan kelompok."></i>
                    </div>

                    <select id="PilihKelompokKegiatan" wire:model="selectedKelompok" class="form-select" style="cursor:pointer" multiple>
                        @foreach($listKelompok as $kelompok)
                            <option value="{{ $kelompok->ms_kelompok_id }}">
                                {{ $kelompok->nama_kelompok }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">

                        <label for="PilihJenjangKegiatan" class="form-label text-uppercase fw-semibold mb-0">
                            Jenjang
                        </label>

                        <i class="mdi mdi-information-outline fs-16 text-primary"
                            style="cursor: pointer;" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Pilih jenjang kegiatan yang ingin ditampilkan.">
                        </i>

                    </div>

                    <select id="PilihJenjangKegiatan" wire:model="selectedJenjang" class="form-select" style="cursor:pointer" multiple>
                        <option value="caberawit">
                            Caberawit
                        </option>

                        <option value="remaja">
                            Remaja
                        </option>

                        <option value="mandiri">
                            Mandiri
                        </option>

                    </select>

                </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label for="PilihTipeKegiatan" class="form-label text-uppercase fw-semibold mb-0">
                            Tipe Kegiatan
                        </label>

                        <i class="mdi mdi-information-outline fs-16 text-primary" style="cursor: pointer;"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Pilih tipe kegiatan yang ingin ditampilkan.">
                        </i>
                    </div>

                    <select id="PilihTipeKegiatan" wire:model="selectedTipeKegiatan" class="form-select" style="cursor:pointer" multiple>
                        <option value="rutin">
                            Rutin
                        </option>

                        <option value="sekali">
                            Sekali
                        </option>

                        <option value="khusus">
                            Khusus
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas-footer border-top bg-light-subtle p-3">
        <div class="d-flex gap-2">
            <button type="button" id="ClearFilterKegiatan" class="btn btn-light rounded-pill w-100" data-bs-dismiss="offcanvas">
                <i class="ri-refresh-line me-1"></i>
                Clear Filter
            </button>

            <button type="button" id="ApplyFilterKegiatan" class="btn btn-primary rounded-pill w-100" data-bs-dismiss="offcanvas">
                <i class="ri-filter-3-line me-1"></i>
                Terapkan Filter
            </button>
        </div>
    </div>
</div>
<script>
    // Select2 handler
    function initSelect2() {
        $('#PilihScopeKegiatan').select2();
        $('#PilihJenjangKegiatan').select2();
        $('#PilihKelompokKegiatan').select2();
        $('#PilihTipeKegiatan').select2();
    }


    // Scope → tampilkan Kelompok
    $('#PilihScopeKegiatan').on('change', function () {
        if ($(this).val() === 'kelompok') {
            $('#filterKelompokKegiatan').removeClass('d-none');

        } else {
            $('#filterKelompokKegiatan').addClass('d-none');
            $('#PilihKelompokKegiatan')
                .val(null)
                .trigger('change');
        }
    });


    // Clear filter
    document.getElementById("ClearFilterKegiatan").addEventListener("click", function () {
        $('#PilihScopeKegiatan').val('').trigger('change');

        $('#PilihJenjangKegiatan').val(null).trigger('change');

        $('#PilihKelompokKegiatan').val(null).trigger('change');

        $('#PilihTipeKegiatan').val(null).trigger('change');

        $('#filterKelompokKegiatan').addClass('d-none');

        Livewire.emit("clearFilters");

        alertify.success("Memperbarui...");

    });


    // Apply filter
    document.getElementById("ApplyFilterKegiatan").addEventListener("click", function () {

        const filters = {

            scope: $("#PilihScopeKegiatan").val(),

            jenjang: $("#PilihJenjangKegiatan").val(),

            kelompok: $("#PilihKelompokKegiatan").val(),

            tipeKegiatan: $("#PilihTipeKegiatan").val(),

        };

        // console.log(filters);
        Livewire.emit("applyFilters", filters);

        alertify.success("Memperbarui...");

    });


    // Inisialisasi Select2 dan hook Livewire
    document.addEventListener("DOMContentLoaded", function () {

        initSelect2();

        Livewire.hook('message.processed', (message, component) => {

            initSelect2();

        });

    });

</script>