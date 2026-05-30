@extends('layouts.petugas')

@section('title', 'Struk Pembayaran')

@section('content')

<style>

body{
    background:#071326;
}

/* ================= WRAPPER ================= */

.struk-wrapper{
    max-width:1000px;
    margin:auto;
    padding:20px;
}

.top-action{
    display:flex;
    justify-content:space-between;
    margin-bottom:20px;
}

.btn-back{
    background:#1e293b;
    color:white;
    padding:10px 18px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
}

.btn-print{
    background:#1d4ed8;
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:10px;
    font-weight:700;
}

/* ================= STRUK ================= */

#struk-area{
    background:white;
    border-top:8px solid #1d4ed8;
    border-bottom:8px solid #1d4ed8;
    position:relative;
    overflow:hidden;
}

/* ================= HEADER ================= */

.struk-header{
    padding:35px 45px 20px;
}

.sekolah-box{
    display:flex;
    align-items:center;
    gap:25px;
}

.logo-sekolah{
    width:95px;
}

.nama-sekolah{
    font-size:30px;
    font-weight:900;
    color:#0f2f6b;
    margin-bottom:5px;
}

.alamat{
    font-size:14px;
    color:#334155;
}

.line-header{
    margin-top:15px;
    height:3px;
    background:#1d4ed8;
    position:relative;
}

.line-header::after{
    content:'◆';
    position:absolute;
    left:50%;
    top:-12px;
    transform:translateX(-50%);
    color:#1d4ed8;
    font-size:22px;
}

.judul{
    text-align:center;
    margin-top:25px;
}

.judul h1{
    font-size:28px;
    font-weight:900;
    color:#111827;
}

.kode-struk{
    display:inline-block;
    margin-top:12px;
    background:#1d4ed8;
    color:white;
    padding:10px 25px;
    border-radius:10px;
    font-size:24px;
    font-weight:800;
}

/* ================= TABLE ================= */

.table-info{
    width:100%;
    border-collapse:collapse;
    margin-top:35px;
}

.table-info td{
    border:1px solid #1e3a8a;
    padding:14px;
    font-size:16px;
    color:#111827;
}

.table-info .label{
    width:20%;
    font-weight:700;
}

/* ================= DETAIL ================= */

.detail-title{
    display:flex;
    align-items:center;
    gap:14px;
    margin-top:35px;
    margin-bottom:20px;
}

.detail-title i{
    background:#1d4ed8;
    color:white;
    width:42px;
    height:42px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
}

.detail-title h3{
    color:#12357a;
    font-weight:900;
    margin:0;
}

.detail-line{
    flex:1;
    height:2px;
    background:#1d4ed8;
}

.table-detail{
    width:100%;
    border-collapse:collapse;
}

.table-detail th{
    background:#dbeafe;
    color:#0f2f6b;
    padding:16px;
    border:1px solid #1e3a8a;
    font-size:16px;
}

.table-detail td{
    border:1px solid #1e3a8a;
    padding:18px;
    text-align:center;
    font-size:16px;
    color:#111827;
}

.total-blue{
    background:#17479e;
    color:white !important;
    font-weight:900;
    font-size:18px;
}

/* ================= TERBILANG ================= */

.terbilang-box{
    margin-top:25px;
    border:1px solid #1e3a8a;
    border-radius:20px;
    padding:18px 25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.terbilang-left{
    display:flex;
    align-items:center;
    gap:15px;
}

.terbilang-left i{
    width:48px;
    height:48px;
    background:#17479e;
    color:white;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
}

.terbilang-title{
    color:#475569;
    font-size:15px;
}

.terbilang-sub{
    color:#111827;
    font-weight:700;
    font-size:16px;
}

.nominal-box{
    background:#17479e;
    color:white;
    padding:15px 28px;
    border-radius:12px;
    font-size:22px;
    font-weight:900;
}

/* ================= FOOTER ================= */

.footer-area{
    margin-top:45px;
    display:flex;
    justify-content:space-between;
    gap:40px;
}

.catatan{
    flex:1;
}

.catatan-title{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:15px;
}

.catatan-title i{
    width:42px;
    height:42px;
    background:#17479e;
    color:white;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
}

.catatan-title h3{
    margin:0;
    color:#12357a;
    font-weight:900;
}

.catatan ol{
    padding-left:22px;
}

.catatan li{
    color:#111827;
    font-size:17px;
    margin-bottom:12px;
    line-height:1.7;
}

/* ================= TTD ================= */

.ttd-box{
    width:320px;
    text-align:center;
    position:relative;
}

.ttd-title{
    font-size:18px;
    font-weight:700;
    color:#111827;
    margin-bottom:10px;
}

.stempel{
    width:180px;
    position:absolute;
    left:50%;
    top:40px;
    transform:translateX(-50%);
    opacity:.95;
}

.ttd{
    width:130px;
    position:relative;
    z-index:2;
    margin-top:50px;
}

.petugas{
    margin-top:10px;
    font-size:20px;
    font-weight:900;
    color:#111827;
}

/* ================= PRINT ================= */

@media print{

    .top-action{
        display:none;
    }

    body{
        background:white;
    }

    .struk-wrapper{
        padding:0;
    }

}

</style>

<div class="struk-wrapper">

    <div class="top-action">

        <a href="{{ route('petugas.tunggakan') }}" class="btn-back">
            ← Kembali
        </a>

        <button onclick="window.print()" class="btn-print">
            Cetak Struk
        </button>

    </div>

    <div id="struk-area">

        <div class="struk-header">

            <div class="sekolah-box">

            <img src="{{ asset('images/logo.png') }}" class="logo-sekolah" alt="Logo">

                <div>

                    <div class="nama-sekolah">
                        SMK ANTARTIKA 2 SIDOARJO
                    </div>

                    <div class="alamat">
                        Jl. Siwalanpanji II, Buduran, Sidoarjo, Jawa Timur 61252
                    </div>

                    <div class="line-header"></div>

                </div>

            </div>

            <div class="judul">

                <h1>BUKTI PEMBAYARAN SPP</h1>

                <div class="kode-struk">
                    {{ $pembayaran->no_kwitansi }}
                </div>

            </div>

            <table class="table-info">

                <tr>
                    <td class="label">Nama Siswa</td>
                    <td>{{ $pembayaran->tagihan->siswa->nama }}</td>

                    <td class="label">Kelas</td>
                    <td>
                        {{ $pembayaran->tagihan->siswa->kelas->tingkat ?? '' }}
                        -
                        {{ strtoupper($pembayaran->tagihan->siswa->kelas->jurusan ?? '') }}
                        -
                        {{ $pembayaran->tagihan->siswa->kelas->nomor_kelas ?? '' }}
                    </td>
                </tr>

                <tr>
                    <td class="label">NIS</td>
                    <td>{{ $pembayaran->tagihan->siswa->nis }}</td>

                    <td class="label">Tanggal Bayar</td>
                    <td>
                        {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y H:i:s') }}
                    </td>
                </tr>

                <tr>
                    <td class="label">Metode Bayar</td>
                    <td>Tunai</td>

                    <td class="label">Keterangan</td>
                    <td>-</td>
                </tr>

            </table>

            <div class="detail-title">

                <i class="bi bi-journal-text"></i>

                <h3>DETAIL PEMBAYARAN</h3>

                <div class="detail-line"></div>

            </div>

            <table class="table-detail">

                <tr>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Nominal</th>
                </tr>

                <tr>
                    <td>
                        {{ $bulanList[$pembayaran->tagihan->bulan] ?? '-' }}
                    </td>

                    <td>
                        {{ date('Y') }}
                    </td>

                    <td>
                        Rp {{ number_format($pembayaran->tagihan->nominal_awal,0,',','.') }}
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <b>Total Sebelum Potongan</b>
                    </td>

                    <td>
                        Rp {{ number_format($pembayaran->tagihan->nominal_awal,0,',','.') }}
                    </td>
                </tr>

                @if($pembayaran->tagihan->total_potongan > 0)

                <tr>
                    <td colspan="2">

                        @foreach($pembayaran->tagihan->siswa->potonganSpps as $potongan)

                            <b>
                                Potongan {{ $potongan->nama_potongan }}
                            </b>

                        @endforeach

                    </td>

                    <td>
                        Rp {{ number_format($pembayaran->tagihan->total_potongan,0,',','.') }}
                    </td>
                </tr>

                @endif

                <tr>

                    <td colspan="2" class="total-blue">
                        TOTAL AKHIR DIBAYAR
                    </td>

                    <td class="total-blue">
                        Rp {{ number_format($pembayaran->jumlah_bayar,0,',','.') }}
                    </td>

                </tr>

            </table>

            <div class="terbilang-box">

                <div class="terbilang-left">

                    <i class="bi bi-cash"></i>

                    <div>

                        <div class="terbilang-title">
                            Total Pembayaran
                        </div>

                        <div class="terbilang-sub">
                            Pembayaran siswa berhasil
                        </div>

                    </div>

                </div>

                <div class="nominal-box">
                    Rp {{ number_format($pembayaran->jumlah_bayar,0,',','.') }}
                </div>

            </div>

            <div class="footer-area">

                <div class="catatan">

                    <div class="catatan-title">

                        <i class="bi bi-bell"></i>

                        <h3>CATATAN</h3>

                    </div>

                    <ol>

                        <li>
                            Pembayaran SPP paling lambat tanggal 10 setiap bulannya
                        </li>

                        <li>
                            Bukti pembayaran jangan sampai hilang
                        </li>

                        <li>
                            Harap membawa bukti pembayaran sebelumnya
                        </li>

                    </ol>

                </div>

                <div class="ttd-box">

                    <div class="ttd-title">
                        Petugas
                    </div>

         <img src="{{ asset('images/stempel.png') }}" class="stempel" alt="Stempel">
<img src="{{ asset('images/ttd.png') }}" class="ttd" alt="TTD">

                    <div class="petugas">
                        {{ $pembayaran->petugas->name ?? 'Petugas' }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection