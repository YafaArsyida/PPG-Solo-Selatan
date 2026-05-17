<div class="row justify-content-center g-3 p-3">
    {{-- ================= LEFT : SCAN PRESENSI ================= --}}
    <div class="col-xl-5 col-lg-6">
        <div class="position-sticky" style="top:20px; z-index:10;">
            <div class="card border-0 shadow-lg overflow-hidden">
                {{-- HEADER --}}
                <div class="card-header border-0 bg-primary bg-gradient p-4">
                    <div class="text-center text-white">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="Logo" class="mb-3"
                            style="height:50px;">
                        <h4 class="fw-bold text-white mb-1">
                            TemanGenerus
                        </h4>
                        <p class="mb-0 text-white-75">
                            Presensi RFID Generus
                        </p>
                    </div>
                </div>
                {{-- BODY --}}
                <div class="card-body p-4">
                    {{-- INFORMASI KEGIATAN --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap mb-3">
                            <div>
                                <h5 class="fw-bold mb-1">
                                    {{ $kegiatan->nama_kegiatan }}
                                </h5>
                                <div class="text-muted">
                                    {{ \App\Http\Controllers\HelperController::formatTanggalIndonesia(
                                    $kegiatan->tanggal,
                                    'd F Y' ) }} • {{ $kegiatan->waktu }}
                                </div>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                    {{ ucfirst($kegiatan->jenjang ?? 'Semua Jenjang') }}
                                </span>
                                <span class="badge rounded-pill bg-info-subtle text-info px-3 py-2">
                                    {{ ucfirst($kegiatan->scope) }}
                                </span>
                            </div>
                        </div>
                        @if($kegiatan->deskripsi)
                        <div class="alert alert-light border mb-0">
                            <i class="ri-information-line me-1 text-primary">
                            </i>
                            {{ $kegiatan->deskripsi }}
                        </div>
                        @endif
                    </div>
                    {{-- LOKASI --}}
                    <div class="border rounded-3 p-3 mb-4 bg-light-subtle">
                        <div class="d-flex align-items-start gap-3">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                    <i class="ri-map-pin-line fs-5">
                                    </i>
                                </span>
                            </div>
                            <div>
                                <div class="fw-semibold mb-1">
                                    Lokasi Kegiatan
                                </div>
                                <div class="text-muted small">
                                    @if($kegiatan->scope === 'daerah') Daerah Sragen Barat @elseif($kegiatan->scope
                                    === 'desa') Desa {{ $kegiatan->ms_desa->nama_desa ?? '-' }} @elseif($kegiatan->scope
                                    === 'kelompok') Kelompok {{ $kegiatan->ms_kelompok->nama_kelompok ?? '-'
                                    }} @endif • {{ $kegiatan->lokasi_final['tempat'] ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- RFID SCANNER --}}
                    <div class="border border-primary rounded-4 p-4 bg-primary-subtle bg-opacity-10">
                        <div class="text-center mb-4">
                            <div class="avatar-sm mx-auto mb-3">
                                <span class="avatar-title rounded-circle bg-primary text-white">
                                    <i class="ri-barcode-box-line fs-1">
                                    </i>
                                </span>
                            </div>
                            <h4 class="fw-bold mb-1">
                                Scan Kartu RFID
                            </h4>
                            <p class="text-muted mb-0">
                                Tempelkan kartu untuk mencatat presensi generus
                            </p>
                        </div>
                        {{-- INPUT --}}
                        <div class="mb-3">
                            <div class="input-group input-group-lg shadow-sm">
                                <span class="input-group-text bg-primary text-white border-primary px-4">
                                    <i class="ri-qr-scan-2-line fs-3">
                                    </i>
                                </span>
                                <input id="barcodeInput" type="text" wire:model.lazy="barcodeInput"
                                    wire:keydown.enter="scanDariBarcode" class="form-control border-primary"
                                    placeholder="Scan kartu RFID..." autofocus>
                            </div>
                        </div>
                        {{-- LIVE CLOCK --}}
                        {{-- <div class="text-center mt-4">
                            <div class="text-muted small mb-1">
                                Waktu Sekarang
                            </div>
                            <h2 class="fw-bold text-primary mb-0">
                                <i class="ri-time-line me-1">
                                </i>
                                <span id="live-clock">
                                    --:--:--
                                </span>
                            </h2>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ================= RIGHT : RIWAYAT ================= --}}
    <div class="col-xl-7 col-lg-6">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            {{-- HEADER --}}
            <div class="card-header bg-white border-bottom p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h4 class="card-title mb-1 fw-bold">
                            <i class="ri-history-line me-1 text-primary">
                            </i>
                            Riwayat Presensi
                        </h4>
                        <p class="text-muted mb-0">
                            Daftar generus yang telah melakukan presensi
                        </p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge bg-success-subtle text-success fs-12 px-3 py-2">
                            {{ count($riwayatAbsensi) }} Presensi
                        </span>
                        <span class="badge bg-light text-dark fs-12 px-3 py-2">
                            Auto Update
                        </span>
                    </div>
                </div>
            </div>
            {{-- BODY --}}
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: calc(100vh - 180px); overflow-y:auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light sticky-top" style="z-index:5;">
                            <tr>
                                <th width="60">
                                    #
                                </th>
                                <th>
                                    Generus
                                </th>
                                <th>
                                    Kelompok
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Waktu
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatAbsensi as $index => $absen)
                            <tr>
                                <td class="fw-semibold text-muted">
                                    {{ $index + 1 }}
                                </td>
                                <td>
                                    <div class="fw-semibold">
                                        {{ $absen->ms_generus->nama_generus ?? '-' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        {{ $absen->ms_generus->ms_kelompok->nama_kelompok ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if($absen->status_hadir === 'hadir')
                                    <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                        <i class="ri-check-line me-1">
                                        </i>
                                        Hadir
                                    </span>
                                    @else
                                    <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">
                                        {{ ucfirst($absen->status_hadir) }}
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-semibold">
                                        {{ \Carbon\Carbon::parse($absen->waktu_hadir)->format('H:i:s') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="ri-inbox-line fs-1 d-block mb-2">
                                        </i>
                                        Belum ada presensi hari ini
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- FOOTER --}}
            <div class="card-footer bg-light border-top text-center small text-muted">
                <i class="ri-refresh-line me-1">
                </i>
                Data diperbarui secara otomatis
            </div>
        </div>
    </div>
    {{-- ================= SCRIPT ================= --}}
    <script>
        document.addEventListener('livewire:load',
    function() {

      Livewire.on('focusBarcode', () = >{

        let input = document.getElementById('barcodeInput');

        if (input) {
          input.focus();
        }

      });

      function updateClock() {

        const clockEl = document.getElementById('live-clock');

        if (!clockEl) return;

        const now = new Date();

        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        clockEl.textContent = `$ {
          hours
        }: $ {
          minutes
        }: $ {
          seconds
        }`;

      }

      updateClock();

      setInterval(updateClock, 1000);

    });
    </script>
</div>