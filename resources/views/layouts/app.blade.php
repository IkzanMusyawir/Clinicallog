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

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @stack('head')
</head>

<body>

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
    <div id="appointmentModal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.6);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);z-index:99999;align-items:center;justify-content:center;padding:20px;transition:all .3s ease;overflow-y:auto;">
        <div class="glass" style="background:rgba(255,255,255,0.92);border:1px solid rgba(15,23,42,0.08);border-radius:24px;width:100%;max-width:500px;padding:32px;box-shadow:0 24px 50px rgba(15,23,42,0.15);position:relative;animation: modalFadeIn 0.3s ease-out;margin:auto;">
            
            {{-- Close Button --}}
            <button onclick="closeAppointmentModal()" style="position:absolute;top:20px;right:20px;background:none;border:none;cursor:pointer;color:var(--text-muted);display:flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:50%;transition:background .2s;" onmouseover="this.style.background='rgba(15,23,42,0.04)'" onmouseout="this.style.background='none'">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>

            {{-- Form Content --}}
            <div id="appointmentFormContent">
                <div style="text-align:center;margin-bottom:24px;">
                    <div style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,rgba(37,99,235,.1),rgba(6,182,212,.1));display:flex;align-items:center;justify-content:center;margin:0 auto 12px;color:var(--blue-lt);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2" /><line x1="16" y1="2" x2="16" y2="6" /><line x1="8" y1="2" x2="8" y2="6" /><line x1="3" y1="10" x2="21" y2="10" /></svg>
                    </div>
                    <h3 style="font-size:20px;font-weight:800;color:var(--text-primary);">Jadwalkan Demo Gratis</h3>
                    <p style="font-size:13px;color:var(--text-muted);margin-top:4px;">Isi formulir di bawah ini untuk mengajukan demo ClinicalLog.</p>
                </div>

                <form id="appointmentForm" onsubmit="submitAppointmentForm(event)">
                    @csrf
                    
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div class="form-group" style="margin-bottom:14px;">
                            <label class="form-label" for="app_name">Nama Lengkap</label>
                            <input type="text" id="app_name" name="name" class="form-input" placeholder="Nama Anda" required style="padding:9px 12px;">
                        </div>
                        <div class="form-group" style="margin-bottom:14px;">
                            <label class="form-label" for="app_email">Email</label>
                            <input type="email" id="app_email" name="email" class="form-input" placeholder="nama@email.com" required style="padding:9px 12px;">
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div class="form-group" style="margin-bottom:14px;">
                            <label class="form-label" for="app_whatsapp">No. WhatsApp</label>
                            <input type="text" id="app_whatsapp" name="whatsapp" class="form-input" placeholder="08123456789" required style="padding:9px 12px;">
                        </div>
                        <div class="form-group" style="margin-bottom:14px;">
                            <label class="form-label" for="app_institution">Nama Institusi/Klinik</label>
                            <input type="text" id="app_institution" name="institution" class="form-input" placeholder="Nama Institusi" required style="padding:9px 12px;">
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div class="form-group" style="margin-bottom:14px;">
                            <label class="form-label" for="app_date">Tanggal Rencana</label>
                            <input type="date" id="app_date" name="demo_date" class="form-input" required style="padding:9px 12px;" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group" style="margin-bottom:14px;">
                            <label class="form-label" for="app_time">Waktu Rencana</label>
                            <input type="time" id="app_time" name="demo_time" class="form-input" required style="padding:9px 12px;">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:20px;">
                        <label class="form-label" for="app_notes">Catatan (Opsional)</label>
                        <textarea id="app_notes" name="notes" class="form-input" placeholder="Ada pesan atau topik khusus yang ingin didiskusikan?" style="min-height:60px;padding:9px 12px;"></textarea>
                    </div>

                    <div id="appFormError" style="display:none;padding:10px 14px;border-radius:10px;background:rgba(248,113,113,.1);border:1px solid rgba(248,113,113,.2);color:#ef4444;font-size:12px;margin-bottom:14px;"></div>

                    <button type="submit" id="appSubmitBtn" class="btn-primary" style="width:100%;justify-content:center;border-radius:12px;padding:12px 24px;">
                        Kirim Pengajuan Demo
                    </button>
                </form>
            </div>

            {{-- Success Content --}}
            <div id="appointmentSuccessContent" style="display:none;text-align:center;padding:16px 0;">
                <div style="width:72px;height:72px;border-radius:50%;background:rgba(52,211,153,.1);border:2px solid rgba(52,211,153,.2);color:#34d399;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:32px;">
                    ✓
                </div>
                <h3 style="font-size:22px;font-weight:800;color:var(--text-primary);">Pengajuan Terkirim!</h3>
                <p style="font-size:14px;color:var(--text-muted);line-height:1.6;max-width:320px;margin:8px auto 24px;">Terima kasih. Pengajuan demo Anda berhasil disimpan. Tim kami akan segera menghubungi Anda melalui WhatsApp atau Email.</p>
                <button onclick="closeAppointmentModal()" class="btn-secondary" style="width:100%;justify-content:center;border-radius:12px;padding:12px 24px;">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <style>
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    {{-- External libraries --}}
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        lucide.createIcons();

        // Sticky navbar
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        }, {
            passive: true
        });

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

        // Scroll reveal with AOS
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: false,
            mirror: true,
            offset: 50
        });

        // ─── Appointment Modal Actions ───
        function openAppointmentModal() {
            document.getElementById('appointmentForm').reset();
            document.getElementById('appointmentFormContent').style.display = 'block';
            document.getElementById('appointmentSuccessContent').style.display = 'none';
            document.getElementById('appFormError').style.display = 'none';
            
            const modal = document.getElementById('appointmentModal');
            modal.style.display = 'flex';
        }

        function closeAppointmentModal() {
            const modal = document.getElementById('appointmentModal');
            modal.style.display = 'none';
        }

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

    @stack('scripts')
</body>

</html>
