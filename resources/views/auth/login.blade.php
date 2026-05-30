<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi SPP Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0a2ed4 0%, #1a4be8 35%, #0d3bc7 65%, #0826a3 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.13) 1.5px, transparent 1.5px);
            background-size: 34px 34px;
            background-position: 18px 18px;
            pointer-events: none;
            z-index: 0;
        }

        .blob { position: fixed; border-radius: 50%; filter: blur(90px); pointer-events: none; z-index: 0; }
        .blob-1 { width: 450px; height: 450px; background: rgba(100,150,255,0.22); top: -120px; left: -100px; }
        .blob-2 { width: 320px; height: 320px; background: rgba(50,100,220,0.25); bottom: -80px; left: 28%; }
        .blob-3 { width: 220px; height: 220px; background: rgba(80,130,255,0.18); top: 15%; right: 4%; }

        .page-wrapper {
            display: flex;
            align-items: center;
            gap: 56px;
            width: 100%;
            max-width: 1080px;
            padding: 36px 24px;
            position: relative;
            z-index: 10;
        }

        /* LEFT PANEL */
        .left-panel { flex: 1; color: #fff; }

        .app-logo-box {
            width: 68px; height: 68px;
            background: #fff;
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.18);
        }
        .app-logo-box i { font-size: 32px; color: #1a4be8; }

        .app-name { font-size: 34px; font-weight: 800; line-height: 1.2; margin-bottom: 10px; }
        .app-tagline { font-size: 14.5px; color: rgba(255,255,255,0.72); line-height: 1.65; margin-bottom: 28px; }

        .accent-bar { width: 48px; height: 4px; background: linear-gradient(90deg, #fff, rgba(255,255,255,0.25)); border-radius: 2px; margin-bottom: 34px; }

        .features { display: flex; flex-direction: column; gap: 20px; }
        .feature-row { display: flex; align-items: flex-start; gap: 14px; }

        .feat-icon {
            width: 46px; height: 46px;
            border-radius: 13px;
            background: rgba(255,255,255,0.13);
            border: 1px solid rgba(255,255,255,0.18);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            backdrop-filter: blur(6px);
        }
        .feat-icon i { font-size: 19px; color: #fff; }
        .feat-text h5 { font-size: 14.5px; font-weight: 700; margin-bottom: 3px; }
        .feat-text p  { font-size: 12.5px; color: rgba(255,255,255,0.68); line-height: 1.5; }

        .school-wrap { margin-top: 38px; }
        .school-wrap svg { width: 255px; opacity: 0.92; }

        /* LOGIN CARD */
        .login-card {
            width: 430px;
            flex-shrink: 0;
            background: #fff;
            border-radius: 22px;
            padding: 38px 34px 30px;
            box-shadow: 0 22px 70px rgba(0,0,0,0.22);
        }

        .card-top { text-align: center; margin-bottom: 26px; }

        .avatar-ring {
            width: 66px; height: 66px;
            background: #1a4be8;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
        }
        .avatar-ring i { font-size: 27px; color: #fff; }

        .card-top h2 { font-size: 21px; font-weight: 800; color: #0f172a; margin-bottom: 5px; }
        .card-top p  { font-size: 13.5px; color: #94a3b8; }

        .role-switcher {
            display: flex;
            background: #f1f5ff;
            border-radius: 11px;
            padding: 4px;
            margin-bottom: 26px;
        }

        .role-btn {
            flex: 1;
            padding: 9px 12px;
            border: none;
            background: transparent;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            color: #94a3b8;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            gap: 7px;
            transition: all 0.22s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .role-btn i { font-size: 15px; }
        .role-btn.active {
            background: #1a4be8;
            color: #fff;
            box-shadow: 0 4px 14px rgba(26,75,232,0.32);
        }

        .form-label { font-size: 13.5px; font-weight: 600; color: #0f172a; margin-bottom: 7px; display: block; }

        .inp-wrap { position: relative; margin-bottom: 18px; }
        .inp-icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: #b0bec5; font-size: 15px; pointer-events: none; }

        .form-control {
            padding: 11px 13px 11px 38px;
            border: 1.5px solid #e2e8f0;
            border-radius: 11px;
            font-size: 13.5px;
            color: #0f172a;
            background: #f8faff;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
            width: 100%;
        }
        .form-control:focus {
            border-color: #1a4be8;
            box-shadow: 0 0 0 3px rgba(26,75,232,0.11);
            background: #fff;
            outline: none;
        }
        .form-control::placeholder { color: #c0c8d8; }

        .eye-btn { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #b0bec5; cursor: pointer; font-size: 15px; padding: 0; }

        .form-bottom { display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px; }
        .form-check { display: flex; align-items: center; gap: 7px; }
        .form-check-input { width: 16px; height: 16px; border: 1.5px solid #cbd5e1; border-radius: 4px; cursor: pointer; accent-color: #1a4be8; }
        .form-check-label { font-size: 12.5px; color: #94a3b8; cursor: pointer; }

        .forgot-link { font-size: 12.5px; font-weight: 600; color: #1a4be8; text-decoration: none; }
        .forgot-link:hover { text-decoration: underline; }

        .btn-submit {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #1a4be8 0%, #0d3bc7 100%);
            color: #fff;
            border: none;
            border-radius: 11px;
            font-size: 14.5px;
            font-weight: 700;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            gap: 9px;
            transition: all 0.22s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
            box-shadow: 0 5px 18px rgba(26,75,232,0.33);
            letter-spacing: 0.2px;
        }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 9px 26px rgba(26,75,232,0.42); }
        .btn-submit:active { transform: translateY(0); }

        .card-foot {
            display: flex; align-items: center; justify-content: space-between;
            margin-top: 22px; padding-top: 16px;
            border-top: 1px solid #f0f4ff;
        }
        .secure-tag { display: flex; align-items: center; gap: 5px; font-size: 11.5px; color: #94a3b8; }
        .secure-tag i { color: #1a4be8; font-size: 13px; }
        .copy-text { font-size: 11.5px; color: #b0bec5; }

        .alert-err {
            border-radius: 9px; font-size: 13px; padding: 9px 13px; margin-bottom: 16px;
            display: flex; align-items: center; gap: 7px;
            background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;
        }

        @media (max-width: 880px) {
            .left-panel { display: none; }
            .page-wrapper { justify-content: center; padding: 20px 16px; }
            .login-card { width: 100%; max-width: 415px; }
        }
    </style>
</head>
<body>

<div class="blob blob-1"></div>
<div class="blob blob-2"></div>
<div class="blob blob-3"></div>

<div class="page-wrapper">

    {{-- LEFT PANEL --}}
    <div class="left-panel">
        <div class="app-logo-box">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <h1 class="app-name">Aplikasi SPP Sekolah</h1>
        <p class="app-tagline">Sistem Pembayaran SPP yang Mudah,<br>Aman dan Terpercaya</p>
        <div class="accent-bar"></div>

        <div class="features">
            <div class="feature-row">
                <div class="feat-icon"><i class="bi bi-shield-check-fill"></i></div>
                <div class="feat-text">
                    <h5>Aman &amp; Terpercaya</h5>
                    <p>Data pembayaran terlindungi dengan<br>sistem keamanan berlapis.</p>
                </div>
            </div>
            <div class="feature-row">
                <div class="feat-icon"><i class="bi bi-bar-chart-fill"></i></div>
                <div class="feat-text">
                    <h5>Laporan Transparan</h5>
                    <p>Pantau riwayat pembayaran dengan<br>laporan yang akurat dan real-time.</p>
                </div>
            </div>
            <div class="feature-row">
                <div class="feat-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                <div class="feat-text">
                    <h5>Mudah &amp; Cepat</h5>
                    <p>Kelola pembayaran SPP dengan mudah,<br>kapan saja dan di mana saja.</p>
                </div>
            </div>
        </div>

        <div class="school-wrap">
            <svg viewBox="0 0 260 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="260" height="150" rx="14" fill="rgba(255,255,255,0.05)"/>
                <ellipse cx="38" cy="38" rx="21" ry="11" fill="rgba(255,255,255,0.14)"/>
                <ellipse cx="55" cy="33" rx="17" ry="10" fill="rgba(255,255,255,0.17)"/>
                <ellipse cx="205" cy="33" rx="17" ry="9" fill="rgba(255,255,255,0.11)"/>
                <ellipse cx="222" cy="28" rx="14" ry="8" fill="rgba(255,255,255,0.14)"/>
                <rect x="0" y="122" width="260" height="28" fill="rgba(255,255,255,0.07)"/>
                <rect x="75" y="65" width="110" height="65" rx="3" fill="rgba(255,255,255,0.19)"/>
                <polygon points="65,65 130,28 195,65" fill="rgba(255,255,255,0.28)"/>
                <rect x="116" y="37" width="28" height="28" rx="3" fill="rgba(255,255,255,0.23)"/>
                <circle cx="130" cy="51" r="8" fill="rgba(255,255,255,0.38)" stroke="rgba(255,255,255,0.55)" stroke-width="1.5"/>
                <line x1="130" y1="51" x2="130" y2="46" stroke="rgba(26,75,232,0.85)" stroke-width="1.5" stroke-linecap="round"/>
                <line x1="130" y1="51" x2="134" y2="51" stroke="rgba(26,75,232,0.85)" stroke-width="1.5" stroke-linecap="round"/>
                <line x1="130" y1="28" x2="130" y2="14" stroke="rgba(255,255,255,0.65)" stroke-width="1.5"/>
                <rect x="130" y="14" width="17" height="6" fill="#cc0001"/>
                <rect x="130" y="20" width="17" height="5" fill="#fff"/>
                <rect x="118" y="98" width="24" height="32" rx="3" fill="rgba(26,75,232,0.38)"/>
                <circle cx="138" cy="114" r="1.8" fill="rgba(255,255,255,0.65)"/>
                <rect x="82" y="74" width="20" height="17" rx="2" fill="rgba(255,220,100,0.38)" stroke="rgba(255,255,255,0.28)" stroke-width="1"/>
                <rect x="82" y="98" width="20" height="17" rx="2" fill="rgba(255,220,100,0.33)" stroke="rgba(255,255,255,0.28)" stroke-width="1"/>
                <rect x="158" y="74" width="20" height="17" rx="2" fill="rgba(255,220,100,0.38)" stroke="rgba(255,255,255,0.28)" stroke-width="1"/>
                <rect x="158" y="98" width="20" height="17" rx="2" fill="rgba(255,220,100,0.33)" stroke="rgba(255,255,255,0.28)" stroke-width="1"/>
                <ellipse cx="38" cy="112" rx="18" ry="20" fill="rgba(50,200,120,0.48)"/>
                <rect x="36" y="120" width="4" height="10" fill="rgba(255,255,255,0.28)"/>
                <ellipse cx="222" cy="112" rx="18" ry="20" fill="rgba(50,200,120,0.43)"/>
                <rect x="220" y="120" width="4" height="10" fill="rgba(255,255,255,0.28)"/>
                <ellipse cx="62" cy="116" rx="12" ry="15" fill="rgba(50,180,100,0.38)"/>
                <ellipse cx="198" cy="116" rx="12" ry="15" fill="rgba(50,180,100,0.38)"/>
                <rect x="112" y="130" width="36" height="5" rx="1" fill="rgba(255,255,255,0.22)"/>
                <rect x="108" y="135" width="44" height="4" rx="1" fill="rgba(255,255,255,0.17)"/>
            </svg>
        </div>
    </div>

    {{-- LOGIN CARD --}}
    <div class="login-card">

        <div class="card-top">
            <div class="avatar-ring">
                <i class="bi bi-people-fill"></i>
            </div>
            <h2>Selamat Datang! 👋</h2>
            <p>Silakan masuk untuk melanjutkan</p>
        </div>

        <div class="role-switcher">
            <button type="button" class="role-btn active" id="btnAdmin" onclick="switchLogin('admin')">
                <i class="bi bi-person-badge"></i> Admin / Petugas
            </button>
            <button type="button" class="role-btn" id="btnSiswa" onclick="switchLogin('siswa')">
                <i class="bi bi-person"></i> Siswa
            </button>
        </div>

        @if ($errors->any())
            <div class="alert-err">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $errors->first() }}
            </div>
        @endif

       <form method="POST" action="{{ route('login') }}" autocomplete="off">
    @csrf
    <input type="hidden" name="login_type" id="login_type" value="admin">

    {{-- Admin: Email --}}
    <div id="formAdmin">
        <label class="form-label">Email</label>
        <div class="inp-wrap">
            <i class="bi bi-envelope inp-icon"></i>
            {{-- PERBAIKAN: Mengubah autocomplete menjadi new-password agar bersih total --}}
            <input type="email" id="email" name="email"
                class="form-control"
                placeholder=""
                value=""
                autocomplete="new-password">
        </div>
    </div>

    {{-- Siswa: Nama --}}
    <div id="formSiswa" style="display:none">
        <label class="form-label">Nama Lengkap</label>
        <div class="inp-wrap">
            <i class="bi bi-person inp-icon"></i>
            {{-- PERBAIKAN: Mengubah autocomplete menjadi off --}}
            <input type="text" id="nama" name="nama"
                class="form-control"
                placeholder="Nama lengkap sesuai data"
                value=""
                autocomplete="off">
        </div>
    </div>

    {{-- Password / NIS --}}
    <label class="form-label" id="labelPassword">Password</label>
    <div class="inp-wrap">
        <i class="bi bi-lock inp-icon"></i>
        {{-- PERBAIKAN: Mengubah autocomplete menjadi new-password --}}
        <input type="password" id="password" name="password"
            class="form-control"
            placeholder=""
            required
            autocomplete="new-password"
            style="padding-right: 40px;">
        <button type="button" class="eye-btn" onclick="togglePassword()">
            <i class="bi bi-eye-slash" id="eyeIcon"></i>
        </button>
    </div>

    {{-- Remember + Forgot --}}
    <div class="form-bottom">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">Ingat saya</label>
        </div>
        <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
    </div>

    <button type="submit" class="btn-submit">
        <i class="bi bi-box-arrow-in-right"></i>
        Login
    </button>
</form>

        <div class="card-foot">
            <div class="secure-tag">
                <i class="bi bi-shield-check"></i>
                <span>Sistem aman &amp; terenkripsi</span>
            </div>
            <span class="copy-text">© 2026 Aplikasi SPP Sekolah</span>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function switchLogin(type) {
        const loginType  = document.getElementById('login_type');
        const formAdmin  = document.getElementById('formAdmin');
        const formSiswa  = document.getElementById('formSiswa');
        const labelPass  = document.getElementById('labelPassword');
        const btnAdmin   = document.getElementById('btnAdmin');
        const btnSiswa   = document.getElementById('btnSiswa');
        const emailInput = document.getElementById('email');
        const namaInput  = document.getElementById('nama');

        if (type === 'admin') {
            loginType.value = 'admin';
            formAdmin.style.display = 'block';
            formSiswa.style.display = 'none';
            labelPass.textContent = 'Password';
            emailInput.setAttribute('required', 'required');
            namaInput.removeAttribute('required');
            btnAdmin.classList.add('active');
            btnSiswa.classList.remove('active');
        } else {
            loginType.value = 'siswa';
            formAdmin.style.display = 'none';
            formSiswa.style.display = 'block';
            labelPass.textContent = 'NIS (Sebagai Password)';
            namaInput.setAttribute('required', 'required');
            emailInput.removeAttribute('required');
            btnSiswa.classList.add('active');
            btnAdmin.classList.remove('active');
        }
    }

    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('email').setAttribute('required', 'required');
    });
</script>
</body>
</html>