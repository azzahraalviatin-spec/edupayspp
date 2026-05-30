@extends('layouts.admin')

@section('title', 'Detail Tahun Ajaran')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card p-4 border-0 shadow-sm" style="background-color: #1a233a; border-radius: 12px;">
            
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h5 class="fw-bold text-white mb-0">Detail Tahun Ajaran</h5>
            </div>

            <div class="mb-3">
                <label class="text-white fw-bold small d-block mb-2">Nama Tahun Ajaran</label>
                <div class="p-2 text-white fw-semibold" style="background-color: #131926; border-radius: 6px; border: 1px solid #2d3748; padding: 10px 12px !important;">
                    {{ $tahunAjaran->nama }}
                </div>
            </div>

            <div class="mb-3">
                <label class="text-white fw-bold small d-block mb-2">Status Keaktifan</label>
                <div class="p-2" style="background-color: #131926; border-radius: 6px; border: 1px solid #2d3748; padding: 10px 12px !important;">
                    @if($tahunAjaran->is_aktif)
                        <span class="badge px-2 py-1" style="background-color: rgba(25, 135, 84, 0.2); color: #75b798; font-size: 11px;">Aktif</span>
                    @else
                        <span class="badge px-2 py-1" style="background-color: rgba(108, 117, 125, 0.2); color: #a0aec0; font-size: 11px;">Nonaktif</span>
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-sm btn-secondary px-3 fw-semibold">
                    Kembali
                </a>
                <a href="{{ route('admin.tahun-ajaran.edit', $tahunAjaran) }}" class="btn btn-sm btn-warning px-3 text-dark fw-semibold shadow-sm">
                    <i class="bi bi-pencil-fill me-1"></i> Edit Data
                </a>
            </div>

        </div>
    </div>
</div>

@endsection