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
        .bc-current { color: #f8fafc; font-weight: 600; font-size: 13px; }

        .icon-btn {
            width: 36px; height: 36px; border-radius: 8px;
            background: #0f172a; border: 1px solid rgba(255,255,255,0.08);
            color: #94a3b8; display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.2s; text-decoration: none;
        }
        .icon-btn:hover { background: rgba(59,130,246,0.15); color: #fff; border-color: #3b82f6; }

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
            <div style="font-size:10px;color:#94a3b8">Panel Admin</div>
        </div>
    </div>

    <div class="sidebar-menu">
        <div class="menu-label">Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i><span class="link-text">Dashboard</span>
        </a>

        <div class="menu-label">Data Master</div>
        <a href="{{ route('admin.siswa.index') }}" class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i><span class="link-text">Kelola Siswa</span>
        </a>
        <a href="{{ route('admin.kelas.index') }}" class="nav-link {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i><span class="link-text">Kelola Kelas</span>
        </a>
        <a href="{{ route('admin.tahun-ajaran.index') }}" class="nav-link {{ request()->routeIs('admin.tahun-ajaran.*') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i><span class="link-text">Tahun Ajaran</span>
        </a>
        <a href="{{ route('admin.setting-spp.index') }}" class="nav-link {{ request()->routeIs('admin.setting-spp.*') ? 'active' : '' }}">
            <i class="bi bi-gear-fill"></i><span class="link-text">Setting SPP</span>
        </a>

        <div class="menu-label">Keuangan</div>
        <a href="{{ route('admin.pembayaran.index') }}" class="nav-link {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}">
            <i class="bi bi-credit-card-fill"></i><span class="link-text">Metode Pembayaran</span>
        </a>
        <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-bar-graph"></i><span class="link-text">Laporan</span>
        </a>

        <div class="menu-label">Akun</div>
        <a href="{{ route('admin.user.index') }}" class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
            <i class="bi bi-person-gear"></i><span class="link-text">Kelola User</span>
        </a>
        <a href="{{ route('admin.profil') }}" class="nav-link {{ request()->routeIs('admin.profil') ? 'active' : '' }}">
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
        <span class="text-muted mx-1"><i class="bi bi-chevron-right" style="font-size:10px"></i></span>
        <span class="bc-current">@yield('title', 'Dashboard')</span>
    </div>

    <div class="navbar-right">

        {{-- NOTIFIKASI --}}
        <div class="dropdown">
            <button class="icon-btn position-relative" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell-fill" style="font-size:14px"></i>
                @if(count($notifDatabase ?? []) > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        id="badgeNotifCount" style="font-size:9px; padding:3px 6px;">
                        {{ count($notifDatabase) }}
                    </span>
                @endif
            </button>
            <div class="dropdown-menu dropdown-menu-end p-0 shadow-lg border-0 mt-2"
                style="background:#1e293b; width:320px; border-radius:12px; border:1px solid rgba(255,255,255,0.05) !important;">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom border-secondary">
                    <h6 class="text-white fw-bold mb-0" style="font-size:13px;">
                        <i class="bi bi-bell me-2 text-primary"></i>Notifikasi Terbaru
                    </h6>
                    <span id="textNotifCount"
                        style="color:#60a5fa; background:rgba(59,130,246,0.15); font-size:11px; padding:3px 8px; border-radius:20px;">
                        {{ count($notifDatabase ?? []) > 0 ? count($notifDatabase).' Belum Dibaca' : 'Tidak ada notifikasi baru' }}
                    </span>
                </div>
                <div class="list-group list-group-flush" style="max-height:250px; overflow-y:auto;">
                    @forelse($notifDatabase ?? [] as $notif)
                    <div class="list-group-item bg-transparent text-white border-bottom border-secondary p-3 item-notif"
                        id="notif-{{ $notif->id }}">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div style="flex:1; min-width:0;">
                                @php
                                    $notifData = json_decode($notif->data, true);
                                    $judul = $notifData['judul'] ?? $notifData['title'] ?? $notifData['message'] ?? 'Notifikasi Baru';
                                    $pesan = $notifData['pesan'] ?? $notifData['body'] ?? ($notifData['data']['message'] ?? '');
                                @endphp
                                <p class="mb-1 fw-semibold text-white" style="font-size:12.5px;">{{ $judul }}</p>
                                <small class="d-block" style="font-size:11px; color:#94a3b8;">{{ $pesan }}</small>
                                <small style="color:#475569; font-size:10px;">
                                    {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                                </small>
                            </div>
                            <button type="button" class="btn p-0 text-primary fw-bold btn-tandai-dibaca flex-shrink-0"
                                data-id="{{ $notif->id }}" style="font-size:10px; white-space:nowrap;">
                                <i class="bi bi-check2-all"></i> Tandai dibaca
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted small">
                        <i class="bi bi-bell-slash d-block fs-3 mb-2"></i>
                        Semua notifikasi telah dibaca
                    </div>
                    @endforelse
                </div>
                <div class="p-2 text-center border-top border-secondary">
                    <small class="text-muted" style="font-size:11px;">Sistem Keuangan Realtime</small>
                </div>
            </div>
        </div>
    {{-- PENGATURAN --}}
        <a href="{{ route('admin.profil') }}" class="icon-btn" title="Pengaturan Profil">
            <i class="bi bi-gear-fill" style="font-size:14px"></i>
        </a>
        {{-- USER BADGE --}}
        <a href="{{ route('admin.profil') }}" class="user-badge">
            <div class="user-avatar">
                <i class="bi bi-person-fill text-white" style="font-size:14px"></i>
            </div>
            <div class="user-info">
                <div class="uname">{{ Auth::user()->name }}</div>
              
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

document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.btn-tandai-dibaca');
    let count = buttons.length;

    buttons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.stopPropagation();
            const notifId = this.getAttribute('data-id');
            const notifItem = document.getElementById(`notif-${notifId}`);

            fetch(`{{ url('admin/notifikasi/baca') }}/${notifId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && notifItem) {
                    notifItem.style.transition = 'all 0.3s ease';
                    notifItem.style.opacity = '0';
                    setTimeout(() => {
                        notifItem.remove();
                        count--;
                        const badge = document.getElementById('badgeNotifCount');
                        const textCount = document.getElementById('textNotifCount');
                        if (count > 0) {
                            if(badge) badge.textContent = count;
                            if(textCount) textCount.textContent = `${count} Belum Dibaca`;
                        } else {
                            if(badge) badge.remove();
                            if(textCount) textCount.textContent = 'Tidak ada notifikasi baru';
                            const listGroup = document.querySelector('.list-group');
                            if(listGroup) listGroup.innerHTML = `<div class="text-center py-4 text-muted small"><i class="bi bi-bell-slash d-block fs-3 mb-2"></i>Semua notifikasi telah dibaca</div>`;
                        }
                    }, 300);
                }
            });
        });
    });
});
</script>
@yield('scripts')
</body>
</html>