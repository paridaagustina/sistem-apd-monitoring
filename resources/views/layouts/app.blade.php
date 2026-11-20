
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'APDMONITOR')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ===== GLOBAL LAYOUT ===== */

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Figtree', sans-serif;
            background: #f4f7fc;
            color: #172b4d;
        }

        .app-shell {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */

        .sidebar {
            width: 255px;
            min-width: 255px;
            height: 100vh;
            position: sticky;
            top: 0;
            display: flex;
            flex-direction: column;
            padding: 25px 18px 15px;
            background: #ffffff;
            border-right: 1px solid #e9eef5;
            overflow-y: auto;
            z-index: 20;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 4px 9px 32px;
            color: #142b50;
            font-size: 21px;
            font-weight: 800;
            letter-spacing: -.6px;
        }

        .brand span {
            color: #2563eb;
        }

        .brand-icon {
            width: 43px;
            height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eaf1ff;
            border-radius: 13px;
            font-size: 23px;
        }

        .sidebar-label {
            color: #a0aec0;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
            padding: 0 12px;
            margin: 0 0 13px;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 13px;
            width: 100%;
            min-height: 48px;
            padding: 12px 14px;
            border: none;
            border-radius: 11px;
            background: transparent;
            color: #64748b;
            text-decoration: none;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            text-align: left;
            cursor: pointer;
            transition: all .2s ease;
        }

        .menu-link span {
            width: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .menu-link:hover {
            background: #f1f5fb;
            color: #2563eb;
            transform: translateX(2px);
        }

        .menu-link.active {
            background: #eaf1ff;
            color: #2563eb;
            font-weight: 800;
        }

        .sidebar-bottom {
            border-top: 1px solid #e8edf5;
            padding-top: 22px;
            margin-top: auto;
            margin-bottom: 18px;
        }

        .sidebar-bottom .sidebar-label {
            margin-bottom: 13px;
        }

        .sidebar-bottom form {
            margin: 5px 0 0;
        }

        .logout-link {
            color: #ef4444;
        }

        .logout-link:hover {
            background: #fff1f2;
            color: #dc2626;
        }

        .sidebar-footer {
            display: flex;
            align-items: center;
            gap: 11px;
            border-top: 1px solid #e8edf5;
            padding: 17px 10px 4px;
        }

        .footer-shield {
            width: 37px;
            height: 37px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e5f8ef;
            color: #059669;
            border-radius: 11px;
            font-size: 18px;
            font-weight: 800;
        }

        .sidebar-footer strong {
            display: block;
            font-size: 11px;
            color: #17345c;
        }

        .sidebar-footer small {
            display: block;
            color: #94a3b8;
            font-size: 10px;
            margin-top: 4px;
        }

        /* ===== MAIN AREA ===== */

        .main-area {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        /* ===== TOPBAR ===== */

        .topbar {
            min-height: 91px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 16px 32px;
            background: #ffffff;
            border-bottom: 1px solid #e9eef5;
        }

        .topbar-title {
            color: #172b4d;
            font-size: 17px;
            font-weight: 800;
            letter-spacing: -.2px;
        }

        .topbar-subtitle {
            margin-top: 5px;
            color: #8291a8;
            font-size: 11px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .user-avatar {
            width: 43px;
            height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #eaf1ff;
            color: #2563eb;
            font-size: 17px;
            font-weight: 800;
        }

        .user-detail strong {
            display: block;
            color: #172b4d;
            font-size: 12px;
            font-weight: 800;
        }

        .user-detail small {
            display: block;
            color: #94a3b8;
            font-size: 10px;
            margin-top: 4px;
        }

        /* ===== PAGE CONTENT ===== */

        .page-content {
            flex: 1;
            padding: 30px 32px;
        }

        .wadah {
            width: 100%;
            max-width: 1500px;
            margin: 0 auto;
        }

        /* ===== RESPONSIVE ===== */

        @media (max-width: 900px) {
            .sidebar {
                width: 220px;
                min-width: 220px;
                padding-left: 13px;
                padding-right: 13px;
            }

            .topbar {
                padding: 15px 22px;
            }

            .page-content {
                padding: 23px 20px;
            }
        }

        @media (max-width: 650px) {
            .app-shell {
                flex-direction: column;
            }

            .sidebar {
                position: relative;
                width: 100%;
                min-width: 100%;
                height: auto;
                padding: 13px;
                overflow: visible;
                border-right: none;
                border-bottom: 1px solid #e9eef5;
            }

            .brand {
                padding: 3px 7px 15px;
                font-size: 19px;
            }

            .brand-icon {
                width: 38px;
                height: 38px;
            }

            .sidebar-label {
                display: none;
            }

            .sidebar-menu {
                flex-direction: row;
                overflow-x: auto;
                padding-bottom: 5px;
            }

            .menu-link {
                width: auto;
                min-width: max-content;
                min-height: 40px;
                padding: 9px 12px;
                font-size: 11px;
                gap: 7px;
            }

            .menu-link span {
                font-size: 14px;
                width: auto;
            }

            .sidebar-bottom {
                display: flex;
                align-items: center;
                gap: 5px;
                border-top: 1px solid #edf1f7;
                padding-top: 9px;
                margin-top: 8px;
                margin-bottom: 0;
            }

            .sidebar-bottom .sidebar-label {
                display: none;
            }

            .sidebar-bottom .menu-link {
                min-height: 37px;
            }

            .sidebar-bottom form {
                margin: 0;
            }

            .sidebar-footer {
                display: none;
            }

            .topbar {
                min-height: 72px;
                padding: 12px 15px;
            }

            .topbar-title {
                font-size: 14px;
            }

            .topbar-subtitle {
                font-size: 9px;
            }

            .user-info {
                gap: 8px;
            }

            .user-avatar {
                width: 36px;
                height: 36px;
                font-size: 14px;
            }

            .user-detail strong {
                font-size: 10px;
            }

            .user-detail small {
                font-size: 9px;
            }

            .page-content {
                padding: 18px 13px;
            }
        }
    </style>

    @stack('styles')

</head>

<body>

<div class="app-shell">

    {{-- SIDEBAR --}}
    <aside class="sidebar">

        {{-- BRAND --}}
        <div class="brand">
            <div class="brand-icon">🛡️</div>
            <div>APD<span>MONITOR</span></div>
        </div>

        <div class="sidebar-label">MENU UTAMA</div>

        {{-- MENU NAVIGASI --}}
        <nav class="sidebar-menu">

            @if(auth()->user()->isAdmin())

                {{-- MENU ADMIN --}}

                <a href="{{ route('admin.dashboard') }}"
                   class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span>⌂</span> Dashboard
                </a>

                <a href="{{ route('admin.apd-items.index') }}"
                   class="menu-link {{ request()->routeIs('admin.apd-items.*') ? 'active' : '' }}">
                    <span>▣</span> Data APD
                </a>

                <a href="{{ route('admin.workers.index') }}"
                   class="menu-link {{ request()->routeIs('admin.workers.*') ? 'active' : '' }}">
                    <span>♙</span> Data Pekerja
                </a>

                <a href="{{ route('admin.field-reports.index') }}"
                   class="menu-link {{ request()->routeIs('admin.field-reports.*') ? 'active' : '' }}">
                    <span>▤</span> Laporan Lapangan
                </a>

                {{-- MENU CCV ADMIN --}}
                <a href="{{ route('admin.ccv.index') }}"
                   class="menu-link {{ request()->routeIs('admin.ccv.*') ? 'active' : '' }}">
                    <span>✓</span> CCV Monitoring
                </a>

                {{-- MENU PEMERIKSAAN KESEHATAN ADMIN --}}
                <a href="{{ route('admin.health-check.index') }}"
                   class="menu-link {{ request()->routeIs('admin.health-check.*') ? 'active' : '' }}">
                    <span>♡</span> Formulir Kesehatan
                </a>

            @else

                {{-- MENU PEKERJA --}}

                <a href="{{ route('pekerja.dashboard') }}"
                   class="menu-link {{ request()->routeIs('pekerja.dashboard') ? 'active' : '' }}">
                    <span>⌂</span> Dashboard
                </a>

                <a href="{{ route('pekerja.monitoring') }}"
                   class="menu-link {{ request()->routeIs('pekerja.monitoring') ? 'active' : '' }}">
                    <span>▣</span> Monitoring APD
                </a>

                <a href="{{ route('pekerja.field-reports.index') }}"
                   class="menu-link {{ request()->routeIs('pekerja.field-reports.*') ? 'active' : '' }}">
                    <span>▤</span> Laporan Lapangan
                </a>

                {{-- MENU FORMULIR CCV PEKERJA --}}
                <a href="{{ route('pekerja.ccv.create') }}"
                   class="menu-link {{ request()->routeIs('pekerja.ccv.*') ? 'active' : '' }}">
                    <span>✓</span> Formulir CCV
                </a>

                {{-- MENU PEMERIKSAAN KESEHATAN PEKERJA --}}
                <a href="{{ route('pekerja.health-check.create') }}"
                   class="menu-link {{ request()->routeIs('pekerja.health-check.*') ? 'active' : '' }}">
                    <span>♡</span> Pemeriksaan Kesehatan Petugas
                </a>

            @endif

        </nav>

        {{-- MENU AKUN --}}
        <div class="sidebar-bottom">

            <div class="sidebar-label">AKUN</div>

            <a href="{{ route('profile.edit') }}"
               class="menu-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <span>⚙</span> Pengaturan Profil
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="menu-link logout-link">
                    <span>⇥</span> Logout
                </button>
            </form>

        </div>

        {{-- FOOTER SIDEBAR --}}
        <div class="sidebar-footer">

            <div class="footer-shield">✓</div>

            <div>
                <strong>APDMONITOR</strong>
                <small>Workplace Safety System</small>
            </div>

        </div>

    </aside>

    {{-- AREA UTAMA --}}
    <div class="main-area">

        {{-- HEADER ATAS --}}
        <header class="topbar">

            <div class="topbar-heading">

                <div class="topbar-title">

                    @if(request()->routeIs('pekerja.ccv.*'))
                        Formulir CCV

                    @elseif(request()->routeIs('pekerja.health-check.*'))
                        Pemeriksaan Kesehatan Petugas

                    @elseif(request()->routeIs('admin.ccv.*'))
                        CCV Monitoring

                    @elseif(request()->routeIs('admin.health-check.*'))
                        Monitoring Kesehatan Petugas

                    @elseif(request()->routeIs('pekerja.field-reports.*'))
                        Live Laporan Lapangan

                    @elseif(request()->routeIs('admin.field-reports.*'))
                        Laporan Lapangan

                    @elseif(request()->routeIs('pekerja.monitoring'))
                        Monitoring APD

                    @elseif(request()->routeIs('admin.apd-items.*'))
                        Data APD

                    @elseif(request()->routeIs('admin.workers.*'))
                        Data Pekerja

                    @elseif(request()->routeIs('profile.*'))
                        Pengaturan Profil

                    @elseif(request()->routeIs('admin.dashboard', 'pekerja.dashboard'))
                        Dashboard

                    @else
                        @yield('page-heading', 'APDMONITOR')
                    @endif

                </div>

                <div class="topbar-subtitle">
                    Sistem Monitoring Keselamatan Kerja
                </div>

            </div>

            {{-- INFORMASI PENGGUNA --}}
            <div class="user-info">

                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="user-detail">

                    <strong>{{ auth()->user()->name }}</strong>

                    <small>
                        {{ auth()->user()->isAdmin()
                            ? 'Administrator'
                            : 'Pekerja Lapangan' }}
                    </small>

                </div>

            </div>

        </header>

        {{-- KONTEN HALAMAN --}}
        <main class="page-content">

            <div class="wadah">
                @yield('content')
            </div>

        </main>

    </div>

</div>

{{-- SCRIPT --}}
@stack('scripts')

</body>
</html>
