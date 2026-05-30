@extends('layouts.siswa')
@section('title', 'Tagihan Saya')
@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show py-2 small">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card p-3">
    <h6 class="fw-bold text-white mb-3">
        <i class="bi bi-file-earmark-text-fill me-2" style="color:#A9CBE0"></i>Semua Tagihan
    </h6>
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0" style="font-size:13px">
            <thead>
                <tr style="border-color:#225688;background:#092C56">
                    <th style="color:#A9CBE0;font-weight:500;padding:10px 12px">No</th>
                    <th style="color:#A9CBE0;font-weight:500;padding:10px 12px">Bulan</th>
                    <th style="color:#A9CBE0;font-weight:500;padding:10px 12px">Tahun Ajaran</th>
                    <th style="color:#A9CBE0;font-weight:500;padding:10px 12px">Nominal SPP</th>
                    <th style="color:#A9CBE0;font-weight:500;padding:10px 12px">Potongan</th>
                    <th style="color:#A9CBE0;font-weight:500;padding:10px 12px">Total Bayar</th>
                    <th style="color:#A9CBE0;font-weight:500;padding:10px 12px">Status</th>
                    <th style="color:#A9CBE0;font-weight:500;padding:10px 12px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tagihans as $t)
                <tr style="border-color:#1a3a5c">

                    {{-- No --}}
                    <td style="color:#668CA9;padding:10px 12px;vertical-align:middle">
                        {{ $loop->iteration }}
                    </td>

                    {{-- Bulan --}}
                    <td style="color:#e2e8f0;padding:10px 12px;vertical-align:middle;font-weight:500">
                        {{ $bulanList[$t->bulan] }}
                    </td>

                    {{-- Tahun Ajaran --}}
                    <td style="color:#94a3b8;padding:10px 12px;vertical-align:middle">
                        {{ $t->tahunAjaran->nama ?? '-' }}
                    </td>

                    {{-- Nominal SPP --}}
                    <td style="color:#e2e8f0;padding:10px 12px;vertical-align:middle">
                        Rp {{ number_format($t->nominal_awal, 0, ',', '.') }}
                    </td>

                    {{-- Potongan: tampil nama + nominal tiap potongan --}}
                    <td style="padding:10px 12px;vertical-align:middle">
                        @php
                            $bulanIni   = $t->bulan;
                            $tahunIni   = $t->tahunAjaran->tahun_mulai ?? now()->year;
                            $sekarang   = ($tahunIni * 12) + $bulanIni;
                            $potonganAktif = $t->siswa->potonganSpps->filter(function($p) use ($sekarang) {
                                $mulai   = ($p->pivot->tahun_mulai * 12) + $p->pivot->bulan_mulai;
                                $selesai = ($p->pivot->tahun_selesai * 12) + $p->pivot->bulan_selesai;
                                return $p->pivot->is_aktif && $sekarang >= $mulai && $sekarang <= $selesai;
                            });
                        @endphp

                        @if($potonganAktif->count() > 0)
                            @foreach($potonganAktif as $potongan)
                                <div style="margin-bottom:4px">
                                    <span style="color:#fbbf24;font-weight:600;font-size:11px">
                                        {{ $potongan->nama }}
                                    </span>
                                    <br>
                                    <span style="color:#10b981;font-size:12px">
                                        -Rp {{ number_format($potongan->nominal_potongan, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                        @elseif($t->total_potongan > 0)
                            <span style="color:#10b981">
                                -Rp {{ number_format($t->total_potongan, 0, ',', '.') }}
                            </span>
                        @else
                            <span style="color:#668CA9">-</span>
                        @endif
                    </td>

                    {{-- Total Bayar --}}
                    <td style="color:#e2e8f0;padding:10px 12px;vertical-align:middle;font-weight:600">
                        Rp {{ number_format($t->nominal_bayar, 0, ',', '.') }}
                    </td>

                    {{-- Status --}}
                    <td style="padding:10px 12px;vertical-align:middle">
                        @if($t->status == 'lunas')
                            <span class="badge bg-success" style="font-size:11px">Lunas ✅</span>
                        @elseif($t->status == 'menunggu')
                            <span class="badge bg-warning text-dark" style="font-size:11px">Menunggu ⏳</span>
                        @else
                            <span class="badge bg-danger" style="font-size:11px">Belum Bayar</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td style="padding:10px 12px;vertical-align:middle">
                        @if($t->status == 'lunas')
                            <a href="{{ route('siswa.tagihan.kwitansi', $t) }}"
                               class="btn btn-sm btn-outline-success"
                               style="font-size:11px">
                                <i class="bi bi-download me-1"></i>Kwitansi
                            </a>
                        @elseif($t->status == 'belum_bayar')
                            <a href="{{ route('siswa.tagihan.bayar', $t->id) }}"
                               class="btn btn-sm"
                               style="font-size:11px;background:#225688;color:#A9CBE0;border:1px solid rgba(169,203,224,0.3)">
                                <i class="bi bi-wallet2 me-1"></i>Bayar
                            </a>
                        @else
                            <span class="text-muted small">Menunggu verifikasi</span>
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4" style="color:#668CA9">
                        <i class="bi bi-inbox me-2"></i>Belum ada tagihan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection