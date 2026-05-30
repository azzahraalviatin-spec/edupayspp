@extends('layouts.petugas')
@section('title', 'Verifikasi Pembayaran')
@section('content')

<style>
    .premium-card {
        background:#172036 !important;
        border:1px solid #2d4a8a !important;
        border-radius:16px;
        box-shadow:0 0 25px rgba(0,0,0,.25);
    }
    .payment-box {
        background:#101827;
        border:1px solid #263552;
        border-radius:14px;
        transition:.25s;
    }
    .payment-box:hover {
        border-color:#3b82f6;
        box-shadow:0 0 18px rgba(59,130,246,.15);
    }
    .text-light-muted { color:#94a3b8 !important; }
    .btn-konfirmasi {
        background:linear-gradient(135deg,#2563eb,#1d4ed8);
        border:none; color:#fff; font-weight:700; font-size:13px;
        padding:8px 14px; border-radius:9px; width:100%;
        display:inline-flex; align-items:center; justify-content:center;
        gap:6px; cursor:pointer; transition:.2s;
    }
    .btn-konfirmasi:hover { background:linear-gradient(135deg,#1d4ed8,#1e40af); transform:translateY(-1px); }
    .btn-tolak {
        background:rgba(220,38,38,.15);
        border:1px solid rgba(220,38,38,.3); color:#f87171; font-weight:700; font-size:13px;
        padding:8px 14px; border-radius:9px; width:100%;
        display:inline-flex; align-items:center; justify-content:center;
        gap:6px; cursor:pointer; transition:.2s;
    }
    .btn-tolak:hover { background:rgba(220,38,38,.3); color:#fca5a5; }
    .btn-konfirmasi-semua {
        background:linear-gradient(135deg,#059669,#047857);
        border:none; color:#fff; font-weight:700; font-size:13px;
        padding:10px 20px; border-radius:10px;
        display:inline-flex; align-items:center; gap:8px;
        cursor:pointer; transition:.2s; text-decoration:none;
    }
    .btn-konfirmasi-semua:hover {
        background:linear-gradient(135deg,#047857,#065f46);
        transform:translateY(-2px);
        box-shadow:0 6px 20px rgba(5,150,105,.35);
        color:#fff;
    }
    .pending-badge {
        background:rgba(234,179,8,.15); color:#fbbf24;
        border:1px solid rgba(234,179,8,.3);
        border-radius:20px; padding:4px 14px;
        font-size:12px; font-weight:700;
    }

    /* Bukti foto */
    .bukti-img {
        width:80px; height:80px; object-fit:cover;
        border-radius:10px; border:2px solid #334155;
        transition:.2s; cursor:pointer;
    }
    .bukti-img:hover { border-color:#3b82f6; transform:scale(1.05); }
    .btn-lihat-bukti {
        background:rgba(59,130,246,.15); border:1px solid rgba(59,130,246,.3);
        color:#60a5fa; font-size:11px; font-weight:700;
        padding:5px 10px; border-radius:8px; cursor:pointer;
        display:inline-flex; align-items:center; gap:4px;
        margin-top:6px; transition:.2s; width:100%; justify-content:center;
    }
    .btn-lihat-bukti:hover { background:rgba(59,130,246,.3); color:#fff; }

    /* Info label */
    .info-label { color:#64748b; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.5px; margin-bottom:3px; }
    .info-value { color:#fff; font-weight:700; font-size:14px; }
    .info-sub   { color:#94a3b8; font-size:12px; }

    /* Modal Bukti */
    .modal-bukti-overlay {
        display:none; position:fixed; inset:0; z-index:9999;
        background:rgba(0,0,0,.85); align-items:center; justify-content:center;
        backdrop-filter:blur(4px);
    }
    .modal-bukti-overlay.show { display:flex; }
    .modal-bukti-content {
        background:#172036; border:1px solid #2d4a8a;
        border-radius:16px; max-width:600px; width:90%;
        max-height:90vh; overflow:hidden;
        box-shadow:0 20px 60px rgba(0,0,0,.6);
        animation: popIn .2s ease;
    }
    @keyframes popIn { from { transform:scale(.9); opacity:0; } to { transform:scale(1); opacity:1; } }
    .modal-bukti-header {
        padding:16px 20px; border-bottom:1px solid #2d4a8a;
        display:flex; justify-content:space-between; align-items:center;
    }
    .modal-bukti-body { padding:20px; text-align:center; }
    .modal-bukti-img {
        max-width:100%; max-height:65vh; border-radius:10px;
        border:2px solid #334155; object-fit:contain;
    }
    .btn-close-modal {
        background:rgba(220,38,38,.2); border:1px solid rgba(220,38,38,.3);
        color:#fca5a5; border-radius:8px; padding:6px 12px;
        cursor:pointer; font-size:12px; font-weight:700;
        display:inline-flex; align-items:center; gap:4px;
    }
    .btn-close-modal:hover { background:rgba(220,38,38,.4); }
    .btn-buka-tab {
        background:rgba(59,130,246,.15); border:1px solid rgba(59,130,246,.3);
        color:#60a5fa; border-radius:8px; padding:6px 12px;
        cursor:pointer; font-size:12px; font-weight:700; text-decoration:none;
        display:inline-flex; align-items:center; gap:4px;
    }
    .btn-buka-tab:hover { background:rgba(59,130,246,.3); color:#fff; }
</style>

{{-- NOTIF --}}
@if(session('success'))
<div class="d-flex align-items-center gap-3 mb-4 px-4 py-3"
     style="background:rgba(5,150,105,.15);border:1px solid rgba(5,150,105,.3);border-radius:12px;color:#6ee7b7;font-weight:600">
    <i class="bi bi-check-circle-fill fs-5"></i>
    {{ session('success') }}
</div>
@endif

<div class="premium-card p-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h5 class="fw-bold text-white mb-1">
                <i class="bi bi-patch-check-fill text-warning me-2"></i>
                Verifikasi Pembayaran
            </h5>
            <div class="text-light-muted" style="font-size:12px">
                Periksa bukti transfer dan konfirmasi pembayaran siswa
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="pending-badge">
                <i class="bi bi-clock-fill me-1"></i>
                {{ $pending->count() }} Menunggu
            </span>
            @if($pending->count() > 0)
            <form action="{{ route('petugas.verifikasi.konfirmasi-semua') }}" method="POST"
                  onsubmit="return confirm('Konfirmasi SEMUA {{ $pending->count() }} pembayaran sekaligus? Pastikan sudah dicek buktinya!')">
                @csrf
                <button type="submit" class="btn-konfirmasi-semua">
                    <i class="bi bi-check-all"></i>
                    Konfirmasi Semua ({{ $pending->count() }})
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- LIST --}}
    <div style="max-height:680px; overflow-y:auto; padding-right:4px;">

        @forelse($pending as $bayar)
        <div class="payment-box p-4 mb-3">
            <div class="row align-items-center g-3">

                {{-- SISWA INFO --}}
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-3">
                        <div style="background:rgba(59,130,246,.15);padding:12px;border-radius:12px;flex-shrink:0">
                            <i class="bi bi-person-fill text-primary fs-5"></i>
                        </div>
                        <div>
                            <div class="info-value">{{ $bayar->tagihan->siswa->nama ?? '-' }}</div>
                            <div class="info-sub">NIS: {{ $bayar->tagihan->siswa->nis ?? '-' }}</div>
                            <div style="color:#38bdf8;font-size:12px;margin-top:2px">
                                {{ $bayar->tagihan->siswa->kelas->tingkat ?? '' }}
                                {{ $bayar->tagihan->siswa->kelas->jurusan ?? '' }}
                                {{ $bayar->tagihan->siswa->kelas->nomor_kelas ?? '' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- NOMINAL --}}
                <div class="col-md-3">
                    <div class="info-label">Jumlah Bayar</div>
                    <div style="color:#4ade80;font-size:18px;font-weight:800">
                        Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}
                    </div>
                    <div class="info-sub mt-1">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y') }}
                    </div>
                    @if($bayar->metode_bayar)
                    <div class="info-sub">
                        <i class="bi bi-credit-card me-1"></i>
                        {{ ucfirst($bayar->metode_bayar) }}
                    </div>
                    @endif
                    <div class="info-sub">
                        <i class="bi bi-clock me-1"></i>
                        {{ \Carbon\Carbon::parse($bayar->created_at)->diffForHumans() }}
                    </div>
                </div>

                {{-- BUKTI --}}
                <div class="col-md-2 text-center">
                    <div class="info-label mb-2">Bukti Transfer</div>
                    @if($bayar->bukti_transfer)
                        <img src="{{ asset('storage/' . $bayar->bukti_transfer) }}"
                             class="bukti-img"
                             onclick="lihatBukti('{{ asset('storage/' . $bayar->bukti_transfer) }}', '{{ $bayar->tagihan->siswa->nama ?? '' }}')"
                             title="Klik untuk perbesar">
                        <button class="btn-lihat-bukti"
                                onclick="lihatBukti('{{ asset('storage/' . $bayar->bukti_transfer) }}', '{{ $bayar->tagihan->siswa->nama ?? '' }}')">
                            <i class="bi bi-zoom-in"></i> Lihat Bukti
                        </button>
                    @else
                        <div style="background:rgba(100,116,139,.1);border:1px dashed #334155;border-radius:10px;padding:20px 10px">
                            <i class="bi bi-image text-muted d-block mb-1" style="font-size:24px"></i>
                            <span style="font-size:11px;color:#475569">Belum upload bukti</span>
                        </div>
                    @endif
                </div>

                {{-- AKSI --}}
                <div class="col-md-3">
                    <form action="{{ route('petugas.verifikasi.konfirmasi', $bayar) }}"
                          method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn-konfirmasi">
                            <i class="bi bi-check-circle-fill"></i> Konfirmasi
                        </button>
                    </form>
                    <button type="button" class="btn-tolak"
                            data-bs-toggle="modal"
                            data-bs-target="#modalTolak{{ $bayar->id }}">
                        <i class="bi bi-x-circle-fill"></i> Tolak
                    </button>
                </div>

            </div>
        </div>

        {{-- MODAL TOLAK --}}
        <div class="modal fade" id="modalTolak{{ $bayar->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background:#172036;border:1px solid #2d4a8a;border-radius:14px">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title text-white">
                            <i class="bi bi-x-circle-fill text-danger me-2"></i>
                            Tolak Pembayaran
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('petugas.verifikasi.tolak', $bayar) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3 p-3" style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:10px">
                                <div style="color:#f87171;font-size:13px;font-weight:600">
                                    {{ $bayar->tagihan->siswa->nama ?? '-' }}
                                </div>
                                <div style="color:#94a3b8;font-size:12px">
                                    Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}
                                </div>
                            </div>
                            <label class="form-label text-white" style="font-size:13px;font-weight:600">
                                Alasan Penolakan <span class="text-danger">*</span>
                            </label>
                            <textarea name="alasan_tolak" rows="4" required
                                      class="form-control"
                                      style="background:#101827;color:white;border:1px solid #334155;border-radius:10px"
                                      placeholder="Contoh: Bukti transfer tidak jelas / nominal tidak sesuai"></textarea>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger btn-sm fw-bold">
                                <i class="bi bi-x-circle-fill me-1"></i>Tolak Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @empty
        <div class="text-center py-5">
            <i class="bi bi-check-circle-fill text-success d-block mb-3" style="font-size:60px"></i>
            <div class="text-white fw-bold fs-5 mb-1">Semua Sudah Diverifikasi!</div>
            <small class="text-light-muted">Tidak ada pembayaran yang menunggu verifikasi.</small>
        </div>
        @endforelse

    </div>
</div>

{{-- MODAL PREVIEW BUKTI --}}
<div class="modal-bukti-overlay" id="modalBukti" onclick="tutupBukti(event)">
    <div class="modal-bukti-content" onclick="event.stopPropagation()">
        <div class="modal-bukti-header">
            <div>
                <div style="color:#fff;font-weight:700;font-size:14px">
                    <i class="bi bi-image me-2 text-primary"></i>
                    Bukti Transfer
                </div>
                <div style="color:#64748b;font-size:12px;margin-top:2px" id="modalBuktiNama"></div>
            </div>
            <div class="d-flex gap-2">
                <a href="#" id="modalBuktiLink" target="_blank" class="btn-buka-tab">
                    <i class="bi bi-box-arrow-up-right"></i> Buka Tab Baru
                </a>
                <button class="btn-close-modal" onclick="tutupBuktiBtn()">
                    <i class="bi bi-x-lg"></i> Tutup
                </button>
            </div>
        </div>
        <div class="modal-bukti-body">
            <img src="" id="modalBuktiImg" class="modal-bukti-img" alt="Bukti Transfer">
        </div>
    </div>
</div>

<script>
function lihatBukti(url, nama) {
    document.getElementById('modalBuktiImg').src  = url;
    document.getElementById('modalBuktiLink').href = url;
    document.getElementById('modalBuktiNama').textContent = nama;
    document.getElementById('modalBukti').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function tutupBuktiBtn() {
    document.getElementById('modalBukti').classList.remove('show');
    document.body.style.overflow = '';
}

function tutupBukti(e) {
    if (e.target === document.getElementById('modalBukti')) {
        tutupBuktiBtn();
    }
}

// Tutup dengan ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') tutupBuktiBtn();
});
</script>

@endsection