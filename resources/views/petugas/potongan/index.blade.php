@extends('layouts.petugas')
@section('title', 'Potongan SPP')
@section('content')

<style>
    .main-card {
        background: #172036;
        border: 1px solid #2d4a8a;
        border-radius: 16px;
        padding: 24px;
    }
    .summary-card {
        background:#131c31;
        border:1px solid #2d4a8a;
        border-radius:14px;
        padding:18px 22px;
    }
    .summary-label {
        color:#64748b; font-size:11px; font-weight:700;
        text-transform:uppercase; letter-spacing:1px;
        margin-bottom:6px;
    }
    .summary-value {
        font-size:22px; font-weight:900; color:#fff;
    }
    .btn-pemerintah {
        background: linear-gradient(135deg,#0ea5e9,#0284c7);
        border: none; color: #fff; font-size: 13px; font-weight: 700;
        padding: 10px 18px; border-radius: 10px;
        display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none; transition: .2s;
    }
    .btn-pemerintah:hover { transform:translateY(-2px); box-shadow:0 6px 18px rgba(14,165,233,.4); color:#fff; }
    .btn-lomba {
        background: linear-gradient(135deg,#f59e0b,#d97706);
        border: none; color: #fff; font-size: 13px; font-weight: 700;
        padding: 10px 18px; border-radius: 10px;
        display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none; transition: .2s;
    }
    .btn-lomba:hover { transform:translateY(-2px); box-shadow:0 6px 18px rgba(245,158,11,.4); color:#fff; }

    .filter-tabs {
        display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap;
    }
    .filter-tab {
        padding: 8px 18px; border-radius: 20px; font-size: 12px; font-weight: 700;
        cursor: pointer; border: 1.5px solid transparent; transition: all .2s;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .filter-tab.all        { border-color:#334155; color:#94a3b8; background:rgba(51,65,85,.3); }
    .filter-tab.pemerintah { border-color:#0ea5e9; color:#38bdf8; background:rgba(14,165,233,.1); }
    .filter-tab.prestasi   { border-color:#f59e0b; color:#fbbf24; background:rgba(245,158,11,.1); }
    .filter-tab.active.all        { background:#334155; color:#fff; }
    .filter-tab.active.pemerintah { background:rgba(14,165,233,.25); color:#fff; }
    .filter-tab.active.prestasi   { background:rgba(245,158,11,.25); color:#fff; }

    .table-custom thead th {
        color:#60a5fa !important; background:#131c31 !important;
        border-bottom:2px solid #2d4a8a !important;
        font-size:11px; text-transform:uppercase; letter-spacing:.5px; padding:13px 12px;
    }
    .table-custom tbody tr { border-color:#1e3a6e !important; }
    .table-custom tbody tr:hover { background:rgba(59,130,246,.05); }
    .table-custom td { padding:13px 12px; vertical-align:middle; }
    .badge-pemerintah {
        background:rgba(14,165,233,.15); color:#38bdf8;
        font-size:11px; padding:5px 10px; border-radius:20px; font-weight:700;
        display:inline-flex; align-items:center; gap:4px;
    }
    .badge-lomba {
        background:rgba(245,158,11,.15); color:#fbbf24;
        font-size:11px; padding:5px 10px; border-radius:20px; font-weight:700;
        display:inline-flex; align-items:center; gap:4px;
    }
    .text-soft { color:#64748b; }
    .btn-aksi {
        font-size:11px; font-weight:700; padding:6px 12px;
        border-radius:8px; border:none; display:inline-flex;
        align-items:center; gap:4px; text-decoration:none; transition:.2s;
    }
    .btn-detail { background:rgba(59,130,246,.15); color:#93c5fd; }
    .btn-detail:hover { background:rgba(59,130,246,.3); color:#fff; }
    .btn-edit { background:rgba(245,158,11,.15); color:#fbbf24; }
    .btn-edit:hover { background:rgba(245,158,11,.3); color:#fff; }
    .btn-hapus { background:rgba(220,38,38,.15); color:#fca5a5; }
    .btn-hapus:hover { background:rgba(220,38,38,.3); color:#fff; }
    .notif-success {
        background:rgba(16,185,129,.15); border:1px solid #10b981; color:#6ee7b7;
        border-radius:12px; padding:13px 18px; margin-bottom:20px;
        display:flex; align-items:center; gap:10px; font-weight:600; font-size:13px;
    }
    .notif-error {
        background:rgba(220,38,38,.15); border:1px solid #dc2626; color:#fca5a5;
        border-radius:12px; padding:13px 18px; margin-bottom:20px;
        display:flex; align-items:center; gap:10px; font-weight:600; font-size:13px;
    }
    .periode-text { font-size:12px; font-weight:700; color:#e2e8f0; }
    .periode-sub  { font-size:10px; color:#64748b; margin-top:2px; }
    .count-badge {
        background:rgba(99,102,241,.2); border:1px solid rgba(99,102,241,.4);
        color:#a5b4fc; border-radius:10px; font-size:11px; font-weight:700;
        padding:2px 8px; margin-left:6px;
    }
</style>

@php
$bulanFull = [
    1=>'Januari', 2=>'Februari', 3=>'Maret',    4=>'April',
    5=>'Mei',     6=>'Juni',     7=>'Juli',      8=>'Agustus',
    9=>'September',10=>'Oktober',11=>'November', 12=>'Desember'
];
@endphp

@if(session('success'))
<div class="notif-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="notif-error"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>
@endif

{{-- RINGKASAN --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="summary-card">
            <div class="summary-label"><i class="bi bi-people-fill me-1"></i> Siswa Dapat Potongan</div>
            <div class="summary-value text-warning">{{ $totalSiswaDapatPotongan }} Siswa</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="summary-card">
            <div class="summary-label"><i class="bi bi-scissors me-1"></i> Total Potongan/Bulan</div>
            <div class="summary-value" style="color:#4ade80;">
                Rp {{ number_format($totalPotonganPerBulan, 0, ',', '.') }}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="summary-card">
            <div class="summary-label"><i class="bi bi-building-fill me-1"></i> Potongan Pemerintah</div>
            <div class="summary-value" style="color:#38bdf8;">
                Rp {{ number_format($totalPemerintah, 0, ',', '.') }}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="summary-card">
            <div class="summary-label"><i class="bi bi-trophy-fill me-1"></i> Potongan Prestasi</div>
            <div class="summary-value" style="color:#fbbf24;">
                Rp {{ number_format($totalPrestasi, 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>

<div class="main-card">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h5 class="fw-bold text-white mb-0">
            <i class="bi bi-scissors text-warning me-2"></i>
            Daftar Potongan SPP Siswa
        </h5>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('petugas.potongan.tambah', 'pemerintah') }}" class="btn-pemerintah">
                <i class="bi bi-building-fill"></i> Tambah Potongan Pemerintah
            </a>
            <a href="{{ route('petugas.potongan.tambah', 'prestasi') }}" class="btn-lomba">
                <i class="bi bi-trophy-fill"></i> Tambah Potongan Lomba
            </a>
        </div>
    </div>

    @php
        $rows = $siswas->flatMap(fn($s) =>
            $s->potonganSpps->map(fn($p) => (object)[
                'siswa'    => $s,
                'potongan' => $p,
            ])
        );
        $countAll        = $rows->count();
        $countPemerintah = $rows->where('potongan.jenis', 'pemerintah')->count();
        $countPrestasi   = $rows->where('potongan.jenis', 'prestasi')->count();
    @endphp

    <div class="filter-tabs">
        <button class="filter-tab all active" onclick="filterTable('semua', this)">
            <i class="bi bi-grid-fill"></i> Semua Potongan
            <span class="count-badge">{{ $countAll }}</span>
        </button>
        <button class="filter-tab pemerintah" onclick="filterTable('pemerintah', this)">
            <i class="bi bi-building-fill"></i> Bantuan Pemerintah
            <span class="count-badge">{{ $countPemerintah }}</span>
        </button>
        <button class="filter-tab prestasi" onclick="filterTable('prestasi', this)">
            <i class="bi bi-trophy-fill"></i> Beasiswa / Prestasi
            <span class="count-badge">{{ $countPrestasi }}</span>
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0 table-custom" id="tabelPotongan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Jenis</th>
                    <th>Nama Potongan</th>
                    <th>Nominal/Bulan</th>
                    <th>Berlaku</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $i => $row)
                @php
                    $pivot   = $row->potongan->pivot;
                    $jenis   = $row->potongan->jenis;
                    // Ambil bulan+tahun dari pivot (bukan tanggal lagi)
                    $bMulai   = $bulanFull[$pivot->bulan_mulai]   ?? '-';
                    $bSelesai = $bulanFull[$pivot->bulan_selesai] ?? '-';
                    $tMulai   = $pivot->tahun_mulai;
                    $tSelesai = $pivot->tahun_selesai;
                @endphp
                <tr data-jenis="{{ $jenis }}">
                    <td class="text-soft row-number">{{ $i + 1 }}</td>
                    <td>
                        <div class="text-white fw-bold">{{ $row->siswa->nama }}</div>
                        <div style="color:#fbbf24; font-size:11px;">{{ $row->siswa->nis }}</div>
                    </td>
                    <td class="text-soft">
                        {{ $row->siswa->kelas->tingkat ?? '' }}
                        {{ $row->siswa->kelas->jurusan ?? '' }}
                        {{ $row->siswa->kelas->nomor_kelas ?? '' }}
                    </td>
                    <td>
                        @if($jenis == 'prestasi')
                            <span class="badge-lomba"><i class="bi bi-trophy-fill"></i> Prestasi</span>
                        @else
                            <span class="badge-pemerintah"><i class="bi bi-building-fill"></i> Pemerintah</span>
                        @endif
                    </td>
                    <td class="text-white">{{ $row->potongan->nama }}</td>
                    <td class="fw-bold" style="color:#4ade80;">
                        -Rp {{ number_format($row->potongan->nominal_potongan, 0, ',', '.') }}
                    </td>
                <td>
    @if($jenis == 'pemerintah')
    <div class="periode-text">{{ $bMulai }} {{ $tMulai }}</div>
    @else
    <div class="periode-text">
        {{ $bMulai }} {{ $tMulai }}
        <span style="color:#475569"> → </span>
        {{ $bSelesai }} {{ $tSelesai }}
    </div>
    @endif
</td>
                    <td>
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('petugas.potongan.detail', [$row->siswa->id, $row->potongan->id]) }}"
                               class="btn-aksi btn-detail">
                                <i class="bi bi-eye-fill"></i> Detail
                            </a>
                            <a href="{{ route('petugas.potongan.edit', [$row->siswa->id, $row->potongan->id]) }}"
                               class="btn-aksi btn-edit">
                                <i class="bi bi-pencil-fill"></i> Edit
                            </a>
                            <form action="{{ route('petugas.potongan.hapus', [$row->siswa->id, $row->potongan->id]) }}"
                                  method="POST" style="display:inline"
                                  onsubmit="return confirm('Hapus potongan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-aksi btn-hapus">
                                    <i class="bi bi-trash-fill"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr id="emptyRow">
                    <td colspan="8" class="text-center py-5">
                        <i class="bi bi-scissors d-block mb-2 text-warning" style="font-size:3rem"></i>
                        <div class="fw-bold text-white mb-1">Belum Ada Potongan</div>
                        <small class="text-soft">Klik tombol di atas untuk menambahkan potongan</small>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
function filterTable(jenis, el) {
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');

    const rows = document.querySelectorAll('#tabelPotongan tbody tr[data-jenis]');
    let visibleCount = 0;

    rows.forEach(row => {
        if (jenis === 'semua' || row.dataset.jenis === jenis) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    let no = 1;
    rows.forEach(row => {
        if (row.style.display !== 'none') {
            row.querySelector('.row-number').textContent = no++;
        }
    });

    const emptyRow = document.getElementById('emptyRow');
    if (emptyRow) emptyRow.style.display = visibleCount === 0 ? '' : 'none';
}
</script>

@endsection