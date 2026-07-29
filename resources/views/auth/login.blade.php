<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — ClinicalLog</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600;700&family=Noto+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Noto Sans', 'Figtree', system-ui, -apple-system, sans-serif;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 40px 0;
            position: relative;
        }
        .auth-bg {
            position: fixed; inset: 0; z-index: 0;
            background: #f1f5f9;
            height: 100%;
        }
        .auth-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: .08;
            animation: blobFloat 14s ease-in-out infinite;
        }
        .auth-blob-1 {
            width: 400px; height: 400px;
            background: linear-gradient(135deg, #0369A1, #22D3EE);
            top: -120px; left: -80px;
            animation-delay: 0s;
        }
        .auth-blob-2 {
            width: 350px; height: 350px;
            background: linear-gradient(135deg, #22d3ee, #818cf8);
            bottom: -80px; right: -60px;
            animation-delay: -5s;
        }
        .auth-blob-3 {
            width: 250px; height: 250px;
            background: linear-gradient(135deg, #6366f1, #0369A1);
            top: 50%; left: 50%;
            animation-delay: -10s;
        }
        @keyframes blobFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(40px, -40px) scale(1.05); }
            66% { transform: translate(-30px, 30px) scale(.95); }
        }
        .auth-wrapper {
            position: relative; z-index: 1;
            width: 100%; max-width: 460px; padding: 0 20px;
            animation: authFadeIn .5s cubic-bezier(.22,1,.36,1) both;
        }
        @keyframes authFadeIn {
            from { opacity: 0; transform: translateY(16px) scale(.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .auth-header { text-align: center; margin-bottom: 28px; }
        .auth-header img {
            height: 52px; width: auto;
            margin: 0 auto 18px; display: block;
            animation: logoFloat 3s ease-in-out infinite;
        }
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }
        .auth-header h1 {
            font-size: 22px; font-weight: 800;
            color: #0f172a; letter-spacing: -.02em;
            margin-bottom: 6px;
        }
        .auth-header p { font-size: 14px; color: #64748b; }
        .auth-card {
            background: rgba(255,255,255,.85);
            backdrop-filter: blur(16px) saturate(160%);
            -webkit-backdrop-filter: blur(16px) saturate(160%);
            border: 1px solid rgba(226,232,240,.8);
            border-radius: 24px;
            padding: 36px 32px;
            box-shadow: 0 4px 20px rgba(0,0,0,.04), 0 1px 3px rgba(0,0,0,.03);
            transition: transform .3s ease, box-shadow .3s ease;
        }
        .auth-card:hover {
            box-shadow: 0 8px 32px rgba(0,0,0,.06), 0 2px 6px rgba(0,0,0,.03);
        }

        /* ── Stagger animations ── */
        .form-group, .auth-checkbox, .btn-primary {
            opacity: 0;
            animation: staggerIn .45s cubic-bezier(.22,1,.36,1) forwards;
        }
        .form-group:nth-child(1) { animation-delay: .1s; }
        .form-group:nth-child(2) { animation-delay: .2s; }
        .auth-checkbox { animation-delay: .25s; }
        .btn-primary { animation-delay: .3s; }
        @keyframes staggerIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block; font-size: 13px; font-weight: 600;
            color: #475569; margin-bottom: 7px;
            transition: color .25s ease;
        }
        .form-input {
            width: 100%; padding: 11px 16px; border-radius: 12px;
            font-size: 14px; font-weight: 500;
            background: #ffffff; border: 1.5px solid #e2e8f0;
            color: #0f172a; outline: none; font-family: inherit;
            transition: border-color .25s ease, box-shadow .25s ease, transform .2s ease;
        }
        .form-input:hover { border-color: #cbd5e1; }
        .form-input:focus {
            border-color: #0369A1;
            box-shadow: 0 0 0 3px rgba(3,105,161,.1);
            transform: scale(1.008);
        }
        .form-input::placeholder { color: #94a3b8; font-weight: 400; }
        .form-input:-webkit-autofill,
        .form-input:-webkit-autofill:hover,
        .form-input:-webkit-autofill:focus {
            -webkit-text-fill-color: #0f172a;
            -webkit-box-shadow: 0 0 0px 1000px #fff inset;
            border-color: #0369A1;
        }
        .form-error {
            font-size: 12px; color: #ef4444; margin-top: 5px;
            display: flex; align-items: center; gap: 5px;
            animation: shakeX .3s ease both;
        }
        .form-error::before {
            content: ''; width: 4px; height: 4px;
            border-radius: 50%; background: #ef4444; flex-shrink: 0;
        }
        @keyframes shakeX {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            75% { transform: translateX(4px); }
        }
        .alert-error {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px; border-radius: 12px;
            background: #fef2f2; border: 1px solid #fecaca;
            color: #dc2626; font-size: 13px; margin-bottom: 20px;
            animation: shakeX .4s ease both;
        }
        .alert-error svg { width: 16px; height: 16px; flex-shrink: 0; }
        .btn-primary {
            width: 100%; justify-content: center;
            padding: 12px 24px; border-radius: 12px;
            font-size: 14px; font-weight: 600;
            background: linear-gradient(135deg, #0369A1, #0891b2);
            color: #fff; border: none;
            box-shadow: 0 4px 14px rgba(3,105,161,.25);
            cursor: pointer; font-family: inherit;
            display: inline-flex; align-items: center; gap: 8px;
            text-decoration: none;
            transition: all .3s cubic-bezier(.22,1,.36,1);
            position: relative; overflow: hidden;
        }
        .btn-primary::before {
            content: '';
            position: absolute; top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.15), transparent);
            transition: left .5s ease;
        }
        .btn-primary:hover::before { left: 100%; }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(3,105,161,.35);
        }
        .btn-primary:active {
            transform: translateY(0) scale(.98);
            box-shadow: 0 2px 8px rgba(3,105,161,.2);
        }
        .auth-checkbox {
            display: flex; align-items: center; gap: 8px; cursor: pointer;
            margin-bottom: 20px;
        }
        .auth-checkbox input[type="checkbox"] {
            accent-color: #0369A1; width: 16px; height: 16px;
            transform: scale(1); transition: transform .2s ease;
        }
        .auth-checkbox input[type="checkbox"]:checked { transform: scale(1.15); }
        .auth-checkbox span { font-size: 13px; color: #64748b; }
        .auth-footer { text-align: center; margin-top: 20px; margin-bottom: 16px; }
        .auth-footer a {
            font-size: 13px; color: #64748b;
            text-decoration: none; transition: color .2s ease;
            position: relative;
        }
        .auth-footer a::after {
            content: '';
            position: absolute; bottom: -1px; left: 0;
            width: 0; height: 1px;
            background: currentColor;
            transition: width .25s ease;
        }
        .auth-footer a:hover::after { width: 100%; }
        .auth-footer a:hover { color: #334155; }
        .auth-footer .auth-link { color: #0369A1; font-weight: 600; }
        .auth-footer .auth-link:hover { color: #0369A1; }

        /* ── Cursor Glow (identik landing page) ── */
        .cursor-glow {
            position: fixed;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(3,105,161,.07) 0%, rgba(22,211,238,.04) 40%, transparent 70%);
            pointer-events: none;
            z-index: 0;
            transform: translate(-50%, -50%);
            transition: transform .08s linear, width .4s ease, height .4s ease, opacity .4s ease;
            opacity: 0;
            will-change: transform;
        }
        .cursor-glow.active { opacity: 1; }
        .cursor-glow.hover-interactive {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(3,105,161,.1) 0%, rgba(22,211,238,.06) 40%, transparent 70%);
        }
        .cursor-dot {
            position: fixed;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0369A1, #22D3EE);
            pointer-events: none;
            z-index: 99998;
            transform: translate(-50%, -50%);
            transition: width .25s cubic-bezier(.34,1.56,.64,1),
                        height .25s cubic-bezier(.34,1.56,.64,1),
                        opacity .3s ease,
                        box-shadow .25s ease;
            opacity: 0;
            will-change: transform;
            box-shadow: 0 0 8px rgba(3,105,161,.3);
        }
        .cursor-dot.active { opacity: 1; }
        .cursor-dot.hover-interactive {
            width: 40px;
            height: 40px;
            background: transparent;
            border: 2px solid rgba(3,105,161,.35);
            box-shadow: 0 0 20px rgba(3,105,161,.1);
        }
        .cursor-dot.clicking {
            width: 30px;
            height: 30px;
            border-width: 3px;
            border-color: rgba(22,211,238,.5);
        }
        @media (hover: none), (pointer: coarse) {
            .cursor-glow, .cursor-dot { display: none !important; }
        }
        @media (max-width: 768px) {
            .cursor-glow, .cursor-dot { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="cursor-glow" id="cursorGlow"></div>
    <div class="cursor-dot" id="cursorDot"></div>

    <div class="auth-bg">
        <div class="auth-blob auth-blob-1"></div>
        <div class="auth-blob auth-blob-2"></div>
        <div class="auth-blob auth-blob-3"></div>
    </div>
    <div class="auth-wrapper">
        <div class="auth-header">
            <img src="{{ asset('assets/logo.png') }}" alt="ClinicalLog">
            <h1>Masuk ke Admin</h1>
            <p>Platform Medical Data &amp; E-Logbook</p>
        </div>
        <div class="auth-card">
            @if (session('error'))
                <div class="alert-error">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}"
                        placeholder="admin@clinicallog.id" required autofocus>
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <label class="auth-checkbox">
                    <input type="checkbox" name="remember">
                    <span>Ingat saya</span>
                </label>
                <button type="submit" class="btn-primary">
                    Masuk
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                        <path d="M13 7l5 5-5 5M5 12h13"/>
                    </svg>
                </button>
            </form>
        </div>
        <div class="auth-footer">
            <a href="{{ route('register') }}" class="auth-link">Belum punya akun? Daftar</a>
            <br><br>
            <a href="{{ route('home') }}">← Kembali ke Website</a>
        </div>
    </div>

    <script>
        // ─── Cursor Glow (identik landing page) ───
        (function() {
            var glow = document.getElementById('cursorGlow');
            var dot = document.getElementById('cursorDot');
            if (!glow || !dot) return;

            var mouseX = -100, mouseY = -100;
            var glowX = -100, glowY = -100;
            var isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
            if (isTouch) return;

            var interactiveSelectors = 'a, button, .btn-primary, input, label, .auth-card, .form-input';

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

            document.addEventListener('mousedown', function() { dot.classList.add('clicking'); });
            document.addEventListener('mouseup', function() { dot.classList.remove('clicking'); });

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
        })();
    </script>
</body>
</html>
