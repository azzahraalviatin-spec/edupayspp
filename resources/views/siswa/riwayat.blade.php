@extends('layouts.siswa')
@section('title', 'Riwayat Bayar')
@section('content')

<div class="card p-3 mb-3">
    <h6 class="fw-bold text-white mb-3"><i class="bi bi-funnel me-2" style="color:#A9CBE0"></i>Filter Riwayat</h6>
    <form method="GET" action="{{ route('siswa.riwayat') }}">
        <div class="row g-2">
            <div class="col-md-4">
                <label class="text-white-50 small mb-1">Bulan</label>
                <select name="bulan" class="form-select form-select-sm" style="background:#0f172a;border:1px solid #225688;color:#fff;">
                    <option value="">-- Semua Bulan --</option>
                    @foreach($bulanList as $angka => $nama)
                        <option value="{{ $angka }}" {{ request('bulan') == $angka ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="text-white-50 small mb-1">Tahun Ajaran</label>
                <select name="tahun_ajaran" class="form-select form-select-sm" style="background:#0f172a;border:1px solid #225688;color:#fff;">
                    <option value="">-- Semua Tahun --</option>
                    @foreach($tahunAjaranList as $ta)
                        <option value="{{ $ta->id }}" {{ request('tahun_ajaran') == $ta->id ? 'selected' : '' }}>{{ $ta->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
                <a href="{{ route('siswa.riwayat') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

@if($adaFilter)
<div class="card p-3 mb-3" style="border-left: 3px solid #3b82f6;">
    <div class="d-flex align-items-center gap-3">
        <i class="bi bi-calculator text-primary fs-4"></i>
        <div>
            <div class="fw-bold text-white">Rp {{ number_format($totalFilter, 0, ',', '.') }}</div>
            <div class="text-white-50 small">Total Pembayaran Sesuai Filter</div>
        </div>
    </div>
</div>
@endif

<div class="card p-3">
    <h6 class="fw-bold text-white mb-3"><i class="bi bi-clock-history me-2" style="color:#A9CBE0"></i>Riwayat Pembayaran</h6>
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0" style="font-size:13px">
            <thead>
                <tr style="border-color:#225688;background:#092C56">
                    <th style="color:#A9CBE0;font-weight:500;padding:10px 12px">No</th>
                    <th style="color:#A9CBE0;font-weight:500;padding:10px 12px">Bulan</th>
                    <th style="color:#A9CBE0;font-weight:500;padding:10px 12px">Tahun Ajaran</th>
                    <th style="color:#A9CBE0;font-weight:500;padding:10px 12px">Jumlah Bayar</th>
                    <th style="color:#A9CBE0;font-weight:500;padding:10px 12px">No Kwitansi</th>
                    <th style="color:#A9CBE0;font-weight:500;padding:10px 12px">Tgl Bayar</th>
                    <th style="color:#A9CBE0;font-weight:500;padding:10px 12px">Metode</th>
                    <th style="color:#A9CBE0;font-weight:500;padding:10px 12px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $r)
                <tr style="border-color:#1a3a5c">
                    <td style="color:#668CA9;padding:10px 12px;vertical-align:middle">{{ $loop->iteration }}</td>
                    <td style="color:#e2e8f0;padding:10px 12px;vertical-align:middle;font-weight:500">{{ $bulanList[$r->bulan] }}</td>
                    <td style="color:#94a3b8;padding:10px 12px;vertical-align:middle">{{ $r->tahunAjaran->nama ?? '-' }}</td>
                    <td style="color:#e2e8f0;padding:10px 12px;vertical-align:middle;font-weight:600">Rp {{ number_format($r->nominal_bayar, 0, ',', '.') }}</td>
                    <td style="color:#A9CBE0;padding:10px 12px;vertical-align:middle">{{ $r->pembayaran->no_kwitansi ?? '-' }}</td>
                    <td style="color:#94a3b8;padding:10px 12px;vertical-align:middle">{{ $r->pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($r->pembayaran->tanggal_bayar)->format('d M Y') : '-' }}</td>
                    <td style="padding:10px 12px;vertical-align:middle">
                        @if($r->pembayaran && $r->pembayaran->metode_bayar == 'tunai')
                        <span class="badge bg-success" style="font-size:11px">Tunai</span>
                        @else
                        <span class="badge" style="font-size:11px;background:#225688;color:#A9CBE0">Transfer</span>
                        @endif
                    </td>
                    <td style="padding:10px 12px;vertical-align:middle">
                        <a href="{{ route('siswa.tagihan.kwitansi', $r) }}" class="btn btn-sm btn-outline-success" style="font-size:11px">
                            <i class="bi bi-download me-1"></i>Kwitansi
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4" style="color:#668CA9">Belum ada riwayat pembayaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">{{ $riwayat->links() }}</div>
    </div>
</div>

@endsection