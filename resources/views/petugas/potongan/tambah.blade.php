@extends('layouts.petugas')
@section('title', 'Tambah Potongan')
@section('content')

<style>
    .pay-wrap { max-width: 700px; margin: 0 auto; }
    .back-link {
        display:inline-flex; align-items:center; gap:8px;
        color:#94a3b8; font-size:13px; font-weight:600;
        text-decoration:none; margin-bottom:20px; padding:10px 18px;
        background:#1a233a; border:1px solid #2d4a8a; border-radius:10px; transition:.2s;
    }
    .back-link:hover { background:#1e3a6e; border-color:#3b82f6; color:#60a5fa; }
    .form-card {
        background:#1a233a; border:1px solid #2d4a8a;
        border-radius:18px; overflow:hidden;
        box-shadow:0 8px 32px rgba(0,0,0,.35);
    }
    .form-header {
        padding:22px 28px; border-bottom:1px solid #2d4a8a;
        display:flex; align-items:center; gap:14px;
    }
    .form-header-icon {
        width:46px; height:46px; border-radius:12px;
        display:flex; align-items:center; justify-content:center;
        font-size:22px; flex-shrink:0;
    }
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
    .form-control::placeholder { color:#475569; }
    .form-control:focus, .form-select:focus {
        outline:none; border-color:#3b82f6 !important;
        box-shadow:0 0 0 3px rgba(59,130,246,.1);
    }
    .form-select option { background:#0f172a; }
    .form-footer {
        padding:20px 28px; border-top:1px solid #1e3a6e;
        display:flex; justify-content:flex-end; gap:12px;
    }
    .btn-batal {
        background:transparent; border:1px solid #334155; color:#94a3b8;
        font-size:13px; font-weight:600; padding:11px 24px; border-radius:10px;
        text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:.2s;
    }
    .btn-batal:hover { border-color:#475569; color:#cbd5e1; }
    .divider { border-color:#1e3a6e; margin:22px 0; }
    .help-text { color:#475569; font-size:11px; margin-top:5px; }
    .notif-error {
        background:rgba(220,38,38,.15); border:1px solid #dc2626; color:#fca5a5;
        border-radius:10px; padding:12px 16px; margin-bottom:16px;
        display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600;
    }

    /* Kalkulasi (pemerintah) */
    .info-kalkulasi {
        background:#0f172a; border:1px solid #1e3a6e;
        border-radius:12px; padding:16px 20px; margin-top:12px; display:none;
    }
    .info-kalkulasi.show { display:block; }
    .kalkulasi-row {
        display:flex; justify-content:space-between; align-items:center;
        padding:8px 0; border-bottom:1px solid #1e3a6e; font-size:13px;
    }
    .kalkulasi-row:last-child { border-bottom:none; }
    .kalkulasi-label { color:#64748b; }
    .kalkulasi-value { color:#fff; font-weight:700; }
    .kalkulasi-highlight {
        background:rgba(74,222,128,.1); border:1px solid rgba(74,222,128,.3);
        border-radius:10px; padding:12px 16px; margin-top:10px;
        display:flex; justify-content:space-between; align-items:center;
    }
    .kalkulasi-highlight .label { color:#4ade80; font-size:13px; font-weight:700; }
    .kalkulasi-highlight .value { color:#4ade80; font-size:20px; font-weight:900; }

    /* Siswa search (prestasi) */
    .siswa-search-wrap { position:relative; }
    .siswa-search-wrap input { padding-left:38px !important; }
    .siswa-search-icon {
        position:absolute; left:12px; top:50%; transform:translateY(-50%);
        color:#475569; font-size:15px; pointer-events:none;
    }
    .siswa-dropdown {
        position:absolute; top:calc(100% + 4px); left:0; right:0; z-index:999;
        background:#0f172a; border:1px solid #3b82f6; border-radius:10px;
        max-height:220px; overflow-y:auto; display:none;
    }
    .siswa-dropdown.show { display:block; }
    .siswa-option {
        padding:10px 14px; cursor:pointer; border-bottom:1px solid #1e3a6e; transition:background .15s;
    }
    .siswa-option:last-child { border-bottom:none; }
    .siswa-option:hover { background:#1e3a6e; }
    .siswa-option .sname { color:#fff; font-size:13px; font-weight:700; }
    .siswa-option .snis  { color:#fbbf24; font-size:11px; }
    .siswa-option .skelas{ color:#64748b; font-size:11px; }
    .siswa-selected-box {
        background:rgba(59,130,246,.1); border:1px solid rgba(59,130,246,.3);
        border-radius:10px; padding:12px 16px; margin-top:10px;
        display:none; align-items:center; justify-content:space-between;
    }
    .siswa-selected-box.show { display:flex; }
    .siswa-selected-box .sname { color:#fff; font-weight:700; font-size:14px; }
    .siswa-selected-box .ssub  { color:#94a3b8; font-size:12px; }
    .btn-clear-siswa {
        background:rgba(220,38,38,.2); border:none; color:#fca5a5;
        border-radius:8px; padding:5px 10px; font-size:12px; cursor:pointer; flex-shrink:0;
    }
    .nominal-preview {
        background:rgba(74,222,128,.08); border:1px solid rgba(74,222,128,.25);
        border-radius:10px; padding:12px 16px; margin-top:10px;
        display:none; justify-content:space-between; align-items:center;
    }
    .nominal-preview.show { display:flex; }
    .nominal-preview .label { color:#4ade80; font-size:13px; font-weight:600; }
    .nominal-preview .value { color:#4ade80; font-size:18px; font-weight:900; }
</style>

<div class="pay-wrap">

    <a href="{{ route('petugas.potongan') }}" class="back-link">
        <i class="bi bi-arrow-left-circle-fill"></i> Kembali ke Daftar Potongan
    </a>

    @if(session('error'))
    <div class="notif-error">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
    </div>
    @endif

    <div class="form-card">

        <div class="form-header"
             style="background:linear-gradient(135deg,{{ $jenis=='prestasi' ? '#78350f,#1a233a' : '#0c4a6e,#1a233a' }})">
            <div class="form-header-icon"
                 style="background:{{ $jenis=='prestasi' ? 'rgba(245,158,11,.18)' : 'rgba(14,165,233,.18)' }};
                        color:{{ $jenis=='prestasi' ? '#fbbf24' : '#38bdf8' }}">
                <i class="bi bi-{{ $jenis=='prestasi' ? 'trophy-fill' : 'building-fill' }}"></i>
            </div>
            <div>
                <h5 class="text-white fw-bold mb-1" style="font-size:16px">
                    Tambah Potongan {{ $jenis == 'prestasi' ? 'Beasiswa / Lomba' : 'Bantuan Pemerintah' }}
                </h5>
                <small style="color:#64748b; font-size:12px;">
                    Isi form berikut untuk menambahkan potongan SPP
                </small>
            </div>
        </div>

        <form action="{{ route('petugas.potongan.store') }}" method="POST">
        @csrf
        <input type="hidden" name="jenis" value="{{ $jenis }}">

        <div class="form-body">

        @if($jenis == 'prestasi')
        {{-- ══════════════════════════════
             FORM LOMBA / BEASISWA
        ══════════════════════════════ --}}

        <input type="hidden" name="target_penerima" value="siswa_tertentu">
        <input type="hidden" name="siswa_id" id="siswaIdInput">

        {{-- 1. CARI SISWA --}}
        <div class="sec-title"><i class="bi bi-person-fill"></i> Siswa Penerima</div>

        <div class="mb-4">
            <label class="form-label">Cari Nama Siswa <span class="text-danger">*</span></label>
            <div class="siswa-search-wrap">
                <i class="bi bi-search siswa-search-icon"></i>
                <input type="text" id="siswaSearch" class="form-control"
                       placeholder="Ketik nama siswa..." autocomplete="off">
                <div class="siswa-dropdown" id="siswaDropdown">
                    @foreach($siswas as $s)
                    <div class="siswa-option"
                         data-id="{{ $s->id }}"
                         data-nama="{{ $s->nama }}"
                         data-nis="{{ $s->nis }}"
                         data-kelas="{{ ($s->kelas->tingkat ?? '') . ' ' . ($s->kelas->jurusan ?? '') . ' ' . ($s->kelas->nomor_kelas ?? '') }}">
                        <div class="sname">{{ $s->nama }}</div>
                        <div class="d-flex gap-2">
                            <span class="snis">{{ $s->nis }}</span>
                            <span class="skelas">· {{ ($s->kelas->tingkat ?? '') }} {{ ($s->kelas->jurusan ?? '') }} {{ ($s->kelas->nomor_kelas ?? '') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="siswa-selected-box" id="siswaSelectedBox">
                <div>
                    <div class="sname" id="siswaSelectedName"></div>
                    <div class="ssub" id="siswaSelectedSub"></div>
                </div>
                <button type="button" class="btn-clear-siswa" onclick="clearSiswa()">
                    <i class="bi bi-x-lg"></i> Ganti
                </button>
            </div>
            <div class="help-text"><i class="bi bi-info-circle me-1"></i>Ketik nama untuk mencari siswa</div>
        </div>

        <hr class="divider">

        {{-- 2. DETAIL LOMBA --}}
        <div class="sec-title"><i class="bi bi-trophy-fill"></i> Detail Lomba / Beasiswa</div>

        <div class="mb-3">
            <label class="form-label">Nama Juara / Lomba / Beasiswa <span class="text-danger">*</span></label>
            <input type="text" name="nama" class="form-control" required
                   placeholder="Contoh: Juara 1 Lomba Matematika Tingkat Kota">
        </div>

        <div class="mb-3">
            <label class="form-label">Nominal Potongan per Siswa (Rp) <span class="text-danger">*</span></label>
            <input type="number" name="nominal_potongan" id="nominalPotongan"
                   class="form-control" required placeholder="Contoh: 150000" min="1"
                   oninput="previewNominal(this.value)">
            <div class="nominal-preview" id="nominalPreview">
                <span class="label"><i class="bi bi-check-circle-fill me-1"></i> Siswa mendapat potongan</span>
                <span class="value" id="nominalPreviewVal">Rp 0</span>
            </div>
        </div>

        <hr class="divider">

        {{-- 3. PERIODE (PRESTASI = RANGE) --}}
        <div class="sec-title"><i class="bi bi-calendar-range-fill"></i> Periode Bulan Berlaku</div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Bulan Mulai <span class="text-danger">*</span></label>
                <select name="bulan_mulai" class="form-select" required>
                    <option value="">-- Pilih Bulan --</option>
                    @foreach($bulanList as $num => $nama)
                    <option value="{{ $num }}" {{ date('n') == $num ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tahun Mulai <span class="text-danger">*</span></label>
                <select name="tahun_mulai" class="form-select" required>
                    <option value="">-- Pilih Tahun --</option>
                    @foreach([2024,2025,2026,2027,2028] as $y)
                    <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
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
                    <option value="{{ $num }}">{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tahun Selesai <span class="text-danger">*</span></label>
                <select name="tahun_selesai" class="form-select" required>
                    <option value="">-- Pilih Tahun --</option>
                    @foreach([2024,2025,2026,2027,2028] as $y)
                    <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr class="divider">

        {{-- 4. KETERANGAN --}}
        <div class="sec-title"><i class="bi bi-chat-left-text-fill"></i> Keterangan</div>

        <div class="mb-2">
            <label class="form-label">Keterangan <span style="color:#475569;font-weight:400">(opsional)</span></label>
            <textarea name="keterangan" class="form-control" rows="3"
                      placeholder="Contoh: Piala tingkat kota, sertifikat terlampir"
                      style="resize:vertical"></textarea>
        </div>

        @else
        {{-- ══════════════════════════════
             FORM BANTUAN PEMERINTAH
        ══════════════════════════════ --}}

        {{-- 1. PILIH TARGET PENERIMA --}}
        <div class="sec-title"><i class="bi bi-people-fill"></i> Pilih Target Penerima</div>

        <div class="mb-4">
            <label class="form-label">Potongan ini Untuk Siapa? <span class="text-danger">*</span></label>
            <select name="target_penerima" class="form-select" id="targetPenerima" required>
                <option value="">-- Pilih Target Penerima --</option>
                <option value="semua">Untuk Semua Kelas</option>
                <option value="10">Untuk Semua Kelas 10</option>
                <option value="11">Untuk Semua Kelas 11</option>
                <option value="12">Untuk Semua Kelas 12</option>
            </select>
        </div>

        <hr class="divider">

        {{-- 2. DETAIL POTONGAN --}}
        <div class="sec-title"><i class="bi bi-building-fill"></i> Detail Potongan</div>

        <div class="mb-3">
            <label class="form-label">Nama Potongan <span class="text-danger">*</span></label>
            <input type="text" name="nama" class="form-control" required
                   placeholder="Contoh: KIP / PKH / BSM / BOS">
        </div>

        <div class="mb-3">
            <label class="form-label">
                Total Dana Bantuan yang Diterima SMK (Rp)
                <span style="color:#64748b; font-weight:400">(opsional)</span>
            </label>
            <input type="number" id="totalDana" class="form-control"
                   placeholder="Contoh: 1000000" min="0">
            <div class="help-text">Isi total dana → nominal per siswa otomatis terhitung</div>
        </div>

        <div class="mb-4">
            <label class="form-label">Nominal Potongan per Siswa (Rp) <span class="text-danger">*</span></label>
            <input type="number" name="nominal_potongan" id="nominalPotongan"
                   class="form-control" required placeholder="Contoh: 50000" min="1">
        </div>

        <div class="info-kalkulasi" id="boxKalkulasi">
            <div style="color:#60a5fa; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;">
                <i class="bi bi-calculator me-1"></i> Ringkasan Kalkulasi
            </div>
            <div class="kalkulasi-row">
                <span class="kalkulasi-label">Total Dana Masuk ke SMK</span>
                <span class="kalkulasi-value" id="showTotalDana">Rp 0</span>
            </div>
            <div class="kalkulasi-highlight">
                <span class="label"><i class="bi bi-check-circle-fill me-1"></i> Masing-masing siswa mendapat potongan</span>
                <span class="value" id="showHighlight">Rp 0</span>
            </div>
        </div>

        <hr class="divider">

        {{-- 3. PERIODE (PEMERINTAH = 1 BULAN SAJA) --}}
        <div class="sec-title"><i class="bi bi-calendar-fill"></i> Bulan Berlaku</div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Bulan <span class="text-danger">*</span></label>
                <select name="bulan_mulai" class="form-select" required>
                    <option value="">-- Pilih Bulan --</option>
                    @foreach($bulanList as $num => $nama)
                    <option value="{{ $num }}" {{ date('n') == $num ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tahun <span class="text-danger">*</span></label>
                <select name="tahun_mulai" class="form-select" required>
                    <option value="">-- Pilih Tahun --</option>
                    @foreach([2024,2025,2026,2027,2028] as $y)
                    <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Hidden: bulan_selesai & tahun_selesai diisi otomatis via JS saat submit --}}
        <input type="hidden" name="bulan_selesai" id="bulanSelesaiHidden">
        <input type="hidden" name="tahun_selesai" id="tahunSelesaiHidden">

        <div class="mb-2">
            <label class="form-label">
                Keterangan <span style="color:#475569; font-weight:400">(opsional)</span>
            </label>
            <input type="text" name="keterangan" class="form-control"
                   placeholder="Contoh: Penerima KIP tahun 2026">
        </div>

        @endif

        </div>{{-- end form-body --}}

        <div class="form-footer">
            <a href="{{ route('petugas.potongan') }}" class="btn-batal">
                <i class="bi bi-x-circle"></i> Batal
            </a>
            <button type="submit"
                    style="background:{{ $jenis=='prestasi' ? 'linear-gradient(135deg,#f59e0b,#d97706)' : 'linear-gradient(135deg,#0ea5e9,#0284c7)' }};
                           border:none; color:#fff; font-size:14px; font-weight:700;
                           padding:11px 28px; border-radius:10px; cursor:pointer;
                           display:inline-flex; align-items:center; gap:8px;">
                <i class="bi bi-plus-circle-fill"></i> Simpan Potongan
            </button>
        </div>

        </form>
    </div>
</div>

<script>
@if($jenis == 'prestasi')
const allSiswas    = Array.from(document.querySelectorAll('.siswa-option'));
const searchInput  = document.getElementById('siswaSearch');
const dropdown     = document.getElementById('siswaDropdown');
const siswaIdInput = document.getElementById('siswaIdInput');
const selectedBox  = document.getElementById('siswaSelectedBox');

searchInput.addEventListener('input', function() {
    const q = this.value.toLowerCase().trim();
    let hasVisible = false;
    allSiswas.forEach(opt => {
        const match = opt.dataset.nama.toLowerCase().includes(q)
                   || opt.dataset.nis.toLowerCase().includes(q)
                   || opt.dataset.kelas.toLowerCase().includes(q);
        opt.style.display = match ? '' : 'none';
        if (match) hasVisible = true;
    });
    dropdown.classList.toggle('show', q.length > 0 && hasVisible);
});

allSiswas.forEach(opt => {
    opt.addEventListener('click', function() {
        siswaIdInput.value = this.dataset.id;
        searchInput.value  = '';
        dropdown.classList.remove('show');
        document.getElementById('siswaSelectedName').textContent = this.dataset.nama;
        document.getElementById('siswaSelectedSub').textContent  =
            'NIS: ' + this.dataset.nis + '  ·  Kelas: ' + this.dataset.kelas.trim();
        selectedBox.classList.add('show');
        searchInput.closest('.siswa-search-wrap').style.display = 'none';
    });
});

function clearSiswa() {
    siswaIdInput.value = '';
    selectedBox.classList.remove('show');
    searchInput.closest('.siswa-search-wrap').style.display = '';
    searchInput.value = '';
    searchInput.focus();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.siswa-search-wrap')) dropdown.classList.remove('show');
});

function previewNominal(val) {
    const n   = parseInt(val) || 0;
    const box = document.getElementById('nominalPreview');
    document.getElementById('nominalPreviewVal').textContent = 'Rp ' + n.toLocaleString('id-ID');
    box.classList.toggle('show', n > 0);
}

@else
function formatRupiah(n) { return 'Rp ' + n.toLocaleString('id-ID'); }

function hitungOtomatis() {
    const totalDana = parseInt(document.getElementById('totalDana').value) || 0;
    const nominal   = parseInt(document.getElementById('nominalPotongan').value) || 0;
    const box       = document.getElementById('boxKalkulasi');
    if (totalDana <= 0 && nominal <= 0) { box.classList.remove('show'); return; }
    box.classList.add('show');
    document.getElementById('showTotalDana').textContent = formatRupiah(totalDana);
    document.getElementById('showHighlight').textContent = formatRupiah(nominal);
}

document.getElementById('totalDana').addEventListener('input', hitungOtomatis);
document.getElementById('nominalPotongan').addEventListener('input', hitungOtomatis);

// Sync bulan_selesai = bulan_mulai saat submit (HARUS di luar hitungOtomatis)
document.querySelector('form').addEventListener('submit', function() {
    const bm = document.querySelector('select[name="bulan_mulai"]').value;
    const tm = document.querySelector('select[name="tahun_mulai"]').value;
    document.getElementById('bulanSelesaiHidden').value = bm;
    document.getElementById('tahunSelesaiHidden').value = tm;
});
@endif
</script>

@endsection