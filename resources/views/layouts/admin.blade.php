<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — ClinicalLog</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Fonts: preconnect for speed --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=3">

    @stack('head')

<style>
.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 99999;
    display: flex;
    flex-direction: column;
    gap: 10px;
    pointer-events: none;
}
.toast {
    pointer-events: auto;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 20px;
    border-radius: 14px;
    font-size: 13px;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    box-shadow: 0 10px 40px rgba(0,0,0,.15), 0 2px 6px rgba(0,0,0,.08);
    animation: toastIn .35s cubic-bezier(.34,1.56,.64,1) both;
    max-width: 420px;
    word-break: break-word;
}
.toast.toast-success {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}
.toast.toast-error {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}
.toast.toast-out {
    animation: toastOut .3s cubic-bezier(.4,0,1,1) both;
}
@keyframes toastIn {
    from { opacity: 0; transform: translateX(40px) scale(.95); }
    to   { opacity: 1; transform: translateX(0) scale(1); }
}
@keyframes toastOut {
    from { opacity: 1; transform: translateX(0) scale(1); }
    to   { opacity: 0; transform: translateX(40px) scale(.9); }
}
.toast .toast-close {
    background: none;
    border: none;
    cursor: pointer;
    color: inherit;
    opacity: .5;
    padding: 0;
    margin-left: 4px;
    flex-shrink: 0;
    transition: opacity .2s;
}
.toast .toast-close:hover { opacity: 1; }
</style>
</head>

<body class="admin-body">

<div class="adm-layout" id="admLayout">

    {{-- ══ SIDEBAR ══ --}}
    <aside class="adm-sidebar" id="adminSidebar" role="navigation" aria-label="Admin navigation">

        {{-- Brand --}}
        <div class="adm-brand">
            <div class="adm-brand-inner">
                <img src="{{ asset('assets/logo.png') }}" alt="ClinicalLog" class="adm-brand-logo">
            </div>
            <button type="button" class="adm-sidebar-close" onclick="closeSidebar()" title="Tutup">
                <i data-lucide="x"></i>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="adm-nav">
            <div class="adm-nav-section-label">Menu Utama</div>

            <a href="{{ route('admin.dashboard') }}"
               class="adm-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="adm-nav-icon"><i data-lucide="layout-dashboard"></i></span>
                <span class="adm-nav-label">Dashboard</span>
            </a>

            <a href="{{ route('admin.landing.edit') }}"
               class="adm-nav-item {{ request()->routeIs('admin.landing.*') ? 'active' : '' }}">
                <span class="adm-nav-icon"><i data-lucide="file-text"></i></span>
                <span class="adm-nav-label">Landing Page</span>
            </a>

            <a href="{{ route('admin.appointments.index') }}"
               class="adm-nav-item {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
                <span class="adm-nav-icon"><i data-lucide="calendar-check"></i></span>
                <span class="adm-nav-label">Appointment</span>
            </a>

            <div class="adm-nav-section-label">Sistem</div>

            <a href="{{ route('admin.users.index') }}"
               class="adm-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <span class="adm-nav-icon"><i data-lucide="users"></i></span>
                <span class="adm-nav-label">Pengguna</span>
            </a>

            <a href="{{ route('home') }}" class="adm-nav-item" target="_blank" rel="noopener">
                <span class="adm-nav-icon"><i data-lucide="external-link"></i></span>
                <span class="adm-nav-label">Lihat Website</span>
            </a>
        </nav>

        <div style="flex:1;"></div>

        {{-- User --}}
        <div class="adm-user-card">
            <div class="adm-user-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="adm-user-info">
                <div class="adm-user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="adm-user-role">Administrator</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="adm-logout-btn" title="Keluar">
                    <i data-lucide="log-out"></i>
                </button>
            </form>
        </div>

    </aside>

    {{-- ══ MAIN ══ --}}
    <div class="adm-main">

        {{-- Header --}}
        <header class="adm-header">
            <div class="adm-header-left">
                <button id="sidebarToggle" onclick="toggleSidebar()" class="adm-menu-btn" aria-label="Toggle menu">
                    <i data-lucide="menu"></i>
                </button>
                <div class="adm-breadcrumb">
                    <span class="adm-breadcrumb-home">
                        <i data-lucide="home" style="width:13px;height:13px;"></i>
                    </span>
                    <span class="adm-breadcrumb-sep">/</span>
                    <span class="adm-breadcrumb-current">@yield('title', 'Dashboard')</span>
                </div>
            </div>
            <div class="adm-header-right">
                <div class="adm-header-time" id="headerTime"></div>
                <a href="{{ route('home') }}" target="_blank" rel="noopener" class="adm-header-btn" title="Buka Website">
                    <i data-lucide="globe"></i>
                </a>
                <div class="adm-header-avatar" title="{{ auth()->user()->name ?? 'Admin' }}">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Flash --}}
        @if (session('success'))
            <div class="adm-alert adm-alert-success" id="flashAlert">
                <i data-lucide="check-circle"></i>
                <span>{{ session('success') }}</span>
                <button onclick="dismissAlert(this.closest('.adm-alert'))" class="adm-alert-close"><i data-lucide="x"></i></button>
            </div>
        @endif
        @if (session('error'))
            <div class="adm-alert adm-alert-error" id="flashAlert">
                <i data-lucide="alert-circle"></i>
                <span>{{ session('error') }}</span>
                <button onclick="dismissAlert(this.closest('.adm-alert'))" class="adm-alert-close"><i data-lucide="x"></i></button>
            </div>
        @endif

        {{-- Content --}}
        <div class="adm-content">
            @yield('content')
        </div>

    </div>
