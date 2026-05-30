<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 13px;
    color: #111827;
    background: white;
}

.page {
    padding: 30px 40px;
}

/* ===== BORDER TOP & BOTTOM ===== */
.border-top-blue {
    height: 8px;
    background: #1d4ed8;
    margin-bottom: 0;
}
.border-bottom-blue {
    height: 8px;
    background: #1d4ed8;
    margin-top: 0;
}

/* ===== HEADER ===== */
.header-row {
    display: block;
    margin-bottom: 15px;
}

.header-table {
    width: 100%;
}

.logo {
    width: 80px;
}

.nama-sekolah {
    font-size: 22px;
    font-weight: 900;
    color: #0f2f6b;
}

.alamat {
    font-size: 12px;
    color: #334155;
    margin-top: 4px;
}

.line-blue {
    border: none;
    border-top: 3px solid #1d4ed8;
    margin: 10px 0 0 0;
}

/* ===== JUDUL ===== */
.judul {
    text-align: center;
    margin: 20px 0 10px;
}

.judul h1 {
    font-size: 22px;
    font-weight: 900;
    color: #111827;
}

.kode-box {
    display: inline-block;
    background: #1d4ed8;
    color: white;
    padding: 8px 22px;
    border-radius: 8px;
    font-size: 20px;
    font-weight: 900;
    margin-top: 8px;
}

