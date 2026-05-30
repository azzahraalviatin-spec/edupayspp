@extends('layouts.admin')
@section('title', 'Detail User')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4">
            <div class="d-flex align-items-center gap-2 mb-4">
                <a href="{{ route('admin.user.index') }}" class="icon-btn"><i class="bi bi-arrow-left"></i></a>
                <h6 class="fw-bold text-white mb-0">Detail User</h6>
            </div>

            @if(session('success'))
            <div class="alert alert-success py-2 small alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-1"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="text-center mb-4">
                <div style="background:#1e3a8a;border-radius:50%;width:64px;height:64px;display:flex;align-items:center;justify-content:center;margin:0 auto">
                    <i class="bi bi-person-fill text-white fs-3"></i>
                </div>
                <div class="fw-bold text-white mt-2 fs-5">{{ $user->name }}</div>
                <span class="badge bg-info text-dark mt-1">{{ ucfirst($user->getRoleNames()->first()) }}</span>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-12">
                    <div style="background:#0f172a;border-radius:8px;padding:12px 16px;border:1px solid #1e3a8a">
                        <div style="color:#60a5fa;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">Email</div>
                        <div class="text-white">{{ $user->email }}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div style="background:#0f172a;border-radius:8px;padding:12px 16px;border:1px solid #1e3a8a">
                        <div style="color:#60a5fa;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">Role</div>
                        <div class="text-white">{{ ucfirst($user->getRoleNames()->first()) }}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div style="background:#0f172a;border-radius:8px;padding:12px 16px;border:1px solid #1e3a8a">
                        <div style="color:#60a5fa;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">Bergabung Sejak</div>
                        <div class="text-white">{{ $user->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mb-4">
                <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-warning btn-sm px-4">
                    <i class="bi bi-pencil-fill me-1"></i>Edit
                </a>
                <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary btn-sm px-4">Kembali</a>
            </div>

            {{-- Reset Password --}}
            <div style="border-top:1px solid #1e3a8a;padding-top:1.25rem">
                <h6 class="fw-bold mb-3" style="color:#f87171">
                    <i class="bi bi-shield-lock-fill me-2"></i>Reset Password
                </h6>
                @if($errors->any())
                <div class="alert alert-danger py-2 small">
                    <i class="bi bi-exclamation-triangle me-1"></i>{{ $errors->first() }}
                </div>
                @endif
                <form action="{{ route('admin.user.reset-password', $user) }}" method="POST" autocomplete="off">
                    @csrf
                    <input type="text" style="display:none">
                    <input type="password" style="display:none">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold" style="color:#93c5fd">Password Baru</label>
                        <div class="input-group input-group-sm">
                            <input type="password" id="newPass" name="new_password"
                                style="background:#0f172a;color:#e2e8f0;border:1px solid #334155;border-right:none"
                                class="form-control form-control-sm" placeholder="Minimal 6 karakter"
                                autocomplete="new-password">
                            <span class="input-group-text" onclick="togglePass('newPass','eyeNew')"
                                style="background:#0f172a;border:1px solid #334155;border-left:none;cursor:pointer">
                                <i class="bi bi-eye" id="eyeNew" style="color:#94a3b8"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold" style="color:#93c5fd">Konfirmasi Password</label>
                        <div class="input-group input-group-sm">
                            <input type="password" id="newPass2" name="new_password_confirmation"
                                style="background:#0f172a;color:#e2e8f0;border:1px solid #334155;border-right:none"
                                class="form-control form-control-sm" placeholder="Ulangi password baru"
                                autocomplete="new-password">
                            <span class="input-group-text" onclick="togglePass('newPass2','eyeNew2')"
                                style="background:#0f172a;border:1px solid #334155;border-left:none;cursor:pointer">
                                <i class="bi bi-eye" id="eyeNew2" style="color:#94a3b8"></i>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm px-4"
                        style="background:#7f1d1d;border:1px solid #991b1b;color:#fca5a5"
                        onclick="return confirm('Yakin reset password user ini?')">
                        <i class="bi bi-shield-lock-fill me-1"></i>Reset Password
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function togglePass(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>
@endsection