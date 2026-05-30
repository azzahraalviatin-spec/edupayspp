@extends('layouts.siswa')
@section('title', 'Profil')
@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show py-2 small">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4">
            <div class="text-center mb-4">
                <div style="background:#092C56;border-radius:50%;width:72px;height:72px;display:flex;align-items:center;justify-content:center;margin:0 auto;border:2px solid #A9CBE0">
                    <i class="bi bi-person-fill text-white fs-2"></i>
                </div>
                <div class="fw-bold text-white mt-2 fs-5">{{ $siswa->nama }}</div>
                <div class="text-muted small">NIS: {{ $siswa->nis }}</div>
                <span class="badge mt-1" style="background:#225688;color:#A9CBE0">
                    {{ $siswa->kelas->tingkat ?? '' }} {{ $siswa->kelas->jurusan ?? '' }}
                </span>
            </div>

            {{-- Info tidak bisa diubah --}}
            <div class="row g-2 mb-4" style="font-size:13px">
                <div class="col-12">
                    <div style="background:#092C56;border-radius:8px;padding:12px 16px;border:1px solid #225688">
                        <div style="color:#A9CBE0;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">Nama Lengkap</div>
                        <div class="text-white">{{ $siswa->nama }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div style="background:#092C56;border-radius:8px;padding:12px 16px;border:1px solid #225688">
                        <div style="color:#A9CBE0;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">NIS</div>
                        <div class="text-white">{{ $siswa->nis }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div style="background:#092C56;border-radius:8px;padding:12px 16px;border:1px solid #225688">
                        <div style="color:#A9CBE0;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">Jenis Kelamin</div>
                        <div class="text-white">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                    </div>
                </div>
            </div>

            {{-- Form yang bisa diubah --}}
            @if($errors->any())
            <div class="alert alert-danger py-2 small"><i class="bi bi-exclamation-triangle me-1"></i>{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('siswa.profil.update') }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label small fw-semibold" style="color:#A9CBE0">Nama Orang Tua</label>
                    <input type="text" name="nama_ortu"
                        style="background:#092C56;color:#e2e8f0;border:1px solid #225688"
                        class="form-control form-control-sm"
                        value="{{ $siswa->nama_ortu }}">
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-semibold" style="color:#A9CBE0">No HP Orang Tua</label>
                    <input type="text" name="no_hp_ortu"
                        style="background:#092C56;color:#e2e8f0;border:1px solid #225688"
                        class="form-control form-control-sm"
                        value="{{ $siswa->no_hp_ortu }}"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                </div>
                <button type="submit" class="btn btn-sm w-100" style="background:#225688;border:1px solid #A9CBE0;color:#A9CBE0">
                    <i class="bi bi-save me-1"></i>Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection