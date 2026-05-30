@extends('layouts.admin')
@section('title', 'Tambah Petugas')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4">
            <div class="d-flex align-items-center gap-2 mb-4">
                <a href="{{ route('admin.user.index') }}" class="icon-btn"><i class="bi bi-arrow-left"></i></a>
                <h6 class="fw-bold text-white mb-0">Tambah Petugas Baru</h6>
            </div>
            @if($errors->any())
            <div class="alert alert-danger py-2 small"><i class="bi bi-exclamation-triangle me-1"></i>{{ $errors->first() }}</div>
            @endif
           <form action="{{ route('admin.user.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold" style="color:#93c5fd">Nama Lengkap</label>
                    <input type="text" name="name" style="background:#0f172a;color:#e2e8f0;border:1px solid #334155" class="form-control form-control-sm" placeholder="Nama petugas" value="{{ old('name') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold" style="color:#93c5fd">Email</label>
                    <input type="email" name="email" style="background:#0f172a;color:#e2e8f0;border:1px solid #334155" class="form-control form-control-sm" placeholder="email@sekolah.com" value="{{ old('email') }}">
                </div>
           <div class="mb-3">
    <label class="form-label small fw-semibold" style="color:#93c5fd">Role</label>
    <select name="role" style="background:#0f172a;color:#e2e8f0;border:1px solid #334155" class="form-select form-select-sm">
        <option value="" disabled selected>-- Pilih Role --</option>
        <option value="petugas">Petugas / Bendahara</option>
        <option value="admin">Admin</option>
    </select>
</div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold" style="color:#93c5fd">Password</label>
                    <div class="input-group input-group-sm">
                        <input type="password" id="password" name="password"
                         autocomplete="new-password"
                            style="background:#0f172a;color:#e2e8f0;border:1px solid #334155;border-right:none"
                            class="form-control form-control-sm" placeholder="Minimal 6 karakter">
                        <span class="input-group-text" onclick="togglePass('password','eyePass')"
                         autocomplete="new-password"
                            style="background:#0f172a;border:1px solid #334155;border-left:none;cursor:pointer">
                            <i class="bi bi-eye" id="eyePass" style="color:#94a3b8"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-semibold" style="color:#93c5fd">Konfirmasi Password</label>
                    <div class="input-group input-group-sm">
                        <input type="password" id="password2" name="password_confirmation"
                            style="background:#0f172a;color:#e2e8f0;border:1px solid #334155;border-right:none"
                            class="form-control form-control-sm" placeholder="Ulangi password">
                        <span class="input-group-text" onclick="togglePass('password2','eyePass2')"
                            style="background:#0f172a;border:1px solid #334155;border-left:none;cursor:pointer">
                            <i class="bi bi-eye" id="eyePass2" style="color:#94a3b8"></i>
                        </span>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm px-4"><i class="bi bi-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary btn-sm px-4">Batal</a>
                </div>
            </form>
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