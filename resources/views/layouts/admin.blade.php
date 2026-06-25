<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — ClinicalLog</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/clinicallog.css') }}">
    <script src="https://cdn.tailwindcss.com/3.4.17"></script>

    @stack('head')
</head>

<body>

    {{-- Background orbs --}}
    <div class="bg-orbs" aria-hidden="true">
        <div class="orb orb-1" style="opacity:.25;"></div>
        <div class="orb orb-3" style="opacity:.20;"></div>
    </div>

    <div class="admin-layout">

        {{-- ─── SIDEBAR ─── --}}
        <aside class="admin-sidebar" id="adminSidebar" role="navigation" aria-label="Admin navigation">

            {{-- Brand --}}
            <div class="admin-sidebar-logo" style="display:flex; align-items:center; justify-content:space-between;">
                <img src="{{ asset('assets/logo.png') }}" alt="ClinicalLog" height="40">
                <button type="button" class="lg:hidden" onclick="document.getElementById('adminSidebar').classList.remove('open')" style="background:none;border:none;cursor:pointer;color:var(--text-dim);padding:4px;" title="Tutup Sidebar">
                    <i data-lucide="x" style="width:20px;height:20px;"></i>
                </button>
            </div>

            {{-- Nav --}}
            <div class="admin-nav-group">Menu</div>

            <a href="{{ route('admin.dashboard') }}"
                class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.landing.edit') }}"
                class="admin-nav-link {{ request()->routeIs('admin.landing.*') ? 'active' : '' }}">
                <i data-lucide="file-text"></i>
                Landing Page
            </a>

            <a href="{{ route('admin.appointments.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
                <i data-lucide="calendar"></i>
                Appointment
            </a>

            <div class="admin-nav-group" style="margin-top:8px;">Sistem</div>

            <a href="{{ route('admin.users.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i data-lucide="users"></i>
                Pengguna
            </a>

            <a href="{{ route('home') }}" class="admin-nav-link" target="_blank">
                <i data-lucide="external-link"></i>
                Lihat Website
            </a>

            {{-- Spacer --}}
            <div style="flex:1;"></div>

            {{-- Auth user --}}
            <div class="glass-sm" style="border-radius:14px;padding:14px 16px;margin-top:16px;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div
                        style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#06b6d4);display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#fff;flex-shrink:0;">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div style="min-width:0;">
                        <div
                            style="font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ auth()->user()->name ?? 'Admin' }}</div>
                        <div style="font-size:11px;color:#64748b;">Administrator</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin-top:12px;">
                    @csrf
                    <button type="submit" class="admin-nav-link"
                        style="width:100%;border:none;background:none;cursor:pointer;color:#ef4444;padding:8px 10px;">
                        <i data-lucide="log-out"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- ─── MAIN CONTENT ─── --}}
        <div class="admin-main">

            {{-- Mobile topbar --}}
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;" class="lg:hidden">
                <button id="sidebarToggle" onclick="document.getElementById('adminSidebar').classList.toggle('open')"
                    style="width:40px;height:40px;border-radius:10px;background:rgba(15,23,42,.04);border:1px solid rgba(15,23,42,.08);display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-primary);">
                    <i data-lucide="menu" style="width:18px;height:18px;"></i>
                </button>
                <span style="font-size:16px;font-weight:600;">ClinicalLog Admin</span>
            </div>

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="glass-sm"
                    style="border-radius:14px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:12px;border-color:rgba(52,211,153,.5);background:rgba(52,211,153,.15);">
                    <i data-lucide="check-circle" style="width:18px;height:18px;color:#059669;flex-shrink:0;"></i>
                    <span style="font-size:14px;color:#064e3b;font-weight:500;">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="glass-sm"
                    style="border-radius:14px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:12px;border-color:rgba(248,113,113,.5);background:rgba(248,113,113,.15);">
                    <i data-lucide="alert-circle" style="width:18px;height:18px;color:#dc2626;flex-shrink:0;"></i>
                    <span style="font-size:14px;color:#7f1d1d;font-weight:500;">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Page content --}}
            @yield('content')

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>
        lucide.createIcons();

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', (e) => {
            const sidebar = document.getElementById('adminSidebar');
            const toggle = document.getElementById('sidebarToggle');
            if (sidebar && toggle && !sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
