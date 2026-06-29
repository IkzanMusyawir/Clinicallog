<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ClinicalLog — Medical Data & E-Logbook')</title>
    <meta name="description"
        content="Platform Medical Data & E-Logbook untuk mendukung pendidikan klinis yang lebih digital, terukur, dan terintegrasi.">

    {{-- CSS --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/clinicallog.css') }}">

    @stack('head')
</head>

<body>

    {{-- Cursor glow --}}
    <div class="cursor-glow" id="cursorGlow"></div>
    <div class="cursor-dot" id="cursorDot"></div>

    {{-- Decorative background orbs --}}
    <div class="bg-orbs" aria-hidden="true">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="orb orb-4"></div>
    </div>

    {{-- Navbar --}}
    <header class="navbar" id="navbar" role="banner">
        @php
            $navLinks = $landing && $landing->navbar_links ? $landing->navbar_links : [
                ['label' => 'Beranda',    'url' => '#beranda'],
                ['label' => 'Tentang',    'url' => '#tentang'],
                ['label' => 'Fitur',      'url' => '#fitur'],
                ['label' => 'Dashboard',  'url' => '#dashboard'],
                ['label' => 'Cara Kerja', 'url' => '#cara-kerja'],
                ['label' => 'Harga',      'url' => '#pricing'],
                ['label' => 'Testimoni',  'url' => '#testimoni'],
                ['label' => 'Kontak',     'url' => '#kontak'],
            ];
            
            // Filter nav links based on section visibility
            if ($landing) {
                if (isset($landing->about_visible) && !$landing->about_visible) {
                    $navLinks = array_filter($navLinks, fn($l) => !str_contains($l['url'] ?? '', '#tentang'));
                }
                if (isset($landing->features_visible) && !$landing->features_visible) {
                    $navLinks = array_filter($navLinks, fn($l) => !str_contains($l['url'] ?? '', '#fitur'));
                }
                if (isset($landing->dashboard_visible) && !$landing->dashboard_visible) {
                    $navLinks = array_filter($navLinks, fn($l) => !str_contains($l['url'] ?? '', '#dashboard'));
                }
                if (isset($landing->testimonials_visible) && !$landing->testimonials_visible) {
                    $navLinks = array_filter($navLinks, fn($l) => !str_contains($l['url'] ?? '', '#testimoni'));
                }
                if (isset($landing->pricing_visible) && !$landing->pricing_visible) {
                    $navLinks = array_filter($navLinks, fn($l) => !str_contains($l['url'] ?? '', '#pricing'));
                }
                if (isset($landing->cta_visible) && !$landing->cta_visible) {
                    $navLinks = array_filter($navLinks, fn($l) => !str_contains($l['url'] ?? '', '#kontak'));
                }
                if (isset($landing->steps_visible) && !$landing->steps_visible) {
                    $navLinks = array_filter($navLinks, fn($l) => !str_contains($l['url'] ?? '', '#cara-kerja'));
                }
            }
            $navCtaText = $landing && $landing->navbar_cta_text ? $landing->navbar_cta_text : 'Minta Demo';
            $navCtaUrl = $landing && $landing->navbar_cta_url ? $landing->navbar_cta_url : '#kontak';

            $getAnchorUrl = function($url) {
                if (is_string($url) && str_starts_with($url, '#')) {
                    if (request()->routeIs('home')) {
                        return $url;
                    }
                    return url('/') . '/' . $url;
                }
                return $url;
            };
        @endphp
        <div class="navbar-inner">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="navbar-logo">
                <img src="{{ asset('assets/logo.png') }}" alt="ClinicalLog" height="44">
            </a>

            {{-- Desktop nav --}}
            <nav aria-label="Navigasi utama">
                <ul class="navbar-nav">
                    @foreach($navLinks as $link)
                        <li><a href="{{ $getAnchorUrl($link['url'] ?? '#') }}">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </nav>

            <div class="navbar-cta">
                <a href="{{ $getAnchorUrl($navCtaUrl) }}" class="btn-primary btn-sm">{{ $navCtaText }}</a>
            </div>

            {{-- Mobile toggle --}}
            <button class="nav-toggle" id="navToggle" aria-label="Buka menu" aria-expanded="false"
                aria-controls="mobileMenu">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2" id="iconMenu">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2" id="iconClose" style="display:none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <nav id="mobileMenu" class="mobile-menu glass mx-4 mt-1" aria-label="Menu mobile">
            @foreach($navLinks as $link)
                <a href="{{ $getAnchorUrl($link['url'] ?? '#') }}">{{ $link['label'] }}</a>
            @endforeach
            <a href="{{ $getAnchorUrl($navCtaUrl) }}" class="btn-primary mt-2" style="border-radius:10px;">{{ $navCtaText }}</a>
        </nav>
    </header>

    {{-- Page content --}}
    <main role="main">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer" role="contentinfo">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <img src="{{ asset('assets/logo.png') }}" alt="ClinicalLog" height="44">
                    <p class="footer-brand-desc">Platform Medical Data &amp; E-Logbook untuk mendukung pendidikan klinis
                        yang lebih digital, terukur, dan terintegrasi.</p>
                </div>
                <div>
                    <h3 class="footer-heading">Produk</h3>
                    <div class="footer-links">
                        @if(!$landing || ($landing->features_visible ?? true))
                            <a href="{{ $getAnchorUrl('#fitur') }}">Fitur</a>
                        @endif
                        @if(!$landing || ($landing->dashboard_visible ?? true))
                            <a href="{{ $getAnchorUrl('#dashboard') }}">Dashboard</a>
                        @endif
                        @if(!$landing || ($landing->pricing_visible ?? true))
                            <a href="{{ $getAnchorUrl('#pricing') }}">Harga</a>
                        @endif
                        <a href="{{ $getAnchorUrl('#top') }}">Dokumentasi</a>
                    </div>
                </div>
                <div>
                    <h3 class="footer-heading">Perusahaan</h3>
                    <div class="footer-links">
                        @if(!$landing || ($landing->about_visible ?? true))
                            <a href="{{ $getAnchorUrl('#tentang') }}">Tentang Kami</a>
                        @endif
                        <a href="{{ $getAnchorUrl('#top') }}">Blog</a>
                        <a href="{{ $getAnchorUrl('#top') }}">Karier</a>
                    </div>
                </div>
                <div>
                    <h3 class="footer-heading">Dukungan</h3>
                    <div class="footer-links">
                        <a href="{{ $getAnchorUrl('#top') }}">Pusat Bantuan</a>
                        @if(!$landing || ($landing->cta_visible ?? true))
                            <a href="{{ $getAnchorUrl('#kontak') }}">Kontak</a>
                        @endif
                        <a href="{{ route('terms') }}">Syarat & Ketentuan</a>
                        <a href="{{ $landing->privacy_gdrive_url ?? 'https://drive.google.com/file/d/1t87654321_your_privacy_policy_gdrive_id/view?usp=sharing' }}" target="_blank">Kebijakan & Privasi</a>
                    </div>
                </div>
                <div>
                    <h3 class="footer-heading">Media Sosial</h3>
                    <div class="footer-links">
                        <a href="#">LinkedIn</a>
                        <a href="#">Instagram</a>
                        <a href="#">YouTube</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="footer-copy">© {{ date('Y') }} ClinicalLog. Seluruh Hak Cipta Dilindungi.</p>
                <div class="footer-socials">
                    <a href="#" aria-label="LinkedIn">in</a>
                    <a href="#" aria-label="Instagram">ig</a>
                    <a href="#" aria-label="YouTube">yt</a>
                </div>
            </div>
        </div>
    </footer>
    {{-- Appointment Modal --}}
    <div id="appointmentModal" class="modal-overlay">
        <div class="modal-container">
            
            {{-- Close Button --}}
            <button onclick="closeAppointmentModal()" class="modal-close-btn" aria-label="Tutup">
                <i data-lucide="x" style="width:18px;height:18px;"></i>
            </button>

            {{-- Form Content --}}
            <div id="appointmentFormContent">
                <div style="text-align:center;margin-bottom:28px;">
                    <div style="width:56px;height:56px;border-radius:16px;background:linear-gradient(135deg,rgba(37,99,235,.1),rgba(6,182,212,.1));display:flex;align-items:center;justify-content:center;margin:0 auto 16px;color:var(--blue-lt);box-shadow: 0 8px 20px rgba(37,99,235,0.06);">
                        <i data-lucide="calendar-check-2" style="width:26px;height:26px;"></i>
                    </div>
                    <h3 style="font-size:22px;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;">Jadwalkan Demo Gratis</h3>
                    <p style="font-size:14px;color:var(--text-muted);margin-top:6px;">Isi formulir di bawah ini untuk mengajukan demo ClinicalLog.</p>
                </div>

                <form id="appointmentForm" onsubmit="submitAppointmentForm(event)">
                    @csrf
                    
                    <div class="modal-grid-2">
                        <div class="modal-form-group">
                            <label class="modal-label" for="app_name">Nama Lengkap</label>
                            <div class="modal-input-wrapper">
                                <i data-lucide="user" class="modal-input-icon"></i>
                                <input type="text" id="app_name" name="name" class="modal-input" placeholder="Nama Lengkap Anda" required>
                            </div>
                        </div>
                        <div class="modal-form-group">
                            <label class="modal-label" for="app_email">Email Akademik / Kerja</label>
                            <div class="modal-input-wrapper">
                                <i data-lucide="mail" class="modal-input-icon"></i>
                                <input type="email" id="app_email" name="email" class="modal-input" placeholder="nama@institusi.com" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-grid-2">
                        <div class="modal-form-group">
                            <label class="modal-label" for="app_whatsapp">No. WhatsApp Aktif</label>
                            <div class="modal-input-wrapper">
                                <i data-lucide="phone" class="modal-input-icon"></i>
                                <input type="text" id="app_whatsapp" name="whatsapp" class="modal-input" placeholder="081234567890" required>
                            </div>
                        </div>
                        <div class="modal-form-group">
                            <label class="modal-label" for="app_institution">Nama Institusi / Klinik</label>
                            <div class="modal-input-wrapper">
                                <i data-lucide="building" class="modal-input-icon"></i>
                                <input type="text" id="app_institution" name="institution" class="modal-input" placeholder="Fakultas Kedokteran Univ. X" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-grid-2">
                        <div class="modal-form-group">
                            <label class="modal-label" for="app_date">Tanggal Rencana</label>
                            <div class="modal-input-wrapper">
                                <i data-lucide="calendar" class="modal-input-icon"></i>
                                <input type="date" id="app_date" name="demo_date" class="modal-input" required min="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="modal-form-group">
                            <label class="modal-label" for="app_time">Waktu Rencana</label>
                            <div class="modal-input-wrapper">
                                <i data-lucide="clock" class="modal-input-icon"></i>
                                <input type="time" id="app_time" name="demo_time" class="modal-input" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-form-group">
                        <label class="modal-label" for="app_notes">Catatan Tambahan (Opsional)</label>
                        <div class="modal-input-wrapper">
                            <i data-lucide="message-square" class="modal-input-icon" style="top: 14px;"></i>
                            <textarea id="app_notes" name="notes" class="modal-input modal-textarea" placeholder="Tuliskan pesan atau topik khusus yang ingin didiskusikan..." style="padding-top:11px;"></textarea>
                        </div>
                    </div>

                    <div id="appFormError" style="display:none;padding:12px 16px;border-radius:12px;background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.15);color:#ef4444;font-size:13px;margin-bottom:18px;line-height:1.5;"></div>

                    <button type="submit" id="appSubmitBtn" class="btn-primary" style="width:100%;justify-content:center;border-radius:14px;padding:14px 28px;box-shadow: 0 10px 25px rgba(37,99,235,0.15);">
                        Kirim Pengajuan Demo
                    </button>
                </form>
            </div>

            {{-- Success Content --}}
            <div id="appointmentSuccessContent" style="display:none;text-align:center;padding:10px 0;">
                <div class="success-icon-wrapper">
                    <svg class="success-check-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                        <circle class="success-check-circle" cx="26" cy="26" r="25" fill="none"/>
                        <path class="success-check-mark" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                    </svg>
                </div>
                <h3 style="font-size:22px;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;">Pengajuan Terkirim!</h3>
                <p style="font-size:14px;color:var(--text-muted);line-height:1.65;max-width:360px;margin:12px auto 28px;">Terima kasih. Pengajuan demo Anda berhasil disimpan. Tim kami akan segera menghubungi Anda melalui WhatsApp atau Email.</p>
                <button onclick="closeAppointmentModal()" class="btn-secondary" style="width:100%;justify-content:center;border-radius:12px;padding:12px 24px;">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <style>
        /* ── Cursor Glow Effect ── */
        .cursor-glow {
            position: fixed;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59,130,246,.07) 0%, rgba(6,182,212,.04) 40%, transparent 70%);
            pointer-events: none;
            z-index: 0;
            transform: translate(-50%, -50%);
            transition: transform .08s linear, width .4s ease, height .4s ease, opacity .4s ease;
            opacity: 0;
            will-change: transform;
        }
        .cursor-glow.active {
            opacity: 1;
        }
        .cursor-glow.hover-interactive {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(37,99,235,.1) 0%, rgba(6,182,212,.06) 40%, transparent 70%);
        }

        .cursor-dot {
            position: fixed;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            pointer-events: none;
            z-index: 99998;
            transform: translate(-50%, -50%);
            transition: width .25s cubic-bezier(.34,1.56,.64,1),
                        height .25s cubic-bezier(.34,1.56,.64,1),
                        opacity .3s ease,
                        box-shadow .25s ease;
            opacity: 0;
            will-change: transform;
            box-shadow: 0 0 8px rgba(37,99,235,.3);
        }
        .cursor-dot.active {
            opacity: 1;
        }
        .cursor-dot.hover-interactive {
            width: 40px;
            height: 40px;
            background: transparent;
            border: 2px solid rgba(37,99,235,.35);
            box-shadow: 0 0 20px rgba(37,99,235,.1);
        }
        .cursor-dot.clicking {
            width: 30px;
            height: 30px;
            border-width: 3px;
            border-color: rgba(6,182,212,.5);
        }

        /* Card tilt glow on hover */
        .card-tilt-glow {
            position: absolute;
            inset: 0;
            border-radius: inherit;
            pointer-events: none;
            opacity: 0;
            transition: opacity .3s ease;
            z-index: 1;
        }
        .feature-card:hover .card-tilt-glow,
        .benefit-card:hover .card-tilt-glow,
        .testi-card:hover .card-tilt-glow,
        .pricing-card:hover .card-tilt-glow,
        .step-item:hover .card-tilt-glow {
            opacity: 1;
        }

        /* Make interactive cards relative for glow positioning */
        .feature-card,
        .benefit-card,
        .testi-card,
        .pricing-card,
        .step-item {
            position: relative;
            overflow: hidden;
        }

        /* Hide custom cursor on touch devices and small screens */
        @media (hover: none), (pointer: coarse) {
            .cursor-glow, .cursor-dot { display: none !important; }
        }
        @media (max-width: 768px) {
            .cursor-glow, .cursor-dot { display: none !important; }
        }

        /* Modern Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            z-index: 99999;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .modal-overlay.show {
            opacity: 1;
        }
        .modal-container {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.85);
            border-radius: 28px;
            width: 100%;
            max-width: 540px;
            padding: 36px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.6);
            position: relative;
            transform: translateY(30px) scale(0.95);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            max-height: 90vh;
            overflow-y: auto;
        }
        .modal-overlay.show .modal-container {
            transform: translateY(0) scale(1);
        }
        .modal-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .modal-form-group {
            margin-bottom: 18px;
        }
        .modal-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 6px;
        }
        .modal-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .modal-input-icon {
            position: absolute;
            left: 14px;
            color: var(--text-dim);
            pointer-events: none;
            width: 16px;
            height: 16px;
        }
        .modal-input {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border-radius: 12px;
            font-size: 14px;
            background: #f8fafc;
            border: 1px solid rgba(15, 23, 42, 0.08);
            color: var(--text-primary);
            outline: none;
            transition: all 0.25s ease;
            font-family: inherit;
        }
        .modal-input:focus {
            background: #ffffff;
            border-color: var(--blue-lt);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        .modal-textarea {
            min-height: 80px;
            resize: vertical;
        }
        .modal-close-btn {
            position: absolute;
            top: 24px;
            right: 24px;
            background: #f1f5f9;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            transition: all 0.2s;
            z-index: 10;
        }
        .modal-close-btn:hover {
            background: #e2e8f0;
            color: var(--text-primary);
            transform: rotate(90deg);
        }

        /* Success Animation styles */
        .success-icon-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .success-check-svg {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: block;
            stroke-width: 3;
            stroke: #10b981;
            stroke-miterlimit: 10;
            box-shadow: inset 0px 0px 0px #10b981;
            animation: success-fill .4s ease-in-out .4s forwards, success-scale .3s ease-in-out 0s both;
        }
        .success-check-circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 3;
            stroke-miterlimit: 10;
            stroke: #10b981;
            fill: none;
            animation: success-stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        .success-check-mark {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            stroke: #10b981;
            animation: success-stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }

        @keyframes success-stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }
        @keyframes success-scale {
            0%, 100% {
                transform: none;
            }
            50% {
                transform: scale3d(1.1, 1.1, 1);
            }
        }
        @keyframes success-fill {
            100% {
                box-shadow: inset 0px 0px 0px 40px rgba(16, 185, 129, 0.1);
            }
        }

        @media (max-width: 540px) {
            .modal-grid-2 {
                grid-template-columns: 1fr;
                gap: 0;
            }
            .modal-container {
                padding: 28px 20px;
            }
            .modal-close-btn {
                top: 16px;
                right: 16px;
            }
        }
    </style>

    {{-- External libraries --}}
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>

    <script>
        lucide.createIcons();

        // Sticky navbar
        const navbar = document.getElementById('navbar');
        const navLinksAll = document.querySelectorAll('.navbar-nav a, .mobile-menu a:not(.btn-primary)');
        let currentActive = ''; // track current active to avoid redundant DOM updates
        let ticking = false;    // throttle scroll updates

        // Scroll-spy: highlight active nav link based on scroll position
        function updateActiveNav() {
            let foundSection = '';
            const scrollPos = window.scrollY + 140;

            // If at very top, activate first nav link (Beranda)
            if (window.scrollY < 100) {
                const firstLink = document.querySelector('.navbar-nav a');
                if (firstLink) {
                    const href = firstLink.getAttribute('href');
                    if (href && href.includes('#')) {
                        foundSection = '#' + href.split('#')[1];
                    }
                }
            } else {
                // Find which section is currently in view
                navLinksAll.forEach(link => {
                    const href = link.getAttribute('href');
                    if (!href || !href.includes('#')) return;
                    const hash = '#' + href.split('#')[1];
                    if (!hash || hash === '#') return;

                    try {
                        const section = document.querySelector(hash);
                        if (section) {
                            const top = section.offsetTop;
                            const bottom = top + section.offsetHeight;
                            if (scrollPos >= top && scrollPos < bottom) {
                                foundSection = hash;
                            }
                        }
                    } catch(e) { /* invalid selector */ }
                });
            }

            // Only update DOM if the active section actually changed
            if (foundSection !== currentActive) {
                currentActive = foundSection;
                navLinksAll.forEach(link => {
                    const href = link.getAttribute('href');
                    if (!href || !href.includes('#')) return;
                    const hash = '#' + href.split('#')[1];
                    if (hash === currentActive) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });
            }
        }

        // Throttled scroll handler using requestAnimationFrame
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
            if (!ticking) {
                requestAnimationFrame(() => {
                    updateActiveNav();
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });

        // Set active on click immediately
        navLinksAll.forEach(link => {
            link.addEventListener('click', function() {
                const href = this.getAttribute('href');
                if (!href || !href.includes('#')) return;
                currentActive = '#' + href.split('#')[1];
                navLinksAll.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Init on page load
        updateActiveNav();

        // Mobile menu toggle
        const toggle = document.getElementById('navToggle');
        const mobileNav = document.getElementById('mobileMenu');
        const iconMenu = document.getElementById('iconMenu');
        const iconClose = document.getElementById('iconClose');

        toggle.addEventListener('click', () => {
            const open = mobileNav.classList.toggle('open');
            toggle.setAttribute('aria-expanded', open);
            iconMenu.style.display = open ? 'none' : '';
            iconClose.style.display = open ? '' : 'none';
        });
        mobileNav.querySelectorAll('a').forEach(a => {
            a.addEventListener('click', () => {
                mobileNav.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
                iconMenu.style.display = '';
                iconClose.style.display = 'none';
            });
        });

        // Modern Custom Scroll Reveal using Intersection Observer (always animate up and down)
        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -50px 0px', // slightly offset trigger threshold
            threshold: 0.05
        };

        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                } else {
                    // This forces the animation to re-trigger when scrolling up or down out of view
                    // We only remove if the element goes below viewport (scrolling up) or above viewport (scrolling down)
                    entry.target.classList.remove('revealed');
                }
            });
        }, observerOptions);

        const aosElements = document.querySelectorAll('[data-aos]');
        aosElements.forEach(el => {
            // Add base class
            el.classList.add('scroll-reveal');

            // Map AOS transition types
            const aosType = el.getAttribute('data-aos');
            if (aosType === 'fade-left') {
                el.classList.add('scroll-reveal-right');
            } else if (aosType === 'fade-right') {
                el.classList.add('scroll-reveal-left');
            } else if (aosType === 'zoom-in') {
                el.classList.add('scroll-reveal-scale');
            } else if (aosType === 'fade-down') {
                el.classList.add('scroll-reveal-up');
            }
            // default is fade-up which doesn't need extra class since translateY is positive by default

            // Apply delays dynamically
            const delay = el.getAttribute('data-aos-delay');
            if (delay) {
                el.style.transitionDelay = `${delay}ms`;
            }

            // Apply duration dynamically
            const duration = el.getAttribute('data-aos-duration');
            if (duration) {
                el.style.transitionDuration = `${duration}ms`;
            }

            revealObserver.observe(el);
        });

        // ─── Appointment Modal Actions ───
        function openAppointmentModal() {
            document.getElementById('appointmentForm').reset();
            document.getElementById('appointmentFormContent').style.display = 'block';
            document.getElementById('appointmentSuccessContent').style.display = 'none';
            document.getElementById('appFormError').style.display = 'none';
            
            const modal = document.getElementById('appointmentModal');
            modal.style.display = 'flex';
            modal.offsetHeight; // force reflow for smooth scale transition
            modal.classList.add('show');
        }

        function closeAppointmentModal() {
            const modal = document.getElementById('appointmentModal');
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        // Close modal when clicking on backdrop overlay
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('appointmentModal');
            if (modal) {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        closeAppointmentModal();
                    }
                });
            }
        });

        function submitAppointmentForm(event) {
            event.preventDefault();
            
            const form = document.getElementById('appointmentForm');
            const submitBtn = document.getElementById('appSubmitBtn');
            const errorBox = document.getElementById('appFormError');
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Mengirim...';
            errorBox.style.display = 'none';
            
            const formData = new FormData(form);
            
            fetch("{{ route('appointments.store') }}", {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                if (res.status === 200 && res.body.success) {
                    document.getElementById('appointmentFormContent').style.display = 'none';
                    document.getElementById('appointmentSuccessContent').style.display = 'block';
                } else {
                    let errMsg = 'Terjadi kesalahan. Silakan coba lagi.';
                    if (res.body.errors) {
                        errMsg = Object.values(res.body.errors).flat().join('<br>');
                    } else if (res.body.message) {
                        errMsg = res.body.message;
                    }
                    errorBox.innerHTML = errMsg;
                    errorBox.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error submitting appointment:', error);
                errorBox.innerHTML = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
                errorBox.style.display = 'block';
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Kirim Pengajuan Demo';
            });
        }
    </script>

    <script>
    (function() {
        var glow = document.getElementById('cursorGlow');
        var dot = document.getElementById('cursorDot');
        if (!glow || !dot) return;

        var mouseX = -100, mouseY = -100;
        var glowX = -100, glowY = -100;
        var isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
        if (isTouch) return;

        var interactiveSelectors = 'a, button, .btn-primary, .btn-secondary, .feature-card, .benefit-card, .testi-card, .pricing-card, .step-item, input, textarea, select, [onclick]';

        document.addEventListener('mousemove', function(e) {
            mouseX = e.clientX;
            mouseY = e.clientY;
            dot.style.left = mouseX + 'px';
            dot.style.top = mouseY + 'px';
            if (!dot.classList.contains('active')) {
                dot.classList.add('active');
                glow.classList.add('active');
            }
        }, { passive: true });

        function animateGlow() {
            glowX += (mouseX - glowX) * 0.12;
            glowY += (mouseY - glowY) * 0.12;
            glow.style.left = glowX + 'px';
            glow.style.top = glowY + 'px';
            requestAnimationFrame(animateGlow);
        }
        animateGlow();

        document.addEventListener('mouseleave', function() {
            glow.classList.remove('active');
            dot.classList.remove('active');
        });
        document.addEventListener('mouseenter', function() {
            glow.classList.add('active');
            dot.classList.add('active');
        });

        document.addEventListener('mousedown', function() {
            dot.classList.add('clicking');
        });
        document.addEventListener('mouseup', function() {
            dot.classList.remove('clicking');
        });

        document.addEventListener('mouseover', function(e) {
            if (e.target.closest(interactiveSelectors)) {
                dot.classList.add('hover-interactive');
                glow.classList.add('hover-interactive');
            }
        }, { passive: true });
        document.addEventListener('mouseout', function(e) {
            if (e.target.closest(interactiveSelectors)) {
                dot.classList.remove('hover-interactive');
                glow.classList.remove('hover-interactive');
            }
        }, { passive: true });

        var cards = document.querySelectorAll('.feature-card, .benefit-card, .testi-card, .pricing-card, .step-item');
        cards.forEach(function(card) {
            var glowEl = document.createElement('div');
            glowEl.className = 'card-tilt-glow';
            card.appendChild(glowEl);

            card.addEventListener('mousemove', function(e) {
                var rect = card.getBoundingClientRect();
                var x = e.clientX - rect.left;
                var y = e.clientY - rect.top;
                var cx = rect.width / 2;
                var cy = rect.height / 2;
                var rotateX = ((y - cy) / cy) * -4;
                var rotateY = ((x - cx) / cx) * 4;
                card.style.transform = 'perspective(800px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) scale3d(1.02,1.02,1)';
                glowEl.style.background = 'radial-gradient(circle at ' + x + 'px ' + y + 'px, rgba(59,130,246,.08) 0%, transparent 60%)';
            }, { passive: true });

            card.addEventListener('mouseleave', function() {
                card.style.transform = '';
                card.style.transition = 'transform .4s cubic-bezier(.34,1.56,.64,1)';
                setTimeout(function() { card.style.transition = ''; }, 400);
            });

            card.addEventListener('mouseenter', function() {
                card.style.transition = 'transform .1s ease-out';
            });
        });

        var heroVisual = document.querySelector('.hero-visual');
        if (heroVisual) {
            var floatCards = heroVisual.querySelectorAll('.float-card');
            var heroImg = heroVisual.querySelector('.hero-card-main');

            document.addEventListener('mousemove', function(e) {
                var rect = heroVisual.getBoundingClientRect();
                if (e.clientX < rect.left - 100 || e.clientX > rect.right + 100 || e.clientY < rect.top - 100 || e.clientY > rect.bottom + 100) return;
                var cx = rect.left + rect.width / 2;
                var cy = rect.top + rect.height / 2;
                var dx = (e.clientX - cx) / rect.width;
                var dy = (e.clientY - cy) / rect.height;

                if (heroImg) {
                    heroImg.style.transform = 'translate(' + (dx * -8) + 'px, ' + (dy * -8) + 'px)';
                }
                floatCards.forEach(function(fc, i) {
                    var factor = (i + 1) * 6;
                    fc.style.transform = 'translate(' + (dx * factor) + 'px, ' + (dy * factor) + 'px)';
                });
            }, { passive: true });
        }
    })();
    </script>

    @stack('scripts')
</body>

</html>
