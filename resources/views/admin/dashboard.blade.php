@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<style>
    /* ===== CSS PENYALAMAT: Membuat Tampilan Kartu Berwarna & Tulisan Terbaca Jelas ===== */
    .stat-card {
        background-color: #1a233a !important; 
        border: 1px solid #2d4a8a !important;
        border-radius: 12px;
        padding: 1.25rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.25);
    }
    /* Memaksa sub-tulisan kecil di bawah angka statistik berwarna abu-abu terang benderang */
    .text-light-muted {
        color: #94a3b8 !important;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .custom-dashboard-card {
        background-color: #1a233a !important;
        border: 1px solid #2d4a8a !important;
        border-radius: 12px;
    }
    /* Mengubah warna font teks th tabel agar menyala premium */
    .table-custom-thead th {
        color: #60a5fa !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #2d4a8a !important;
    }
</style>

{{-- Statistik Atas --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(59,130,246,0.15); padding:14px; border-radius:12px">
                    <i class="bi bi-people-fill text-primary fs-3"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-white mb-0" style="line-height: 1.1;">{{ $totalSiswa }}</div>
                    <div class="text-light-muted">Total Siswa Aktif</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(34,197,94,0.15); padding:14px; border-radius:12px">
                    <i class="bi bi-check-circle-fill text-success fs-3"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-white mb-0" style="line-height: 1.1;">{{ $totalLunas }}</div>
                    <div class="text-light-muted">Tagihan Lunas</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(234,179,8,0.15); padding:14px; border-radius:12px">
                    <i class="bi bi-clock-fill text-warning fs-3"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-white mb-0" style="line-height: 1.1;">{{ $totalMenunggu }}</div>
                    <div class="text-light-muted">Menunggu Verifikasi</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(239,68,68,0.15); padding:14px; border-radius:12px">
                    <i class="bi bi-x-circle-fill text-danger fs-3"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-white mb-0" style="line-height: 1.1;">{{ $totalBelumBayar }}</div>
                    <div class="text-light-muted">Belum Bayar</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Pemasukan Nominal Keuangan --}}
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="stat-card" style="border-left: 4px solid #3b82f6 !important;">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(59,130,246,0.15); padding:14px; border-radius:12px">
                    <i class="bi bi-cash-coin text-primary fs-3"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-white mb-1">Rp {{ number_format($pemasukanHariIni, 0, ',', '.') }}</div>
                    <div class="text-light-muted text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">Pemasukan Hari Ini</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stat-card" style="border-left: 4px solid #6366f1 !important;">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(99,102,241,0.15); padding:14px; border-radius:12px">
                    <i class="bi bi-graph-up-arrow text-info fs-3"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-white mb-1">Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</div>
                    <div class="text-light-muted text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">Pemasukan Bulan Ini</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Grafik & Tabel Transaksi Pending --}}
<div class="row g-3 mb-4">
    {{-- Grafik Batang Pemasukan --}}
    <div class="col-md-8">
        <div class="card p-4 custom-dashboard-card h-100">
            <h6 class="fw-bold text-white mb-4"><i class="bi bi-bar-chart-fill text-primary me-2"></i>Grafik Rekapitulasi Pemasukan SPP {{ date('Y') }}</h6>
            <div style="position: relative; width: 100%; height: 100%;">
                <canvas id="grafikSPP" height="135"></canvas>
            </div>
        </div>
    </div>

    {{-- Daftar Menunggu Verifikasi --}}
    <div class="col-md-4">
        <div class="card p-4 custom-dashboard-card h-100">
            <h6 class="fw-bold text-white mb-4"><i class="bi bi-clock-fill text-warning me-2"></i>Menunggu Verifikasi</h6>
            <div style="max-height: 230px; overflow-y: auto; padding-right: 2px;">
                @forelse($menungguVerifikasi ?? [] as $bayar)
                <div class="d-flex align-items-center gap-3 mb-2 p-2 rounded-3" style="background:#131926; border: 1px solid #2d3748;">
                    <div style="background:rgba(234,179,8,0.12); padding:8px; border-radius:10px">
                        <i class="bi bi-person-fill text-warning" style="font-size:15px"></i>
                    </div>
                    <div style="flex:1; min-width:0">
                        <div class="text-white fw-bold" style="font-size:13px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis">
                            {{ $bayar->tagihan->siswa->nama ?? ($bayar->siswa->nama ?? '-') }}
                        </div>
                        <div class="fw-bold text-warning small mt-1" style="font-size:11px">
                            Rp {{ number_format($bayar->jumlah_bayar ?? $bayar->nominal, 0, ',', '.') }}
                        </div>
                    </div>
                    <span class="badge bg-warning text-dark fw-bold" style="font-size:10px; padding: 4px 8px;">Pending</span>
                </div>
                @empty
                <div class="text-center text-light-muted py-5">
                    <i class="bi bi-check-circle-fill text-success d-block mb-2" style="font-size: 2.5rem;"></i>
                    <span class="d-block fw-semibold">Semua data aman!</span>
                    <small class="text-muted" style="font-size: 11px;">Tidak ada transaksi tertunda.</small>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Tabel Siswa Nunggak --}}
