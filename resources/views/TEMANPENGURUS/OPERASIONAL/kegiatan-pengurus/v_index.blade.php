@extends('template_machine_temanpengurus.v_template')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Operasional Kegiatan Pengurus</h4>
        
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">TemanPengurus</a></li>
                            <li class="breadcrumb-item active">Operasional</li>
                            <li class="breadcrumb-item active">Operasional Kegiatan Pengurus</li>
                        </ol>
                    </div>
        
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="row-xxl-12">
                @livewire('teman-pengurus.operasional.kegiatan-pengurus.index')
                @livewire('teman-pengurus.operasional.kegiatan-pengurus.report')
                @livewire('teman-pengurus.operasional.kegiatan-pengurus.status')

                @livewire('teman-pengurus.kegiatan-pengurus.create')
                @livewire('teman-pengurus.kegiatan-pengurus.detail')

                @livewire('teman-pengurus.infaq.create')
                @livewire('teman-pengurus.infaq.edit')
            </div>
        </div>
    
    </div>
</div>

@endsection