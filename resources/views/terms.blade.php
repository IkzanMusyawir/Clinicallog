@extends('layouts.app')

@section('title', 'Syarat & Ketentuan — ClinicalLog')

@section('content')
    <section class="section" style="padding-top: 140px; min-height: 80vh;">
        <div class="container" style="max-width: 860px;">
            
            {{-- Main Container Card --}}
            <div class="glass" data-aos="fade-up" style="border-radius: 24px; padding: 48px; box-shadow: var(--glass-shadow); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">
                
                {{-- Header --}}
                <h1 style="font-size: 28px; font-weight: 800; color: var(--text-primary); margin-bottom: 24px;">Syarat & Ketentuan</h1>

                {{-- Terms Text --}}
                <div style="color: var(--text-muted); font-size: 15px; line-height: 1.8; display: flex; flex-direction: column; gap: 20px; margin-bottom: 40px; text-align: justify;">
                    <p>
                        Selamat datang di ClinicalLog. Terima kasih telah mengunduh dan mengunjungi platform ClinicalLog. Sebelum mengakses dan/atau menggunakan Layanan yang ada di dalam situs dan/atau Aplikasi lunak ClinicalLog, pastikan Anda membaca dengan cermat dan hati-hati Syarat dan Ketentuan Penggunaan Situs dan Aplikasi Lunak ClinicalLog ("Syarat dan Ketentuan") yang ada di halaman ini.
                    </p>
                    <p>
                        Dengan mengunduh dan/atau menggunakan platform ClinicalLog, Anda setuju bahwa Anda telah membaca, memahami, menerima dan menyetujui serta terikat secara hukum pada Syarat dan Ketentuan ini dan dokumen-dokumen lain sehubungan dengan itu. Jika Anda tidak menyetujui Syarat dan Ketentuan ini, mohon tidak mengakses platform dan menggunakan Layanan ClinicalLog.
                    </p>
                    <p>
                        Syarat dan Ketentuan dalam dokumen ini menggambarkan dan menetapkan ketentuan yang mengendalikan serta mengatur hubungan hukum antara penyedia Layanan dan platform ClinicalLog dan Anda atau User sebagai pengguna platform ClinicalLog.
                    </p>
                    <p>
                        Anda harus membaca Syarat dan Ketentuan dengan hati-hati dan tidak harus menerima Syarat atau mendaftar, mengakses atau menggunakan Layanan kecuali Anda setuju dengan Syarat dan Ketentuan ini.
                    </p>
                </div>

                {{-- Centered Download Button --}}
                <div style="display: flex; justify-content: center; margin-bottom: 32px;">
                    <a href="{{ $landing->terms_gdrive_url ?? 'https://drive.google.com/file/d/1t87654321_your_terms_and_conditions_gdrive_id/view?usp=sharing' }}" target="_blank" class="btn-primary" style="border-radius: 12px; font-size: 15px; padding: 12px 28px; display: inline-flex; align-items: center; gap: 10px; background: #2563eb; color: #fff; box-shadow: 0 4px 12px rgba(37,99,235,0.25);">
                        <i data-lucide="download" style="width: 18px; height: 18px;"></i>
                        Download S&K
                    </a>
                </div>

                {{-- Back to Home --}}
                <div style="text-align: center; border-top: 1px solid var(--glass-border); padding-top: 24px;">
                    <a href="{{ route('home') }}" style="color: var(--blue-lt); text-decoration: none; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 6px;">
                        ← Kembali ke Beranda
                    </a>
                </div>

            </div>

        </div>
    </section>
@endsection
