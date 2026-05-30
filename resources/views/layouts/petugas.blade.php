<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Aplikasi SPP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { background: #0f172a; color: #f8fafc; margin: 0; font-family: 'Segoe UI', sans-serif; }

        .sidebar {
            width: 250px; min-height: 100vh; background: #1e293b;
            position: fixed; top: 0; left: 0; z-index: 100;
            display: flex; flex-direction: column;
            border-right: 1px solid rgba(255,255,255,0.05);
            transition: width 0.3s ease; overflow: hidden;
        }
        .sidebar.collapsed { width: 68px; }

        .sidebar-brand {
            padding: 0 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            background: rgba(59,130,246,0.08);
            display: flex; align-items: center; gap: 10px;
            white-space: nowrap; height: 64px; min-height: 64px;
        }
        .sidebar-brand .brand-text { transition: opacity 0.2s; }
        .sidebar.collapsed .brand-text { opacity: 0; width: 0; overflow: hidden; }

        .sidebar-menu { padding: 0.5rem 0; flex: 1; overflow-y: auto; overflow-x: hidden; }

        .menu-label {
            font-size: 10px; font-weight: 700; letter-spacing: 1.5px;
            color: #3b82f6; padding: 0.75rem 1.25rem 0.25rem;
            text-transform: uppercase; white-space: nowrap; transition: opacity 0.2s;
        }
        .sidebar.collapsed .menu-label { opacity: 0; }

        .nav-link {
            padding: 0.6rem 1.25rem; color: #94a3b8; border-radius: 0;
            display: flex; align-items: center; gap: 10px; font-size: 13.5px;
            transition: all 0.2s; border-left: 3px solid transparent; white-space: nowrap;
        }
        .nav-link:hover { color: #fff; background: rgba(255,255,255,0.03); border-left: 3px solid #3b82f6; }
        .nav-link.active { color: #fff; background: rgba(59,130,246,0.12); border-left: 3px solid #3b82f6; font-weight: 600; }
        .nav-link i { font-size: 16px; width: 20px; flex-shrink: 0; }
        .nav-link .link-text { transition: opacity 0.2s; }
        .sidebar.collapsed .link-text { opacity: 0; width: 0; overflow: hidden; }

        .btn-logout-sidebar {
            background: transparent; border: none; color: #fca5a5;
            text-align: left; width: 100%;
        }
        .btn-logout-sidebar:hover {
            background: rgba(239,68,68,0.1) !important;
            color: #ef4444 !important;
            border-left: 3px solid #ef4444 !important;
        }

        .navbar-top {
            position: fixed; top: 0; left: 250px; right: 0; height: 64px;
            background: #1e293b; border-bottom: 1px solid rgba(255,255,255,0.05);
            z-index: 99; display: flex; align-items: center;
            justify-content: space-between; padding: 0 1.5rem;
            transition: left 0.3s ease;
        }
        .navbar-top.collapsed { left: 68px; }
        .navbar-left { display: flex; align-items: center; gap: 12px; }
        .navbar-right { display: flex; align-items: center; gap: 8px; }

        .toggle-btn {
            width: 36px; height: 36px; border-radius: 8px;
            background: #0f172a; border: 1px solid rgba(255,255,255,0.08);
            color: #94a3b8; display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.2s;
        }
        .toggle-btn:hover { background: rgba(59,130,246,0.15); color: #fff; border-color: #3b82f6; }

        .breadcrumb-nav { display: flex; align-items: center; gap: 6px; font-size: 13px; }
        .breadcrumb-nav .bc-home { color: #3b82f6; text-decoration: none; }
        .breadcrumb-nav .bc-sep { color: #334155; }
        .breadcrumb-nav .bc-current { color: #f8fafc; font-weight: 600; }

        .icon-btn {
            width: 36px; height: 36px; border-radius: 8px;
            background: #0f172a; border: 1px solid rgba(255,255,255,0.08);
            color: #94a3b8; display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.2s; text-decoration: none;
            position: relative;
        }
        .icon-btn:hover { background: rgba(59,130,246,0.15); color: #fff; border-color: #3b82f6; }

        /* ── NOTIF BADGE ── */
        .notif-badge {
            position: absolute; top: -5px; right: -5px;
            background: #ef4444; color: #fff;
            font-size: 9px; font-weight: 800;
            width: 18px; height: 18px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid #1e293b;
            animation: pulse-badge 2s infinite;
        }
        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50%       { transform: scale(1.15); }
        }

        /* ── NOTIF DROPDOWN ── */
        .notif-dropdown {
            position: absolute; top: calc(100% + 10px); right: 0;
            width: 340px; background: #1e293b;
            border: 1px solid rgba(59,130,246,0.25);
            border-radius: 14px; box-shadow: 0 16px 48px rgba(0,0,0,0.5);
            z-index: 9999; display: none; overflow: hidden;
        }
        .notif-dropdown.show { display: block; }
        .notif-header {
            padding: 14px 16px; border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex; align-items: center; justify-content: space-between;
        }
        .notif-header .title { color: #fff; font-size: 13px; font-weight: 700; }
        .notif-header .mark-all {
            color: #3b82f6; font-size: 11px; font-weight: 600;
            text-decoration: none; cursor: pointer; background: none; border: none; padding: 0;
        }
        .notif-header .mark-all:hover { color: #60a5fa; }
        .notif-list { max-height: 320px; overflow-y: auto; }
        .notif-list::-webkit-scrollbar { width: 4px; }
        .notif-list::-webkit-scrollbar-thumb { background: #334155; border-radius: 99px; }

        .notif-item {
            padding: 12px 16px; border-bottom: 1px solid rgba(255,255,255,0.04);
            display: flex; align-items: flex-start; gap: 11px;
            transition: background .15s; cursor: pointer; text-decoration: none;
        }
        .notif-item:hover { background: rgba(59,130,246,0.07); }
        .notif-item.unread { background: rgba(59,130,246,0.05); }
        .notif-item:last-child { border-bottom: none; }

        .notif-icon {
            width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center; font-size: 16px;
        }
        .notif-icon.pending  { background: rgba(234,179,8,0.15);  color: #fbbf24; }
        .notif-icon.lunas    { background: rgba(34,197,94,0.15);   color: #4ade80; }
        .notif-icon.ditolak  { background: rgba(239,68,68,0.15);   color: #f87171; }

        .notif-content { flex: 1; min-width: 0; }
        .notif-content .ntitle { color: #e2e8f0; font-size: 12.5px; font-weight: 600; line-height: 1.3; }
        .notif-content .nsub   { color: #64748b;  font-size: 11px; margin-top: 3px; }
        .notif-content .ntime  { color: #475569;  font-size: 10px; margin-top: 4px; }
        .notif-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #3b82f6; flex-shrink: 0; margin-top: 5px;
        }

        .notif-footer {
            padding: 10px 16px; border-top: 1px solid rgba(255,255,255,0.06);
            text-align: center;
        }
        .notif-footer a {
            color: #3b82f6; font-size: 12px; font-weight: 600; text-decoration: none;
        }
        .notif-footer a:hover { color: #60a5fa; }

        .notif-empty {
            padding: 32px 16px; text-align: center;
        }
        .notif-empty i    { font-size: 2.5rem; color: #334155; display: block; margin-bottom: 8px; }
        .notif-empty span { color: #475569; font-size: 13px; }

        /* USER BADGE */
        .user-badge {
            display: flex; align-items: center; gap: 8px;
            background: #0f172a; border: 1px solid rgba(255,255,255,0.08);
            border-radius: 30px; padding: 4px 14px 4px 4px;
            text-decoration: none; transition: all 0.2s; cursor: pointer;
        }
        .user-badge:hover { border-color: #3b82f6; background: rgba(59,130,246,0.08); }
        .user-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .user-info .uname { font-size: 12px; font-weight: 700; color: #e2e8f0; line-height: 1.2; }
        .user-info .urole { font-size: 10px; color: #64748b; line-height: 1.2; }

        .main-content {
            margin-left: 250px; margin-top: 64px;
            min-height: calc(100vh - 64px); background: #0f172a;
            transition: margin-left 0.3s ease;
        }
        .main-content.collapsed { margin-left: 68px; }
        .content-area { padding: 1.5rem; }

        .card {
            background: #1e293b !important;
            border: 1px solid rgba(255,255,255,0.05) !important;
            border-radius: 12px;
        }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 10px; }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div style="background:#3b82f6;border-radius:8px;padding:6px 8px;flex-shrink:0">
            <i class="bi bi-mortarboard-fill text-white" style="font-size:16px"></i>
        </div>
        <div class="brand-text">
            <div class="fw-bold text-white" style="font-size:13px">Edupay</div>
            <div style="font-size:10px;color:#94a3b8">Panel Petugas</div>
        </div>
    </div>

    <div class="sidebar-menu">
        <div class="menu-label">Utama</div>
        <a href="{{ route('petugas.dashboard') }}" class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i><span class="link-text">Dashboard</span>
        </a>

        <div class="menu-label">Tagihan</div>
        <a href="{{ route('petugas.tagihan.generate') }}" class="nav-link {{ request()->routeIs('petugas.tagihan.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-plus-fill"></i><span class="link-text">Generate Tagihan</span>
        </a>
        <a href="{{ route('petugas.tunggakan') }}" class="nav-link {{ request()->routeIs('petugas.tunggakan*') ? 'active' : '' }}">
            <i class="bi bi-exclamation-triangle-fill"></i><span class="link-text">Cek Tunggakan</span>
        </a>

        <div class="menu-label">Pembayaran</div>
        <a href="{{ route('petugas.verifikasi.index') }}" class="nav-link {{ request()->routeIs('petugas.verifikasi.*') ? 'active' : '' }}">
            <i class="bi bi-patch-check-fill"></i>
            <span class="link-text">Verifikasi Bayar</span>
            @php $pendingCount = \App\Models\Pembayaran::where('status_verifikasi','pending')->count(); @endphp
            @if($pendingCount > 0)
                <span class="ms-auto badge" style="background:#ef4444;font-size:10px;border-radius:20px;padding:2px 7px">{{ $pendingCount }}</span>
            @endif
        </a>
        <a href="{{ route('petugas.riwayat') }}" class="nav-link {{ request()->routeIs('petugas.riwayat') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i><span class="link-text">Riwayat Transaksi</span>
        </a>

        <div class="menu-label">Lainnya</div>
        <a href="{{ route('petugas.potongan') }}" class="nav-link {{ request()->routeIs('petugas.potongan*') ? 'active' : '' }}">
            <i class="bi bi-scissors"></i><span class="link-text">Potongan SPP</span>
        </a>
        <a href="{{ route('petugas.profil') }}" class="nav-link {{ request()->routeIs('petugas.profil') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i><span class="link-text">Profil</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link btn-logout-sidebar">
                <i class="bi bi-box-arrow-right text-danger"></i>
                <span class="link-text text-danger fw-bold">Logout</span>
            </button>
        </form>
    </div>
</div>

{{-- NAVBAR --}}
<nav class="navbar-top" id="navbarTop">
    <div class="navbar-left">
        <button class="toggle-btn" onclick="toggleSidebar()">
            <i class="bi bi-list" style="font-size:18px"></i>
        </button>
        <div class="breadcrumb-nav">
            <a href="{{ route('petugas.dashboard') }}" class="bc-home">
                <i class="bi bi-house-fill me-1"></i>Home
            </a>
            <span class="bc-sep"><i class="bi bi-chevron-right" style="font-size:10px"></i></span>
            <span class="bc-current">@yield('title', 'Dashboard')</span>
        </div>
    </div>

    <div class="navbar-right">

        {{-- ── NOTIFIKASI ── --}}
        @php
            $notifPending = \App\Models\Pembayaran::with('tagihan.siswa')
                ->where('status_verifikasi', 'pending')
                ->latest()
                ->take(8)
                ->get();
            $notifCount = $notifPending->count();
        @endphp

        <div style="position:relative" id="notifWrap">
            <button class="icon-btn" id="notifBtn" onclick="toggleNotif()" title="Notifikasi">
                <i class="bi bi-bell-fill" style="font-size:14px"></i>
                @if($notifCount > 0)
                    <span class="notif-badge">{{ $notifCount > 9 ? '9+' : $notifCount }}</span>
                @endif
            </button>

            <div class="notif-dropdown" id="notifDropdown">
                <div class="notif-header">
                    <span class="title">
                        <i class="bi bi-bell-fill me-2" style="color:#fbbf24"></i>
                        Notifikasi
                        @if($notifCount > 0)
                            <span style="background:rgba(239,68,68,.2);color:#f87171;border-radius:20px;padding:2px 8px;font-size:10px;margin-left:6px">{{ $notifCount }} pending</span>
                        @endif
                    </span>
                    @if($notifCount > 0)
                        <a href="{{ route('petugas.verifikasi.index') }}" class="mark-all">Lihat Semua →</a>
                    @endif
                </div>

                <div class="notif-list">
                    @forelse($notifPending as $p)
                    <a href="{{ route('petugas.verifikasi.index') }}" class="notif-item unread">
                        <div class="notif-icon pending">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <div class="notif-content">
                            <div class="ntitle">{{ $p->tagihan->siswa->nama ?? 'Siswa' }} mengirim bukti bayar</div>
                            <div class="nsub">
                                Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                                @if($p->metode_pembayaran)
                                    · via {{ ucfirst($p->metode_pembayaran) }}
                                @endif
                            </div>
                            <div class="ntime">
                                <i class="bi bi-clock me-1"></i>
                                {{ \Carbon\Carbon::parse($p->created_at)->diffForHumans() }}
                            </div>
                        </div>
                        <div class="notif-dot"></div>
                    </a>
                    @empty
                    <div class="notif-empty">
                        <i class="bi bi-bell-slash"></i>
                        <span>Tidak ada notifikasi baru</span>
                    </div>
                    @endforelse
                </div>

                @if($notifCount > 0)
                <div class="notif-footer">
                    <a href="{{ route('petugas.verifikasi.index') }}">
                        <i class="bi bi-arrow-right-circle me-1"></i>
                        Lihat semua & verifikasi
                    </a>
                </div>
                @endif
            </div>
        </div>

        {{-- PENGATURAN --}}
        <a href="{{ route('petugas.profil') }}" class="icon-btn" title="Profil">
            <i class="bi bi-gear-fill" style="font-size:14px"></i>
        </a>

        {{-- USER BADGE --}}
        <a href="{{ route('petugas.profil') }}" class="user-badge">
            <div class="user-avatar">
                <i class="bi bi-person-fill text-white" style="font-size:14px"></i>
            </div>
            <div class="user-info">
                <div class="uname">{{ Auth::user()->name }}</div>
                <div class="urole">Petugas / Bendahara</div>
            </div>
        </a>

    </div>
</nav>

{{-- CONTENT --}}
<div class="main-content" id="mainContent">
    <div class="content-area">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('collapsed');
    document.getElementById('navbarTop').classList.toggle('collapsed');
    document.getElementById('mainContent').classList.toggle('collapsed');
}

function toggleNotif() {
    document.getElementById('notifDropdown').classList.toggle('show');
}

// Tutup dropdown kalau klik di luar
document.addEventListener('click', function(e) {
    const wrap = document.getElementById('notifWrap');
    if (wrap && !wrap.contains(e.target)) {
        document.getElementById('notifDropdown').classList.remove('show');
    }
});

// Auto refresh notif badge tiap 30 detik
setInterval(function() {
    fetch(window.location.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(() => {})
        .catch(() => {});
}, 30000);
</script>
@yield('scripts')
</body>
</html>