<div class="card p-4 custom-dashboard-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold text-white mb-0"><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>Daftar Siswa Belum Bayar Bulan Ini</h6>
        
        <a href="{{ route('admin.siswa.index', ['status' => 'Belum Bayar']) }}" 
           class="btn btn-sm btn-outline-primary px-3 fw-semibold" 
           style="font-size:12px; border-radius: 6px;">
           Lihat Semua
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0" style="font-size:13px; background-color: transparent !important;">
            <thead class="table-custom-thead">
                <tr>
                    <th style="padding: 12px 8px;">NIS</th>
                    <th style="padding: 12px 8px;">Nama Siswa</th>
                    <th style="padding: 12px 8px;">Kelas</th>
                    <th style="padding: 12px 8px;">Nominal Tagihan</th>
                    <th class="text-center" style="padding: 12px 8px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswaNunggak ?? [] as $tagihan)
                <tr style="border-color:#2d4a8a !important; vertical-align: middle;">
                    <td style="color: #94a3b8; padding: 12px 8px;">{{ $tagihan->siswa->nis ?? '-' }}</td>
                    <td class="text-white fw-bold" style="padding: 12px 8px;">{{ $tagihan->siswa->nama ?? '-' }}</td>
                    <td style="color: #94a3b8; padding: 12px 8px;">
                        {{ $tagihan->siswa->kelas->tingkat ?? '' }}
                        {{ $tagihan->siswa->kelas->jurusan ?? '' }}
                        {{ $tagihan->siswa->kelas->nomor_kelas ?? '' }}
                    </td>
                    <td class="text-white fw-bold" style="padding: 12px 8px;">Rp {{ number_format($tagihan->nominal_bayar ?? $tagihan->nominal ?? 0, 0, ',', '.') }}</td>
                    <td class="text-center" style="padding: 12px 8px;"><span class="badge bg-danger px-2 py-1 fw-bold" style="font-size:11px; border-radius: 5px;">Belum Bayar</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-light-muted py-4">
                        <i class="bi bi-emoji-smile text-success d-block mb-1" style="font-size: 2rem;"></i>
                        <span class="fw-bold text-white">Luar Biasa! Semua siswa sudah melunasi SPP bulan ini.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('grafikSPP').getContext('2d');
    
    // Trik Gradasi Biru Neon Premium bawaan Chart.js
    const gradient = ctx.createLinearGradient(0, 0, 0, 200);
    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.8)');
    gradient.addColorStop(1, 'rgba(30, 58, 138, 0.2)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                label: 'Pemasukan Terverifikasi (Rp)',
                data: {!! json_encode($grafikBulanan ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!},
                backgroundColor: gradient,
                borderColor: '#60a5fa',
                borderWidth: 2,
                borderRadius: 5,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { labels: { color: '#e2e8f0', font: { size: 11, weight: '600' } } }
            },
            scales: {
                x: { 
                    ticks: { color: '#94a3b8', font: { size: 11 } }, 
                    grid: { color: '#232d45', drawOnChartArea: true } 
                },
                y: { 
                    ticks: { 
                        color: '#94a3b8',
                        font: { size: 11 },
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value / 1000000) + 'jt';
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }, 
                    grid: { color: '#232d45', drawOnChartArea: true } 
                }
            }
        }
    });
});
</script>
@endsection