</div>

{{-- Mobile overlay --}}
<div class="adm-overlay" id="admOverlay" onclick="closeSidebar()"></div>

{{-- Lucide icons (deferred) --}}
<script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js" defer></script>
<script>
    // Run after DOM ready
    document.addEventListener('DOMContentLoaded', function () {
        // Init icons
        if (window.lucide) lucide.createIcons();

        // Live clock
        const clockEl = document.getElementById('headerTime');
        function tick() {
            if (!clockEl) return;
            const now = new Date();
            clockEl.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }
        tick();
        setInterval(tick, 30000); // update every 30s for perf

        // Auto-dismiss flash alert with smooth animation
        const flash = document.getElementById('flashAlert');
        if (flash) {
            setTimeout(() => dismissAlert(flash), 4000);
        }
    });

    // Wait for lucide to load if deferred
    window.addEventListener('load', () => {
        if (window.lucide) lucide.createIcons();
    });

    // Smooth navigation for anchor links – works on click and on page load with hash
    document.addEventListener('DOMContentLoaded', () => {
        // Handle clicks on hash links
        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', e => {
                const href = link.getAttribute('href');
                if (!href || href.length < 2) return; // ignore just '#'
                const targetId = href.substring(1);
                const targetEl = document.getElementById(targetId);
                if (targetEl) {
                    e.preventDefault();
                    targetEl.scrollIntoView({ behavior: 'smooth' });
                    // Update URL hash without jumping
                    history.pushState(null, '', href);
                }
            });
        });
        // If page loaded with a hash, animate scroll after a short delay
        if (window.location.hash) {
            const targetId = window.location.hash.substring(1);
            const targetEl = document.getElementById(targetId);
            if (targetEl) {
                setTimeout(() => {
                    targetEl.scrollIntoView({ behavior: 'smooth' });
                }, 150);
            }
        }
    });

    // Smooth alert dismiss using transitionend for precise timing
    function dismissAlert(el) {
        if (!el || el.classList.contains('dismissing')) return;
        el.classList.add('dismissing');
        // Remove after the last transition finishes
        const removeAfter = (e) => {
            // Ensure we act only on the element itself, not children
            if (e.target !== el) return;
            el.removeEventListener('transitionend', removeAfter);
            el.remove();
        };
        el.addEventListener('transitionend', removeAfter);
    }


    function toggleSidebar() {
        document.getElementById('admLayout').classList.toggle('sidebar-open');
        document.getElementById('admOverlay').classList.toggle('active');
    }
    function closeSidebar() {
        document.getElementById('admLayout').classList.remove('sidebar-open');
        document.getElementById('admOverlay').classList.remove('active');
    }

    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function showToast(message, type = 'success', duration = 4000) {
        let container = document.getElementById('toastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container';
            document.body.appendChild(container);
        }
        const toast = document.createElement('div');
        toast.className = 'toast toast-' + type;
        const iconSvg = type === 'success'
            ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>'
            : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>';
        toast.innerHTML = iconSvg + '<span>' + message + '</span><button class="toast-close" onclick="dismissToast(this.parentElement)">&times;</button>';
        container.appendChild(toast);
        setTimeout(function() { dismissToast(toast); }, duration);
    }

    function dismissToast(el) {
        if (!el || el.classList.contains('toast-out')) return;
        el.classList.add('toast-out');
        el.addEventListener('animationend', function() { el.remove(); });
    }

    function ajaxSubmit(form, options = {}) {
        const method = form.method ? form.method.toUpperCase() : 'POST';
        const action = form.action;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('[type="submit"]');
        const originalBtnHTML = submitBtn ? submitBtn.innerHTML : '';

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="animation:spin 1s linear infinite"><path d="M21 12a9 9 0 1 1-6.22-8.56"/></svg> Menyimpan...';
        }

        fetch(action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(function(response) {
            return response.json().then(function(data) {
                return { status: response.status, body: data };
            });
        })
        .then(function(res) {
            if (res.status >= 200 && res.status < 300 && res.body.success) {
                showToast(res.body.message || 'Berhasil disimpan!', 'success');
                if (options.onSuccess) options.onSuccess(res.body);
            } else if (res.body.errors) {
                var msgs = Object.values(res.body.errors).flat().join(', ');
                showToast(msgs, 'error', 6000);
                if (options.onError) options.onError(res.body);
            } else {
                showToast(res.body.message || 'Terjadi kesalahan.', 'error');
                if (options.onError) options.onError(res.body);
            }
        })
        .catch(function(err) {
            showToast('Koneksi gagal. Silakan coba lagi.', 'error');
            if (options.onError) options.onError(err);
        })
        .finally(function() {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHTML;
            }
            if (options.onComplete) options.onComplete();
        });
    }

    function ajaxAction(url, method, data, options = {}) {
        var body = new FormData();
        body.append('_token', CSRF_TOKEN);
        if (method !== 'POST') body.append('_method', method);
        if (data) {
            Object.keys(data).forEach(function(key) {
                body.append(key, data[key]);
            });
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: body,
        })
        .then(function(response) {
            return response.json().then(function(d) {
                return { status: response.status, body: d };
            });
        })
        .then(function(res) {
            if (res.status >= 200 && res.status < 300 && res.body.success) {
                showToast(res.body.message || 'Berhasil!', 'success');
                if (options.onSuccess) options.onSuccess(res.body);
            } else if (res.body.errors) {
                var msgs = Object.values(res.body.errors).flat().join(', ');
                showToast(msgs, 'error', 6000);
                if (options.onError) options.onError(res.body);
            } else {
                showToast(res.body.message || 'Terjadi kesalahan.', 'error');
                if (options.onError) options.onError(res.body);
            }
        })
        .catch(function(err) {
            showToast('Koneksi gagal. Silakan coba lagi.', 'error');
            if (options.onError) options.onError(err);
        });
    }
</script>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>

@stack('scripts')
</body>
</html>
