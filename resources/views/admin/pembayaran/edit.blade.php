@extends('layouts.admin')
@section('title', 'Edit Metode Pembayaran')
@section('content')

<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8">
            <div class="mb-3">
                <a href="{{ route('admin.pembayaran.index') }}" class="btn text-muted small p-0 shadow-none d-inline-flex align-items-center" style="background: transparent;">
                    <i class="bi bi-arrow-left me-1.5"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="card border-0 shadow-sm" style="background: #1e293b; border-radius: 12px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-white m-0 d-flex align-items-center" style="font-size: 16px;">
                        <span class="p-2 bg-warning bg-opacity-10 rounded-3 me-2.5 d-inline-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                            <i class="bi bi-pencil-square text-warning"></i>
                        </span>
                        Ubah Data Metode Pembayaran
                    </h5>
                    <p class="text-muted small mt-1 mb-0">Perbarui informasi detail metode pembayaran yang dipilih.</p>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.pembayaran.update', $metode->id) }}" method="POST">
                        @csrf @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label small fw-semibold" style="color: #94a3b8;">Nama Metode Pembayaran</label>
                            <input type="text" name="nama" required style="background: #0f172a; color: #e2e8f0; border: 1px solid #334155;" class="form-control form-control-sm shadow-none" value="{{ $metode->nama }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold" style="color: #94a3b8;">Nomor Rekening / Virtual Account</label>
                            <input type="text" name="no_rekening" style="background: #0f172a; color: #e2e8f0; border: 1px solid #334155;" class="form-control form-control-sm shadow-none" value="{{ $metode->no_rekening }}" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold" style="color: #94a3b8;">Atas Nama Pemilik</label>
                            <input type="text" name="atas_nama" style="background: #0f172a; color: #e2e8f0; border: 1px solid #334155;" class="form-control form-control-sm shadow-none" value="{{ $metode->atas_nama }}">
                        </div>

                        <div class="p-3 rounded-3 mb-4" style="background: #0f172a; border: 1px solid #334155;">
                            <div class="form-check form-switch m-0 d-flex align-items-center">
                                <input class="form-check-input shadow-none me-2" type="checkbox" name="is_aktif" id="is_aktif" {{ $metode->is_aktif ? 'checked' : '' }} style="cursor: pointer;">
                                <label class="form-check-label small fw-semibold" style="color: #38bdf8; cursor: pointer;" for="is_aktif">Metode ini Tetap Aktif</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-sm text-white border-0 fw-medium px-3.5 py-2" style="background: #334155; border-radius: 6px;">Batal</a>
                            <button type="submit" class="btn btn-warning btn-sm text-dark fw-bold px-4 py-2 shadow-sm" style="border-radius: 6px;">
                                <i class="bi bi-arrow-clockwise me-1.5"></i> Update Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection