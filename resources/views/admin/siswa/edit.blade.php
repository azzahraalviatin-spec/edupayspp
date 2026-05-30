@extends('layouts.admin')

@section('title', 'Edit Data Siswa')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4 border-0 shadow-sm" style="background-color: #1a233a; border-radius: 12px;">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h5 class="fw-bold text-white mb-0">Edit Data Siswa</h5>
            </div>

            @if($errors->any())
            <div class="alert alert-danger py-2 small border-0" style="background-color: rgba(220, 53, 69, 0.2); color: #ea868f;">
                <i class="bi bi-exclamation-triangle me-1"></i>
                Mohon periksa kembali data yang Anda masukkan.
            </div>
            @endif

            <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
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
                        border-color: #ffc107 !important; /* Glow kuning pas edit data */
                        box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.25) !important;
                    }
                    .custom-input:disabled {
                        background-color: #0f1420 !important;
                        color: #64748b !important;
                        border-color: #1e293b !important;
                        cursor: not-allowed;
                    }
                    .custom-label {
                        color: #ffffff;
                        font-weight: 500;
                        font-size: 0.875rem;
                        margin-bottom: 0.5rem;
                        display: block;
                    }
                </style>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="custom-label">NIS (Nomor Induk Siswa)</label>
                       <input type="text" name="nis" class="form-control custom-input" value="{{ old('nis', $siswa->nis) }}">
                        <small class="text-warning opacity-75 mt-1 d-block" style="font-size: 11px;">
   
                        </small>
                    </div>

                    <div class="col-md-6">
                        <label class="custom-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control custom-input @error('nama') is-invalid @enderror"
                            value="{{ old('nama', $siswa->nama) }}">
                        @error('nama')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="custom-label">Kelas</label>
                        <select name="kelas_id" class="form-select custom-input @error('kelas_id') is-invalid @enderror">
                            <option value="" style="background-color: #131926;">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }} style="background-color: #131926;">
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
                            <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }} style="background-color: #131926;">Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }} style="background-color: #131926;">Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="custom-label">Nama Orang Tua / Wali</label>
                        <input type="text" name="nama_ortu" class="form-control custom-input @error('nama_ortu') is-invalid @enderror"
                            value="{{ old('nama_ortu', $siswa->nama_ortu) }}">
                        @error('nama_ortu')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="custom-label">No. HP Orang Tua</label>
                        <input type="text" name="no_hp_ortu" class="form-control custom-input @error('no_hp_ortu') is-invalid @enderror"
                            value="{{ old('no_hp_ortu', $siswa->no_hp_ortu) }}">
                        @error('no_hp_ortu')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="custom-label">Tahun Masuk</label>
                        <input type="number" name="tahun_masuk" class="form-control custom-input @error('tahun_masuk') is-invalid @enderror"
                            value="{{ old('tahun_masuk', $siswa->tahun_masuk) }}">
                        @error('tahun_masuk')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="custom-label">Status Siswa</label>
                        <select name="status" class="form-select custom-input @error('status') is-invalid @enderror">
                            <option value="aktif" {{ old('status', $siswa->status) == 'aktif' ? 'selected' : '' }} style="background-color: #131926;">Aktif</option>
                            <option value="alumni" {{ old('status', $siswa->status) == 'alumni' ? 'selected' : '' }} style="background-color: #131926;">Alumni</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary px-4 text-white border-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-warning px-4 shadow-sm fw-semibold text-dark">
                        <i class="bi bi-save me-2"></i>Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection