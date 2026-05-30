@extends('layouts.admin')

@section('title', 'Tahun Ajaran')

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
    /* PERBAIKAN: Memaksa teks header berwarna putih terang agar kelihatan jelas */
    .custom-table-header th {
        color: #ffffff !important; 
        background-color: #131926 !important;
        font-weight: bold !important;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.05em;
        padding: 14px 10px !important;
        border-bottom: 2px solid #2d3748 !important;
    }
    .custom-table tbody td {
        padding: 14px 10px !important;
        vertical-align: middle;
    }
    .text-gray-light {
        color: #94a3b8 !important; 
    }
</style>

<div class="card p-4 custom-table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-white mb-0">
            <i class="bi bi-calendar3 text-primary me-2"></i>Kelola Data Tahun Ajaran
        </h5>
        <a href="{{ route('admin.tahun-ajaran.create') }}" class="btn btn-primary btn-sm px-3 fw-semibold shadow-sm">
            <i class="bi bi-plus-lg me-1"></i>Tambah
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0" style="font-size:13px; background-color: transparent !important;">
            <thead>
                <tr class="custom-table-header">
                    <th style="width: 8%">No</th>
                    <th style="width: 42%">Tahun Ajaran</th>
                    <th style="width: 25%">Status</th>
                    <th class="text-center" style="width: 25%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tahunAjarans as $index => $ta)
                <tr style="border-color: #2d3748; background-color: transparent !important;">
                    <td class="text-gray-light fw-medium">{{ $index + 1 }}</td>
                    
                    <td class="text-white fw-semibold">{{ $ta->nama }}</td>
                    
                    <td>
                        @if($ta->is_aktif)
                            <span class="badge px-2 py-1" style="background-color: rgba(25, 135, 84, 0.2); color: #75b798;">Aktif</span>
                        @else
                            <span class="badge px-2 py-1" style="background-color: rgba(108, 117, 125, 0.2); color: #a0aec0;">Nonaktif</span>
                        @endif
                    </td>
                    
                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('admin.tahun-ajaran.show', $ta->id) }}" class="btn btn-sm btn-info text-white d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size:12px; border-radius: 6px;" title="Lihat Detail">
                                <i class="bi bi-eye-fill"></i>
                            </a>

                            <a href="{{ route('admin.tahun-ajaran.edit', $ta) }}" class="btn btn-sm btn-warning text-dark d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size:12px; border-radius: 6px;" title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </a>

                            <form action="{{ route('admin.tahun-ajaran.destroy', $ta) }}" method="POST" class="d-inline form-delete">
                                @csrf 
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger text-white d-flex align-items-center justify-content-center btn-delete" 
                                    data-info="{{ $ta->nama }}"
                                    style="width: 28px; height: 28px; font-size:12px; border-radius: 6px;" title="Hapus">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-light py-4 fs-6">
                        <i class="bi bi-calendar-x d-block mb-2 text-muted fs-3"></i>
                        Belum ada data tahun ajaran.
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
                const info = this.getAttribute('data-info');
                
                Swal.fire({
                    title: 'Hapus Tahun Ajaran?',
                    text: `Anda akan menghapus data tahun ajaran "${info}".`,
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