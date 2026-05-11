<div class="mt-3 mt-lg-0">

    <div class="card border-0 shadow-sm mb-0">
        <div class="card-body py-3 px-3">

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                {{-- Title --}}
                <div>
                    <h6 class="mb-1 fw-semibold">
                        <i class="ri-government-line text-primary"></i>
                        Filter Desa
                    </h6>

                    <p class="text-muted fs-12 mb-0">
                        Pilih desa untuk menampilkan data administrasi
                    </p>
                </div>

                {{-- Select --}}
                <div style="min-width: 260px;">

                    <div class="input-group">

                        <span class="input-group-text bg-primary-subtle border-primary-subtle text-primary">
                            <i class="ri-government-line"></i>
                        </span>

                        <select wire:model="selectedDesa" class="form-select border-primary-subtle shadow-sm"
                            style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-trigger="hover"
                            data-bs-placement="top" title="Pilih Desa">

                            @foreach ($select_desa as $item)
                            <option value="{{ $item->ms_desa_id }}">
                                Desa {{ $item->nama_desa }}
                            </option>
                            @endforeach

                        </select>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.emit('parameterUpdated', @json($selectedDesa));
        });
    </script>

</div>