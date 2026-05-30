@extends('layouts.siswa')
@section('title', 'Ringkasan Pembayaran')
@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show py-2 small">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<style>
.ringkasan-card {
    background: linear-gradient(135deg, #0d2240 0%, #0a1a2e 100%);
    border: 1px solid rgba(34,86,136,0.6);
    border-radius: 16px;
    padding: 24px;
}
.section-title {
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #A9CBE0;
    margin-bottom: 16px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(169,203,224,0.15);
    display: flex;
    align-items: center;
    gap: 8px;
}
.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 9px 0;
    border-bottom: 1px solid rgba(169,203,224,0.07);
    font-size: 13px;
}
.info-row:last-child { border-bottom: none; }
.info-label { color: #668CA9; }
.info-value { color: #e2e8f0; font-weight: 500; }
.potongan-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(16,185,129,0.08);
    border: 1px solid rgba(16,185,129,0.2);
    border-radius: 8px;
    padding: 8px 12px;
    margin-bottom: 6px;
}
.potongan-nama { color: #fbbf24; font-weight: 600; font-size: 12px; }
.potongan-nominal { color: #10b981; font-weight: 700; font-size: 13px; }
.total-box {
    background: linear-gradient(90deg, rgba(29,78,216,0.3), rgba(29,78,216,0.1));
    border: 1px solid rgba(29,78,216,0.5);
    border-radius: 10px;
    padding: 14px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 16px;
}
.total-label { color: #A9CBE0; font-size: 13px; font-weight: 600; }
.total-value { color: #60a5fa; font-size: 20px; font-weight: 800; }
.metode-terpilih-box {
    background: rgba(9,44,86,0.6);
    border: 1px solid rgba(34,86,136,0.5);
    border-radius: 10px;
    padding: 12px 14px;
    margin-bottom: 16px;
}
.metode-terpilih-label { font-size: 11px; color: #668CA9; margin-bottom: 4px; }
.metode-terpilih-value { color: #60a5fa; font-weight: 700; font-size: 14px; }
.metode-radio-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 12px; }
.metode-radio-label {
    display: flex;
    align-items: center;
    gap: 12px;
    background: rgba(9,44,86,0.5);
    border: 1px solid rgba(34,86,136,0.4);
    border-radius: 10px;
    padding: 12px 14px;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 13px;
}
.metode-radio-label:hover {
    border-color: rgba(59,130,246,0.6);
    background: rgba(29,78,216,0.15);
}
.metode-radio-label:has(input:checked) {
    border-color: rgba(59,130,246,0.8);
    background: rgba(29,78,216,0.25);
}
.metode-radio-label input[type=radio] { accent-color: #3b82f6; width: 16px; height: 16px; flex-shrink: 0; }
.metode-info-nama { font-weight: 700; color: #e2e8f0; font-size: 13px; }
.metode-info-rek { font-size: 11px; color: #668CA9; margin-top: 2px; }
.info-rekening-box {
    display: none;
    background: rgba(59,130,246,0.1);
    border: 1px solid rgba(59,130,246,0.4);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 16px;
    animation: fadeIn 0.3s ease;
}
.info-rekening-box.show { display: block; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: translateY(0); } }
.rek-title { font-size: 11px; color: #60a5fa; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: flex; align-items: center; gap: 6px; }
.rek-row { display: flex; justify-content: space-between; align-items: center; padding: 7px 0; border-bottom: 1px solid rgba(59,130,246,0.15); font-size: 13px; }
.rek-row:last-child { border-bottom: none; }
.rek-key { color: #668CA9; }
.rek-val { color: #e2e8f0; font-weight: 600; }
.rek-nominal { color: #60a5fa; font-size: 18px; font-weight: 800; }
.upload-area {
    border: 2px dashed rgba(169,203,224,0.3);
    border-radius: 10px;
    padding: 16px;
    text-align: center;
    margin-bottom: 14px;
    transition: border-color 0.2s;
}
.upload-area:hover { border-color: rgba(169,203,224,0.6); }
.btn-kirim {
    background: linear-gradient(90deg, #1d4ed8, #2563eb);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 11px;
    font-size: 13px;
    font-weight: 700;
    width: 100%;
    cursor: pointer;
    transition: opacity 0.2s;
}
.btn-kirim:hover { opacity: 0.9; }
.btn-kembali {
    display: block;
    text-align: center;
    margin-top: 12px;
    color: #668CA9;
    font-size: 12px;
    text-decoration: none;
    padding: 8px;
    border: 1px solid rgba(169,203,224,0.2);
    border-radius: 8px;
    transition: all 0.2s;
}
.btn-kembali:hover { color: #A9CBE0; border-color: rgba(169,203,224,0.4); }
</style>

<div class="row g-4">

    {{-- ===== KIRI: RINGKASAN TAGIHAN ===== --}}
    <div class="col-md-5">
        <div class="ringkasan-card">
            <div class="section-title">
                <i class="bi bi-receipt"></i> Ringkasan Tagihan
            </div>

            <div class="info-row">
                <span class="info-label">Bulan</span>
                <span class="info-value">{{ $bulanList[$tagihan->bulan] }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tahun Ajaran</span>
                <span class="info-value">{{ $tagihan->tahunAjaran->nama ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Nominal SPP</span>
                <span class="info-value">Rp {{ number_format($tagihan->nominal_awal, 0, ',', '.') }}</span>
            </div>

            {{-- Potongan --}}
            <div style="margin: 14px 0 6px">
                <div style="font-size:11px;color:#668CA9;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px">
                    Potongan Diperoleh
                </div>
                @if($potonganAktif->count() > 0)
                    @foreach($potonganAktif as $pot)
                    <div class="potongan-item">
                        <div>
                            <div class="potongan-nama"><i class="bi bi-tag-fill me-1"></i>{{ $pot->nama }}</div>
                            <div style="font-size:10px;color:#94a3b8;margin-top:2px">{{ ucfirst($pot->jenis ?? '') }}</div>
                        </div>
                        <div class="potongan-nominal">-Rp {{ number_format($pot->nominal_potongan, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                @else
                    <div style="font-size:12px;color:#475569;font-style:italic;padding:6px 0">Tidak ada potongan</div>
                @endif
            </div>

            {{-- Kalkulasi --}}
            @if($totalPotongan > 0)
            <div style="border-top:1px dashed rgba(169,203,224,0.2);padding-top:10px;margin-top:6px">
                <div class="info-row">
                    <span class="info-label">Nominal Awal</span>
                    <span class="info-value">Rp {{ number_format($tagihan->nominal_awal, 0, ',', '.') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total Potongan</span>
                    <span style="color:#10b981;font-weight:600">-Rp {{ number_format($totalPotongan, 0, ',', '.') }}</span>
                </div>
            </div>
            @endif

            <div class="total-box">
                <span class="total-label"><i class="bi bi-wallet2 me-2"></i>Total Wajib Bayar</span>
                <span class="total-value">Rp {{ number_format($tagihan->nominal_bayar, 0, ',', '.') }}</span>
            </div>

            <a href="{{ route('siswa.tagihan') }}" class="btn-kembali">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Tagihan
            </a>
        </div>
    </div>

    {{-- ===== KANAN: METODE / UPLOAD ===== --}}
    <div class="col-md-7">
        <div class="ringkasan-card">

            @if(!$pembayaran || !$pembayaran->metode_bayar)

            {{-- ===== PILIH METODE ===== --}}
            <div class="section-title">
                <i class="bi bi-credit-card-2-front"></i> Pilih Metode Pembayaran
            </div>

            @if($metodePembayarans->count() > 0)

            <div id="metodeData" style="display:none">
                @foreach($metodePembayarans as $m)
                <span
                    data-id="{{ $m->id }}"
                    data-nama="{{ $m->nama }}"
                    data-rek="{{ $m->no_rekening ?? '-' }}"
                    data-atasnama="{{ $m->atas_nama ?? '-' }}">
                </span>
                @endforeach
            </div>

            <form action="{{ route('siswa.tagihan.simpan-metode', $tagihan->id) }}" method="POST">
                @csrf
                <div class="metode-radio-group">
                    @foreach($metodePembayarans as $metode)
                    <label class="metode-radio-label">
                        <input type="radio" name="metode_bayar" value="{{ $metode->id }}"
                               onchange="tampilInfoRek({{ $metode->id }})" required>
                        <div style="flex:1">
                            <div class="metode-info-nama">
                                <i class="bi bi-bank me-1"></i>{{ $metode->nama }}
                            </div>
                            @if($metode->no_rekening)
                            <div class="metode-info-rek">
                                {{ $metode->no_rekening }}
                                @if($metode->atas_nama) — a/n {{ $metode->atas_nama }} @endif
                            </div>
                            @endif
                        </div>
                    </label>
                    @endforeach
                </div>

                {{-- Info rekening muncul setelah pilih --}}
                <div class="info-rekening-box" id="infoRekeningBox">
                    <div class="rek-title">
                        <i class="bi bi-info-circle-fill"></i> Info Transfer
                    </div>
                    <div class="rek-row">
                        <span class="rek-key">Bank / Metode</span>
                        <span class="rek-val" id="rekNama">-</span>
                    </div>
                    <div class="rek-row">
                        <span class="rek-key">No. Rekening</span>
                        <span class="rek-val" id="rekNoRek">-</span>
                    </div>
                    <div class="rek-row">
                        <span class="rek-key">Atas Nama</span>
                        <span class="rek-val" id="rekAtasNama">-</span>
                    </div>
                    <div class="rek-row" style="margin-top:8px;padding-top:8px;border-top:1px solid rgba(59,130,246,0.3)">
                        <span class="rek-key">Nominal Transfer</span>
                        <span class="rek-nominal">Rp {{ number_format($tagihan->nominal_bayar, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="p-3 rounded mb-3" style="background:rgba(251,191,36,0.08);border:1px solid rgba(251,191,36,0.2)">
                    <div style="font-size:12px;color:#fbbf24;font-weight:600;margin-bottom:6px">
                        <i class="bi bi-info-circle me-1"></i>Petunjuk
                    </div>
                    <ol style="font-size:12px;color:#94a3b8;padding-left:16px;margin:0;line-height:1.8">
                        <li>Pilih metode transfer di atas</li>
                        <li>Transfer sesuai nominal yang tertera</li>
                        <li>Simpan bukti transfer</li>
                        <li>Upload bukti pada langkah berikutnya</li>
                    </ol>
                </div>

                <button type="submit" class="btn-kirim">
                    <i class="bi bi-check-circle me-2"></i>Konfirmasi Metode Pembayaran
                </button>
            </form>

            @else
            <div class="text-center py-4" style="color:#668CA9">
                <i class="bi bi-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>
                <div style="font-size:13px">Belum ada metode pembayaran tersedia.</div>
                <div style="font-size:12px;color:#475569;margin-top:4px">Hubungi admin/petugas sekolah.</div>
            </div>
            @endif

            @else

            {{-- ===== UPLOAD BUKTI (tanpa countdown) ===== --}}
            <div class="section-title">
                <i class="bi bi-cloud-arrow-up"></i> Upload Bukti Transfer
            </div>

            <div class="metode-terpilih-box">
                <div class="metode-terpilih-label">Metode Pembayaran Terpilih</div>
                <div class="metode-terpilih-value">
                    <i class="bi bi-bank me-2"></i>{{ $pembayaran->metode_bayar }}
                </div>
            </div>

            <div class="p-3 rounded mb-3" style="background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.2)">
                <div style="font-size:11px;color:#668CA9;margin-bottom:4px">Nominal yang harus ditransfer</div>
                <div style="font-size:22px;font-weight:800;color:#60a5fa">
                    Rp {{ number_format($tagihan->nominal_bayar, 0, ',', '.') }}
                </div>
            </div>

            <form action="{{ route('siswa.tagihan.upload', $tagihan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="upload-area">
                    <i class="bi bi-cloud-arrow-up" style="font-size:28px;color:#668CA9;display:block;margin-bottom:8px"></i>
                    <div style="font-size:12px;color:#94a3b8;margin-bottom:10px">Klik untuk pilih foto bukti transfer</div>
                    <input type="file" name="bukti_transfer" id="fileInput"
                           style="display:none" accept="image/*" required
                           onchange="previewFile(this)">
                    <label for="fileInput"
                           style="background:#1d4ed8;color:white;border:none;border-radius:6px;padding:6px 16px;cursor:pointer;font-size:12px;display:inline-block">
                        <i class="bi bi-folder2-open me-1"></i>Pilih File
                    </label>
                    <div id="fileName" style="margin-top:8px;font-size:11px;color:#60a5fa"></div>
                </div>
                <small style="display:block;color:#475569;font-size:11px;margin-bottom:14px">
                    <i class="bi bi-info-circle me-1"></i>Format: JPG, JPEG, PNG — Maks. 2MB
                </small>
                <button type="submit" class="btn-kirim">
                    <i class="bi bi-cloud-arrow-up-fill me-2"></i>Kirim Bukti Pembayaran
                </button>
            </form>

            @endif
        </div>
    </div>
</div>

<script>
var metodeMap = {};
document.querySelectorAll('#metodeData span').forEach(function(el) {
    metodeMap[el.dataset.id] = {
        nama:     el.dataset.nama,
        rek:      el.dataset.rek,
        atasNama: el.dataset.atasnama,
    };
});

function tampilInfoRek(id) {
    var data = metodeMap[id];
    if (!data) return;
    document.getElementById('rekNama').textContent     = data.nama;
    document.getElementById('rekNoRek').textContent    = data.rek;
    document.getElementById('rekAtasNama').textContent = data.atasNama;
    var box = document.getElementById('infoRekeningBox');
    box.classList.remove('show');
    void box.offsetWidth;
    box.classList.add('show');
}

function previewFile(input) {
    document.getElementById('fileName').textContent = input.files[0] ? '✅ ' + input.files[0].name : '';
}
</script>

@endsection