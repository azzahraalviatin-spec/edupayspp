@extends('layouts.admin')

@section('title', 'Edit Kelas')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4 border-0 shadow-sm" style="background-color: #1a233a; border-radius: 12px;">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h5 class="fw-bold text-white mb-0">Edit Kelas</h5>
            </div>

            @if($errors->any())
            <div class="alert alert-danger py-2 small border-0" style="background-color: rgba(220, 53, 69, 0.2); color: #ea868f;">
                <i class="bi bi-exclamation-triangle me-1"></i>
                Mohon periksa kembali data kelas yang Anda masukkan.
            </div>
            @endif

      <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
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
                    }
                    .custom-input:focus {
                        background-color: #131926 !important;
                        border-color: #ffc107 !important; /* Glow kuning pas edit */
                        box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.25) !important;
                    }
                    .custom-label {
                        color: #e2e8f0;
                        font-weight: 500;
                        font-size: 0.875rem;
                        margin-bottom: 0.5rem;
                    }
                </style>

                <div class="mb-3">
                    <label class="custom-label">Tingkat</label>
                    <select name="tingkat" class="form-select custom-input @error('tingkat') is-invalid @enderror">
                        <option value="" style="background-color: #131926;">-- Pilih Tingkat --</option>
                        <option value="X" {{ old('tingkat', $kelas->tingkat) == 'X' ? 'selected' : '' }} style="background-color: #131926;">X (Sepuluh)</option>
                        <option value="XI" {{ old('tingkat', $kelas->tingkat) == 'XI' ? 'selected' : '' }} style="background-color: #131926;">XI (Sebelas)</option>
                        <option value="XII" {{ old('tingkat', $kelas->tingkat) == 'XII' ? 'selected' : '' }} style="background-color: #131926;">XII (Dua Belas)</option>
                    </select>
                    @error('tingkat')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="custom-label">Jurusan</label>
                    <input type="text" name="jurusan" class="form-control custom-input @error('jurusan') is-invalid @enderror"
                        placeholder="Contoh: TKJ, RPL, Akuntansi" value="{{ old('jurusan', $kelas->jurusan) }}">
                    @error('jurusan')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>

               <div class="form-group mb-3">
    <label for="nomor_kelas" class="text-white fw-bold mb-2">Nomor Kelas</label>
    
    <input type="number" 
           name="nomor_kelas" 
           id="nomor_kelas"
           class="form-control" 
           value="{{ old('nomor_kelas', $kelas->nomor_kelas ?? '') }}" 
           placeholder="Contoh: 1, 2, 3" 
           required>

    @error('nomor_kelas')
        <span class="text-danger fw-bold small d-block mt-1" style="color: #ef4444 !important;">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $message }}
        </span>
    @enderror
</div>

                <div class="mb-4">
                    <label class="custom-label">Wali Kelas <span class="text-muted fw-normal fs-7">(Opsional)</span></label>
                    <input type="text" name="wali_kelas" class="form-control custom-input @error('wali_kelas') is-invalid @enderror"
                        placeholder="Nama lengkap guru wali kelas" value="{{ old('wali_kelas', $kelas->wali_kelas) }}">
                    @error('wali_kelas')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-secondary px-4 text-white border-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-warning px-4 shadow-sm fw-semibold text-dark">
                        <i class="bi bi-save me-2"></i>Update Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection