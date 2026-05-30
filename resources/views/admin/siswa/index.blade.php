@extends('layouts.admin')

@section('title', 'Kelola Siswa')

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
    /* Mengubah warna judul kolom agar terlihat jelas dan tajam */
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
    
    /* STYLE TAMBAHAN: Membuat tombol Navigasi Pilihan/Tab Horizontal mirip halaman Potongan */
    .nav-tabs-custom {
        border-bottom: 1px solid #2d3748;
    }
    .nav-tabs-custom .nav-link {
        color: #94a3b8;
        border: none;
        background: transparent;
        padding: 0.6rem 1.2rem;
        font-size: 13.5px;
        font-weight: 600;
        transition: all 0.2s ease;
        position: relative;
    }
    .nav-tabs-custom .nav-link:hover {
        color: #ffffff;
    }
    .nav-tabs-custom .nav-link.active {
        color: #3b82f6 !important;
        background: transparent;
        font-weight: 700;
    }
    .nav-tabs-custom .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #3b82f6;
    }
</style>

<div class="nav-tabs-custom d-flex gap-2 mb-3">
    <a href="{{ route('admin.siswa.index') }}" 
       class="nav-link {{ !request()->has('status') ? 'active' : '' }}">
        <i class="bi bi-grid-fill me-2"></i>Semua Siswa
    </a>
    <a href="{{ route('admin.siswa.index', ['status' => 'Belum Bayar']) }}" 
       class="nav-link {{ request('status') == 'Belum Bayar' ? 'active' : '' }}">
        <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>Belum Bayar Bulan Ini
    </a>
</div>

<div class="card p-4 custom-table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-white mb-0">
            <i class="bi bi-people-fill text-primary me-2"></i>
            {{ request('status') == 'Belum Bayar' ? 'Data Siswa Menunggak SPP' : 'Data Semua Siswa' }}
        </h5>
        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary btn-sm px-3 fw-semibold shadow-sm">
            <i class="bi bi-plus-lg me-1"></i>Tambah Siswa
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0 custom-table" style="font-size:13px; background-color: transparent !important;">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 12%">NIS</th>
                    <th>Nama Lengkap</th>
                    <th>Kelas</th>
                    <th>L/P</th>
                    <th>No. HP Ortu</th>
                    <th>Status</th>
                    <th class="text-center" style="width: 18%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $index => $siswa)
                <tr style="border-color: #2d3748">
                    <td class="text-gray-light fw-medium">
                        {{ method_exists($siswas, 'firstItem') ? ($siswas->firstItem() + $index) : ($index + 1) }}
                    </td>
                    <td class="text-warning fw-semibold">{{ $siswa->nis }}</td>
                    <td class="text-white fw-medium">{{ $siswa->nama }}</td>
                    <td class="text-white">
                        @if($siswa->kelas)
                            <span class="badge px-2 py-1" style="background-color: rgba(59, 130, 246, 0.15); color: #3b82f6;">
                                {{ $siswa->kelas->tingkat }} {{ $siswa->kelas->jurusan }} {{ $siswa->kelas->nomor_kelas }}
                            </span>
                        @else
                            <span class="text-muted small italic">Kosong</span>
                        @endif
                    </td>
                    <td class="text-gray-light">
                        {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </td>
                    <td class="text-gray-light">{{ $siswa->no_hp_ortu ?? '-' }}</td>
                    <td>
                        @if(request('status') == 'Belum Bayar')
                            <span class="badge px-2 py-1 bg-danger text-white">Nunggak</span>
                        @else
                            @if($siswa->status == 'aktif')
                                <span class="badge px-2 py-1" style="background-color: rgba(25, 135, 84, 0.2); color: #1ea97c; border: 1px solid rgba(25, 135, 84, 0.3);">Aktif</span>
                            @else
                                <span class="badge px-2 py-1" style="background-color: rgba(108, 117, 125, 0.2); color: #adb5bd; border: 1px solid rgba(108, 117, 125, 0.3);">Alumni</span>
                            @endif
                        @endif
                    </td>
                  <td>
    <div class="d-flex justify-content-center gap-1">
        @if(request('status') != 'Belum Bayar')
        <a href="{{ route('admin.siswa.show', $siswa) }}" class="btn btn-sm btn-outline-info d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size:12px; border-radius: 6px;" title="Detail Siswa">
            <i class="bi bi-eye-fill"></i>
        </a>

        <a href="{{ route('admin.siswa.edit', $siswa) }}" class="btn btn-sm btn-outline-warning d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size:12px; border-radius: 6px;" title="Edit Siswa">
            <i class="bi bi-pencil-fill"></i>
        </a>

        <form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST" class="d-inline form-delete">
            @csrf 
            @method('DELETE')
            <button type="button" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center btn-delete" 
                data-nama="{{ $siswa->nama }} (NIS: {{ $siswa->nis }})"
                style="width: 28px; height: 28px; font-size:12px; border-radius: 6px;" title="Hapus Siswa">
                <i class="bi bi-trash-fill"></i>
            </button>
        </form>
        @endif
    </div>
</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-gray-light py-5 fs-6">
                        <i class="bi bi-people d-block mb-2 text-muted fs-2"></i>
                        Tidak ada data siswa yang cocok ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($siswas, 'links'))
        <div class="mt-3">
            {{ $siswas->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                const form = this.closest('.form-delete');
                const namaSiswa = this.getAttribute('data-nama');
                
                Swal.fire({
                    title: 'Hapus data siswa?',
                    text: `Anda akan menghapus data atas nama "${namaSiswa}". Tindakan ini tidak dapat dibatalkan!`,
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