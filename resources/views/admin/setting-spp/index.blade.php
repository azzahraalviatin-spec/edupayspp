@extends('layouts.admin')

@section('title', 'Setting SPP')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible border-0 fade show py-2 small mb-3" role="alert" style="background-color: rgba(25, 135, 84, 0.2); color: #75b798;">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<style>
    .custom-table-card {
        background-color: #1a233a !important; 
        border: none !important;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .custom-table thead th {
        color: #e2e8f0 !important; 
        font-weight: 600 !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 12px 8px !important;
        border-bottom: 2px solid #2d3748 !important;
    }
    .custom-table tbody td {
        padding: 12px 8px !important;
        vertical-align: middle;
    }
    .text-gray-light {
        color: #94a3b8 !important; 
    }
</style>

<div class="card p-4 custom-table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-white mb-0">
            <i class="bi bi-gear-fill text-primary me-2"></i>Konfigurasi Tarif SPP
        </h5>
        <a href="{{ route('admin.setting-spp.create') }}" class="btn btn-primary btn-sm px-3 fw-semibold shadow-sm">
            <i class="bi bi-plus-lg me-1"></i>Atur Tarif Baru
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0 custom-table" style="font-size:13px; background-color: transparent !important;">
            <thead>
                <tr>
                    <th style="width: 8%">No</th>
                    <th>Tahun Ajaran</th>
                    <th>Tingkat</th>
                    <th>Nominal Tarif</th>
                    <th class="text-center" style="width: 18%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $dataSetting = $settings ?? $settingSpps ?? []; @endphp
                
                @forelse($dataSetting as $index => $set)
                <tr style="border-color: #2d3748">
                    <td class="text-gray-light fw-medium">{{ $index + 1 }}</td>
                    <td class="text-white fw-semibold">
                        {{ $set->tahunAjaran->nama ?? 'Semua Tahun' }}
                    </td>
                    <td>
                        <span class="badge px-2 py-1" style="background-color: rgba(59, 130, 246, 0.15); color: #3b82f6;">
                            Kelas {{ $set->kelas->tingkat ?? 'Semua' }}
                        </span>
                    </td>
                    <td class="text-warning fw-bold">
                        Rp {{ number_format((int)($set->nominal ?? 0), 0, ',', '.') }}
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('admin.setting-spp.show', $set->id) }}" class="btn btn-sm btn-outline-info d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size:12px; border-radius: 6px;" title="Lihat Detail">
                                <i class="bi bi-eye-fill"></i>
                            </a>

                            <a href="{{ route('admin.setting-spp.edit', $set->id) }}" class="btn btn-sm btn-outline-warning d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size:12px; border-radius: 6px;" title="Edit Aturan">
                                <i class="bi bi-pencil-fill"></i>
                            </a>

                            <form action="{{ route('admin.setting-spp.destroy', $set->id) }}" method="POST" class="d-inline form-delete">
                                @csrf 
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center btn-delete" 
                                    data-info="Kelas {{ $set->kelas->tingkat ?? '' }} - Rp {{ number_format($set->nominal ?? 0, 0, ',', '.') }}"
                                    style="width: 28px; height: 28px; font-size:12px; border-radius: 6px;" title="Hapus Aturan">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-light py-4 fs-6">
                        <i class="bi bi-sliders d-block mb-2 text-muted fs-3"></i>
                        Belum ada konfigurasi tarif SPP yang dibuat
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                const form = this.closest('.form-delete');
                const infoTarif = this.getAttribute('data-info');
                
                Swal.fire({
                    title: 'Hapus konfigurasi tarif?',
                    text: `Anda akan menghapus "${infoTarif}". Aturan nominal tagihan siswa terkait akan ikut terhapus!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    background: '#1a233a',
                    color: '#ffffff',
                    iconColor: '#ffc107'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection