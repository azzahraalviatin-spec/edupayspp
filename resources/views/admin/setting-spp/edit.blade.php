@extends('layouts.admin')

@section('title', 'Edit Tarif SPP')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4 border-0 shadow-sm" style="background-color: #1a233a; border-radius: 12px;">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('admin.setting-spp.index') }}" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h5 class="fw-bold text-white mb-0">Edit Tarif SPP</h5>
            </div>

            @if($errors->any())
            <div class="alert alert-danger py-2 small border-0" style="background-color: rgba(220, 53, 69, 0.2); color: #ea868f;">
                <i class="bi bi-exclamation-triangle me-1"></i>
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('admin.setting-spp.update', $settingSpp->id) }}" method="POST">
                @csrf
                @method('PUT')

                <style>
                    .custom-input {
                        background-color: #131926 !important;
                        color: #ffffff !important;
                        border: 1px solid #2d3748 !important;
                        border-radius: 6px;
                        padding: 0.6rem 0.75rem;
                        transition: all 0.2s ease;
                    }
                    .custom-input:focus {
                        background-color: #131926 !important;
                        border-color: #3b82f6 !important;
                        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25) !important;
                    }
                    .custom-input:disabled {
                        background-color: #242f4d !important;
                        color: #a0aec0 !important;
                        opacity: 0.7;
                    }
                    .custom-label {
                        color: #ffffff;
                        font-weight: 500;
                        font-size: 0.875rem;
                        margin-bottom: 0.5rem;
                        display: block;
                    }
                </style>

                <div class="mb-3">
                    <label class="custom-label">Tahun Ajaran</label>
                    <select class="form-select custom-input" disabled>
                        @foreach($tahunAjarans ?? [] as $ta)
                            <option value="{{ $ta->id }}" {{ $settingSpp->tahun_ajaran_id == $ta->id ? 'selected' : '' }}>
                                {{ $ta->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="custom-label">Tingkat Kelas</label>
                    <select class="form-select custom-input" disabled>
                        @foreach($kelas ?? [] as $k)
                            <option value="{{ $k->id }}" {{ $settingSpp->kelas_id == $k->id ? 'selected' : '' }}>
                                Kelas {{ $k->tingkat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="custom-label">Nominal Tarif SPP Baru (Bulanan)</label>
                    <div class="input-group">
                        <span class="input-group-text border-secondary border-end-0 text-white fw-semibold" style="background-color: #131926;">Rp</span>
                        <input type="number" name="nominal" class="form-control custom-input border-start-0 @error('nominal') is-invalid @enderror" 
                            placeholder="Contoh: 250000" value="{{ old('nominal', (int)$settingSpp->nominal) }}" min="0" required>
                    </div>
                    @error('nominal')
                        <div class="invalid-feedback small d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('admin.setting-spp.index') }}" class="btn btn-outline-secondary px-4 text-white border-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-warning px-4 shadow-sm fw-semibold text-dark">
                        <i class="bi bi-check-circle-fill me-2"></i>Update Tarif
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection