<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan_Pembayaran_SPP</title>
    <style>
        /* Gaya standar agar HTML sukses diubah jadi PDF oleh Dompdf */
        body { 
            font-family: sans-serif; 
            color: #333333; 
            padding: 10px;
            font-size: 12px;
        }
        .kop-surat { 
            text-align: center; 
            border-bottom: 2px solid #000000; 
            padding-bottom: 5px; 
            margin-bottom: 20px; 
        }
        .table-cetak {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table-cetak th, .table-cetak td {
            border: 1px solid #666666;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }
        .table-cetak th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2 style="margin: 0 0 5px 0; font-weight: bold; text-transform: uppercase;">LAPORAN PEMBAYARAN SPP</h2>
        <p style="margin: 0; color: #666; font-size: 11px;">Data Rekapitulasi Transaksi Keuangan Realtime Sekolah</p>
    </div>

    <table class="table-cetak">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%" class="text-center">Tanggal</th>
                <th width="15%" class="text-center">NISN</th>
                <th>Nama Siswa</th>
                <th width="15%" class="text-center">Kelas</th>
                <th width="15%" class="text-center">Untuk Bulan</th>
                <th width="20%" class="text-center">Jumlah Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporans ?? [] as $index => $lap)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ date('d/m/Y', strtotime($lap->tanggal_bayar ?? $lap->created_at)) }}</td>
                
                {{-- FIX NISN: Jalur diperbaiki lewat relasi tagihan --}}
                <td class="text-center">{{ $lap->tagihan->siswa->nis ?? $lap->siswa->nis ?? '-' }}</td>
                
                {{-- FIX NAMA SISWA: Jalur diperbaiki lewat relasi tagihan --}}
                <td class="fw-bold">{{ $lap->tagihan->siswa->nama ?? $lap->siswa->nama ?? '-' }}</td>
                
                {{-- FIX KELAS: Disesuaikan agar tingkat dan nama kelas tampil serempak --}}
                <td class="text-center">
                    @if(isset($lap->tagihan->siswa->kelas))
                        {{ $lap->tagihan->siswa->kelas->tingkat }} {{ $lap->tagihan->siswa->kelas->nama_kelas ?? $lap->tagihan->siswa->kelas->jurusan ?? '' }}
                    @elseif(isset($lap->siswa->kelas))
                        {{ $lap->siswa->kelas->tingkat }} {{ $lap->siswa->kelas->nama_kelas ?? $lap->siswa->kelas->jurusan ?? '' }}
                    @else
                        {{ $lap->kelas ?? '-' }}
                    @endif
                </td>
                
                {{-- FIX BULAN: Memanggil bulan_teks dari controller hasil konversi huruf ("Mei") --}}
                <td class="text-center">{{ $lap->bulan_teks ?? '-' }}</td>
                
                <td class="text-end fw-bold">Rp {{ number_format($lap->jumlah_bayar ?? $lap->nominal ?? 0, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 20px; color: #666;">Tidak ada data transaksi pembayaran SPP.</td>
            </tr>
            @endforelse
        </tbody>
        @if(count($laporans ?? []) > 0)
        <tfoot>
            <tr style="background-color: #f9f9f9; font-weight: bold;">
                <td colspan="6" class="text-end">TOTAL REKAPITULASI DANA:</td>
                <td class="text-end" style="color: #d9534f;">Rp {{ number_format($laporans->sum('jumlah_bayar'), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div style="text-align: right; margin-top: 40px; padding-right: 10px;">
        <p style="margin: 0; font-size: 11px;">Sidoarjo, {{ date('d F Y') }}</p>
        <p style="margin: 0 35px 0 0; font-size: 11px;">Bendahara Sekolah,</p>
        <br><br><br>
        <p style="margin: 0; font-weight: bold;">_______________________</p>
    </div>

</body>
</html>