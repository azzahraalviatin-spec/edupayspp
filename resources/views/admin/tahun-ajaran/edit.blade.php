@extends('layouts.admin')

@section('title', 'Edit Tahun Ajaran')

@section('content')

@php
    // Taktik sakti memecah string "2024/2025" menjadi array angka [2024, 2025]
    $pecahTahun = explode('/', $tahunAjaran->nama);
    $tahunMulai = $pecahTahun[0] ?? '';
    $tahunSelesai = $pecahTahun[1] ?? '';
@endphp

<div class="row justify-content-center">
    <div class="col-md-5"> <div class="card p-4 border-0 shadow-sm" style="background-color: #1a233a; border-radius: 12px;">
            
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h5 class="fw-bold text-white mb-0">Edit Tahun Ajaran</h5>
            </div>

            @if($errors->any())
            <div class="alert alert-danger py-2 small border-0 mb-3" style="background-color: rgba(220, 53, 69, 0.2); color: #ea868f;">
                <i class="bi bi-exclamation-triangle me-1"></i> Mohon periksa kembali data yang Anda masukkan.
            </div>
            @endif

            <form action="{{ route('admin.tahun-ajaran.update', $tahunAjaran) }}" method="POST">
                @csrf
                @method('PUT')

                <style>
                    .custom-input {
                        background-color: #131926 !important;
                        color: #ffffff !important;
                        border: 1px solid #2d3748 !important;
                        border-radius: 6px;
                        padding: 0.6rem 0.75rem;
                        transition: all 0.2s ease;
                        text-align: center;
                    }
                    .custom-input:focus {
                        background-color: #131926 !important;
                        border-color: #ffc107 !important; /* Berganti kuning sesuai tema tombol update */
                        box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.25) !important;
                    }
                    .custom-label {
                        color: #ffffff !important;
                        font-weight: 500;
                        font-size: 0.875rem;
                        margin-bottom: 0.5rem;
                        display: block;
                    }
                </style>

                <div class="mb-3">
                    <label class="custom-label">Masukkan Tahun Ajaran</label>
                    
                    <div class="d-flex align-items-center gap-2">
                        <input type="number" 
                               name="tahun_mulai" 
                               class="form-control custom-input @error('nama') is-invalid @enderror" 
                               value="{{ old('tahun_mulai', $tahunMulai) }}" 
                               placeholder="2025" 
                               min="2000" max="2100"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                               required>

                        <span class="fw-bold text-white fs-4 mx-1">/</span >

                        <input type="number" 
                               name="tahun_selesai" 
                               class="form-control custom-input @error('nama') is-invalid @enderror" 
                               value="{{ old('tahun_selesai', $tahunSelesai) }}" 
                               placeholder="2026" 
                               min="2000" max="2100"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                               required>
                    </div>

                    @error('nama')
                        <span class="text-danger fw-bold small d-block mt-2" style="color: #ef4444 !important;">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $message }}
                        </span>
                    @enderror
                    
                    <small class="text-white opacity-50 mt-2 d-block" style="font-size: 11px;">
                        <i class="bi bi-info-circle me-1"></i>Sistem akan otomatis memperbarui periode tanggal (Juli - Juni).
                    </small>
                </div>

                <div class="mb-4 mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_aktif" id="is_aktif" value="1" style="cursor: pointer;" {{ old('is_aktif', $tahunAjaran->is_aktif) ? 'checked' : '' }}>
                        <label class="form-check-label small text-white opacity-75 ms-1" for="is_aktif" style="cursor: pointer;">
                            Jadikan tahun ajaran aktif saat ini
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-sm btn-outline-secondary px-4 text-white border-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-sm btn-warning px-4 shadow-sm text-dark fw-bold">
                        <i class="bi bi-arrow-clockwise me-1"></i> Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection