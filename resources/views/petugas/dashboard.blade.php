@extends('layouts.petugas')

@section('title', 'Dashboard')

@section('content')

<style>
    body{
        background:#0b1120 !important;
    }

    /* ===== CARD PREMIUM ===== */
    .stat-card{
        background:#18223b !important;
        border:1px solid #2d4a8a !important;
        border-radius:18px;
        padding:22px;
        transition:0.25s ease;
        box-shadow:0 4px 20px rgba(0,0,0,0.25);
    }

    .stat-card:hover{
        transform:translateY(-3px);
        box-shadow:0 10px 25px rgba(37,99,235,0.25);
    }

    /* ===== CARD BIASA ===== */
    .dashboard-card{
        background:#18223b !important;
        border:1px solid #2d4a8a !important;
        border-radius:18px;
        box-shadow:0 4px 20px rgba(0,0,0,0.25);
    }

    /* ===== TEXT ===== */
    .text-soft{
        color:#94a3b8 !important;
    }

    .title-card{
        color:white;
        font-weight:700;
        font-size:16px;
    }

    /* ===== MENU CEPAT ===== */
    .quick-menu{
        background:#0f172a;
        border:1px solid #334155;
        border-radius:14px;
        transition:0.25s;
    }

    .quick-menu:hover{
        transform:translateY(-3px);
        border-color:#3b82f6;
        box-shadow:0 8px 25px rgba(59,130,246,0.20);
    }

    /* ===== ITEM LIST ===== */
    .list-item{
        background:#0f172a;
        border:1px solid #1e293b;
        border-radius:12px;
        transition:0.2s;
    }

    .list-item:hover{
        border-color:#3b82f6;
        background:#111c31;
    }

    /* ===== SCROLL ===== */
    .custom-scroll{
        max-height:320px;
        overflow-y:auto;
        padding-right:3px;
    }

    .custom-scroll::-webkit-scrollbar{
        width:6px;
    }

    .custom-scroll::-webkit-scrollbar-thumb{
        background:#334155;
        border-radius:10px;
    }

    /* ===== BADGE ===== */
    .badge-premium{
        padding:5px 10px;
        border-radius:8px;
        font-size:11px;
        font-weight:700;
    }
    /* SCROLL PREMIUM */
div::-webkit-scrollbar{
    width:6px;
}

div::-webkit-scrollbar-thumb{
    background:#334155;
    border-radius:10px;
}

div::-webkit-scrollbar-track{
    background:transparent;
}
</style>

{{-- ================= STATISTIK ================= --}}
<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="stat-card h-100">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(234,179,8,0.15);padding:16px;border-radius:14px">
                    <i class="bi bi-clock-fill text-warning fs-3"></i>
                </div>

                <div>
                    <div class="fs-2 fw-bold text-white">
                        {{ $totalMenunggu }}
                    </div>

                    <div class="text-soft fw-semibold">
                        Menunggu Verifikasi
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card h-100">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(34,197,94,0.15);padding:16px;border-radius:14px">
                    <i class="bi bi-check-circle-fill text-success fs-3"></i>
                </div>

                <div>
                    <div class="fs-2 fw-bold text-white">
                        {{ $totalLunas }}
                    </div>

                    <div class="text-soft fw-semibold">
                        Tagihan Lunas
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card h-100">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(239,68,68,0.15);padding:16px;border-radius:14px">
                    <i class="bi bi-x-circle-fill text-danger fs-3"></i>
                </div>

                <div>
                    <div class="fs-2 fw-bold text-white">
                        {{ $totalBelumBayar }}
                    </div>

                    <div class="text-soft fw-semibold">
                        Belum Bayar
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card h-100">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(59,130,246,0.15);padding:16px;border-radius:14px">
                    <i class="bi bi-cash-coin text-primary fs-3"></i>
                </div>

                <div>
                    <div class="fs-5 fw-bold text-white">
                        Rp {{ number_format($pemasukanHariIni, 0, ',', '.') }}
                    </div>

                    <div class="text-soft fw-semibold">
                        Pemasukan Hari Ini
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ================= PEMASUKAN BULAN INI ================= --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div style="background:rgba(99,102,241,0.15);padding:16px;border-radius:14px">
                    <i class="bi bi-graph-up-arrow text-info fs-3"></i>
                </div>

                <div>
                    <div class="fs-3 fw-bold text-white">
                        Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}
                    </div>

                    <div class="text-soft fw-semibold text-uppercase" style="font-size:12px">
                        Total Pemasukan Bulan Ini
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



{{-- ================= LIST DATA ================= --}}
<div class="row g-4">

    {{-- MENUNGGU VERIFIKASI --}}
    <div class="col-md-6">

        <div class="dashboard-card p-4 h-100">

            <h5 class="title-card mb-4">
                <i class="bi bi-clock-fill text-warning me-2"></i>
                Menunggu Verifikasi
            </h5>

          <div style="max-height: 420px; overflow-y: auto; padding-right: 4px;">

                @forelse($menungguVerifikasi as $bayar)

                <div class="list-item d-flex align-items-center gap-3 p-3 mb-3">

                    <div style="background:rgba(234,179,8,0.15);padding:10px;border-radius:10px">
                        <i class="bi bi-person-fill text-warning"></i>
                    </div>

                    <div style="flex:1; min-width:0">

                        <div class="fw-bold text-white text-truncate">
                            {{ $bayar->tagihan->siswa->nama ?? '-' }}
                        </div>

                        <div class="text-soft small mt-1">
                            Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}
                        </div>

                    </div>

                    <a href="{{ route('petugas.verifikasi.index') }}"
                        class="btn btn-sm btn-warning fw-bold px-3">
                        Cek
                    </a>

                </div>

                @empty

                <div class="text-center py-5">

                    <i class="bi bi-check-circle-fill text-success"
                        style="font-size:55px"></i>

                    <div class="text-white fw-bold mt-3">
                        Semua Sudah Diverifikasi
                    </div>

                    <div class="text-soft small">
                        Tidak ada transaksi pending.
                    </div>

                </div>

                @endforelse

            </div>

        </div>

    </div>

    {{-- SISWA NUNGGAK --}}
    <div class="col-md-6">

        <div class="dashboard-card p-4 h-100">

            <h5 class="title-card mb-4">
                <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                Siswa Belum Bayar
            </h5>
<div style="max-height: 420px; overflow-y: auto; padding-right: 4px;">  

                @forelse($siswaNunggak as $tagihan)

                <div class="list-item d-flex align-items-center gap-3 p-3 mb-3">

                    <div style="background:rgba(239,68,68,0.15);padding:10px;border-radius:10px">
                        <i class="bi bi-person-fill text-danger"></i>
                    </div>

                    <div style="flex:1; min-width:0">

                        <div class="fw-bold text-white text-truncate">
                            {{ $tagihan->siswa->nama ?? '-' }}
                        </div>

                        <div class="text-soft small mt-1">
                            {{ $tagihan->siswa->kelas->tingkat ?? '' }}
                            {{ $tagihan->siswa->kelas->jurusan ?? '' }}
                            |
                            Rp {{ number_format($tagihan->nominal_bayar, 0, ',', '.') }}
                        </div>

                    </div>

                    <span class="badge bg-danger badge-premium">
                        Belum
                    </span>

                </div>

                @empty

                <div class="text-center py-5">

                    <i class="bi bi-emoji-smile-fill text-success"
                        style="font-size:55px"></i>

                    <div class="text-white fw-bold mt-3">
                        Semua Siswa Sudah Bayar
                    </div>

                    <div class="text-soft small">
                        Tidak ada tunggakan bulan ini.
                    </div>

                </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection