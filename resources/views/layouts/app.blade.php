<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — PPKD Hotel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --ppkd-primary:    #4caf7d;
            --ppkd-primary-dk: #388e5c;
            --ppkd-primary-lt: #e8f5ee;
            --ppkd-accent:     #2d7a55;
            --ppkd-soft:       #f0faf4;
            --ppkd-mint:       #b8e4c9;
            --ppkd-sidebar-bg: #1b4332;
            --ppkd-sidebar-text: #d1fae5;
            --ppkd-sidebar-hover: #2d6a4f;
            --ppkd-sidebar-active: #40916c;
            --ppkd-text:       #1a2e23;
            --ppkd-muted:      #6b8f78;
            --ppkd-border:     #d4edda;
            --ppkd-card-shadow: 0 2px 16px rgba(76,175,125,.10);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f4faf7;
            color: var(--ppkd-text);
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        #sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--ppkd-sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-brand .brand-logo {
            width: 48px; height: 48px;
            background: var(--ppkd-primary);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; color: #fff;
            margin-bottom: 10px;
        }
        .sidebar-brand h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; color: #fff;
            margin: 0; font-weight: 700;
        }
        .sidebar-brand span {
            font-size: .72rem;
            color: var(--ppkd-mint);
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .nav-section-title {
            font-size: .65rem; letter-spacing: .1em;
            text-transform: uppercase; color: #52826a;
            padding: 12px 10px 6px; margin-top: 8px;
        }

        .sidebar-nav .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 14px; border-radius: 10px;
            color: var(--ppkd-sidebar-text);
            font-size: .88rem; font-weight: 500;
            text-decoration: none;
            transition: all .2s;
            margin-bottom: 2px;
        }
        .sidebar-nav .nav-link i { font-size: 1.1rem; width: 20px; text-align: center; }
        .sidebar-nav .nav-link:hover { background: var(--ppkd-sidebar-hover); color: #fff; }
        .sidebar-nav .nav-link.active { background: var(--ppkd-sidebar-active); color: #fff; box-shadow: 0 2px 8px rgba(0,0,0,.2); }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-user {
            display: flex; align-items: center; gap: 10px;
            padding: 10px; border-radius: 10px;
            background: rgba(255,255,255,.06);
        }
        .sidebar-user .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--ppkd-primary);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #fff; font-size: .9rem;
        }
        .sidebar-user .info { flex: 1; min-width: 0; }
        .sidebar-user .info .name { color: #fff; font-size: .85rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-user .info .role { color: var(--ppkd-mint); font-size: .7rem; text-transform: capitalize; }

        /* ── Main content ── */
        #main-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--ppkd-border);
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }
        .topbar .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem; font-weight: 700;
            color: var(--ppkd-text);
        }
        .topbar .breadcrumb { margin: 0; font-size: .78rem; color: var(--ppkd-muted); }

        .content-area { padding: 28px; flex: 1; }

        /* ── Cards ── */
        .card {
            border: 1px solid var(--ppkd-border);
            border-radius: 16px;
            box-shadow: var(--ppkd-card-shadow);
            background: #fff;
        }
        .card-header {
            background: #fff;
            border-bottom: 1px solid var(--ppkd-border);
            border-radius: 16px 16px 0 0 !important;
            padding: 18px 22px;
            font-weight: 700;
            font-size: .95rem;
        }

        /* ── Stats cards ── */
        .stat-card {
            border-radius: 16px;
            padding: 22px;
            display: flex; align-items: center; gap: 16px;
            border: 1px solid var(--ppkd-border);
            background: #fff;
            box-shadow: var(--ppkd-card-shadow);
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(76,175,125,.15); }
        .stat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
        }
        .stat-icon.green  { background: var(--ppkd-primary-lt); color: var(--ppkd-primary); }
        .stat-icon.red    { background: #fde8e8; color: #e53e3e; }
        .stat-icon.yellow { background: #fef9e7; color: #d4a017; }
        .stat-icon.blue   { background: #e8f4fd; color: #3182ce; }
        .stat-value { font-size: 2rem; font-weight: 800; line-height: 1; color: var(--ppkd-text); }
        .stat-label { font-size: .8rem; color: var(--ppkd-muted); margin-top: 4px; }

        /* ── Room grid ── */
        .room-card {
            border-radius: 12px;
            padding: 14px;
            border: 2px solid transparent;
            transition: all .2s;
            cursor: default;
        }
        .room-card.available  { background: var(--ppkd-primary-lt); border-color: var(--ppkd-mint); }
        .room-card.occupied   { background: #fde8e8; border-color: #f5b7b7; }
        .room-card.cleaning   { background: #fef9e7; border-color: #f7dc6f; }
        .room-card.maintenance{ background: #f1f0f0; border-color: #ccc; }

        .room-number { font-weight: 800; font-size: 1.1rem; }
        .room-type-badge {
            font-size: .65rem; padding: 2px 8px; border-radius: 20px;
            font-weight: 600; text-transform: uppercase; letter-spacing: .05em;
        }

        /* ── Buttons ── */
        .btn-ppkd {
            background: var(--ppkd-primary);
            color: #fff; border: none;
            padding: 10px 22px; border-radius: 10px;
            font-weight: 600; font-size: .88rem;
            transition: all .2s;
        }
        .btn-ppkd:hover { background: var(--ppkd-primary-dk); color: #fff; transform: translateY(-1px); }
        .btn-ppkd-outline {
            background: transparent;
            color: var(--ppkd-primary);
            border: 1.5px solid var(--ppkd-primary);
            padding: 9px 20px; border-radius: 10px;
            font-weight: 600; font-size: .88rem;
            transition: all .2s;
        }
        .btn-ppkd-outline:hover { background: var(--ppkd-primary-lt); color: var(--ppkd-primary); }

        /* ── Forms ── */
        .form-control, .form-select {
            border: 1.5px solid var(--ppkd-border);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: .88rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--ppkd-primary);
            box-shadow: 0 0 0 3px rgba(76,175,125,.15);
        }
        .form-label { font-weight: 600; font-size: .82rem; color: var(--ppkd-muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: .04em; }

        .form-section {
            background: var(--ppkd-soft);
            border: 1px solid var(--ppkd-border);
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 22px;
        }
        .form-section-title {
            font-weight: 700; font-size: .9rem;
            color: var(--ppkd-accent);
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 18px; padding-bottom: 12px;
            border-bottom: 1px solid var(--ppkd-border);
        }

        /* ── Tables ── */
        .table { font-size: .85rem; }
        .table thead th {
            background: var(--ppkd-soft);
            color: var(--ppkd-accent);
            font-weight: 700;
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            border-bottom: 2px solid var(--ppkd-border);
        }
        .table tbody tr:hover { background: var(--ppkd-soft); }

        /* ── Badges ── */
        .badge-status {
            padding: 4px 12px; border-radius: 20px;
            font-size: .73rem; font-weight: 600;
        }
        .badge-available   { background: #d1fae5; color: #065f46; }
        .badge-occupied    { background: #fee2e2; color: #991b1b; }
        .badge-cleaning    { background: #fef3c7; color: #92400e; }
        .badge-maintenance { background: #f3f4f6; color: #374151; }
        .badge-reserved    { background: #dbeafe; color: #1e40af; }
        .badge-checked_in  { background: #d1fae5; color: #065f46; }
        .badge-checked_out { background: #f3f4f6; color: #374151; }
        .badge-cancelled   { background: #fee2e2; color: #991b1b; }

        /* ── Alert ── */
        .alert-ppkd {
            border-radius: 12px; border: none;
            padding: 14px 18px; font-size: .88rem;
        }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-danger  { background: #fee2e2; color: #991b1b; }

        /* ── Mobile toggle ── */
        .sidebar-toggle { display: none; }

        @media (max-width: 992px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
            #main-content { margin-left: 0; }
            .sidebar-toggle { display: block; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<div id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo">🏨</div>
        <h1>PPKD Hotel</h1>
        <span>Sistem Manajemen</span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-title">Menu Utama</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>
        <a href="{{ route('reservations.create') }}" class="nav-link {{ request()->routeIs('reservations.create') ? 'active' : '' }}">
            <i class="bi bi-person-plus-fill"></i> Check In Tamu
        </a>
        <a href="{{ route('reservations.index') }}" class="nav-link {{ request()->routeIs('reservations.index') ? 'active' : '' }}">
            <i class="bi bi-calendar2-check-fill"></i> Reservasi
        </a>
        <a href="{{ route('rooms.index') }}" class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
            <i class="bi bi-door-open-fill"></i> Status Kamar
        </a>
    

      @if(auth()->user()->isAdmin())
    <div class="nav-section-title">Administrator</div>
    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <i class="bi bi-people-fill"></i> Kelola Karyawan
    </a>
    <a href="{{ route('room-types.index') }}" class="nav-link {{ request()->routeIs('room-types.*') ? 'active' : '' }}">
        <i class="bi bi-door-open-fill"></i> Tipe Kamar
    </a>
@endif
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="info">
                <div class="name">{{ auth()->user()->name }}</div>
                <div class="role">{{ auth()->user()->role }}</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="mt-2">
            @csrf
            <button type="submit" class="btn btn-sm w-100" style="background:rgba(255,255,255,.08);color:#d1fae5;border-radius:8px;font-size:.8rem;">
                <i class="bi bi-box-arrow-left me-1"></i> Logout
            </button>
        </form>
    </div>
</div>

<!-- Main Content -->
<div id="main-content">
    <div class="topbar">
        <div>
            <div class="page-title">@yield('page-title', 'Dashboard')</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">@yield('breadcrumb')</ol>
            </nav>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted" style="font-size:.82rem;">{{ now()->format('l, d F Y') }}</span>
            <button class="btn btn-sm sidebar-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
                <i class="bi bi-list fs-5"></i>
            </button>
        </div>
    </div>

    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-ppkd alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-ppkd alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