/* ===== TABLE INFO ===== */
.table-info {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table-info td {
    border: 1px solid #1e3a8a;
    padding: 10px 12px;
    font-size: 13px;
}

.table-info .label {
    font-weight: 700;
    width: 18%;
    background: #f1f5f9;
}

/* ===== SECTION TITLE ===== */
.section-title {
    margin: 20px 0 10px;
    font-size: 15px;
    font-weight: 900;
    color: #12357a;
    border-left: 5px solid #1d4ed8;
    padding-left: 10px;
}

/* ===== TABLE DETAIL ===== */
.table-detail {
    width: 100%;
    border-collapse: collapse;
}

.table-detail th {
    background: #dbeafe;
    color: #0f2f6b;
    padding: 12px;
    border: 1px solid #1e3a8a;
    font-size: 13px;
    text-align: center;
}

.table-detail td {
    border: 1px solid #1e3a8a;
    padding: 12px;
    text-align: center;
    font-size: 13px;
}

.total-blue {
    background: #17479e;
    color: white;
    font-weight: 900;
    font-size: 15px;
}

/* ===== TOTAL BOX ===== */
.total-box {
    margin-top: 15px;
    border: 1px solid #1e3a8a;
    border-radius: 10px;
    padding: 14px 20px;
}

.total-box-inner {
    width: 100%;
}

.total-label {
    font-size: 13px;
    color: #475569;
}

.total-sub {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
}

.total-nominal {
    background: #17479e;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 18px;
    font-weight: 900;
    text-align: right;
}

/* ===== FOOTER ===== */
.footer-area {
    margin-top: 30px;
    width: 100%;
}

.footer-table {
    width: 100%;
}

.catatan-title {
    font-size: 14px;
    font-weight: 900;
    color: #12357a;
    border-left: 5px solid #17479e;
    padding-left: 10px;
    margin-bottom: 10px;
}

.catatan ol {
    padding-left: 20px;
}

.catatan li {
    font-size: 13px;
    margin-bottom: 8px;
    line-height: 1.6;
    color: #111827;
}

.ttd-area {
    text-align: center;
    width: 220px;
}

.ttd-title {
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 60px;
}

.ttd-nama {
    font-size: 16px;
    font-weight: 900;
    border-top: 2px solid #111827;
    padding-top: 6px;
    margin-top: 5px;
}

</style>
</head>
<body>

<div class="border-top-blue"></div>

<div class="page">

    {{-- ===== HEADER SEKOLAH ===== --}}
    <table class="header-table">
        <tr>
            <td style="width:90px;vertical-align:middle">
                <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
            </td>
            <td style="vertical-align:middle;padding-left:15px">
                <div class="nama-sekolah">SMK ANTARTIKA 2 SIDOARJO</div>
                <div class="alamat">Jl. Siwalanpanji II, Buduran, Sidoarjo, Jawa Timur 61252</div>
                <hr class="line-blue">
            </td>
        </tr>
    </table>

    {{-- ===== JUDUL ===== --}}
    <div class="judul">
        <h1>KWITANSI PEMBAYARAN SPP</h1>
        <div>
            <span class="kode-box">
                {{ $tagihan->pembayaran->no_kwitansi ?? '-' }}
            </span>
        </div>
    </div>

    {{-- ===== INFO SISWA ===== --}}
    <table class="table-info">
        <tr>
            <td class="label">Nama Siswa</td>
            <td>{{ $tagihan->siswa->nama }}</td>
            <td class="label">Kelas</td>
            <td>
                {{ $tagihan->siswa->kelas->tingkat ?? '' }}
                -
                {{ strtoupper($tagihan->siswa->kelas->jurusan ?? '') }}
                -
                {{ $tagihan->siswa->kelas->nomor_kelas ?? '' }}
            </td>
        </tr>
        <tr>
            <td class="label">NIS</td>
            <td>{{ $tagihan->siswa->nis }}</td>
            <td class="label">Tanggal Bayar</td>
            <td>
                {{ $tagihan->pembayaran && $tagihan->pembayaran->tanggal_bayar
                    ? \Carbon\Carbon::parse($tagihan->pembayaran->tanggal_bayar)->format('d-m-Y H:i:s')
                    : '-' }}
            </td>
        </tr>
        <tr>
            <td class="label">Metode Bayar</td>
            <td>{{ ucfirst($tagihan->pembayaran->metode_bayar ?? '-') }}</td>
            <td class="label">Status</td>
            <td><strong style="color:#16a34a">LUNAS</strong></td>
        </tr>
    </table>

    {{-- ===== DETAIL PEMBAYARAN ===== --}}
    <div class="section-title">DETAIL PEMBAYARAN</div>

    <table class="table-detail">
        <tr>
            <th>Bulan</th>
            <th>Tahun Ajaran</th>
            <th>Nominal SPP</th>
        </tr>
        <tr>
            <td>{{ $bulanList[$tagihan->bulan] ?? '-' }}</td>
            <td>{{ $tagihan->tahunAjaran->nama ?? date('Y') }}</td>
            <td>Rp {{ number_format($tagihan->nominal_awal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="2"><b>Total Sebelum Potongan</b></td>
            <td>Rp {{ number_format($tagihan->nominal_awal, 0, ',', '.') }}</td>
        </tr>

        @if($tagihan->total_potongan > 0)
        <tr>
            <td colspan="2">
                @foreach($tagihan->siswa->potonganSpps as $potongan)
                    <b>Potongan {{ $potongan->nama }}</b>
                @endforeach
            </td>
            <td style="color:#16a34a">
                - Rp {{ number_format($tagihan->total_potongan, 0, ',', '.') }}
            </td>
        </tr>
        @endif

        <tr>
            <td colspan="2" class="total-blue">TOTAL AKHIR DIBAYAR</td>
            <td class="total-blue">
                Rp {{ number_format($tagihan->nominal_bayar, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    {{-- ===== TOTAL BOX ===== --}}
    <table class="total-box" style="width:100%;border-collapse:collapse">
        <tr>
            <td style="vertical-align:middle">
                <div class="total-label">Total Pembayaran</div>
                <div class="total-sub">Pembayaran siswa berhasil</div>
            </td>
            <td style="text-align:right;vertical-align:middle">
                <div class="total-nominal">
                    Rp {{ number_format($tagihan->nominal_bayar, 0, ',', '.') }}
                </div>
            </td>
        </tr>
    </table>

    {{-- ===== FOOTER ===== --}}
    <table class="footer-table" style="margin-top:30px">
        <tr>
            <td style="vertical-align:top;padding-right:30px">
                <div class="catatan">
                    <div class="catatan-title">CATATAN</div>
                    <ol>
                        <li>Pembayaran SPP paling lambat tanggal 10 setiap bulannya</li>
                        <li>Bukti pembayaran jangan sampai hilang</li>
                        <li>Harap membawa bukti pembayaran sebelumnya</li>
                    </ol>
                </div>
            </td>
            <td style="text-align:center;width:200px;vertical-align:top">
                <div class="ttd-title">Petugas</div>
                <div class="ttd-nama">
                    {{ $tagihan->pembayaran->petugas->name ?? 'Petugas' }}
                </div>
            </td>
        </tr>
    </table>

</div>

<div class="border-bottom-blue"></div>

</body>
</html>