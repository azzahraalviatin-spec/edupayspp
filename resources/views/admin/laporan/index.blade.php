@extends('layouts.admin')

@section('title', 'Laporan Pembayaran SPP')

@section('content')

<style>
    body { background-color: #0d121f; }
    .custom-card {
        background-color: #161d31 !important; 
        border: none !important;
        border-radius: 8px;
        box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.24);
    }
    .custom-input, .custom-select {
        background-color: #111625 !important;
        color: #ffffff !important;
        border: 1px solid #283046 !important;
        border-radius: 6px;
        padding: 0.55rem 0.75rem;
    }
    .custom-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23d0d2d6' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }
    .custom-input::placeholder { color: #676d7d !important; }
    .custom-input:focus, .custom-select:focus {
        background-color: #111625 !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25) !important;
        color: #fff !important;
    }
    .custom-table thead th {
        color: #b4b7bd !important; 
        font-weight: 600 !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #283046 !important;
        padding: 14px 10px !important;
    }
    .custom-table tbody tr { border-bottom: 1px solid #283046 !important; }
    .custom-table tbody td { padding: 14px 10px !important; vertical-align: middle; color: #d0d2d6 !important; }
    .badge-tunai { background-color: rgba(40, 199, 111, 0.12) !important; color: #28c76f !important; border: 1px solid rgba(40, 199, 111, 0.3); }
    .badge-transfer { background-color: rgba(0, 145, 255, 0.12) !important; color: #0091ff !important; border: 1px solid rgba(0, 145, 255, 0.3); }
    .badge-ewallet { background-color: rgba(115, 103, 240, 0.12) !important; color: #7367f0 !important; border: 1px solid rgba(115, 103, 240, 0.3); }
    .badge-dana { background-color: rgba(0, 145, 255, 0.12) !important; color: #0091ff !important; border: 1px solid rgba(0, 145, 255, 0.3); }
    .badge-valid { background-color: #28c76f !important; color: #ffffff !important; }
    .badge-pending { background-color: #ff9f43 !important; color: #ffffff !important; }
    .badge-tolak { background-color: #ea5455 !important; color: #ffffff !important; }
    .pagination .page-link { background-color: #111625 !important; border-color: #283046 !important; color: #b4b7bd !important; }
    .pagination .page-item.active .page-link { background-color: #3b82f6 !important; border-color: #3b82f6 !important; color: #fff !important; }
    .pagination .page-item.disabled .page-link { background-color: #161d31 !important; color: #676d7d !important; }
</style>

<div class="card p-4 custom-card mb-4">
    <h6 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
        <i class="bi bi-funnel text-primary"></i> Filter Laporan Pembayaran
    </h6>
    <form action="{{ route('admin.laporan.index') }}" method="GET">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="text-white-50 small mb-1">Bulan</label>
                <select name="bulan" class="form-select custom-select">
                    <option value="">-- Semua Bulan --</option>
                    @foreach($nama_bulan as $angka => $nama)
                        <option value="{{ $angka }}" {{ request('bulan') == $angka ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="text-white-50 small mb-1">Tahun</label>
                <select name="tahun" class="form-select custom-select">
                    <option value="">-- Semua Tahun --</option>
                    @foreach($list_tahun as $thn)
                        <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="text-white-50 small mb-1">Cari Siswa (Nama/NIS)</label>
                <input type="text" name="search" class="form-control custom-input" placeholder="Masukkan nama atau NIS..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary fw-semibold flex-grow-1" style="height: 43px;">
                    <i class="bi bi-search me-1"></i> Filter
                </button>
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary d-flex align-items-center justify-content-center" style="height: 43px; padding-left: 15px; padding-right: 15px;">
                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                </a>
            </div>
        </div>
    </form>
</div>

{{-- SUMMARY CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card p-3 custom-card h-100" style="border-left: 3px solid #28c76f !important;">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(40,199,111,0.15);padding:12px;border-radius:10px">
                    <i class="bi bi-cash-coin text-success fs-4"></i>
                </div>
                <div>
                    <div class="text-white-50 small">Total Pendapatan</div>
                    <div class="fw-bold text-white">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div class="text-white-50" style="font-size:10px">{{ $filterLabel }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 custom-card h-100" style="border-left: 3px solid #3b82f6 !important;">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(59,130,246,0.15);padding:12px;border-radius:10px">
                    <i class="bi bi-check2-circle text-primary fs-4"></i>
                </div>
                <div>
                    <div class="text-white-50 small">Transaksi Lunas</div>
                    <div class="fw-bold text-white">{{ $totalTransaksi }} Transaksi</div>
                    <div class="text-white-50" style="font-size:10px">{{ $filterLabel }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 custom-card h-100" style="border-left: 3px solid #ff9f43 !important;">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(255,159,67,0.15);padding:12px;border-radius:10px">
                    <i class="bi bi-clock text-warning fs-4"></i>
                </div>
                <div>
                    <div class="text-white-50 small">Menunggu Verifikasi</div>
                    <div class="fw-bold text-white">{{ $totalPending }} Transaksi</div>
                    <div class="text-white-50" style="font-size:10px">{{ $filterLabel }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 custom-card h-100" style="border-left: 3px solid #7367f0 !important;">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(115,103,240,0.15);padding:12px;border-radius:10px">
                    <i class="bi bi-graph-up text-info fs-4"></i>
                </div>
                <div>
                    <div class="text-white-50 small">Rata-rata per Transaksi</div>
                    <div class="fw-bold text-white">Rp {{ number_format($rataRata, 0, ',', '.') }}</div>
                    <div class="text-white-50" style="font-size:10px">{{ $filterLabel }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="areaCetak" class="card p-4 custom-card">
    <div class="d-flex justify-content-between align-items-center mb-4 non-printable">
        <h6 class="fw-bold text-white mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-file-earmark-text text-success"></i> Data Transaksi SPP
        </h6>
        <a href="{{ route('admin.laporan.pdf', request()->all()) }}" 
           class="btn btn-sm text-white px-3 py-2 fw-semibold d-flex align-items-center gap-2" 
           style="background-color: #ea5455; border: none; border-radius: 6px;">
            <i class="bi bi-file-earmark-pdf-fill"></i> Download PDF
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0 custom-table" style="font-size: 13px; background-color: transparent !important;">
            <thead>
                <tr>
                    <th style="width: 4%">NO</th>
                    <th>TANGGAL</th>
                    <th>NIS</th>
                    <th>NAMA SISWA</th>
                    <th>KELAS</th>
                    <th>BULAN</th>
                    <th>JUMLAH BAYAR</th>
                    <th>METODE</th>
                    <th class="text-center">STATUS</th>
                    <th>PETUGAS</th>
                    <th>NO KWITANSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $index => $lap)
                <tr>
                    <td>{{ $laporans->firstItem() + $index }}</td>
                    <td>
                        {{ date('d/m/Y', strtotime($lap->tanggal_bayar ?? $lap->created_at)) }}<br>
                        <small class="text-muted">{{ date('H:i', strtotime($lap->tanggal_bayar ?? $lap->created_at)) }} WIB</small>
                    </td>
                    <td>{{ $lap->tagihan->siswa->nis ?? '-' }}</td>
                    <td class="fw-semibold text-white">{{ $lap->tagihan->siswa->nama ?? '-' }}</td>
                    <td>
                        @if(isset($lap->tagihan->siswa->kelas))
                            {{ $lap->tagihan->siswa->kelas->tingkat ?? '' }}
                            {{ $lap->tagihan->siswa->kelas->jurusan ?? '' }}
                            {{ $lap->tagihan->siswa->kelas->nomor_kelas ?? '' }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $lap->bulan_teks }}</td>
                    <td style="color: #ff9f43 !important;" class="fw-bold">
                        Rp {{ number_format($lap->jumlah_bayar ?? 0, 0, ',', '.') }}
                    </td>
                    <td>
                        @php $metode = strtolower($lap->metode_bayar ?? 'tunai'); @endphp
                        @if($metode == 'transfer')
                            <span class="badge badge-transfer px-2 py-1">Transfer</span>
                        @elseif($metode == 'ewallet')
                            <span class="badge badge-ewallet px-2 py-1">E-Wallet</span>
                        @elseif($metode == 'dana')
                            <span class="badge badge-dana px-2 py-1">Dana</span>
                        @else
                            <span class="badge badge-tunai px-2 py-1">Tunai</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @php $status = strtolower($lap->status_verifikasi ?? 'pending'); @endphp
                        @if($status == 'valid')
                            <span class="badge badge-valid px-2 py-1 rounded-pill" style="min-width:60px">Lunas</span>
                        @elseif($status == 'pending')
                            <span class="badge badge-pending px-2 py-1 rounded-pill" style="min-width:60px">Pending</span>
                        @else
                            <span class="badge badge-tolak px-2 py-1 rounded-pill" style="min-width:60px">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        <span class="text-white">{{ $lap->petugas->name ?? '-' }}</span>
                    </td>
                    <td class="text-muted">{{ $lap->no_kwitansi ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center py-5">
                        <h6 class="fw-bold text-white mb-1">Data Tidak Ditemukan</h6>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-between align-items-center non-printable">
        <div class="text-white-50 small">
            Menampilkan {{ $laporans->firstItem() ?? 0 }} - {{ $laporans->lastItem() ?? 0 }} dari {{ $laporans->total() }} data
        </div>
        <div>
            {{ $laporans->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection