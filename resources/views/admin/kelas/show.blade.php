@extends('layouts.admin')

@section('title', 'Detail Kelas')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="background-color: #1a233a; border-radius: 12px;">
            
            <div class="card-header border-0 bg-transparent pt-4 px-4 pb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <h5 class="fw-bold text-white mb-0">Detail Informasi Kelas</h5>
                    </div>
                    <a href="{{ route('admin.kelas.edit', $kelas->id) }}" class="btn btn-warning btn-sm px-3 fw-semibold text-dark">
                        <i class="bi bi-pencil-fill me-1"></i> Edit Kelas
                    </a>
                </div>
            </div>

            <div class="card-body px-4 pb-4">
                <hr style="border-color: #2d3748;">
                <div class="row g-3">
                    
                    <div class="col-sm-4">
                        <span class="text-white opacity-75 d-block small mb-2 fw-semibold">TINGKAT KELAS</span>
                        <span class="badge px-3 py-2 fs-6" style="background-color: rgba(59, 130, 246, 0.2); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.3);">
                            Kelas {{ $kelas->tingkat }}
                        </span>
                    </div>
                    
                    <div class="col-sm-4">
                        <span class="text-white opacity-75 d-block small mb-2 fw-semibold">NAMA JURUSAN</span>
                        <span class="fs-5 fw-bold text-white text-uppercase">{{ $kelas->jurusan }}</span>
                    </div>
                    
                    <div class="col-sm-4">
                        <span class="text-white opacity-75 d-block small mb-2 fw-semibold">NOMOR URUT KELAS</span>
                        <span class="fs-5 fw-bold text-warning">{{ $kelas->nomor_kelas }}</span>
                    </div>
                    
                    <div class="col-12 mt-4">
                        <div class="p-3" style="background-color: #131926; border-radius: 8px; border: 1px solid #2d3748;">
                            <span class="text-white opacity-50 d-block small mb-1 fw-semibold">GURU WALI KELAS</span>
                            <span class="fs-6 fw-semibold text-info">
                                <i class="bi bi-person-badge me-2"></i>{{ $kelas->wali_kelas ?? 'Belum Ditentukan' }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection