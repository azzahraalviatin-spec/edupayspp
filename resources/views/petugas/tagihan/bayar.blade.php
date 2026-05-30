@extends('layouts.petugas')

@section('title', 'Pembayaran Tunai')

@section('content')

<style>
    .pay-wrap {
        max-width: 760px;
        margin: 0 auto;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #94a3b8;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        margin-bottom: 20px;
        transition: color .2s;
    }
    .back-link:hover { color: #60a5fa; }

    .pay-card {
        background: #1a233a;
        border: 1px solid #2d4a8a;
        border-radius: 18px;
        box-shadow: 0 8px 32px rgba(0,0,0,.35);
        overflow: hidden;
    }

    .pay-header {
        background: linear-gradient(135deg, #1e3a6e 0%, #1a233a 100%);
        border-bottom: 1px solid #2d4a8a;
        padding: 22px 28px;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .pay-header-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: rgba(59,130,246,.18);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #60a5fa;
        flex-shrink: 0;
    }
    .pay-header h5 {
        color: #fff;
        font-weight: 700;
        font-size: 17px;
        margin: 0 0 2px;
    }
    .pay-header small { color: #64748b; font-size: 12px; }

    .pay-body { padding: 28px 28px 0 28px; }

    .section-title {
        color: #60a5fa;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #1e3a6e;
    }

    /* Info grid siswa */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 24px;
    }
    .info-item {
        background: #131c31;
        border: 1px solid #1e3a6e;
        border-radius: 12px;
        padding: 13px 16px;
    }
    .info-item label {
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .5px;
        display: block;
        margin-bottom: 4px;
    }
    .info-item .val { color: #fff; font-size: 14px; font-weight: 700; }
    .info-item .val.nis { color: #fbbf24; }
    .info-item .val.kelas {
        display: inline-block;
        background: rgba(59,130,246,.12);
        color: #93c5fd;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
    }

    /* Ringkasan tagihan */
    .tagihan-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
        margin-bottom: 24px;
    }
    .tagihan-item {
        background: #131c31;
        border: 1px solid #1e3a6e;
        border-radius: 12px;
        padding: 13px 16px;
    }
    .tagihan-item label {
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .5px;
        display: block;
        margin-bottom: 4px;
    }
    .tagihan-item .val { font-size: 16px; font-weight: 800; }
    .tagihan-item .val.merah  { color: #f87171; }
    .tagihan-item .val.kuning { color: #fbbf24; }
    .tagihan-item .val.hijau  { color: #4ade80; }

    .pay-divider {
        border: none;
        border-top: 1px dashed #2d4a8a;
        margin: 0 0 24px;
    }

    /* Potongan card */
    .potongan-item {
        background: #131c31;
        border: 1px solid #1e3a6e;
        border-radius: 10px;
        padding: 10px 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }
    .potongan-item .p-nama { color: #fff; font-size: 13px; font-weight: 700; }
    .potongan-item .p-jenis { color: #64748b; font-size: 11px; margin-top: 2px; }
    .potongan-item .p-nominal { color: #fbbf24; font-weight: 800; font-size: 13px; }

    .no-potongan {
        background: #131c31;
        border: 1px solid #1e3a6e;
        border-radius: 10px;
        padding: 12px 16px;
        color: #475569;
        font-size: 13px;
    }

    /* Metode badge */
    .metode-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(59,130,246,.12);
        border: 1px solid rgba(59,130,246,.3);
        color: #93c5fd;
        font-size: 13px;
        font-weight: 700;
        padding: 12px 16px;
        border-radius: 10px;
        width: 100%;
    }

    /* Form */
    .form-label {
        color: #cbd5e1;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }
    .form-control {
        background: #0f172a !important;
        border: 1px solid #334155 !important;
        color: #fff !important;
        border-radius: 10px;
        padding: 13px 16px;
        font-size: 15px;
        font-weight: 600;
        width: 100%;
        transition: border-color .2s;
    }
    .form-control::placeholder { color: #334155; font-weight: 400; }
    .form-control:focus {
        outline: none;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59,130,246,.1);
    }

    /* Uang & kembalian row */
    .uang-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 28px;
    }

    /* Kembalian box */
    .kembalian-box {
        background: rgba(16,185,129,.08);
        border: 1px solid rgba(16,185,129,.25);
        border-radius: 12px;
        padding: 13px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 52px;
        transition: .3s;
    }
    .kembalian-box .kb-label { color: #6ee7b7; font-size: 12px; font-weight: 600; }
    .kembalian-box .kb-amount { color: #6ee7b7; font-size: 18px; font-weight: 800; }
    .kembalian-box.kurang {
        background: rgba(239,68,68,.08);
        border-color: rgba(239,68,68,.3);
    }
    .kembalian-box.kurang .kb-label,
    .kembalian-box.kurang .kb-amount { color: #fca5a5; }

    .kurang-warning {
        display: none;
        background: rgba(239,68,68,.1);
        border: 1px solid rgba(239,68,68,.3);
        color: #fca5a5;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 600;
        margin-top: 6px;
        align-items: center;
        gap: 6px;
    }
    .kurang-warning.show { display: flex; }

    /* Footer */
    .pay-footer {
        padding: 20px 28px 28px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        border-top: 1px solid #1e3a6e;
        margin-top: 4px;
    }
    .btn-batal {
        background: transparent;
        border: 1px solid #334155;
        color: #94a3b8;
        font-size: 13px;
        font-weight: 600;
        padding: 11px 24px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: .2s;
    }
    .btn-batal:hover { border-color: #475569; color: #cbd5e1; }
    .btn-proses {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border: none;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        padding: 11px 28px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: .2s;
    }
    .btn-proses:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(59,130,246,.4);
    }
    .btn-proses:disabled {
        opacity: .45;
        cursor: not-allowed;
    }
</style>

<div class="pay-wrap">

    <a href="{{ route('petugas.tunggakan') }}" class="back-link">
        <i class="bi bi-arrow-left-circle-fill"></i>
        Kembali ke Daftar Tunggakan
    </a>

    <form action="{{ route('petugas.bayar.tunai', $tagihan->id) }}" method="POST" id="formBayar">
    @csrf

    <div class="pay-card">

        {{-- Header --}}
        <div class="pay-header">
            <div class="pay-header-icon">
                <i class="bi bi-cash-coin"></i>
            </div>
            <div>
                <h5>Pembayaran SPP Tunai</h5>
                <small>Periksa ringkasan tagihan sebelum memproses pembayaran</small>
            </div>
        </div>

        <div class="pay-body">

            {{-- ── Info Siswa ── --}}
            <div class="section-title">
                <i class="bi bi-person-fill"></i> Informasi Siswa
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <label>Nama Siswa</label>
                    <div class="val">{{ $tagihan->siswa->nama ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <label>NIS</label>
                    <div class="val nis">{{ $tagihan->siswa->nis ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <label>Kelas</label>
                    <div class="val">
                        <span class="kelas">
                            {{ $tagihan->siswa->kelas->tingkat ?? '' }}
                            {{ $tagihan->siswa->kelas->jurusan ?? '' }}
                            {{ $tagihan->siswa->kelas->nomor_kelas ?? '' }}
                        </span>
                    </div>
                </div>
                <div class="info-item">
                    <label>Bulan Tagihan</label>
                    <div class="val">{{ $bulanList[$tagihan->bulan] ?? '-' }}</div>
                </div>
            </div>

            {{-- ── Ringkasan Tagihan ── --}}
            <div class="section-title">
                <i class="bi bi-receipt"></i> Ringkasan Tagihan
            </div>

            <div class="tagihan-grid">
                <div class="tagihan-item">
                    <label>Nominal SPP</label>
                    <div class="val merah">
                        Rp {{ number_format($tagihan->nominal_awal ?? $tagihan->nominal_bayar, 0, ',', '.') }}
                    </div>
                </div>
                <div class="tagihan-item">
                    <label>Potongan</label>
                    <div class="val kuning">
                        Rp {{ number_format($tagihan->total_potongan ?? 0, 0, ',', '.') }}
                    </div>
                </div>
                <div class="tagihan-item">
                    <label>Total Bayar</label>
                    <div class="val hijau">
                        Rp {{ number_format($tagihan->nominal_bayar, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <hr class="pay-divider">

            {{-- ── Proses Pembayaran ── --}}
            <div class="section-title">
                <i class="bi bi-wallet2"></i> Proses Pembayaran
            </div>

            {{-- Potongan & Metode (berdampingan) --}}
            <div class="row g-3 mb-3">

                {{-- Potongan (kiri) --}}
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-scissors me-1 text-warning"></i>
                        Potongan
                    </label>

                    @if($potonganAktif->isEmpty())
                        <div class="no-potongan">
                            <i class="bi bi-dash-circle me-1"></i> Tidak ada potongan
                        </div>
                        <input type="hidden" name="potongan" value="0">
                    @else
                        @foreach($potonganAktif as $p)
                        <div class="potongan-item">
                            <div>
                                <div class="p-nama">{{ $p->nama }}</div>
                                <div class="p-jenis">{{ $p->jenis }}</div>
                            </div>
                            <div class="p-nominal">
                                -Rp {{ number_format($p->nominal_potongan, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                        <input type="hidden" name="potongan"
                               value="{{ $potonganAktif->sum('nominal_potongan') }}">
                        <small style="color:#6ee7b7; font-size:11px; margin-top:4px; display:block;">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            Total: Rp {{ number_format($potonganAktif->sum('nominal_potongan'), 0, ',', '.') }}
                        </small>
                    @endif
                </div>

                {{-- Metode Pembayaran (kanan) --}}
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-credit-card me-1 text-info"></i>
                        Metode Pembayaran
                    </label>
                    <div class="metode-badge">
                        <i class="bi bi-cash-stack"></i> Tunai (Cash)
                    </div>
                    <input type="hidden" name="metode" value="tunai">
                </div>

            </div>

            {{-- Uang Dibayar & Kembalian (berdampingan) --}}
            <div class="uang-row">

                {{-- Uang Dibayar --}}
                <div>
                    <label class="form-label">
                        <i class="bi bi-currency-dollar me-1 text-success"></i>
                        Uang Dibayar Siswa <span class="text-danger">*</span>
                    </label>
                    <input type="number"
                           name="uang_dibayar"
                           id="uang_dibayar"
                           class="form-control"
                           placeholder="Masukkan nominal..."
                           min="0"
                           required>
                    <div class="kurang-warning" id="kurang-warning">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span id="kurang-text">Uang masih kurang!</span>
                    </div>
                </div>

                {{-- Kembalian --}}
                <div>
                    <label class="form-label">
                        <i class="bi bi-arrow-return-left me-1 text-success"></i>
                        Kembalian
                    </label>
                    <div class="kembalian-box" id="kembalian-box">
                        <span class="kb-label"><i class="bi bi-coin me-1"></i> Kembalian siswa</span>
                        <span class="kb-amount" id="kembalian-amount">Rp 0</span>
                    </div>
                </div>

            </div>

        </div>{{-- end pay-body --}}

        {{-- Footer --}}
        <div class="pay-footer">
            <a href="{{ route('petugas.tunggakan') }}" class="btn-batal">
                <i class="bi bi-x-circle"></i> Batal
            </a>
            <button type="submit" class="btn-proses" id="btn-proses" disabled>
                <i class="bi bi-check-circle-fill"></i> Proses Pembayaran
            </button>
        </div>

    </div>{{-- end pay-card --}}

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const totalBayar = {{ $tagihan->nominal_bayar }};

    const elUang         = document.getElementById('uang_dibayar');
    const elKembalianAmt = document.getElementById('kembalian-amount');
    const elKembalianBox = document.getElementById('kembalian-box');
    const elKurangWarn   = document.getElementById('kurang-warning');
    const elKurangText   = document.getElementById('kurang-text');
    const elBtnProses    = document.getElementById('btn-proses');

    function fmt(n) {
        return 'Rp ' + n.toLocaleString('id-ID');
    }

    elUang.addEventListener('input', function () {

        const uang   = parseInt(this.value) || 0;
        const sisa   = uang - totalBayar;

        if (uang === 0) {
            // Belum diisi
            elKembalianAmt.textContent = 'Rp 0';
            elKembalianBox.classList.remove('kurang');
            elKurangWarn.classList.remove('show');
            elBtnProses.disabled = true;

        } else if (sisa >= 0) {
            // Cukup / lebih → tampilkan kembalian
            elKembalianAmt.textContent = fmt(sisa);
            elKembalianBox.classList.remove('kurang');
            elKurangWarn.classList.remove('show');
            elBtnProses.disabled = false;

        } else {
            // Kurang
            elKembalianAmt.textContent = 'Rp 0';
            elKembalianBox.classList.add('kurang');
            elKurangText.textContent =
                'Uang kurang! Masih kurang ' + fmt(Math.abs(sisa));
            elKurangWarn.classList.add('show');
            elBtnProses.disabled = true;
        }
    });

    // Cegah submit kalau kurang
    document.getElementById('formBayar').addEventListener('submit', function (e) {
        const uang = parseInt(elUang.value) || 0;
        if (uang < totalBayar) {
            e.preventDefault();
            alert('Uang yang dibayarkan masih kurang!');
        }
    });

});
</script>

@endsection