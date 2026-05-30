@extends('layouts.admin')

@section('title', 'Kelola User')

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
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .custom-table thead th {
        color: #ffffff !important; 
        background-color: #131926 !important;
        font-weight: 600 !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        border-bottom: 2px solid #2d3748 !important;
        padding: 12px 8px !important;
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
            <i class="bi bi-people-fill text-success me-2"></i>Kelola User Petugas
        </h5>
        <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-sm px-3 fw-semibold shadow-sm">
            <i class="bi bi-person-plus-fill me-1"></i>+ Tambah Petugas
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0 custom-table" style="font-size:13px; background-color: transparent !important;">
            <thead>
                <tr>
                    <th style="width: 8%">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-center" style="width: 20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users ?? [] as $index => $user)
                <tr style="border-color: #2d3748">
                    <td class="text-gray-light fw-medium">{{ $index + 1 }}</td>
                    <td class="text-white fw-semibold">{{ $user->name ?? $user->nama }}</td>
                    <td class="text-gray-light">{{ $user->email }}</td>
                    <td>
                        <span class="badge px-2 py-1" style="background-color: rgba(13, 202, 240, 0.15); color: #0dcaf0;">
                            {{ $user->role ?? 'Petugas' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-sm btn-info text-white" style="font-size:11px; border-radius: 6px;">
                                <i class="bi bi-eye-fill"></i> Detail
                            </a>
                            
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-warning text-dark" style="font-size:11px; border-radius: 6px;">
                                <i class="bi bi-pencil-fill"></i> Edit
                            </a>
                            
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="d-inline form-delete">
                                @csrf 
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="{{ $user->name ?? $user->nama }}" style="font-size:11px; border-radius: 6px;">
                                    <i class="bi bi-trash-fill"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr style="border-color: #2d3748">
                    <td class="text-gray-light">1</td>
                    <td class="text-white fw-semibold">gg</td>
                    <td class="text-gray-light">gaga@gmail.com</td>
                    <td><span class="badge bg-info text-dark" style="font-size:11px">Petugas</span></td>
                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ url('/admin/user/1') }}" class="btn btn-sm btn-info text-white py-1 px-2" style="font-size:11px; border-radius: 6px;"><i class="bi bi-eye-fill"></i> Detail</a>
                            <a href="{{ url('/admin/user/1/edit') }}" class="btn btn-sm btn-warning text-dark py-1 px-2" style="font-size:11px; border-radius: 6px;"><i class="bi bi-pencil-fill"></i> Edit</a>
                            
                            <form action="#" method="POST" class="d-inline form-delete">
                                <button type="button" class="btn btn-sm btn-danger py-1 px-2 btn-delete" data-name="gg" style="font-size:11px; border-radius: 6px;">
                                    <i class="bi bi-trash-fill"></i> Hapus
                                </button>
                            </form>
                        </div>
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
                const name = this.getAttribute('data-name');
                
                Swal.fire({
                    title: 'Anda yakin?',
                    text: `Akun "${name}" akan dihapus secara permanen dari sistem!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Tidak, Batalkan',
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