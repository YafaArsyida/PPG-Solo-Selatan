@extends('template_machine.v_template')
@section('content')
<div class="page-content">
    <div class="container-fluid">
    
        <div class="row mb-3 pb-1">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-16 mb-1">Laporan Kehadiran Generus</h4>
                        <p class="text-muted mb-0">Operasional > Laporan Kehadiran</p>
                    </div>
                    @livewire('parameter.desa')
                </div><!-- end card header -->
            </div>
            <!--end col-->
        </div>

        <div class="row">
            <div class="row-xxl-12">
                @livewire('laporan-kehadiran.index')
                @livewire('parameter.filter-kegiatan')
            </div>
        </div>
    
    </div>
</div>

@endsection