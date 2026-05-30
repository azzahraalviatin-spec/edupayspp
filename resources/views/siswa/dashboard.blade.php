@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('content')

<style>
    :root {
        --abyss:   #092C56;
        --lapis:   #225688;
        --slate:   #668CA9;
        --glacier: #A9CBE0;
        --quartz:  #F0F5F4;
    }

    .hero-card {
        background: linear-gradient(135deg, var(--abyss) 0%, var(--lapis) 60%, var(--slate) 100%);
        border-radius: 16px;
        border: none;
        position: relative;
        overflow: hidden;
    }
    .hero-card::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 200px; height: 200px;
        background: rgba(169,203,224,0.12);
        border-radius: 50%;
    }
    .hero-card::after {
        content: '';
        position: absolute;
        bottom: -60px; left: 30%;
        width: 280px; height: 280px;
        background: rgba(169,203,224,0.07);
        border-radius: 50%;
    }

    .stat-card {
        border-radius: 14px;
        border: 1.5px solid rgba(169,203,224,0.18);
        background: rgba(9,44,86,0.55);
        backdrop-filter: blur(6px);
        transition: transform .18s, box-shadow .18s;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(9,44,86,0.35) !important;
    }
    .stat-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        margin: 0 auto 10px;
    }

    .content-card {
        border-radius: 14px;
        border: 1.5px solid rgba(169,203,224,0.18);
        background: rgba(9,44,86,0.55);
        backdrop-filter: blur(6px);
    }
    .content-card .card-header {
        background: transparent;
        border-bottom: 1px solid rgba(169,203,224,0.15);
        padding: 1.2rem 1.4rem 0.8rem;
    }

    .tagihan-box {
        border-radius: 10px;
        padding: 1rem 1.1rem;
    }
    .tagihan-box.lunas    { background: rgba(25,135,84,0.15);  border: 1px solid rgba(25,135,84,0.3); }
    .tagihan-box.belum   { background: rgba(220,53,69,0.15);  border: 1px solid rgba(220,53,69,0.3); }
    .tagihan-box.menunggu{ background: rgba(255,193,7,0.12);  border: 1px solid rgba(255,193,7,0.3); }

    .riwayat-item {
        background: rgba(169,203,224,0.07);
        border: 1px solid rgba(169,203,224,0.13);
        border-radius: 10px;
        padding: 0.65rem 0.9rem;
        transition: background .15s;
    }
    .riwayat-item:hover { background: rgba(169,203,224,0.13); }

    .label-text  { color: var(--glacier); font-size: 0.75rem; }
    .value-text  { color: #fff; font-weight: 600; font-size: 0.9rem; }
    .muted-text  { color: var(--slate); font-size: 0.75rem; }
    .section-title { color: var(--glacier); font-weight: 700; font-size: 0.82rem; letter-spacing:.05em; text-transform:uppercase; }
</style>

<div class="container-fluid py-4">

    {{-- HERO GREETING --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="hero-card card shadow">
                <div class="card-body p-4 position-relative" style="z-index:1">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <h4 class="text-white mb-1 fw-bold fs-4">
                                <i class="bi bi-mortarboard-fill me-2" style="color:var(--glacier)"></i>
                                Halo, {{ $siswa->nama ?? Auth::user()->name }}!
                            </h4>
                            <p class="mb-0" style="color:var(--glacier); font-size:.92rem">
                                <i class="bi bi-building me-1"></i>
                                Kelas
                                @if($siswa->kelas && is_object($siswa->kelas))
                                    {{ $siswa->kelas->tingkat ?? '' }}
                                    {{ $siswa->kelas->jurusan ?? '' }}
                                    {{ $siswa->kelas->nomor_kelas ?? '' }}
                                @elseif($siswa->kelas)
                                    {{ $siswa->kelas }}
                                @else
                                    -
                                @endif
                                @if($siswa->nis)
                                    &nbsp;<span style="color:var(--slate)">·</span>&nbsp; NIS: {{ $siswa->nis }}
                                @endif
                            </p>
                        </div>
                        <div class="text-end">
                            <div style="color:var(--glacier); font-size:.85rem">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card card shadow-sm h-100">
                <div class="card-body text-center p-3">
                    <div class="stat-icon" style="background:rgba(34,86,136,0.5)">
                        <i class="bi bi-receipt" style="color:var(--glacier)"></i>
                    </div>
                    <h3 class="fw-bold mb-0" style="color:var(--glacier)">{{ $totalTagihan }}</h3>
                    <div class="muted-text mt-1">Total Tagihan</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card card shadow-sm h-100">
                <div class="card-body text-center p-3">
                    <div class="stat-icon" style="background:rgba(25,135,84,0.2)">
                        <i class="bi bi-check-circle" style="color:#2ecc71"></i>
                    </div>
                    <h3 class="fw-bold mb-0" style="color:#2ecc71">{{ $totalLunas }}</h3>
                    <div class="muted-text mt-1">Lunas</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card card shadow-sm h-100">
                <div class="card-body text-center p-3">
                    <div class="stat-icon" style="background:rgba(220,53,69,0.2)">
                        <i class="bi bi-exclamation-circle" style="color:#e74c3c"></i>
                    </div>
                    <h3 class="fw-bold mb-0" style="color:#e74c3c">{{ $totalBelumBayar }}</h3>
                    <div class="muted-text mt-1">Belum Bayar</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card card shadow-sm h-100">
                <div class="card-body text-center p-3">
                    <div class="stat-icon" style="background:rgba(255,193,7,0.15)">
                        <i class="bi bi-hourglass-split" style="color:#f39c12"></i>
                    </div>
                    <h3 class="fw-bold mb-0" style="color:#f39c12">{{ $totalMenunggu }}</h3>
                    <div class="muted-text mt-1">Menunggu</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- TAGIHAN BULAN INI --}}
        <div class="col-12 col-lg-7">
            <div class="content-card card shadow h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="section-title"><i class="bi bi-calendar-check me-2"></i>Tagihan Bulan Ini</span>
                            <div class="muted-text mt-1">{{ $bulanList[\Carbon\Carbon::now()->month] }} {{ \Carbon\Carbon::now()->year }}</div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($tagihanBulanIni)
                        <div class="tagihan-box {{ $tagihanBulanIni->status == 'lunas' ? 'lunas' : ($tagihanBulanIni->status == 'belum_bayar' ? 'belum' : 'menunggu') }} mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-semibold text-white">SPP {{ $bulanList[$tagihanBulanIni->bulan] }}</span>
                                @if($tagihanBulanIni->status == 'lunas')
                                    <span class="badge px-3 py-2" style="background:rgba(46,204,113,0.2);color:#2ecc71;border:1px solid rgba(46,204,113,0.4)">
                                        <i class="bi bi-check-circle-fill me-1"></i>Lunas
                                    </span>
                                @elseif($tagihanBulanIni->status == 'belum_bayar')
                                    <span class="badge px-3 py-2" style="background:rgba(231,76,60,0.2);color:#e74c3c;border:1px solid rgba(231,76,60,0.4)">
                                        <i class="bi bi-x-circle-fill me-1"></i>Belum Bayar
                                    </span>
                                @else
                                    <span class="badge px-3 py-2" style="background:rgba(243,156,18,0.2);color:#f39c12;border:1px solid rgba(243,156,18,0.4)">
                                        <i class="bi bi-hourglass-fill me-1"></i>Menunggu
                                    </span>
                                @endif
                            </div>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="label-text">Nominal</div>
                                    <div class="value-text">Rp {{ number_format($tagihanBulanIni->nominal ?? 0, 0, ',', '.') }}</div>
                                </div>
                                @if($tagihanBulanIni->tahunAjaran)
                                <div class="col-6">
                                    <div class="label-text">Tahun Ajaran</div>
                                    <div class="value-text">{{ $tagihanBulanIni->tahunAjaran->nama ?? '-' }}</div>
                                </div>
                                @endif
                                @if($tagihanBulanIni->jatuh_tempo)
                                <div class="col-6">
                                    <div class="label-text">Jatuh Tempo</div>
                                    <div class="value-text">{{ \Carbon\Carbon::parse($tagihanBulanIni->jatuh_tempo)->format('d M Y') }}</div>
                                </div>
                                @endif
                                @if($tagihanBulanIni->pembayaran)
                                <div class="col-6">
                                    <div class="label-text">Tgl Bayar</div>
                                    <div class="value-text">{{ \Carbon\Carbon::parse($tagihanBulanIni->pembayaran->tanggal_bayar ?? $tagihanBulanIni->pembayaran->created_at)->format('d M Y') }}</div>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($potonganAktif->isNotEmpty())
                        <div class="mt-3">
                            <div class="label-text mb-2">Potongan Aktif</div>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($potonganAktif as $pot)
                                <span class="badge px-3 py-2" style="background:rgba(169,203,224,0.12);color:var(--glacier);border:1px solid rgba(169,203,224,0.25);font-size:.78rem">
                                    <i class="bi bi-scissors me-1"></i>{{ $pot->nama }}
                                    @if($pot->nilai)
                                        — {{ $pot->tipe == 'persen' ? $pot->nilai.'%' : 'Rp '.number_format($pot->nilai,0,',','.') }}
                                    @endif
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-3" style="color:var(--slate)"></i>
                            <p class="mb-0" style="color:var(--slate)">Belum ada tagihan untuk bulan ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- RIWAYAT PEMBAYARAN --}}
        <div class="col-12 col-lg-5">
            <div class="content-card card shadow h-100">
                <div class="card-header">
                    <span class="section-title"><i class="bi bi-clock-history me-2"></i>Riwayat Pembayaran</span>
                    <div class="muted-text mt-1">5 transaksi terakhir</div>
                </div>
                <div class="card-body p-4">
                    @if($riwayat->isNotEmpty())
                        <div class="d-flex flex-column gap-2">
                            @foreach($riwayat as $item)
                            <div class="riwayat-item d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                         style="width:38px;height:38px;background:rgba(46,204,113,0.15);border:1px solid rgba(46,204,113,0.3)">
                                        <i class="bi bi-check-lg" style="color:#2ecc71"></i>
                                    </div>
                                    <div>
                                        <div class="value-text" style="font-size:.85rem">SPP {{ $bulanList[$item->bulan] }}</div>
                                        <div class="muted-text">{{ $item->tahunAjaran->nama ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-semibold" style="color:#2ecc71;font-size:.85rem">
                                        Rp {{ number_format($item->nominal ?? 0, 0, ',', '.') }}
                                    </div>
                                    @if($item->pembayaran)
                                    <div class="muted-text">
                                        {{ \Carbon\Carbon::parse($item->pembayaran->tanggal_bayar ?? $item->pembayaran->created_at)->format('d M Y') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-clock-history fs-1 d-block mb-3" style="color:var(--slate)"></i>
                            <p class="mb-0" style="color:var(--slate)">Belum ada riwayat pembayaran.</p>
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('siswa.tagihan') }}"
                           class="btn w-100 fw-semibold"
                           style="background:rgba(34,86,136,0.4);color:var(--glacier);border:1px solid rgba(169,203,224,0.3);border-radius:10px">
                            <i class="bi bi-list-ul me-2"></i>Lihat Semua Tagihan
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection