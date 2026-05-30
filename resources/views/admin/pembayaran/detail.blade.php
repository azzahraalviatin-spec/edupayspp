@extends('layouts.admin')
@section('title', 'Detail Metode Pembayaran')
@section('content')

<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8">
            {{-- Tombol Kembali --}}
            <div class="mb-3">
                <a href="{{ route('admin.pembayaran.index') }}" class="btn text-muted small p-0 shadow-none d-inline-flex align-items-center" style="background: transparent;">
                    <i class="bi bi-arrow-left me-1.5"></i> Kembali ke Daftar
                </a>
            </div>

            {{-- Card Utama Tema Gelap --}}
            <div class="card border-0 shadow" style="background: #111827; border-radius: 12px; border: 1px solid #1f2937;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-white m-0 d-flex align-items-center" style="font-size: 16px;">
                        <span class="p-2 bg-info bg-opacity-10 rounded-3 me-2.5 d-inline-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                            <i class="bi bi-info-circle-fill text-info"></i>
                        </span>
                        Detail Informasi Opsi Pembayaran
                    </h5>
                </div>

                <div class="card-body p-4">
                    {{-- List Group Super Gelap dengan Teks Putih Terang --}}
                    <div class="list-group list-group-flush rounded-3" style="border: 1px solid #1f2937; background: #0f172a;">
                        
                        {{-- Baris 1: Nama Metode --}}
                        <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center py-3 px-4" style="border-bottom: 1px solid #1f2937;">
                            <span class="text-light fw-semibold" style="width: 150px; font-size: 13.5px;">Nama Metode</span>
                            <span class="fw-bold text-info text-end" style="font-size: 14px;">{{ $metode->nama }}</span>
                        </div>

                        {{-- Baris 2: No Rekening --}}
                        <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center py-3 px-4" style="border-bottom: 1px solid #1f2937;">
                            <span class="text-light fw-semibold" style="width: 150px; font-size: 13.5px;">No. Rekening / VA</span>
                            <span class="fw-bold text-white text-end" style="font-size: 14px; letter-spacing: 0.5px;">{{ $metode->no_rekening ?? '-' }}</span>
                        </div>

                        {{-- Baris 3: Atas Nama --}}
                        <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center py-3 px-4" style="border-bottom: 1px solid #1f2937;">
                            <span class="text-light fw-semibold" style="width: 150px; font-size: 13.5px;">Atas Nama Pemilik</span>
                            <span class="text-white fw-bold text-end" style="font-size: 14px;">{{ $metode->atas_nama ?? '-' }}</span>
                        </div>

                    {{-- Baris 4: Status --}}
<div class="list-group-item bg-transparent d-flex justify-content-between align-items-center py-3 px-4">
    <span class="text-light fw-semibold" style="width: 150px; font-size: 13.5px;">Status Penggunaan</span>
    <span class="text-end">
        @if($metode->is_aktif)
        {{-- BADGE GREEN SOLID DENGAN TEKS PUTIH TEGAS WEE --}}
        <span class="badge bg-success text-white px-3 py-1.5 rounded-pill fw-bold shadow-sm" style="font-size: 11px; letter-spacing: 0.3px;">
            <i class="bi bi-check-circle-fill me-1"></i> Aktif
        </span>
        @else
        {{-- BADGE RED SOLID DENGAN TEKS PUTIH TEGAS WEE --}}
        <span class="badge bg-danger text-white px-3 py-1.5 rounded-pill fw-bold shadow-sm" style="font-size: 11px; letter-spacing: 0.3px;">
            <i class="bi bi-x-circle-fill me-1"></i> Non-Aktif
        </span>
        @endif
    </span>
</div>
                    </div>

                    {{-- Tombol Aksi bawah --}}
                  {{-- Tombol Aksi bawah (Cuma Kembali dan Edit Data sesuai request wee) --}}
<div class="d-flex justify-content-end gap-2 mt-4 pt-2">
    {{-- Tombol Kembali --}}
    <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-sm text-white border-0 fw-semibold px-3.5 py-2" style="background: #334155; border-radius: 8px;">
        <i class="bi bi-arrow-left me-1.5"></i> Kembali
    </a>
    
    {{-- Tombol Edit Data --}}
    <a href="{{ route('admin.pembayaran.edit', $metode->id) }}" class="btn btn-warning btn-sm text-dark fw-bold px-3.5 py-2" style="border-radius: 8px;">
        <i class="bi bi-pencil-square me-1.5"></i> Edit Data
    </a>
</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection