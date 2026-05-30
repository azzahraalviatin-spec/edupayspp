@extends('layouts.admin')

@section('title', 'Tambah Siswa')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4 border-0 shadow-sm" style="background-color: #1a233a; border-radius: 12px;">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h5 class="fw-bold text-white mb-0">Tambah Siswa Baru</h5>
            </div>

            @if($errors->any())
            <div class="alert alert-danger py-2 small border-0" style="background-color: rgba(220, 53, 69, 0.2); color: #ea868f;">
                <i class="bi bi-exclamation-triangle me-1"></i>
                Mohon periksa kembali data yang Anda masukkan.
            </div>
            @endif

            <form action="{{ route('admin.siswa.store') }}" method="POST">
                @csrf

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
                        border-color: #3b82f6 !important;
                        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25) !important;
                    }
                    .custom-label {
                        color: #e2e8f0;
                        font-weight: 500;
                        font-size: 0.875rem;
                        margin-bottom: 0.5rem;
                    }
                </style>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="custom-label">NIS (Nomor Induk Siswa)</label>
                        <input type="text" name="nis"
                            class="form-control custom-input @error('nis') is-invalid @enderror"
                            placeholder="Contoh: 242501001" value="{{ old('nis') }}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        @error('nis')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="custom-label">Nama Lengkap</label>
                        <input type="text" name="nama"
                            class="form-control custom-input @error('nama') is-invalid @enderror"
                            placeholder="Nama lengkap siswa" value="{{ old('nama') }}"
                            oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '');">
                        @error('nama')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="custom-label">Kelas</label>
                        <select name="kelas_id" class="form-select custom-input @error('kelas_id') is-invalid @enderror">
                            <option value="" style="background-color: #131926;">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }} style="background-color: #131926;">
                                {{ $k->tingkat }} {{ $k->jurusan }} {{ $k->nomor_kelas }}
                            </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="custom-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select custom-input @error('jenis_kelamin') is-invalid @enderror">
                            <option value="" style="background-color: #131926;">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }} style="background-color: #131926;">Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }} style="background-color: #131926;">Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="custom-label">Nama Orang Tua / Wali</label>
                        <input type="text" name="nama_ortu"
                            class="form-control custom-input @error('nama_ortu') is-invalid @enderror"
                            placeholder="Nama kandung orang tua atau wali" value="{{ old('nama_ortu') }}"
                            oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '');">
                        @error('nama_ortu')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="custom-label">No. HP Orang Tua</label>
                        <input type="text" name="no_hp_ortu"
                            class="form-control custom-input @error('no_hp_ortu') is-invalid @enderror"
                            placeholder="Contoh: 081234567890" value="{{ old('no_hp_ortu') }}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        @error('no_hp_ortu')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="custom-label">Tahun Masuk</label>
                        <input type="number" name="tahun_masuk"
                            class="form-control custom-input @error('tahun_masuk') is-invalid @enderror"
                            placeholder="Contoh: 2026" value="{{ old('tahun_masuk', date('Y')) }}" min="2000" max="2099">
                        @error('tahun_masuk')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mt-4">
                        <div class="alert alert-info py-3 border-0 mb-0 d-flex align-items-center gap-2" style="background-color: rgba(13, 202, 240, 0.15); color: #6edff6; border-radius: 8px;">
                            <i class="bi bi-info-circle-fill fs-5"></i>
                            <span class="small">Password akun login siswa akan otomatis disamakan dengan nilai <strong>NIS</strong> yang didaftarkan.</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary px-4 text-white border-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm fw-semibold">
                        <i class="bi bi-save me-2"></i>Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection