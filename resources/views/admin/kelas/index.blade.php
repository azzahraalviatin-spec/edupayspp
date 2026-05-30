@extends('layouts.admin')

@section('title', 'Kelola Kelas')

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
            <i class="bi bi-building text-primary me-2"></i>Data Kelas
        </h5>
        <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary btn-sm px-3 fw-semibold shadow-sm">
            <i class="bi bi-plus-lg me-1"></i>Tambah Kelas
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0 custom-table" style="font-size:13px; background-color: transparent !important;">
            <thead>
                <tr>
                    <th style="width: 8%">No</th>
                    <th>Tingkat</th>
                    <th>Jurusan</th>
                    <th>Nomor Kelas</th>
                    <th>Wali Kelas</th>
                    <th class="text-center" style="width: 18%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas as $k)
                <tr style="border-color: #2d3748">
                    <td class="text-gray-light fw-medium">{{ $loop->iteration }}</td>
                    <td>
                        <span class="badge px-2 py-1" style="background-color: rgba(59, 130, 246, 0.2); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.3);">
                            Kelas {{ $k->tingkat }}
                        </span>
                    </td>
                    <td class="text-white fw-medium">{{ $k->jurusan }}</td>
                    <td class="text-white">
                        <span class="fw-semibold text-warning">{{ $k->nomor_kelas }}</span>
                    </td>
                    <td class="text-gray-light">{{ $k->wali_kelas ?? '-' }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('admin.kelas.show', $k) }}" class="btn btn-sm btn-outline-info d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size:12px; border-radius: 6px;" title="Lihat Detail">
                                <i class="bi bi-eye-fill"></i>
                            </a>

                            <a href="{{ route('admin.kelas.edit', $k) }}" class="btn btn-sm btn-outline-warning d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size:12px; border-radius: 6px;" title="Edit Kelas">
                                <i class="bi bi-pencil-fill"></i>
                            </a>

                            <form action="{{ route('admin.kelas.destroy', $k) }}" method="POST" class="d-inline form-delete">
                                @csrf 
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center btn-delete" 
                                    data-nama="Kelas {{ $k->tingkat }} {{ $k->jurusan }} {{ $k->nomor_kelas }}"
                                    style="width: 28px; height: 28px; font-size:12px; border-radius: 6px;" title="Hapus Kelas">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-light py-4 fs-6">
                        <i class="bi bi-folder-x d-block mb-2 text-muted fs-3"></i>
                        Belum ada data kelas yang terdaftar
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
        // Tangkap semua tombol hapus
        const deleteButtons = document.querySelectorAll('.btn-delete');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                const form = this.closest('.form-delete');
                const namaKelas = this.getAttribute('data-nama');
                
                // Munculkan Pop Up SweetAlert2 Tema Premium Dark-Friendly
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Kamu akan menghapus "${namaKelas}". Data siswa di dalamnya mungkin akan ikut terpengaruh!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545', // Warna merah Bootstrap untuk Hapus
                    cancelButtonColor: '#6c757d',  // Warna abu-abu untuk Batal
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    background: '#1a233a',         // Menyesuaikan background dashboard kamu
                    color: '#ffffff',              // Warna teks putih
                    iconColor: '#ffc107'           // Warna ikon alert kuning emas
                }).then((result) => {
                    // Jika admin menekan tombol "Ya, Hapus!"
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection