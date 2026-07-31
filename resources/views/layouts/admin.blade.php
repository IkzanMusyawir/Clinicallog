<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — ClinicalLog</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=7">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @stack('head')
</head>
<body class="admin-body">
@php
    $adminUser = auth()->user();
    $adminUserName = $adminUser->name ?? 'Admin';
    $adminUserInitial = strtoupper(substr($adminUserName, 0, 1));
@endphp
<div id="navProgress"></div>
<div class="adm-layout" id="admLayout">
    <aside class="adm-sidebar" id="adminSidebar" role="navigation" aria-label="Admin navigation">
        <div class="adm-brand">
            <div class="adm-brand-inner">
                <img src="{{ asset('assets/logo.webp') }}" alt="ClinicalLog" class="adm-brand-logo">
            </div>
            <button type="button" class="adm-sidebar-close" onclick="closeSidebar()" title="Tutup">
                <x-icon name="x" />
            </button>
        </div>
        <nav class="adm-nav">
            <div class="adm-nav-section-label">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="adm-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="adm-nav-icon"><x-icon name="layout-dashboard" /></span>
                <span class="adm-nav-label">Dashboard</span>
            </a>
            <div class="adm-nav-dropdown-wrapper {{ request()->routeIs('admin.landing.*') ? 'open' : '' }}">
                <div style="display:flex;align-items:stretch;">
                    <a href="{{ route('admin.landing.edit') }}" class="adm-nav-item {{ request()->routeIs('admin.landing.*') ? 'active' : '' }}" style="flex:1;border-radius:10px 0 0 10px;">
                        <span class="adm-nav-icon"><x-icon name="file-text" /></span>
                        <span class="adm-nav-label">Konten Website</span>
                    </a>
                    <button type="button" onclick="toggleLandingDropdown(event)" class="adm-nav-item" style="border:none;border-radius:0 10px 10px 0;padding:10px 8px;cursor:pointer;flex-shrink:0;background:none;color:var(--atext2);font-family:inherit;" aria-label="Toggle submenu">
                        <x-icon name="chevron-down" class="adm-nav-chevron" />
                    </button>
                </div>
                <div class="adm-nav-sub" id="landingSubNav">
                    <a href="#" class="adm-nav-sub-item" data-section="hero" onclick="event.preventDefault(); goToLandingSection('hero'); return false;">Hero</a>
                    <a href="#" class="adm-nav-sub-item" data-section="navigation" onclick="event.preventDefault(); goToLandingSection('navigation'); return false;">Navigasi</a>
                    <a href="#" class="adm-nav-sub-item" data-section="about" onclick="event.preventDefault(); goToLandingSection('about'); return false;">Tentang</a>
                    <a href="#" class="adm-nav-sub-item" data-section="features" onclick="event.preventDefault(); goToLandingSection('features'); return false;">Fitur</a>
                    <a href="#" class="adm-nav-sub-item" data-section="benefits" onclick="event.preventDefault(); goToLandingSection('benefits'); return false;">Keunggulan</a>
                    <a href="#" class="adm-nav-sub-item" data-section="dashboard_tab" onclick="event.preventDefault(); goToLandingSection('dashboard_tab'); return false;">Dashboard</a>
                    <a href="#" class="adm-nav-sub-item" data-section="steps" onclick="event.preventDefault(); goToLandingSection('steps'); return false;">Cara Kerja</a>
                    <a href="#" class="adm-nav-sub-item" data-section="testimonials" onclick="event.preventDefault(); goToLandingSection('testimonials'); return false;">Testimoni</a>
                    <a href="#" class="adm-nav-sub-item" data-section="pricing" onclick="event.preventDefault(); goToLandingSection('pricing'); return false;">Harga</a>
                    <a href="#" class="adm-nav-sub-item" data-section="cta" onclick="event.preventDefault(); goToLandingSection('cta'); return false;">CTA</a>
                    <a href="#" class="adm-nav-sub-item" data-section="footer" onclick="event.preventDefault(); goToLandingSection('footer'); return false;">Footer</a>
                </div>
            </div>
            <a href="{{ route('admin.appointments.index') }}" class="adm-nav-item {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
                <span class="adm-nav-icon"><x-icon name="calendar-check" /></span>
                <span class="adm-nav-label">Appointment</span>
                <span class="adm-badge" id="appointmentsBadge" style="display:none;background:#ef4444;color:#fff;font-size:11px;font-weight:700;padding:2px 6px;border-radius:10px;margin-left:auto;min-width:18px;text-align:center;">0</span>
            </a>
            <div class="adm-nav-section-label">Sistem</div>
            <a href="{{ route('admin.users.index') }}" class="adm-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <span class="adm-nav-icon"><x-icon name="users" /></span>
                <span class="adm-nav-label">Pengguna</span>
            </a>
            <a href="{{ route('home') }}" class="adm-nav-item" target="_blank" rel="noopener">
                <span class="adm-nav-icon"><x-icon name="external-link" /></span>
                <span class="adm-nav-label">Lihat Website</span>
            </a>
        </nav>
        <div style="flex:1;"></div>
        <div class="adm-user-card">
            <div class="adm-user-avatar">{{ $adminUserInitial }}</div>
            <div class="adm-user-info">
                <div class="adm-user-name">{{ $adminUserName }}</div>
                <div class="adm-user-role">Administrator</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="adm-logout-btn" title="Keluar">
                    <x-icon name="log-out" />
                </button>
            </form>
        </div>
    </aside>
    <div class="adm-main">
        <header class="adm-header">
            <div class="adm-header-left">
                <button id="sidebarToggle" onclick="toggleSidebar()" class="adm-menu-btn" aria-label="Toggle menu">
                    <x-icon name="menu" />
                </button>
                <div class="adm-breadcrumb">
                    <span class="adm-breadcrumb-home"><x-icon name="home" /></span>
                    <span class="adm-breadcrumb-sep">/</span>
                    <span class="adm-breadcrumb-current">@yield('title', 'Dashboard')</span>
                </div>
            </div>
            <div class="adm-header-right">
                <div class="adm-header-time" id="headerTime"></div>
                <a href="{{ route('home') }}" target="_blank" rel="noopener" class="adm-header-btn" title="Buka Website">
                    <x-icon name="globe" />
                </a>
                <div class="adm-header-avatar" title="{{ $adminUserName }}">{{ $adminUserInitial }}</div>
            </div>
        </header>
        @if (session('success'))
        <div class="adm-alert adm-alert-success" id="flashSuccess">
            <x-icon name="check-circle" />
            <span>{{ session('success') }}</span>
            <button onclick="dismissAlert(this.closest('.adm-alert'))" class="adm-alert-close"><x-icon name="x" /></button>
        </div>
        @endif
        @if (session('error'))
        <div class="adm-alert adm-alert-error" id="flashError">
            <x-icon name="alert-circle" />
            <span>{{ session('error') }}</span>
            <button onclick="dismissAlert(this.closest('.adm-alert'))" class="adm-alert-close"><x-icon name="x" /></button>
        </div>
        @endif
        <div id="swup" class="adm-content transition-fade">
            @yield('content')
        </div>
    </div>
</div>
<div class="adm-overlay" id="admOverlay" onclick="closeSidebar()"></div>
<script>
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const APP_URL = @json(url('/'));
</script>
<script src="{{ asset('js/swup.umd.js') }}"></script>
    <script src="{{ asset('js/toggles.js') }}?v=1"></script>
    <script src="{{ asset('js/admin.js') }}?v=3"></script>
@stack('scripts')
</body>
</html>
