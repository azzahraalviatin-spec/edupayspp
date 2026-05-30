<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Aplikasi SPP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --abyss:   #092C56;
            --lapis:   #225688;
            --slate:   #668CA9;
            --glacier: #A9CBE0;
            --quartz:  #F0F5F4;
            --sidebar-w: 260px;
            --sidebar-w-collapsed: 72px;
            --topbar-h: 64px;
        }

        * { box-sizing: border-box; }

        body {
            background: #071d38;
            color: var(--quartz);
            margin: 0;
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            font-size: 14px;
        }

        /* ───── SIDEBAR ───── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--abyss) 0%, #061929 100%);
            position: fixed;
            top: 0; left: 0;
            z-index: 200;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(169,203,224,0.12);
            transition: width 0.3s cubic-bezier(.4,0,.2,1);
            overflow: hidden;
        }
        .sidebar.collapsed { width: var(--sidebar-w-collapsed); }

        .sidebar-brand {
            padding: 0 1.4rem;
            height: var(--topbar-h);
            border-bottom: 1px solid rgba(169,203,224,0.1);
            background: rgba(9,44,86,0.8);
            display: flex;
            align-items: center;
            gap: 12px;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .brand-icon {
            background: linear-gradient(135deg, var(--lapis), var(--slate));
            border-radius: 10px;
            width: 38px; height: 38px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(9,44,86,0.5);
        }
        .brand-text { transition: opacity 0.2s, width 0.2s; overflow: hidden; }
        .sidebar.collapsed .brand-text { opacity: 0; width: 0; }
        .brand-text .brand-name { font-size: 15px; font-weight: 800; color: var(--quartz); letter-spacing: -.01em; }
        .brand-text .brand-sub  { font-size: 10.5px; color: var(--glacier); font-weight: 500; }

        .sidebar-menu { padding: 1rem 0; flex: 1; overflow-y: auto; overflow-x: hidden; }
        .sidebar-menu::-webkit-scrollbar { width: 3px; }
        .sidebar-menu::-webkit-scrollbar-thumb { background: var(--lapis); border-radius: 99px; }

        .menu-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.8px;
            color: var(--slate);
            padding: 0.6rem 1.4rem 0.3rem;
            text-transform: uppercase;
            white-space: nowrap;
            transition: opacity 0.2s;
        }
        .sidebar.collapsed .menu-label { opacity: 0; }

        .nav-link {
            padding: 0.72rem 1.4rem;
            color: rgba(169,203,224,0.7);
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14.5px;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
            white-space: nowrap;
            position: relative;
        }
        .nav-link:hover {
            color: var(--quartz);
            background: rgba(169,203,224,0.08);
            border-left-color: var(--slate);
        }
        .nav-link.active {
            color: var(--quartz);
            background: linear-gradient(90deg, rgba(34,86,136,0.5) 0%, rgba(34,86,136,0.1) 100%);
            border-left-color: var(--glacier);
            font-weight: 700;
        }
        .nav-link i { font-size: 18px; width: 22px; flex-shrink: 0; }
        .nav-link .link-text { transition: opacity 0.2s; }
        .sidebar.collapsed .link-text { opacity: 0; width: 0; overflow: hidden; }

        .sidebar-footer {
            padding: 1rem 0 1rem;
            border-top: 1px solid rgba(169,203,224,0.1);
            background: rgba(6,25,41,0.6);
            white-space: nowrap;
            overflow: hidden;
            flex-shrink: 0;
        }
        .btn-logout {
            width: 100%;
            background: transparent;
            border: none;
            border-left: 3px solid transparent;
            color: #d6a3a3;
            font-size: 14.5px;
            font-weight: 500;
            padding: 0.72rem 1.4rem;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: left;
        }
        .btn-logout i { font-size: 18px; width: 22px; flex-shrink: 0; }
        .sidebar.collapsed .btn-logout-text { opacity: 0; width: 0; overflow: hidden; display: inline-block; }

        /* ───── TOPBAR ───── */
        .navbar-top {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            height: var(--topbar-h);
            background: rgba(9,44,86,0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(169,203,224,0.1);
            z-index: 150;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.75rem;
            transition: left 0.3s cubic-bezier(.4,0,.2,1);
        }
        .navbar-top.collapsed { left: var(--sidebar-w-collapsed); }

        .toggle-btn {
            width: 38px; height: 38px;
            border-radius: 9px;
            background: rgba(169,203,224,0.08);
            border: 1px solid rgba(169,203,224,0.15);
            color: var(--glacier);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 18px;
        }
        .toggle-btn:hover { background: var(--lapis); color: var(--quartz); border-color: var(--slate); }

        .breadcrumb-nav { display: flex; align-items: center; gap: 7px; font-size: 13.5px; }
        .bc-home { color: var(--glacier); text-decoration: none; font-weight: 500; }
        .bc-sep  { color: var(--slate); font-size: 10px; }
        .bc-current { color: var(--quartz); font-weight: 700; }

        .user-chip {
            background: rgba(34,86,136,0.4);
            border: 1px solid rgba(169,203,224,0.25);
            border-radius: 20px;
            padding: 5px 14px 5px 8px;
            font-size: 13px;
            color: var(--glacier);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .user-chip-dot {
            width: 28px; height: 28px;
            background: linear-gradient(135deg, var(--lapis), var(--slate));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px;
            color: #fff;
        }

        /* ───── NOTIFIKASI BELL ───── */
        .notif-wrap {
            position: relative;
        }

        .notif-btn {
            width: 38px; height: 38px;
            border-radius: 9px;
            background: rgba(169,203,224,0.08);
            border: 1px solid rgba(169,203,224,0.15);
            color: var(--glacier);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 18px;
            position: relative;
        }
        .notif-btn:hover { background: var(--lapis); color: var(--quartz); border-color: var(--slate); }

        .notif-badge {
            position: absolute;
            top: -5px; right: -5px;
            background: #ef4444;
            color: white;
            font-size: 10px;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            border-radius: 99px;
            display: flex; align-items: center; justify-content: center;
            padding: 0 4px;
            border: 2px solid #071d38;
        }
        .notif-badge.hidden { display: none; }

        /* Dropdown */
        .notif-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 360px;
            background: #0d2d4e;
            border: 1px solid rgba(169,203,224,0.2);
            border-radius: 14px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            z-index: 999;
            overflow: hidden;
        }
        .notif-dropdown.show { display: block; }

        .notif-head {
            padding: 14px 18px;
            border-bottom: 1px solid rgba(169,203,224,0.12);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .notif-head-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--quartz);
        }
        .btn-baca-semua {
            font-size: 12px;
            color: var(--glacier);
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            font-weight: 600;
        }
        .btn-baca-semua:hover { color: white; }

        .notif-list {
            max-height: 340px;
            overflow-y: auto;
        }
        .notif-list::-webkit-scrollbar { width: 3px; }
        .notif-list::-webkit-scrollbar-thumb { background: var(--lapis); border-radius: 99px; }

        .notif-item {
            padding: 13px 18px;
            border-bottom: 1px solid rgba(169,203,224,0.07);
            display: flex;
            gap: 12px;
            cursor: pointer;
            transition: background 0.15s;
            text-decoration: none;
        }
        .notif-item:hover { background: rgba(169,203,224,0.07); }
        .notif-item.unread { background: rgba(34,86,136,0.25); }

        .notif-icon {
            width: 38px; height: 38px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .notif-body { flex: 1; min-width: 0; }
        .notif-judul {
            font-size: 13px;
            font-weight: 700;
            color: var(--quartz);
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .notif-pesan {
            font-size: 12px;
            color: var(--glacier);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .notif-waktu {
            font-size: 11px;
            color: var(--slate);
            margin-top: 4px;
        }

        .notif-dot {
            width: 8px; height: 8px;
            background: #3b82f6;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 5px;
        }

        .notif-empty {
            padding: 40px 20px;
            text-align: center;
            color: var(--slate);
            font-size: 13px;
        }
        .notif-empty i { font-size: 36px; display: block; margin-bottom: 10px; opacity: 0.5; }

        .notif-footer {
            padding: 12px 18px;
            border-top: 1px solid rgba(169,203,224,0.12);
            text-align: center;
        }
        .notif-footer a {
            font-size: 13px;
            color: var(--glacier);
            text-decoration: none;
            font-weight: 600;
        }
        .notif-footer a:hover { color: white; }

        /* ───── MAIN ───── */
        .main-content {
            margin-left: var(--sidebar-w);
            margin-top: var(--topbar-h);
            min-height: calc(100vh - var(--topbar-h));
            transition: margin-left 0.3s cubic-bezier(.4,0,.2,1);
        }
        .main-content.collapsed { margin-left: var(--sidebar-w-collapsed); }
        .content-area { padding: 1.75rem; }

        .card {
            background: rgba(9,44,86,0.45);
            border: 1px solid rgba(169,203,224,0.13);
            border-radius: 14px;
            backdrop-filter: blur(8px);
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-mortarboard-fill text-white" style="font-size:17px"></i>
        </div>
        <div class="brand-text">
            <div class="brand-name">Aplikasi SPP</div>
            <div class="brand-sub">Portal Siswa</div>
        </div>
    </div>

    <div class="sidebar-menu">
        <div class="menu-label">Menu</div>
        <a href="{{ route('siswa.dashboard') }}"
           class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}"
           title="Dashboard">
            <i class="bi bi-speedometer2"></i>
            <span class="link-text">Dashboard</span>
        </a>
        <a href="{{ route('siswa.tagihan') }}"
           class="nav-link {{ request()->routeIs('siswa.tagihan') ? 'active' : '' }}"
           title="Tagihan Saya">
            <i class="bi bi-file-earmark-text-fill"></i>
            <span class="link-text">Tagihan Saya</span>
        </a>
        <a href="{{ route('siswa.riwayat') }}"
           class="nav-link {{ request()->routeIs('siswa.riwayat') ? 'active' : '' }}"
           title="Riwayat Bayar">
            <i class="bi bi-clock-history"></i>
            <span class="link-text">Riwayat Bayar</span>
        </a>
        <a href="{{ route('siswa.profil') }}"
           class="nav-link {{ request()->routeIs('siswa.profil') ? 'active' : '' }}"
           title="Profil">
            <i class="bi bi-person-circle"></i>
            <span class="link-text">Profil</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout" title="Logout">
                <i class="bi bi-box-arrow-right"></i>
                <span class="btn-logout-text">Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- Topbar -->
<nav class="navbar-top" id="navbarTop">
    <div class="d-flex align-items-center gap-3">
        <button class="toggle-btn" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <div class="breadcrumb-nav">
            <a href="{{ route('siswa.dashboard') }}" class="bc-home">
                <i class="bi bi-house-fill me-1"></i>Home
            </a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current">@yield('title', 'Dashboard')</span>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">

        {{-- ===== BELL NOTIFIKASI ===== --}}
        <div class="notif-wrap" id="notifWrap">
            <button class="notif-btn" id="notifBtn" onclick="toggleNotif(event)">
                <i class="bi bi-bell-fill"></i>
                <span class="notif-badge hidden" id="notifBadge">0</span>
            </button>

            <div class="notif-dropdown" id="notifDropdown">
                <div class="notif-head">
                    <span class="notif-head-title">🔔 Notifikasi</span>
                    <button class="btn-baca-semua" onclick="bacaSemua()">Tandai semua dibaca</button>
                </div>
                <div class="notif-list" id="notifList">
                    <div class="notif-empty">
                        <i class="bi bi-bell-slash"></i>
                        Memuat notifikasi...
                    </div>
                </div>
                <div class="notif-footer">
                    <a href="{{ route('siswa.notifications') }}">Lihat semua notifikasi</a>
                </div>
            </div>
        </div>

        <div class="user-chip">
            <div class="user-chip-dot"><i class="bi bi-person-fill"></i></div>
            {{ Auth::user()->name }}
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <div class="content-area">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ===== SIDEBAR TOGGLE =====
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('collapsed');
    document.getElementById('navbarTop').classList.toggle('collapsed');
    document.getElementById('mainContent').classList.toggle('collapsed');
}

// ===== NOTIFIKASI =====
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function toggleNotif(e) {
    e.stopPropagation();
    const dd = document.getElementById('notifDropdown');
    dd.classList.toggle('show');
    if (dd.classList.contains('show')) {
        loadNotif();
    }
}

// Tutup dropdown kalau klik di luar
document.addEventListener('click', function(e) {
    const wrap = document.getElementById('notifWrap');
    if (!wrap.contains(e.target)) {
        document.getElementById('notifDropdown').classList.remove('show');
    }
});

function loadNotif() {
    fetch('{{ route("siswa.notifications") }}', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        renderNotif(data.notifs);
        updateBadge(data.unread_count);
    })
    .catch(() => {
        document.getElementById('notifList').innerHTML = `
            <div class="notif-empty">
                <i class="bi bi-exclamation-circle"></i>
                Gagal memuat notifikasi
            </div>`;
    });
}

function renderNotif(notifs) {
    const list = document.getElementById('notifList');
    if (!notifs || notifs.length === 0) {
        list.innerHTML = `
            <div class="notif-empty">
                <i class="bi bi-bell-slash"></i>
                Belum ada notifikasi
            </div>`;
        return;
    }

    const warnaBg = {
        'success': 'rgba(22,163,74,0.2)',
        'warning': 'rgba(234,179,8,0.2)',
        'danger':  'rgba(239,68,68,0.2)',
        'info':    'rgba(59,130,246,0.2)',
        'primary': 'rgba(29,78,216,0.2)',
    };
    const warnaText = {
        'success': '#4ade80',
        'warning': '#fbbf24',
        'danger':  '#f87171',
        'info':    '#60a5fa',
        'primary': '#818cf8',
    };

    list.innerHTML = notifs.map(n => `
        <div class="notif-item ${n.dibaca ? '' : 'unread'}"
             onclick="bacaNotif('${n.id}', '${n.url}')">
            <div class="notif-icon"
                 style="background:${warnaBg[n.warna] || warnaBg['info']};color:${warnaText[n.warna] || warnaText['info']}">
                <i class="bi bi-${n.icon || 'bell'}"></i>
            </div>
            <div class="notif-body">
                <div class="notif-judul">${n.judul}</div>
                <div class="notif-pesan">${n.pesan}</div>
                <div class="notif-waktu">${n.waktu}</div>
            </div>
            ${!n.dibaca ? '<div class="notif-dot"></div>' : ''}
        </div>
    `).join('');
}

function updateBadge(count) {
    const badge = document.getElementById('notifBadge');
    if (count > 0) {
        badge.textContent = count > 99 ? '99+' : count;
        badge.classList.remove('hidden');
    } else {
        badge.classList.add('hidden');
    }
}

function bacaNotif(id, url) {
    fetch(`/siswa/notifications/${id}/baca`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json'
        }
    }).then(() => {
        if (url && url !== 'null' && url !== '') {
            window.location.href = url;
        } else {
            loadNotif();
        }
    });
}

function bacaSemua() {
    fetch('{{ route("siswa.notifications.baca-semua") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json'
        }
    }).then(() => {
        loadNotif();
    });
}

// Load badge saat halaman dibuka
document.addEventListener('DOMContentLoaded', function() {
    fetch('{{ route("siswa.notifications") }}', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => updateBadge(data.unread_count))
    .catch(() => {});
});
</script>
@yield('scripts')
</body>
</html>