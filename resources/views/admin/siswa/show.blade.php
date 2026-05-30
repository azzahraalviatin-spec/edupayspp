@extends('layouts.admin')

@section('title', 'Detail Siswa')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm" style="background-color: #1a233a; border-radius: 12px;">
            
            <div class="card-header border-0 bg-transparent pt-4 px-4 pb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <h5 class="fw-bold text-white mb-0">Detail Profil Siswa</h5>
                    </div>
                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-warning btn-sm px-3 fw-semibold text-dark">
                        <i class="bi bi-pencil-fill me-1"></i> Edit Profil
                    </a>
                </div>
            </div>

            <div class="card-body px-4 pb-4">
                <hr style="border-color: #2d3748;">
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <span class="text-white opacity-50 d-block small mb-1 fw-semibold">NOMOR INDUK SISWA (NIS)</span>
                        <span class="fs-6 fw-bold text-warning">{{ $siswa->nis }}</span>
                    </div>

                    <div class="col-md-6">
                        <span class="text-white opacity-50 d-block small mb-1 fw-semibold">NAMA LENGKAP</span>
                        <span class="fs-6 fw-bold text-white">{{ $siswa->nama }}</span>
                    </div>

                    <div class="col-md-6">
                        <span class="text-white opacity-50 d-block small mb-1 fw-semibold">KELAS / JURUSAN</span>
                        <span class="fs-6 fw-semibold text-white">
                            @if($siswa->kelas)
                                <span class="badge px-2 py-1" style="background-color: rgba(59, 130, 246, 0.2); color: #3b82f6;">
                                    {{ $siswa->kelas->tingkat }} {{ $siswa->kelas->jurusan }} {{ $siswa->kelas->nomor_kelas }}
                                </span>
                            @else
                                <span class="text-muted italic small">Belum diatur</span>
                            @endif
                        </span>
                    </div>

                    <div class="col-md-6">
                        <span class="text-white opacity-50 d-block small mb-1 fw-semibold">JENIS KELAMIN</span>
                        <span class="fs-6 text-white">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                    </div>

                    <div class="col-md-6">
                        <span class="text-white opacity-50 d-block small mb-1 fw-semibold">TAHUN MASUK</span>
                        <span class="fs-6 text-white">{{ $siswa->tahun_masuk ?? '-' }}</span>
                    </div>

                    <div class="col-md-6">
                        <span class="text-white opacity-50 d-block small mb-1 fw-semibold">STATUS AKUN</span>
                        @if($siswa->status == 'aktif')
                            <span class="badge px-2 py-1" style="background-color: rgba(25, 135, 84, 0.2); color: #1ea97c; border: 1px solid rgba(25, 135, 84, 0.3);">Aktif</span>
                        @else
                            <span class="badge px-2 py-1" style="background-color: rgba(108, 117, 125, 0.2); color: #adb5bd; border: 1px solid rgba(108, 117, 125, 0.3);">Alumni</span>
                        @endif
                    </div>

                    <div class="col-12 mt-4">
                        <div class="p-3" style="background-color: #131926; border-radius: 8px; border: 1px solid #2d3748;">
                            <h6 class="text-primary fw-bold mb-3 small uppercase" style="letter-spacing: 0.05em;">
                                <i class="bi bi-person-bounding-box me-2"></i>Data Orang Tua / Wali
                            </h6>
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <span class="text-white opacity-50 d-block small">Nama Orang Tua:</span>
                                    <span class="text-white fw-medium">{{ $siswa->nama_ortu ?? '-' }}</span>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-white opacity-50 d-block small">No. HP Hubungan:</span>
                                    <span class="text-info fw-semibold">{{ $siswa->no_hp_ortu ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection