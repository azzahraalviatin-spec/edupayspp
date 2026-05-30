@extends('layouts.petugas')
@section('title', 'Edit Potongan')
@section('content')

<style>
    .pay-wrap { max-width: 680px; margin: 0 auto; }
    .back-link {
        display:inline-flex; align-items:center; gap:8px; color:#94a3b8;
        font-size:13px; font-weight:600; text-decoration:none; margin-bottom:20px;
        padding:10px 18px; background:#1a233a; border:1px solid #2d4a8a;
        border-radius:10px; transition:.2s;
    }
    .back-link:hover { background:#1e3a6e; border-color:#3b82f6; color:#60a5fa; }
    .form-card {
        background:#1a233a; border:1px solid #2d4a8a;
        border-radius:18px; overflow:hidden; box-shadow:0 8px 32px rgba(0,0,0,.35);
    }
    .form-header { padding:22px 28px; border-bottom:1px solid #2d4a8a; display:flex; align-items:center; gap:14px; }
    .form-body { padding:28px; }
    .sec-title {
        color:#60a5fa; font-size:11px; font-weight:700;
        text-transform:uppercase; letter-spacing:1px;
        margin-bottom:14px; display:flex; align-items:center; gap:8px;
    }
    .sec-title::after { content:''; flex:1; height:1px; background:#1e3a6e; }
    .form-label { color:#cbd5e1; font-size:13px; font-weight:600; margin-bottom:6px; display:block; }
    .form-control, .form-select {
        background:#0f172a !important; border:1px solid #334155 !important;
        color:#fff !important; border-radius:10px; padding:11px 14px;
        font-size:14px; width:100%; transition:border-color .2s;
    }
    .form-control:focus, .form-select:focus { outline:none; border-color:#3b82f6 !important; box-shadow:0 0 0 3px rgba(59,130,246,.1); }
    .form-control::placeholder { color:#334155; }
    .form-select option { background:#0f172a; }
    .form-footer { padding:20px 28px; border-top:1px solid #1e3a6e; display:flex; justify-content:flex-end; gap:12px; }
    .btn-batal {
        background:transparent; border:1px solid #334155; color:#94a3b8;
        font-size:13px; font-weight:600; padding:11px 24px; border-radius:10px;
        text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:.2s;
    }
    .btn-batal:hover { border-color:#475569; color:#cbd5e1; }
    .siswa-readonly {
        background:#131c31 !important; border:1px solid #1e3a6e !important;
        color:#94a3b8 !important; cursor:not-allowed;
    }
    .target-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:4px; }
    .target-card {
        background:#0f172a; border:2px solid #1e3a6e;
        border-radius:12px; padding:14px 16px; cursor:pointer;
        transition:.2s; display:flex; align-items:center; gap:10px;
    }
    .target-card:hover { border-color:#3b82f6; }
    .target-card.selected { border-color:#3b82f6; background:rgba(59,130,246,.1); }
    .target-icon {
        width:36px; height:36px; border-radius:9px;
        display:flex; align-items:center; justify-content:center;
        font-size:16px; flex-shrink:0;
    }
    .target-label { color:#fff; font-size:13px; font-weight:700; }
    .target-sub { color:#64748b; font-size:11px; margin-top:2px; }
    .target-card.selected .target-label { color:#60a5fa; }
    .notif-error {
        background:rgba(220,38,38,.15); border:1px solid #dc2626; color:#fca5a5;
        border-radius:10px; padding:12px 16px; margin-bottom:16px;
        display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600;
    }
</style>

@php
$bulanList = [
    1=>'Januari', 2=>'Februari', 3=>'Maret',    4=>'April',
    5=>'Mei',     6=>'Juni',     7=>'Juli',      8=>'Agustus',
    9=>'September',10=>'Oktober',11=>'November', 12=>'Desember'
];
$isPemerintah = $potongan->jenis === 'pemerintah';
$defaultTarget = $isPemerintah ? 'semua' : 'satu';
@endphp

<div class="pay-wrap">

    <a href="{{ route('petugas.potongan') }}" class="back-link">
        <i class="bi bi-arrow-left-circle-fill"></i> Kembali ke Daftar Potongan
    </a>

    @if(session('error'))
    <div class="notif-error"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>
    @endif

    <div class="form-card">

        <div class="form-header" style="background:linear-gradient(135deg,{{ $isPemerintah ? '#0c4a6e,#1a233a' : '#78350f,#1a233a' }})">
            <div style="width:46px; height:46px; border-radius:12px; flex-shrink:0;
                        display:flex; align-items:center; justify-content:center; font-size:22px;
                        background:{{ $isPemerintah ? 'rgba(14,165,233,.18)' : 'rgba(245,158,11,.18)' }};
                        color:{{ $isPemerintah ? '#38bdf8' : '#fbbf24' }}">
                <i class="bi bi-pencil-fill"></i>
            </div>
            <div>
                <h5 class="text-white fw-bold mb-1" style="font-size:16px">Edit Potongan SPP</h5>
                <small style="color:#64748b;">
                    {{ $isPemerintah ? 'Bantuan Pemerintah — update bisa massal per kelas' : 'Prestasi/Lomba — update untuk siswa ini' }}
                </small>
            </div>
        </div>

        <form action="{{ route('petugas.potongan.update', [$siswa->id, $potongan->id]) }}" method="POST">
        @csrf @method('PUT')
        <input type="hidden" name="update_target" id="updateTargetInput" value="{{ $defaultTarget }}">

        @if($isPemerintah)
        {{-- Hidden: bulan_selesai = bulan_mulai, diisi via JS saat submit --}}
        <input type="hidden" name="bulan_selesai" id="bulanSelesaiHidden" value="{{ $pivot->bulan_mulai }}">
        <input type="hidden" name="tahun_selesai" id="tahunSelesaiHidden" value="{{ $pivot->tahun_mulai }}">
        @endif

        <div class="form-body">

            {{-- INFO SISWA --}}
            <div class="sec-title"><i class="bi bi-person-fill"></i> Siswa</div>
            <div class="mb-4">
                <label class="form-label">Nama Siswa</label>
                <input type="text" class="form-control siswa-readonly"
                       value="{{ $siswa->nama }} — {{ $siswa->kelas->tingkat ?? '' }} {{ $siswa->kelas->jurusan ?? '' }}"
                       readonly>
                <small style="color:#475569; font-size:11px;">
                    {{ $isPemerintah ? 'Pilih scope update di bawah untuk update massal' : 'Siswa tidak bisa diubah' }}
                </small>
            </div>

            <hr style="border-color:#1e3a6e; margin-bottom:20px;">

            {{-- DETAIL POTONGAN --}}
            <div class="sec-title"><i class="bi bi-scissors"></i> Detail Potongan</div>

            <div class="mb-3">
                <label class="form-label">Jenis Potongan</label>
                <select name="jenis" class="form-select" required>
                    <option value="pemerintah" {{ $potongan->jenis != 'prestasi' ? 'selected' : '' }}>Bantuan Pemerintah</option>
                    <option value="prestasi"   {{ $potongan->jenis == 'prestasi' ? 'selected' : '' }}>Prestasi / Lomba</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Potongan <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control" required value="{{ $potongan->nama }}">
            </div>

            <div class="mb-4">
                <label class="form-label">Nominal Potongan (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="nominal_potongan" class="form-control" required
                       value="{{ $potongan->nominal_potongan }}" min="1">
            </div>

            <hr style="border-color:#1e3a6e; margin-bottom:20px;">

            {{-- PERIODE --}}
            @if($isPemerintah)
            {{-- PEMERINTAH = 1 BULAN SAJA --}}
            <div class="sec-title"><i class="bi bi-calendar-fill"></i> Bulan Berlaku</div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Bulan <span class="text-danger">*</span></label>
                    <select name="bulan_mulai" class="form-select" required>
                        <option value="">-- Pilih Bulan --</option>
                        @foreach($bulanList as $num => $nama)
                        <option value="{{ $num }}" {{ $pivot->bulan_mulai == $num ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tahun <span class="text-danger">*</span></label>
                    <select name="tahun_mulai" class="form-select" required>
                        <option value="">-- Pilih Tahun --</option>
                        @foreach([2024,2025,2026,2027,2028] as $y)
                        <option value="{{ $y }}" {{ $pivot->tahun_mulai == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @else
            {{-- PRESTASI = RANGE --}}
            <div class="sec-title"><i class="bi bi-calendar-range-fill"></i> Periode Berlaku</div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Bulan Mulai <span class="text-danger">*</span></label>
                    <select name="bulan_mulai" class="form-select" required>
                        <option value="">-- Pilih Bulan --</option>
                        @foreach($bulanList as $num => $nama)
                        <option value="{{ $num }}" {{ $pivot->bulan_mulai == $num ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tahun Mulai <span class="text-danger">*</span></label>
                    <select name="tahun_mulai" class="form-select" required>
                        <option value="">-- Pilih Tahun --</option>
                        @foreach([2024,2025,2026,2027,2028] as $y)
                        <option value="{{ $y }}" {{ $pivot->tahun_mulai == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Bulan Selesai <span class="text-danger">*</span></label>
                    <select name="bulan_selesai" class="form-select" required>
                        <option value="">-- Pilih Bulan --</option>
                        @foreach($bulanList as $num => $nama)
                        <option value="{{ $num }}" {{ $pivot->bulan_selesai == $num ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tahun Selesai <span class="text-danger">*</span></label>
                    <select name="tahun_selesai" class="form-select" required>
                        <option value="">-- Pilih Tahun --</option>
                        @foreach([2024,2025,2026,2027,2028] as $y)
                        <option value="{{ $y }}" {{ $pivot->tahun_selesai == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif

            <div class="mb-4">
                <label class="form-label">Keterangan <span style="color:#475569;font-weight:400">(opsional)</span></label>
                <input type="text" name="keterangan" class="form-control"
                       value="{{ $pivot->keterangan }}" placeholder="Keterangan tambahan">
            </div>

            {{-- SCOPE UPDATE — hanya tampil untuk pemerintah --}}
            @if($isPemerintah)
            <hr style="border-color:#1e3a6e; margin-bottom:20px;">

            <div class="sec-title"><i class="bi bi-people-fill"></i> Update Untuk Siapa?</div>
            <p style="color:#64748b; font-size:12px; margin-bottom:14px;">
                Pilih kelas mana yang periodenya ikut diperbarui.
            </p>

            <div class="target-grid">
                <div class="target-card {{ $defaultTarget=='semua'?'selected':'' }}" onclick="pilihTarget('semua', this)" style="grid-column:span 2;">
                    <div class="target-icon" style="background:rgba(16,185,129,.15); color:#6ee7b7;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <div class="target-label">Semua Kelas</div>
                        <div class="target-sub">{{ $jumlahPerKelas['semua'] }} siswa</div>
                    </div>
                </div>

                <div class="target-card" onclick="pilihTarget('10', this)">
                    <div class="target-icon" style="background:rgba(14,165,233,.15); color:#38bdf8;">
                        <i class="bi bi-building-fill"></i>
                    </div>
                    <div>
                        <div class="target-label">Kelas 10 Saja</div>
                        <div class="target-sub">{{ $jumlahPerKelas['10'] }} siswa</div>
                    </div>
                </div>

                <div class="target-card" onclick="pilihTarget('11', this)">
                    <div class="target-icon" style="background:rgba(245,158,11,.15); color:#fbbf24;">
                        <i class="bi bi-building-fill"></i>
                    </div>
                    <div>
                        <div class="target-label">Kelas 11 Saja</div>
                        <div class="target-sub">{{ $jumlahPerKelas['11'] }} siswa</div>
                    </div>
                </div>

                <div class="target-card" onclick="pilihTarget('12', this)" style="grid-column:span 2;">
                    <div class="target-icon" style="background:rgba(239,68,68,.15); color:#fca5a5;">
                        <i class="bi bi-building-fill"></i>
                    </div>
                    <div>
                        <div class="target-label">Kelas 12 Saja</div>
                        <div class="target-sub">{{ $jumlahPerKelas['12'] }} siswa</div>
                    </div>
                </div>
            </div>

            <div id="massalWarning" style="margin-top:12px;
                 background:rgba(234,179,8,.08); border:1px solid rgba(234,179,8,.25);
                 border-radius:10px; padding:12px 16px; color:#fbbf24; font-size:13px;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <span id="massalText">Perubahan ini akan diterapkan ke {{ $jumlahPerKelas['semua'] }} siswa (semua kelas) sekaligus.</span>
            </div>
            @endif

        </div>{{-- end form-body --}}

        <div class="form-footer">
            <a href="{{ route('petugas.potongan') }}" class="btn-batal">
                <i class="bi bi-x-circle"></i> Batal
            </a>
            <button type="submit"
                    style="background:linear-gradient(135deg,{{ $isPemerintah ? '#0ea5e9,#0284c7' : '#f59e0b,#d97706' }}); border:none; color:#fff;
                           font-size:14px; font-weight:700; padding:11px 28px; border-radius:10px;
                           cursor:pointer; display:inline-flex; align-items:center; gap:8px;">
                <i class="bi bi-check-circle-fill"></i> Simpan Perubahan
            </button>
        </div>

        </form>
    </div>
</div>

<script>
@if($isPemerintah)
const jumlah = {
    semua: {{ $jumlahPerKelas['semua'] }},
    '10':  {{ $jumlahPerKelas['10'] }},
    '11':  {{ $jumlahPerKelas['11'] }},
    '12':  {{ $jumlahPerKelas['12'] }},
};

function pilihTarget(val, el) {
    document.querySelectorAll('.target-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('updateTargetInput').value = val;

    const label = val === 'semua' ? 'semua kelas' : 'kelas ' + val;
    const jml   = val === 'semua' ? jumlah.semua : jumlah[val];
    document.getElementById('massalText').textContent =
        `Perubahan ini akan diterapkan ke ${jml} siswa (${label}) sekaligus.`;
}

// Sync bulan_selesai = bulan_mulai saat submit
document.querySelector('form').addEventListener('submit', function() {
    const bm = document.querySelector('select[name="bulan_mulai"]').value;
    const tm = document.querySelector('select[name="tahun_mulai"]').value;
    document.getElementById('bulanSelesaiHidden').value = bm;
    document.getElementById('tahunSelesaiHidden').value = tm;
});
@endif
</script>

@endsection