@extends('layouts.petugas')

@section('title', 'Cek Tunggakan')

@section('content')

<style>
    .custom-card{
        background:#1a233a !important;
        border:1px solid #2d4a8a !important;
        border-radius:14px;
        box-shadow:0 4px 20px rgba(0,0,0,.25);
    }
    .table-custom thead th{
        color:#60a5fa !important;
        background:#131c31 !important;
        border-bottom:2px solid #2d4a8a !important;
        font-size:12px;
        text-transform:uppercase;
        letter-spacing:.5px;
        padding:14px 10px;
        white-space: nowrap;
    }
    .table-custom tbody tr{
        border-color:#2d4a8a !important;
    }
    .table-custom tbody tr:hover{
        background:rgba(59,130,246,.05);
    }
    .table-custom td{
        padding:13px 10px;
        vertical-align:middle;
    }
    .text-soft{ color:#94a3b8; }
    .badge-kelas{
        background:rgba(59,130,246,.12);
        color:#93c5fd;
        font-size:11px;
        padding:6px 10px;
        border-radius:30px;
        display:inline-block;
    }
    .badge-danger-custom{
        background:#dc2626;
        color:white;
        font-size:11px;
        padding:6px 10px;
        border-radius:30px;
        display:inline-block;
    }
    .btn-detail{
        background:linear-gradient(135deg,#6366f1,#4f46e5);
        border:none;
        color:white;
        font-size:12px;
        font-weight:600;
        padding:7px 12px;
        border-radius:8px;
        transition:.2s;
        text-decoration:none;
        display:inline-flex;
        align-items:center;
        gap:5px;
    }
    .btn-detail:hover{
        transform:translateY(-1px);
        box-shadow:0 4px 14px rgba(99,102,241,.4);
        color:white;
    }
    .btn-bayar{
        background:linear-gradient(135deg,#3b82f6,#2563eb);
        border:none;
        color:white;
        font-size:12px;
        font-weight:600;
        padding:7px 12px;
        border-radius:8px;
        transition:.2s;
        text-decoration:none;
        display:inline-flex;
        align-items:center;
        gap:5px;
    }
    .btn-bayar:hover{
        transform:translateY(-1px);
        box-shadow:0 4px 14px rgba(59,130,246,.4);
        color:white;
    }
    .notif-error {
        background: rgba(220,38,38,.15);
        border: 1px solid #dc2626;
        color: #fca5a5;
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        font-size: 14px;
    }
    .notif-success {
        background: rgba(16,185,129,.15);
        border: 1px solid #10b981;
        color: #6ee7b7;
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        font-size: 14px;
    }
    .search-input {
        background:#131c31 !important;
        border:1px solid #2d4a8a !important;
        color:#fff !important;
        border-radius:8px;
        padding: 8px 14px;
        font-size:13px;
    }
    .search-input::placeholder { color:#4a5568; }
    .search-input:focus {
        outline:none;
        border-color:#3b82f6 !important;
        box-shadow:0 0 0 3px rgba(59,130,246,.2) !important;
    }
</style>

<div class="custom-card p-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-white mb-0">
            <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
            Daftar Siswa Tunggakan
            <span class="text-soft ms-2" style="font-size:13px;font-weight:400">
                — {{ $bulanList[now()->month] }} {{ now()->year }}
            </span>
        </h5>
        <span class="badge bg-danger px-3 py-2">
            <span id="jumlah-siswa">{{ $tunggakan->count() }}</span> Siswa
        </span>
    </div>

    @if(session('error'))
    <div class="notif-error">
        <i class="bi bi-exclamation-triangle-fill"></i>
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
    <div class="notif-success">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- Filter Pencarian --}}
    <div class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" id="cari-nis" class="form-control search-input"
                placeholder="🔍 Cari NIS...">
        </div>
        <div class="col-md-4">
            <input type="text" id="cari-nama" class="form-control search-input"
                placeholder="🔍 Cari Nama Siswa...">
        </div>
        <div class="col-md-4 d-flex align-items-center">
            <button onclick="resetFilter()" class="btn btn-sm btn-outline-secondary text-white px-3">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
            </button>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0 table-custom" id="tabel-tunggakan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Bulan Nunggak</th>
                    <th>Total Tunggakan</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="tbody-tunggakan">
                @forelse($tunggakan as $siswa)
                <tr class="row-siswa"
                    data-nis="{{ strtolower($siswa->nis) }}"
                    data-nama="{{ strtolower($siswa->nama) }}">

                    <td class="text-white fw-semibold row-no">{{ $loop->iteration }}</td>

                    <td class="fw-semibold text-warning">
                        {{ $siswa->nis }}
                    </td>

                    <td class="fw-bold text-white">
                        {{ $siswa->nama }}
                    </td>

                    <td>
                        <span class="badge-kelas">
                            {{ $siswa->kelas->tingkat ?? '' }}
                            {{ $siswa->kelas->jurusan ?? '' }}
                            {{ $siswa->kelas->nomor_kelas ?? '' }}
                        </span>
                    </td>

                    <td class="text-soft">
                        {{ $bulanList[now()->month] }} {{ now()->year }}
                    </td>

                    <td class="fw-bold text-danger">
                        Rp {{ number_format($siswa->total_tunggakan, 0, ',', '.') }}
                    </td>

                    <td>
                        <span class="badge-danger-custom">Belum Bayar</span>
                    </td>

                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                           <a href="{{ route('petugas.tunggakan.detail', $siswa->tagihans->first()->id) }}" class="btn-detail">
                                <i class="bi bi-eye-fill"></i> Detail
                            </a>
                            {{-- Bayar langsung tagihan bulan ini --}}
                            @php
                                $tagihanBulanIni = $siswa->tagihans
                                    ->where('bulan', now()->month)
                                    ->where('status', 'belum_bayar')
                                    ->first();
                            @endphp
                            @if($tagihanBulanIni)
                            <a href="{{ route('petugas.bayar.page', $tagihanBulanIni->id) }}" class="btn-bayar">
                                <i class="bi bi-cash-coin"></i> Bayar
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr id="empty-row">
                    <td colspan="8" class="text-center py-5">
                        <i class="bi bi-emoji-smile-fill text-success d-block mb-2"
                           style="font-size:3rem"></i>
                        <div class="fw-bold text-white mb-1">Tidak Ada Tunggakan 🎉</div>
                        <small class="text-soft">Semua siswa sudah bayar bulan ini.</small>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pesan tidak ditemukan saat filter --}}
        <div id="tidak-ditemukan" class="text-center py-4 text-soft" style="display:none;">
            <i class="bi bi-search d-block mb-2" style="font-size:2rem"></i>
            Siswa tidak ditemukan.
        </div>
    </div>
</div>

<script>
    const inputNis  = document.getElementById('cari-nis');
    const inputNama = document.getElementById('cari-nama');

    function filterTabel() {
        const nis  = inputNis.value.toLowerCase().trim();
        const nama = inputNama.value.toLowerCase().trim();
        const rows = document.querySelectorAll('.row-siswa');

        let tampil = 0;
        let no = 1;

        rows.forEach(row => {
            const nisRow  = row.dataset.nis;
            const namaRow = row.dataset.nama;

            const cocok = nisRow.includes(nis) && namaRow.includes(nama);
            row.style.display = cocok ? '' : 'none';

            if (cocok) {
                row.querySelector('.row-no').textContent = no++;
                tampil++;
            }
        });

        document.getElementById('jumlah-siswa').textContent = tampil;
        document.getElementById('tidak-ditemukan').style.display = tampil === 0 ? 'block' : 'none';
    }

    function resetFilter() {
        inputNis.value  = '';
        inputNama.value = '';
        filterTabel();
    }

    inputNis.addEventListener('input', filterTabel);
    inputNama.addEventListener('input', filterTabel);
</script>

@endsection