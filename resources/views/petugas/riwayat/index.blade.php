{{-- ========================= --}}
{{-- RIWAYAT TRANSAKSI PREMIUM --}}
{{-- ========================= --}}

@extends('layouts.petugas')

@section('title', 'Riwayat Transaksi')

@section('content')

<style>
    body{ background:#081028 !important; }
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
    .table-dark{ --bs-table-bg: transparent !important; }
    .table-dark tbody tr{ border-color:#263552 !important; }
    .table-dark tbody tr:hover{ background:rgba(59,130,246,.08) !important; }
    .table-dark td{ padding:14px 10px; }
    .custom-thead th{
        color:#60a5fa !important;
        font-size:11px;
        text-transform:uppercase;
        letter-spacing:.5px;
        border-bottom:2px solid #2d4a8a !important;
        padding:14px 10px;
    }
    .text-light-muted{ color:#94a3b8 !important; }
    .bukti-thumb{
        width:60px;
        height:60px;
        object-fit:cover;
        border-radius:8px;
        border:2px solid #2d4a8a;
        cursor:pointer;
        transition:.2s;
    }
    .bukti-thumb:hover{
        border-color:#3b82f6;
        transform:scale(1.05);
    }
    .no-bukti{
        width:60px;
        height:60px;
        border-radius:8px;
        border:2px dashed #2d4a8a;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#475569;
        font-size:10px;
        text-align:center;
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
                    <div class="fs-4 fw-bold text-white">Rp {{ number_format($totalHariIni, 0, ',', '.') }}</div>
                    <div class="text-light-muted small">Pemasukan Hari Ini</div>
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
                    <div class="fs-4 fw-bold text-white">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</div>
                    <div class="text-light-muted small">Pemasukan Bulan Ini</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- FORM FILTER --}}
<div class="premium-card p-4 mb-4">
    <h6 class="fw-bold text-white mb-3"><i class="bi bi-funnel text-primary me-2"></i>Filter Riwayat</h6>
    <form method="GET" action="{{ route('petugas.riwayat') }}">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="text-light-muted small mb-1">Dari Tanggal</label>
                <input type="date" name="dari" value="{{ request('dari') }}"
                    class="form-control" style="background:#0f172a;border:1px solid #2d4a8a;color:#fff;">
            </div>
            <div class="col-md-3">
                <label class="text-light-muted small mb-1">Sampai Tanggal</label>
                <input type="date" name="sampai" value="{{ request('sampai') }}"
                    class="form-control" style="background:#0f172a;border:1px solid #2d4a8a;color:#fff;">
            </div>
            <div class="col-md-2">
                <label class="text-light-muted small mb-1">Bulan</label>
                <select name="bulan" class="form-select" style="background:#0f172a;border:1px solid #2d4a8a;color:#fff;">
                    <option value="">Semua</option>
                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $b)
                        <option value="{{ $i+1 }}" {{ request('bulan') == $i+1 ? 'selected' : '' }}>{{ $b }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="text-light-muted small mb-1">Tahun</label>
                <select name="tahun" class="form-select" style="background:#0f172a;border:1px solid #2d4a8a;color:#fff;">
                    <option value="">Semua</option>
                    @foreach(range(2023, 2040) as $t)
                        <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary fw-bold flex-grow-1">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
                <a href="{{ route('petugas.riwayat') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

@if($adaFilter)
<div class="stat-card mb-4" style="border-left: 4px solid #3b82f6 !important;">
    <div class="d-flex align-items-center gap-3">
        <div style="background:rgba(59,130,246,.15);padding:14px;border-radius:12px">
            <i class="bi bi-calculator text-primary fs-3"></i>
        </div>
        <div>
            <div class="fs-4 fw-bold text-white">Rp {{ number_format($totalFilter, 0, ',', '.') }}</div>
            <div class="text-light-muted small">Total Pemasukan Sesuai Filter</div>
        </div>
    </div>
</div>
@endif

<div class="premium-card p-4">
    <h5 class="fw-bold text-white mb-4">
        <i class="bi bi-clock-history text-info me-2"></i>Riwayat Transaksi
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
                    <th>Bukti Transfer</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $r)
                <tr>
                    <td class="text-light-muted">{{ $loop->iteration }}</td>
                    <td class="text-info fw-bold">{{ $r->no_kwitansi ?? '-' }}</td>
                    <td class="text-white fw-semibold">{{ $r->tagihan->siswa->nama ?? '-' }}</td>
                    <td class="text-light-muted">
                        {{ $r->tagihan->siswa->kelas->tingkat ?? '' }}
                        {{ $r->tagihan->siswa->kelas->jurusan ?? '' }}
                    </td>
                    <td class="text-light-muted">
                        {{ \Carbon\Carbon::create()->month($r->tagihan->bulan)->translatedFormat('F') }}
                    </td>
                    <td class="text-white fw-bold">Rp {{ number_format($r->jumlah_bayar, 0, ',', '.') }}</td>
                    <td class="text-light-muted">
                        {{ $r->tanggal_bayar ? \Carbon\Carbon::parse($r->tanggal_bayar)->translatedFormat('d M Y') : '-' }}
                    </td>
                    <td class="text-light-muted">{{ $r->petugas->name ?? '-' }}</td>
                    <td>
                        @if($r->bukti_transfer)
                            <img src="{{ asset('storage/' . $r->bukti_transfer) }}"
                                 class="bukti-thumb"
                                 alt="Bukti Transfer"
                                 data-bs-toggle="modal"
                                 data-bs-target="#modalBukti"
                                 data-src="{{ asset('storage/' . $r->bukti_transfer) }}"
                                 onclick="document.getElementById('modalBuktiImg').src=this.dataset.src">
                        @else
                            <div class="no-bukti">Tidak ada</div>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-success px-3 py-2">Lunas</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('petugas.struk', $r->id) }}"
                           target="_blank"
                           style="background:linear-gradient(135deg,#3b82f6,#2563eb);
                                  color:white;font-size:12px;font-weight:600;
                                  padding:7px 14px;border-radius:8px;
                                  text-decoration:none;display:inline-flex;
                                  align-items:center;gap:5px;">
                            <i class="bi bi-printer-fill"></i> Cetak
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center py-5">
                        <i class="bi bi-receipt text-info d-block mb-3" style="font-size:50px"></i>
                        <div class="text-white fw-bold mb-1">Belum Ada Riwayat</div>
                        <small class="text-light-muted">Data transaksi masih kosong.</small>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $riwayat->links() }}</div>
</div>

{{-- MODAL BUKTI TRANSFER --}}
<div class="modal fade" id="modalBukti" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:#172036;border:1px solid #2d4a8a;">
            <div class="modal-header border-0">
                <h6 class="modal-title text-white fw-bold">Bukti Transfer</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalBuktiImg" src="" alt="Bukti Transfer"
                     style="max-width:100%;border-radius:10px;">
            </div>
        </div>
    </div>
</div>

@endsection