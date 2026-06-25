<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — ClinicalLog</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/clinicallog.css') }}">
</head>

<body style="min-height:100vh;display:flex;align-items:center;justify-content:center;">

    {{-- Orbs --}}
    <div class="bg-orbs" aria-hidden="true">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div style="position:relative;z-index:1;width:100%;max-width:420px;padding:24px;">

        {{-- Logo --}}
        <div style="text-align:center;margin-bottom:32px;">
            <img src="{{ asset('assets/logo.png') }}" alt="ClinicalLog" height="52" style="margin:0 auto 16px;">
            <h1 style="font-size:22px;font-weight:800;color:#f0f6ff;letter-spacing:-.02em;">Masuk ke Admin</h1>
            <p style="font-size:14px;color:#64748b;margin-top:6px;">Platform Medical Data & E-Logbook</p>
        </div>

        {{-- Card --}}
        <div class="glass" style="border-radius:24px;padding:32px;">

            @if (session('error'))
                <div
                    style="padding:12px 16px;border-radius:10px;background:rgba(248,113,113,.1);border:1px solid rgba(248,113,113,.25);color:#fca5a5;font-size:13px;display:flex;gap:10px;align-items:center;margin-bottom:20px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
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
                        <p style="font-size:12px;color:#f87171;margin-top:5px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••"
                        required>
                    @error('password')
                        <p style="font-size:12px;color:#f87171;margin-top:5px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                        <input type="checkbox" name="remember" style="accent-color:#2563eb;">
                        <span style="font-size:13px;color:#94a3b8;">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">
                    Masuk
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M5 12h13" />
                    </svg>
                </button>
            </form>
        </div>

        <p style="text-align:center;margin-top:20px;">
            <a href="{{ route('home') }}" style="font-size:13px;color:#64748b;text-decoration:none;">← Kembali ke
                Website</a>
        </p>
    </div>

</body>

</html>
