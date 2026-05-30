@extends('layouts.admin')

@section('title', 'Detail Konfigurasi SPP')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card p-4 border-0 shadow-sm" style="background-color: #1a233a; border-radius: 12px;">
            
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('admin.setting-spp.index') }}" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h5 class="fw-bold text-white mb-0">Detail Konfigurasi SPP</h5>
            </div>

            <div class="p-2" style="background-color: #131926; border-radius: 8px; border: 1px solid #2d3748;">
                
                <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom: 1px solid #2d3748;">
                    <span class="text-white-50 small fw-medium">Tahun Ajaran</span>
                    <span class="text-white fw-bold">: {{ $settingSpp->tahunAjaran->nama ?? 'Semua Tahun' }}</span>
                </div>

                <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom: 1px solid #2d3748;">
                    <span class="text-white-50 small fw-medium">Tingkat Kelas</span>
                    <span class="text-info fw-bold">: Kelas {{ $settingSpp->kelas->tingkat ?? 'Semua' }}</span>
                </div>

                <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom: 1px solid #2d3748;">
                    <span class="text-white-50 small fw-medium">Nominal Tarif</span>
                    <span class="text-warning fw-bold">: Rp {{ number_format((int)($settingSpp->nominal ?? 0), 0, ',', '.') }} / Bulan</span>
                </div>

                <div class="d-flex justify-content-between align-items-center p-3">
                    <span class="text-white-50 small fw-medium">Terakhir Diperbarui</span>
                    <span class="text-white fw-semibold small">: {{ $settingSpp->updated_at ? $settingSpp->updated_at->format('d M Y, H:i') . ' WIB' : '-' }}</span>
                </div>

            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.setting-spp.index') }}" class="btn btn-sm btn-secondary px-3 fw-semibold">
                    Kembali
                </a>
                <a href="{{ route('admin.setting-spp.edit', $settingSpp->id) }}" class="btn btn-sm btn-warning px-3 text-dark fw-bold shadow-sm">
                    <i class="bi bi-pencil-fill me-1"></i> Edit Tarif
                </a>
            </div>

        </div>
    </div>
</div>

@endsection