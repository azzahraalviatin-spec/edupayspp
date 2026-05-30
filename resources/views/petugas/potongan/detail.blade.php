@extends('layouts.petugas')
@section('title', 'Detail Potongan')
@section('content')

<style>
    .pay-wrap { max-width: 620px; margin: 0 auto; }
    .back-link {
        display:inline-flex; align-items:center; gap:8px; color:#94a3b8;
        font-size:13px; font-weight:600; text-decoration:none; margin-bottom:20px;
        padding:10px 18px; background:#1a233a; border:1px solid #2d4a8a;
        border-radius:10px; transition:.2s;
    }
    .back-link:hover { background:#1e3a6e; border-color:#3b82f6; color:#60a5fa; }
    .detail-card {
        background:#1a233a; border:1px solid #2d4a8a;
        border-radius:18px; overflow:hidden;
        box-shadow:0 8px 32px rgba(0,0,0,.35);
    }
    .detail-header {
        padding:22px 28px; border-bottom:1px solid #2d4a8a;
        display:flex; align-items:center; gap:14px;
    }
    .detail-body { padding:28px; }
    .sec-title {
        color:#60a5fa; font-size:11px; font-weight:700;
        text-transform:uppercase; letter-spacing:1px;
        margin-bottom:14px; display:flex; align-items:center; gap:8px;
    }
    .sec-title::after { content:''; flex:1; height:1px; background:#1e3a6e; }
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:20px; }
    .info-item {
        background:#131c31; border:1px solid #1e3a6e;
        border-radius:12px; padding:13px 16px;
    }
    .info-item label {
        color:#64748b; font-size:11px; font-weight:600;
        text-transform:uppercase; letter-spacing:.5px;
        display:block; margin-bottom:4px;
    }
    .info-item .val { color:#fff; font-size:14px; font-weight:700; }
    .info-item .val.green { color:#4ade80; font-size:18px; }
    .detail-footer {
        padding:20px 28px; border-top:1px solid #1e3a6e;
        display:flex; justify-content:flex-end; gap:10px;
    }
    .btn-edit-link {
        background:linear-gradient(135deg,#f59e0b,#d97706);
        border:none; color:#fff; font-size:13px; font-weight:700;
        padding:11px 22px; border-radius:10px;
        display:inline-flex; align-items:center; gap:7px;
        text-decoration:none; transition:.2s;
    }
    .btn-edit-link:hover { transform:translateY(-2px); color:#fff; }
    .btn-back-link {
        background:transparent; border:1px solid #334155; color:#94a3b8;
        font-size:13px; font-weight:600; padding:11px 22px; border-radius:10px;
        text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:.2s;
    }
    .btn-back-link:hover { border-color:#475569; color:#cbd5e1; }
</style>

@php
$bulanFull = [
    1=>'Januari', 2=>'Februari', 3=>'Maret',    4=>'April',
    5=>'Mei',     6=>'Juni',     7=>'Juli',      8=>'Agustus',
    9=>'September',10=>'Oktober',11=>'November', 12=>'Desember'
];
@endphp

<div class="pay-wrap">

    <a href="{{ route('petugas.potongan') }}" class="back-link">
        <i class="bi bi-arrow-left-circle-fill"></i> Kembali ke Daftar Potongan
    </a>

    <div class="detail-card">

        <div class="detail-header"
             style="background:linear-gradient(135deg,{{ $potongan->jenis=='prestasi' ? '#78350f,#1a233a' : '#0c4a6e,#1a233a' }})">
            <div style="width:46px; height:46px; border-radius:12px; flex-shrink:0;
                        display:flex; align-items:center; justify-content:center; font-size:22px;
                        background:{{ $potongan->jenis=='prestasi' ? 'rgba(245,158,11,.18)' : 'rgba(14,165,233,.18)' }};
                        color:{{ $potongan->jenis=='prestasi' ? '#fbbf24' : '#38bdf8' }}">
                <i class="bi bi-{{ $potongan->jenis=='prestasi' ? 'trophy-fill' : 'building-fill' }}"></i>
            </div>
            <div>
                <h5 class="text-white fw-bold mb-1" style="font-size:16px">Detail Potongan SPP</h5>
                <small style="color:#64748b;">{{ $potongan->nama }}</small>
            </div>
        </div>

        <div class="detail-body">

            {{-- Info Siswa --}}
            <div class="sec-title"><i class="bi bi-person-fill"></i> Informasi Siswa</div>
            <div class="info-grid">
                <div class="info-item">
                    <label>Nama Siswa</label>
                    <div class="val">{{ $siswa->nama }}</div>
                </div>
                <div class="info-item">
                    <label>NIS</label>
                    <div class="val" style="color:#fbbf24;">{{ $siswa->nis }}</div>
                </div>
                <div class="info-item" style="grid-column:span 2;">
                    <label>Kelas</label>
                    <div class="val">
                        {{ $siswa->kelas->tingkat ?? '' }}
                        {{ $siswa->kelas->jurusan ?? '' }}
                        {{ $siswa->kelas->nomor_kelas ?? '' }}
                    </div>
                </div>
            </div>

            {{-- Detail Potongan --}}
            <div class="sec-title"><i class="bi bi-scissors"></i> Detail Potongan</div>
            <div class="info-grid">
                <div class="info-item">
                    <label>Jenis</label>
                    <div class="val">
                        @if($potongan->jenis == 'prestasi')
                            <span style="color:#fbbf24;"><i class="bi bi-trophy-fill me-1"></i>Prestasi/Lomba</span>
                        @else
                            <span style="color:#38bdf8;"><i class="bi bi-building-fill me-1"></i>Bantuan Pemerintah</span>
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <label>Nama Potongan</label>
                    <div class="val">{{ $potongan->nama }}</div>
                </div>
                <div class="info-item" style="grid-column:span 2;">
                    <label>Nominal Potongan</label>
                    <div class="val green">
                        -Rp {{ number_format($potongan->nominal_potongan, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            {{-- Periode --}}
            <div class="sec-title"><i class="bi bi-calendar-fill"></i> Periode Berlaku</div>
            <div class="info-grid">
                @if($potongan->jenis == 'pemerintah')
                {{-- PEMERINTAH: tampilkan 1 bulan saja --}}
                <div class="info-item" style="grid-column:span 2;">
                    <label>Bulan Berlaku</label>
                    <div class="val">
                        {{ $bulanFull[$pivot->bulan_mulai] ?? '-' }} {{ $pivot->tahun_mulai }}
                    </div>
                </div>
                @else
                {{-- PRESTASI: tampilkan range --}}
                <div class="info-item">
                    <label>Bulan Mulai</label>
                    <div class="val">
                        {{ $bulanFull[$pivot->bulan_mulai] ?? '-' }} {{ $pivot->tahun_mulai }}
                    </div>
                </div>
                <div class="info-item">
                    <label>Bulan Selesai</label>
                    <div class="val">
                        {{ $bulanFull[$pivot->bulan_selesai] ?? '-' }} {{ $pivot->tahun_selesai }}
                    </div>
                </div>
                @endif

                @if($pivot->keterangan)
                <div class="info-item" style="grid-column:span 2;">
                    <label>Keterangan</label>
                    <div class="val" style="font-size:13px; font-weight:500;">{{ $pivot->keterangan }}</div>
                </div>
                @endif
            </div>

        </div>

        <div class="detail-footer">
            <a href="{{ route('petugas.potongan') }}" class="btn-back-link">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('petugas.potongan.edit', [$siswa->id, $potongan->id]) }}"
               class="btn-edit-link">
                <i class="bi bi-pencil-fill"></i> Edit Potongan
            </a>
        </div>

    </div>
</div>

@endsection