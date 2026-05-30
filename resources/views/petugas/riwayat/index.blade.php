{{-- ========================= --}}
{{-- RIWAYAT TRANSAKSI PREMIUM --}}
{{-- ========================= --}}

@extends('layouts.petugas')

@section('title', 'Riwayat Transaksi')

@section('content')

<style>
    body{
        background:#081028 !important;
    }

    .premium-card{
        background:#172036 !important;
        border:1px solid #2d4a8a !important;
        border-radius:16px;
        box-shadow:0 0 25px rgba(0,0,0,.25);
    }

    .stat-card{
        background:#172036;
        border:1px solid #2d4a8a;
        border-radius:16px;
        padding:20px;
        transition:.25s;
    }

    .stat-card:hover{
        transform:translateY(-4px);
        box-shadow:0 0 20px rgba(59,130,246,.25);
    }

    .table-dark{
        --bs-table-bg: transparent !important;
    }

    .table-dark tbody tr{
        border-color:#263552 !important;
    }

    .table-dark tbody tr:hover{
        background:rgba(59,130,246,.08) !important;
    }

    .table-dark td{
        padding:14px 10px;
    }

    .custom-thead th{
        color:#60a5fa !important;
        font-size:11px;
        text-transform:uppercase;
        letter-spacing:.5px;
        border-bottom:2px solid #2d4a8a !important;
        padding:14px 10px;
    }

    .text-light-muted{
        color:#94a3b8 !important;
    }

    .pagination svg{
        width:16px;
    }
</style>

@if(session('success'))
<div class="alert alert-success border-0" style="background:#134e4a;color:#d1fae5">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
</div>
@endif

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(59,130,246,.15);padding:14px;border-radius:12px">
                    <i class="bi bi-cash-coin text-primary fs-3"></i>
                </div>

                <div>
                    <div class="fs-4 fw-bold text-white">
                        Rp {{ number_format($totalHariIni, 0, ',', '.') }}
                    </div>

                    <div class="text-light-muted small">
                        Pemasukan Hari Ini
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(99,102,241,.15);padding:14px;border-radius:12px">
                    <i class="bi bi-graph-up-arrow text-info fs-3"></i>
                </div>

                <div>
                    <div class="fs-4 fw-bold text-white">
                        Rp {{ number_format($totalBulanIni, 0, ',', '.') }}
                    </div>

                    <div class="text-light-muted small">
                        Pemasukan Bulan Ini
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="premium-card p-4">

    <h5 class="fw-bold text-white mb-4">
        <i class="bi bi-clock-history text-info me-2"></i>
        Riwayat Transaksi
    </h5>

    <div class="table-responsive">

        <table class="table table-dark table-hover align-middle mb-0">

            <thead class="custom-thead">
                <tr>
                    <th>No</th>
                    <th>No Kwitansi</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Bulan</th>
                    <th>Jumlah</th>
                    <th>Tgl Bayar</th>
                    <th>Petugas</th>
                    <th>Status</th>
<th class="text-center">Aksi</th>  {{-- tambah ini --}}
                </tr>
            </thead>

            <tbody>
                @forelse($riwayat as $r)

                <tr>

                    <td class="text-light-muted">
                        {{ $loop->iteration }}
                    </td>

                    <td class="text-info fw-bold">
                        {{ $r->no_kwitansi ?? '-' }}
                    </td>

                    <td class="text-white fw-semibold">
                        {{ $r->tagihan->siswa->nama ?? '-' }}
                    </td>

                    <td class="text-light-muted">
                        {{ $r->tagihan->siswa->kelas->tingkat ?? '' }}
                        {{ $r->tagihan->siswa->kelas->jurusan ?? '' }}
                    </td>

                    <td class="text-light-muted">
                        {{ \Carbon\Carbon::create()->month($r->tagihan->bulan)->translatedFormat('F') }}
                    </td>

                    <td class="text-white fw-bold">
                        Rp {{ number_format($r->jumlah_bayar, 0, ',', '.') }}
                    </td>

                    <td class="text-light-muted">
                        {{ $r->tanggal_bayar ? \Carbon\Carbon::parse($r->tanggal_bayar)->translatedFormat('d M Y') : '-' }}
                    </td>

                    <td class="text-light-muted">
                        {{ $r->petugas->name ?? '-' }}
                    </td>

                    <td>
                        <span class="badge bg-success px-3 py-2">
                            Lunas
                        </span>
                    </td>
   <td class="text-center">
                        <a href="{{ route('petugas.struk', $r->id) }}"
                           target="_blank"
                           style="background:linear-gradient(135deg,#3b82f6,#2563eb);
                                  color:white; font-size:12px; font-weight:600;
                                  padding:7px 14px; border-radius:8px;
                                  text-decoration:none; display:inline-flex;
                                  align-items:center; gap:5px;">
                            <i class="bi bi-printer-fill"></i> Cetak
                        </a>
                    </td>
                </tr>

                @empty

                <tr>
                    <td colspan="10" class="text-center py-5">

                        <i class="bi bi-receipt text-info d-block mb-3"
                           style="font-size:50px"></i>

                        <div class="text-white fw-bold mb-1">
                            Belum Ada Riwayat
                        </div>

                        <small class="text-light-muted">
                            Data transaksi masih kosong.
                        </small>

                    </td>
                </tr>

                @endforelse
            </tbody>

        </table>

    </div>

    <div class="mt-4">
        {{ $riwayat->links() }}
    </div>

</div>

@endsection