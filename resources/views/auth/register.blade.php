<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin — ClinicalLog</title>
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
            <h1 style="font-size:22px;font-weight:800;color:#f0f6ff;letter-spacing:-.02em;">Daftar Akun Baru</h1>
            <p style="font-size:14px;color:#64748b;margin-top:6px;">Platform Medical Data & E-Logbook</p>
        </div>

        {{-- Card --}}
        <div class="glass" style="border-radius:24px;padding:32px;">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}"
                        placeholder="Admin Clinicallog" required autofocus autocomplete="name">
                    @error('name')
                        <p style="font-size:12px;color:#f87171;margin-top:5px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}"
                        placeholder="admin@clinicallog.id" required autocomplete="username">
                    @error('email')
                        <p style="font-size:12px;color:#f87171;margin-top:5px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••"
                        required autocomplete="new-password">
                    @error('password')
                        <p style="font-size:12px;color:#f87171;margin-top:5px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
                        placeholder="••••••••" required autocomplete="new-password">
                    @error('password_confirmation')
                        <p style="font-size:12px;color:#f87171;margin-top:5px;">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary"
                    style="width:100%;justify-content:center;margin-bottom:20px;">
                    Daftar
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M5 12h13" />
                    </svg>
                </button>

                <div style="text-align:center;">
                    <span style="font-size:13px;color:#94a3b8;">Sudah punya akun? </span>
                    <a href="{{ route('login') }}"
                        style="font-size:13px;color:#2563eb;text-decoration:none;font-weight:600;">Masuk</a>
                </div>
            </form>
        </div>

        <p style="text-align:center;margin-top:20px;">
            <a href="{{ route('home') }}" style="font-size:13px;color:#64748b;text-decoration:none;">← Kembali ke
                Website</a>
        </p>
    </div>

</body>

</html>
