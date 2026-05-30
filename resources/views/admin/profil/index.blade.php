@extends('layouts.admin')

@section('title', 'Profil Pengaturan')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7"> <div class="card p-4 border-0 shadow-sm" style="background-color: #1a233a; border-radius: 12px;">
            
            <div class="text-center mb-4 border-bottom border-secondary pb-3">
                <div class="mx-auto mb-3" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);">
                    <i class="bi bi-person-badge-fill text-white" style="font-size: 35px;"></i>
                </div>
                <h5 class="fw-bold text-white mb-0">{{ $user->name }}</h5>
                <span class="badge bg-primary px-3 py-1 mt-2" style="font-size: 11px;">Akses: {{ ucfirst($user->role ?? 'Administrator') }}</span>
            </div>

            <div class="row g-3" style="font-size: 14px;">
                
                <div class="col-12 p-3 rounded-3 mb-2" style="background-color: #131926; border: 1px solid #2d3748;">
                    <span class="d-block small fw-bold text-uppercase mb-2" style="font-size: 11px; color: #94a3b8 !important; letter-spacing: 0.5px;">
                        Nama Pengguna
                    </span>
                    <span class="fw-bold fs-5" style="color: #00d2ff !important;"><i class="bi bi-person-fill me-2"></i>{{ $user->name }}</span>
                </div>

                <div class="col-12 p-3 rounded-3 mb-2" style="background-color: #131926; border: 1px solid #2d3748;">
                    <span class="d-block small fw-bold text-uppercase mb-2" style="font-size: 11px; color: #94a3b8 !important; letter-spacing: 0.5px;">
                        Alamat Email Akun
                    </span>
                    <span class="fw-bold fs-5" style="color: #00d2ff !important;"><i class="bi bi-envelope-fill me-2"></i>{{ $user->email }}</span>
                </div>

                <div class="col-12 p-3 rounded-3" style="background-color: #131926; border: 1px solid #2d3748;">
                    <span class="d-block small fw-bold text-uppercase mb-2" style="font-size: 11px; color: #94a3b8 !important; letter-spacing: 0.5px;">
                        Waktu Akun Dibuat
                    </span>
                    <span class="fw-semibold fs-6" style="color: #a7f3d0 !important;">
                        <i class="bi bi-calendar-check-fill me-2 text-success"></i>
                        {{ $user->created_at ? $user->created_at->translatedFormat('d F Y (H:i)') : '-' }}
                    </span>
                </div>
            </div>

            <div class="alert alert-info border-0 mt-4 py-2 small d-flex align-items-center gap-2 mb-0" style="background-color: rgba(13, 202, 240, 0.15); color: #6fe5ff; border-radius: 8px;">
                <i class="bi bi-info-circle-fill"></i>
                <span>Data profil di atas diambil otomatis secara aman dari database akun sistem sekolah.</span>
            </div>

        </div>
    </div>
</div>

@endsection