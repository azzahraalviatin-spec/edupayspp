@extends('layouts.petugas')

@section('title', 'Generate Tagihan')

@section('content')

<style>
    .custom-card{
        background:#1a233a !important;
        border:1px solid #2d4a8a !important;
        border-radius:14px;
        box-shadow:0 4px 20px rgba(0,0,0,.25);
    }
    .custom-input{
        background:#0f172a !important;
        border:1px solid #334155 !important;
        color:#fff !important;
        border-radius:10px;
        padding:10px 12px;
    }
    .custom-label{
        color:#93c5fd;
        font-size:13px;
        font-weight:600;
        margin-bottom:8px;
    }
    .generate-btn{
        background:linear-gradient(90deg,#2563eb,#3b82f6);
        border:none;
        color:white;
        border-radius:10px;
        padding:11px;
        font-weight:600;
        transition:.2s;
    }
    .generate-btn:hover{
        transform:translateY(-2px);
        box-shadow:0 8px 20px rgba(59,130,246,.35);
    }
    .info-alert{
        background:rgba(59,130,246,.12);
        border:1px solid rgba(59,130,246,.35);
        color:#bfdbfe;
        border-radius:10px;
    }
    .display-box{
        background:#0f172a !important;
        border:1px solid #334155 !important;
        color:#fff !important;
        border-radius:10px;
        padding:10px 12px;
        font-weight:600;
    }
</style>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="custom-card p-4">

            <h4 class="fw-bold text-white mb-4">
                <i class="bi bi-file-earmark-plus-fill text-primary me-2"></i>
                Generate Tagihan SPP
            </h4>

            <div class="info-alert p-3 mb-4">
                <i class="bi bi-info-circle-fill me-2"></i>
                Generate tagihan otomatis untuk semua siswa aktif sesuai kelas dan potongan yang berlaku.
            </div>

            @if($errors->any())
            <div class="alert alert-danger border-0">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ $errors->first() }}
            </div>
            @endif

            @if(!$tahunAktif)
            <div class="alert alert-warning border-0">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Tidak ada tahun ajaran yang aktif! Silakan aktifkan tahun ajaran terlebih dahulu.
            </div>
            @else

            @php $bulanSekarang = date('n'); @endphp

            <form action="{{ route('petugas.tagihan.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="custom-label">Tahun Ajaran</label>
                    <div class="display-box">
                        <i class="bi bi-calendar-check text-primary me-2"></i>
                        {{ $tahunAktif->nama }}
                        <span class="badge bg-success ms-2">Aktif</span>
                    </div>
                    <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAktif->id }}">
                </div>

                <div class="mb-4">
                    <label class="custom-label">Bulan</label>
                    <div class="display-box">
                        <i class="bi bi-calendar-month text-primary me-2"></i>
                        {{ $bulanList[$bulanSekarang] }}
                    </div>
                    <input type="hidden" name="bulan" value="{{ $bulanSekarang }}">
                </div>

                <button type="submit" class="btn generate-btn w-100"
                    onclick="return confirm('Yakin generate tagihan sekarang?')">
                    <i class="bi bi-lightning-charge-fill me-1"></i>
                    Generate Tagihan Sekarang
                </button>

            </form>
            @endif

        </div>
    </div>
</div>

@endsection