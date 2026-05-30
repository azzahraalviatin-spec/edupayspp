@extends('layouts.petugas')
@section('title', 'Profil')
@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show py-2 small">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4" style="background:#1a233a !important; border:1px solid #2d4a8a !important; border-radius:16px;">
            <div class="text-center mb-4">
                <div style="background:linear-gradient(135deg,#1d4ed8,#3b82f6);border-radius:50%;width:72px;height:72px;display:flex;align-items:center;justify-content:center;margin:0 auto;border:2px solid #3b82f6;box-shadow:0 0 20px rgba(59,130,246,0.4)">
                    <i class="bi bi-person-fill text-white fs-2"></i>
                </div>
                <div class="fw-bold text-white mt-2 fs-5">{{ $user->name }}</div>
                <span class="badge mt-1" style="background:rgba(59,130,246,0.2);color:#60a5fa;border:1px solid rgba(59,130,246,0.3);">
                    Petugas / Bendahara
                </span>
            </div>

            @if($errors->any())
            <div class="alert alert-danger py-2 small border-0" style="background:rgba(220,38,38,0.15);color:#fca5a5;">
                <i class="bi bi-exclamation-triangle me-1"></i>{{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('petugas.profil.update') }}" method="POST" autocomplete="off">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label small fw-semibold" style="color:#93c5fd">Nama Lengkap</label>
                    <input type="text" name="name"
                        style="background:#0f172a;color:#e2e8f0;border:1px solid #2d4a8a;border-radius:8px;"
                        class="form-control form-control-sm"
                        value="{{ $user->name }}">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold" style="color:#93c5fd">Email</label>
                    <input type="email" name="email"
                        style="background:#0f172a;color:#e2e8f0;border:1px solid #2d4a8a;border-radius:8px;"
                        class="form-control form-control-sm"
                        value="{{ $user->email }}">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold" style="color:#93c5fd">
                        Password Baru
                        <span style="color:#64748b;font-weight:400">(kosongkan jika tidak diubah)</span>
                    </label>
                    <div class="input-group input-group-sm">
                        <input type="password" id="password" name="password" autocomplete="new-password"
                            style="background:#0f172a;color:#e2e8f0;border:1px solid #2d4a8a;border-right:none;border-radius:8px 0 0 8px;"
                            class="form-control form-control-sm"
                            placeholder="Minimal 6 karakter">
                        <span class="input-group-text" onclick="togglePass('password','eyePass')"
                            style="background:#0f172a;border:1px solid #2d4a8a;border-left:none;cursor:pointer;border-radius:0 8px 8px 0;">
                            <i class="bi bi-eye" id="eyePass" style="color:#94a3b8"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold" style="color:#93c5fd">Konfirmasi Password</label>
                    <div class="input-group input-group-sm">
                        <input type="password" id="password2" name="password_confirmation" autocomplete="new-password"
                            style="background:#0f172a;color:#e2e8f0;border:1px solid #2d4a8a;border-right:none;border-radius:8px 0 0 8px;"
                            class="form-control form-control-sm"
                            placeholder="Ulangi password baru">
                        <span class="input-group-text" onclick="togglePass('password2','eyePass2')"
                            style="background:#0f172a;border:1px solid #2d4a8a;border-left:none;cursor:pointer;border-radius:0 8px 8px 0;">
                            <i class="bi bi-eye" id="eyePass2" style="color:#94a3b8"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-sm w-100 fw-bold"
                    style="background:linear-gradient(135deg,#1d4ed8,#3b82f6);border:none;color:#fff;border-radius:8px;padding:10px;">
                    <i class="bi bi-save me-1"></i>Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function togglePass(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>
@endsection