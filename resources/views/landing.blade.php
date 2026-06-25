@extends('layouts.app')

@section('title', 'ClinicalLog — Medical Data & E-Logbook')

@section('content')

    {{-- ═══════════════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════════════ --}}
    <section class="hero" id="beranda">
        <div class="container">
            <div class="hero-grid">

                {{-- Left: Copy --}}
                <div class="" data-aos="fade-right">
                    <div class="hero-badge">
                        <span class="hero-badge-dot"></span>
                        {{ $landing->hero_badge ?? 'Platform E-Logbook Kedokteran #1 Indonesia' }}
                    </div>

                    <h1 class="hero-title">
                        @if($landing && $landing->hero_title)
                            {!! nl2br(e($landing->hero_title)) !!}
                        @else
                            Transformasi<br>
                            <span class="gradient-text">Pendidikan</span><br>
                            Kedokteran Digital
                        @endif
                    </h1>

                    <p class="hero-desc">
                        {{ $landing->hero_description ?? 'ClinicalLog adalah platform Medical Data & E-Logbook yang membantu mahasiswa, dosen, dan institusi kedokteran mencatat, memantau, dan mengevaluasi aktivitas klinis secara real-time.' }}
                    </p>

                    <div class="hero-cta">
                        <a href="#kontak" class="btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            {{ $landing->hero_cta_primary ?? 'Minta Demo Gratis' }}
                        </a>
                        <a href="#fitur" class="btn-secondary">
                            {{ $landing->hero_cta_secondary ?? 'Lihat Fitur' }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                    </div>

                    <div class="hero-stats">
                        <div>
                            <div class="hero-stat-num gradient-text" id="statPaperless">0%</div>
                            <div class="hero-stat-lbl">Digital & tanpa kertas</div>
                        </div>
                        <div class="hero-stat-divider"></div>
                        <div>
                            <div class="hero-stat-num gradient-text-warm" id="statRealtime"></div>
                            <div class="hero-stat-lbl">Monitoring terintegrasi</div>
                        </div>
                        <div class="hero-stat-divider"></div>
                        <div>
                            <div class="hero-stat-num gradient-text" id="statMulti"></div>
                            <div class="hero-stat-lbl">Platform & perangkat</div>
                        </div>
                    </div>
                </div>

                {{-- Right: Visual --}}
                <div class="hero-visual" data-aos="fade-left" style="position:relative;padding:30px 0;">

                    {{-- Background decorative circle --}}
                    <div class="hero-circle-bg"></div>

                    {{-- Main image card --}}
                    <div class="hero-card-main">
                        <img src="{{ $landing && $landing->hero_image ? asset('storage/' . $landing->hero_image) : 'https://images.pexels.com/photos/5355850/pexels-photo-5355850.jpeg?auto=compress&cs=tinysrgb&w=1280' }}"
                            alt="Tenaga medis menggunakan ClinicalLog" loading="lazy">
                    </div>

                    {{-- Float card: Activity --}}
                    <div class="float-card float-card-activity" data-aos="zoom-in" data-aos-delay="200">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px; width: 100%;">
                            <div>
                                <div style="font-size:12px; font-weight:700; color:#0f172a; margin-bottom:2px;">Aktivitas Klinis</div>
                                <div style="font-size:10px; color:#64748b;">Minggu ini</div>
                            </div>
                            <div style="width:28px; height:28px; border-radius:8px; background:rgba(6,182,212,.1); display:flex; align-items:center; justify-content:center; color:#06b6d4; flex-shrink:0;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                        <div style="font-size:24px; font-weight:800; color:#0f172a; margin-bottom:4px; line-height:1.1; letter-spacing:-0.03em;">1.248</div>
                        <div style="display:flex; align-items:center; gap:4px; margin-bottom:12px;">
                            <span style="color:#10b981; font-size:11px; font-weight:700;">+18%</span>
                            <span style="color:#64748b; font-size:10px;">dibanding minggu lalu</span>
                        </div>
                        <div class="bar-chart" style="display:flex; align-items:flex-end; gap:5px; height:36px; width:100%;">
                            <span style="height:25%; background:rgba(34,211,238,0.2); flex:1; border-radius:3px;"></span>
                            <span style="height:45%; background:rgba(34,211,238,0.4); flex:1; border-radius:3px;"></span>
                            <span style="height:35%; background:rgba(59,130,246,0.3); flex:1; border-radius:3px;"></span>
                            <span style="height:65%; background:rgba(34,211,238,0.6); flex:1; border-radius:3px;"></span>
                            <span style="height:50%; background:rgba(59,130,246,0.5); flex:1; border-radius:3px;"></span>
                            <span style="height:80%; background:#3b82f6; flex:1; border-radius:3px;"></span>
                            <span style="height:90%; background:#06b6d4; flex:1; border-radius:3px;"></span>
                        </div>
                    </div>

                    {{-- Float card: GPS Attendance --}}
                    <div class="float-card float-card-gps" data-aos="zoom-in" data-aos-delay="400">
                        <div style="display:flex; align-items:center; margin-bottom:12px; width:100%;">
                            <div style="width:32px; height:32px; border-radius:50%; background:rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.15); display:flex; align-items:center; justify-content:center; color:#10b981; flex-shrink:0;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div style="margin-left:10px;">
                                <div style="font-size:12px; font-weight:700; color:#0f172a; line-height:1.2;">Absensi GPS</div>
                                <div style="font-size:10px; color:#64748b; margin-top:1px;">RS Pendidikan</div>
                            </div>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
                            <span style="background:rgba(16,185,129,0.1); color:#10b981; font-size:10px; font-weight:700; padding:4px 10px; border-radius:999px;">Terverifikasi</span>
                            <span style="font-size:10px; color:#64748b; font-weight:500;">08:14</span>
                        </div>
                    </div>

                    {{-- Float card: Progress --}}
                    <div class="float-card float-card-progress" data-aos="zoom-in" data-aos-delay="600">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:10px; width:100%;">
                            <div>
                                <div style="font-size:12px; font-weight:700; color:#0f172a; margin-bottom:2px;">Kompetensi</div>
                                <div style="font-size:10px; color:#64748b;">Progress mahasiswa</div>
                            </div>
                            <div style="width:28px; height:28px; border-radius:50%; background:rgba(37,99,235,0.1); display:flex; align-items:center; justify-content:center; color:#2563eb; flex-shrink:0;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a3 3 0 100-6 3 3 0 000 6z" />
                                </svg>
                            </div>
                        </div>
                        
                        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:8px; width:100%;">
                            <span style="font-size:24px; font-weight:800; color:#0f172a; line-height:1.1;">76%</span>
                            <span style="font-size:10px; color:#64748b; margin-bottom:2px;">Target semester</span>
                        </div>
                        
                        <div class="prog-bar" style="height:6px; background:#e2e8f0; border-radius:999px; overflow:hidden; width:100%;">
                            <div class="prog-fill" style="width:76%; height:100%; background:linear-gradient(90deg, #06b6d4, #3b82f6); border-radius:999px;"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    {{-- ═══════════════════════════════════════════════════════
     TENTANG
═══════════════════════════════════════════════════════ --}}
    @if(!$landing || ($landing->about_visible ?? true))
    <section class="section" id="tentang">
        <div class="container">
            <div class="about-grid">

                {{-- Image --}}
                <div class="about-img-wrap" data-aos="fade-right">
                    <img src="{{ $landing && $landing->about_image ? asset('storage/' . $landing->about_image) : 'https://images.pexels.com/photos/5452187/pexels-photo-5452187.jpeg?auto=compress&cs=tinysrgb&w=1280' }}"
                        alt="Dokter menggunakan ClinicalLog" loading="lazy">
                    <div class="about-img-overlay"></div>
                    <div class="about-img-badge glass-sm">
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <div>
                                <div style="font-size:13px;font-weight:700;color:#f0f6ff;">Pembelajaran klinis lebih
                                    terstruktur</div>
                                <div style="font-size:12px;color:#94a3b8;margin-top:3px;">Dari pencatatan hingga evaluasi
                                </div>
                            </div>
                            <div
                                style="width:38px;height:38px;border-radius:10px;background:rgba(6,182,212,.2);display:flex;align-items:center;justify-content:center;color:#22d3ee;flex-shrink:0;margin-left:12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.5l6 6 9-11" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Text --}}
                <div class="" data-aos="fade-left">
                    <div class="section-label">Tentang ClinicalLog</div>
                    <h2 class="section-title">
                        {{ $landing->about_title ?? 'Solusi Digital untuk Pendidikan Kedokteran Modern' }}</h2>
                    <p class="section-subtitle">
                        {{ $landing->about_description ?? 'ClinicalLog dirancang untuk menjembatani gap antara pendidikan teori dan praktik klinis dengan teknologi yang mudah digunakan oleh seluruh ekosistem akademik kedokteran.' }}
                    </p>

                    <ul class="about-check-list">
                        <li>
                            <div class="about-check-icon">✓</div>
                            <span class="about-check-text">Mendukung pembelajaran klinis yang lebih terukur dan efisien
                                dengan data yang akurat.</span>
                        </li>
                        <li>
                            <div class="about-check-icon">✓</div>
                            <span class="about-check-text">Memudahkan pemantauan mahasiswa oleh dosen dan dokter pembimbing
                                secara real-time.</span>
                        </li>
                        <li>
                            <div class="about-check-icon">✓</div>
                            <span class="about-check-text">Menyediakan data evaluasi yang rapi, akurat, dan siap dianalisis
                                kapan saja.</span>
                        </li>
                    </ul>

                    <div style="margin-top:20px;">
                        <a href="#kontak" class="btn-primary">Pelajari Lebih Lanjut</a>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endif


    {{-- ═══════════════════════════════════════════════════════
     FITUR
═══════════════════════════════════════════════════════ --}}
    @if(!$landing || ($landing->features_visible ?? true))
    <section class="section" id="fitur">
        <div class="container">
            <div class="text-center" data-aos="fade-up" style="margin-bottom:56px;">
                <div class="section-label" style="justify-content:center;">Fitur Unggulan</div>
                <h2 class="section-title">Semua yang Anda Butuhkan</h2>
                <p class="section-subtitle" style="margin:0 auto;">Dirancang khusus untuk ekosistem pendidikan kedokteran
                    Indonesia — dari mahasiswa, dosen, hingga institusi.</p>
            </div>

            <div class="features-grid">
                @foreach ($features as $index => $feature)
                    <article class="feature-card glass" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="feature-icon">
                            @if ($feature->icon_name)
                                <i data-lucide="{{ $feature->icon_name }}" style="width:24px;height:24px;"></i>
                            @elseif ($feature->icon)
                                <img src="{{ asset('storage/' . $feature->icon) }}" alt="{{ $feature->title }}">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            @endif
                        </div>
                        <h3 class="feature-title">{{ $feature->title }}</h3>
                        <p class="feature-desc">{{ $feature->description }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif


    {{-- ═══════════════════════════════════════════════════════
     KEUNGGULAN
═══════════════════════════════════════════════════════ --}}
    @if(!$landing || ($landing->benefits_visible ?? true))
    <section class="section" style="padding-top:0;">
        <div class="container">
            <div class="text-center" data-aos="fade-up" style="margin-bottom:48px;">
                <div class="section-label" style="justify-content:center;">Keunggulan</div>
                <h2 class="section-title">Mengapa Memilih ClinicalLog?</h2>
                <p class="section-subtitle" style="margin:0 auto;">Dirancang untuk membantu institusi pendidikan kedokteran beroperasi lebih
                    modern, efisien, dan kolaboratif.</p>
            </div>

            <div class="benefits-grid">
                @php
                    $benefitsData = $landing && $landing->benefits ? $landing->benefits : [
                        ['icon' => 'zap', 'title' => 'Efisiensi proses pendidikan kedokteran'],
                        ['icon' => 'radar', 'title' => 'Monitoring dan evaluasi secara real-time'],
                        ['icon' => 'file-check', 'title' => 'Dokumentasi digital tanpa kertas'],
                        ['icon' => 'users', 'title' => 'Kolaborasi mahasiswa dan dokter pembimbing'],
                    ];
                @endphp
                @foreach ($benefitsData as $index => $b)
                    <article class="benefit-card glass" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="benefit-icon">
                            <i data-lucide="{{ $b['icon'] }}" style="width:22px;height:22px;"></i>
                        </div>
                        <h3 class="benefit-title">{{ $b['title'] }}</h3>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif


    {{-- ═══════════════════════════════════════════════════════
     DASHBOARD PREVIEW
 ═══════════════════════════════════════════════════════ --}}
    @if(!$landing || ($landing->dashboard_visible ?? true))
    <section class="section" id="dashboard">
        <div class="container">
            <div class="text-center" data-aos="fade-up" style="margin-bottom:48px;">
                <div class="section-label" style="justify-content:center;">Dashboard</div>
                <h2 class="section-title">{{ $landing->dashboard_title ?? 'Dashboard ClinicalLog' }}</h2>
                <p class="section-subtitle" style="margin:0 auto;">{{ $landing->dashboard_description ?? 'Tampilan dashboard akan hadir pada versi berikutnya.' }}</p>
            </div>

            @if($landing && $landing->dashboard_image)
                <div class="glass" data-aos="fade-up" style="border-radius:28px;padding:12px;box-shadow:0 30px 60px rgba(15,23,42,0.06);border:1px solid rgba(255,255,255,0.7);background:rgba(255,255,255,0.65);">
                    <img src="{{ asset('storage/' . $landing->dashboard_image) }}" alt="{{ $landing->dashboard_title ?? 'Dashboard ClinicalLog' }}" style="width:100%;height:auto;display:block;border-radius:20px;border:1px solid rgba(15,23,42,0.08);">
                </div>
            @else
                <div class="glass" data-aos="fade-up" style="border-radius:28px;padding:8px;box-shadow:0 30px 60px rgba(15,23,42,0.04);">
                    <div class="glass-strong"
                        style="border-radius:22px;min-height:560px;display:flex;align-items:center;justify-content:center;flex-direction:column;text-align:center;gap:16px;">
                        <div
                            style="width:72px;height:72px;border-radius:20px;background:rgba(37,99,235,0.08);border:1px solid rgba(37,99,235,0.15);display:flex;align-items:center;justify-content:center;margin-bottom:8px;">
                            <i data-lucide="monitor" style="width:32px;height:32px;color:var(--blue-lt);"></i>
                        </div>
                        <h3 style="font-size:22px;font-weight:700;color:var(--text-primary);">Dashboard Preview</h3>
                        <p style="font-size:15px;color:var(--text-muted);max-width:340px;">Area dashboard disiapkan untuk screenshot
                            aplikasi ClinicalLog.</p>
                        <a href="#kontak" class="btn-primary" style="margin-top:8px;">Jadwalkan Demo</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
    @endif


    {{-- ═══════════════════════════════════════════════════════
     CARA KERJA
═══════════════════════════════════════════════════════ --}}
    @if(!$landing || ($landing->steps_visible ?? true))
    <section class="section" id="cara-kerja">
        <div class="container">
            <div class="text-center" data-aos="fade-up" style="margin-bottom:60px;">
                <div class="section-label" style="justify-content:center;">Cara Kerja</div>
                <h2 class="section-title">Alur ClinicalLog</h2>
                <p class="section-subtitle" style="margin:0 auto;">Proses sederhana dan terintegrasi dari pencatatan
                    hingga evaluasi akhir.</p>
            </div>

            <div class="steps-grid">
                @php
                    $stepsData = $landing && $landing->steps ? $landing->steps : [
                        [
                            'icon' => 'clipboard-edit',
                            'num' => '01',
                            'title' => 'Catat Aktivitas Klinis',
                            'desc' =>
                                'Mahasiswa mencatat kasus dan aktivitas klinis secara digital langsung dari smartphone.',
                        ],
                        [
                            'icon' => 'qr-code',
                            'num' => '02',
                            'title' => 'Verifikasi QR Code',
                            'desc' => 'Aktivitas diverifikasi oleh pembimbing dengan scan QR Code yang aman dan cepat.',
                        ],
                        [
                            'icon' => 'line-chart',
                            'num' => '03',
                            'title' => 'Pantau Kompetensi',
                            'desc' =>
                                'Progress kompetensi mahasiswa terpantau secara real-time oleh dosen dan institusi.',
                        ],
                        [
                            'icon' => 'file-bar-chart',
                            'num' => '04',
                            'title' => 'Laporan & Evaluasi',
                            'desc' =>
                                'Data tersaji rapi untuk laporan otomatis dan pengambilan keputusan berbasis data.',
                        ],
                    ];
                @endphp
                @foreach ($stepsData as $index => $s)
                    <div class="step-item" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="step-num">
                            <i data-lucide="{{ $s['icon'] }}" style="width:26px;height:26px;"></i>
                        </div>
                        <div class="step-label">Langkah {{ $s['num'] }}</div>
                        <h3 class="step-title">{{ $s['title'] }}</h3>
                        <p class="step-desc">{{ $s['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif


    {{-- ═══════════════════════════════════════════════════════
     TESTIMONI
═══════════════════════════════════════════════════════ --}}
    @if(!$landing || ($landing->testimonials_visible ?? true))
    <section class="section" id="testimoni">
        <div class="container">
            <div class="text-center" data-aos="fade-up" style="margin-bottom:48px;">
                <div class="section-label" style="justify-content:center;">Testimoni</div>
                <h2 class="section-title">Apa Kata Pengguna?</h2>
                <p class="section-subtitle" style="margin:0 auto;">Dipercaya oleh tenaga pendidik dan mahasiswa untuk
                    menciptakan proses pembelajaran klinis yang lebih efektif.</p>
            </div>

            <div class="flex justify-center" style="margin-bottom:36px;">
                <div class="testi-toggle">
                    <button class="testi-toggle-btn active" id="showBtn" onclick="showTestimonials()">
                        <i data-lucide="eye" style="width:14px;height:14px;"></i> Tampilkan
                    </button>
                    <button class="testi-toggle-btn" id="hideBtn" onclick="hideTestimonials()">
                        <i data-lucide="eye-off" style="width:14px;height:14px;"></i> Sembunyikan
                    </button>
                </div>
            </div>

            <div class="testi-grid" id="testimonialCards">
                @php
                    $testiData = $landing && $landing->testimonials ? $landing->testimonials : [
                        [
                            'quote' =>
                                'ClinicalLog membantu kami memantau perkembangan mahasiswa dengan jauh lebih cepat dan terstruktur. Proses evaluasi menjadi lebih objektif dan mudah dilakukan.',
                            'name' => 'dr. Andi Prasetyo, Sp.PD',
                            'role' => 'Dosen Fakultas Kedokteran',
                            'img' =>
                                'https://images.pexels.com/photos/5452293/pexels-photo-5452293.jpeg?auto=compress&cs=tinysrgb&w=400',
                        ],
                        [
                            'quote' =>
                                'Dengan verifikasi digital dan monitoring real-time, aktivitas mahasiswa di lapangan menjadi lebih transparan dan mudah dikontrol.',
                            'name' => 'dr. Maya Wulandari',
                            'role' => 'Dokter Pembimbing Klinik',
                            'img' =>
                                'https://images.pexels.com/photos/8376281/pexels-photo-8376281.jpeg?auto=compress&cs=tinysrgb&w=400',
                        ],
                        [
                            'quote' =>
                                'Aplikasi ini membuat pencatatan aktivitas jauh lebih praktis. Saya bisa fokus belajar tanpa harus repot dengan dokumen manual.',
                            'name' => 'Nadia Azzahra',
                            'role' => 'Mahasiswa Kedokteran',
                            'img' =>
                                'https://images.pexels.com/photos/27392533/pexels-photo-27392533.jpeg?auto=compress&cs=tinysrgb&w=400',
                        ],
                    ];
                @endphp
                @foreach ($testiData as $index => $t)
                    <article class="testi-card glass" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="testi-stars">★★★★★</div>
                        <p class="testi-quote">"{{ $t['quote'] }}"</p>
                        <div class="testi-author">
                            <img class="testi-author-img" src="{{ $t['img'] }}" alt="{{ $t['name'] }}"
                                loading="lazy">
                            <div>
                                <div class="testi-author-name">{{ $t['name'] }}</div>
                                <div class="testi-author-role">{{ $t['role'] }}</div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif


    {{-- ═══════════════════════════════════════════════════════
     CTA
═══════════════════════════════════════════════════════ --}}
    @if(!$landing || ($landing->cta_visible ?? true))
    <section class="section-sm" id="kontak">
        <div class="container">
            <div class="cta-banner" data-aos="fade-up">
                <h2 class="cta-title">
                    {!! nl2br(e($landing->cta_title ?? 'Digitalisasi Pembelajaran Klinis Bersama ClinicalLog')) !!}
                </h2>
                <p class="cta-desc">{{ $landing->cta_description ?? 'Tingkatkan kualitas pendidikan kedokteran dengan platform Medical Data & E-Logbook yang terintegrasi dan mudah digunakan.' }}</p>
                <div class="cta-actions">
                    <a href="javascript:void(0)" onclick="openAppointmentModal()" class="btn-primary" style="background:#fff;color:#1e40af;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Jadwalkan Demo
                    </a>
                    <a href="https://wa.me/6281234567890?text=Halo%20ClinicalLog%2C%20saya%20ingin%20bertanya%20mengenai%20platform%20ClinicalLog." target="_blank" class="btn-secondary"
                        style="background:rgba(255,255,255,.12);color:#fff;border-color:rgba(255,255,255,.3);">
                        Hubungi Tim Kami
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif


    {{-- ═══════════════════════════════════════════════════════
     PRICING
═══════════════════════════════════════════════════════ --}}
    @if(!$landing || ($landing->pricing_visible ?? true))
    <section class="section" id="pricing">
        <div class="container">
            <div class="text-center" data-aos="fade-up" style="margin-bottom:56px;">
                <div class="section-label" style="justify-content:center;">Paket Lisensi</div>
                <h2 class="section-title">Pilih Paket ClinicalLog</h2>
                <p class="section-subtitle" style="margin:0 auto;">Fleksibel untuk kebutuhan departemen, fakultas, hingga
                    universitas.</p>
            </div>

            <div class="pricing-grid">
                @php
                    $plansData = $landing && $landing->pricing_plans ? $landing->pricing_plans : [
                        [
                            'tier' => 'Starter',
                            'name' => 'Department',
                            'price' => 'Rp25 Juta',
                            'featured' => false,
                            'features' => ['Maks 100 mahasiswa', 'Maks 5 dosen', 'Dashboard basic', 'Support email'],
                        ],
                        [
                            'tier' => 'Populer',
                            'name' => 'Faculty',
                            'price' => 'Rp50 Juta',
                            'featured' => true,
                            'features' => [
                                'Unlimited mahasiswa',
                                'Unlimited dosen',
                                'Integrasi SIAKAD',
                                'Dashboard Analytics',
                                'Priority support',
                            ],
                        ],
                        [
                            'tier' => 'Enterprise',
                            'name' => 'University',
                            'price' => 'Rp75 Juta',
                            'featured' => false,
                            'features' => [
                                'Multi-fakultas',
                                'Central Admin',
                                'Custom Reporting',
                                'Training & Support',
                                'SLA Guarantee',
                            ],
                        ],
                    ];
                @endphp
                @foreach ($plansData as $index => $plan)
                    <div class="pricing-card glass {{ $plan['featured'] ? 'featured' : '' }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                        onclick="this.classList.toggle('selected')">
                        @if ($plan['featured'])
                            <div class="pricing-badge">⭐ Paling Populer</div>
                        @endif
                        <div class="pricing-tier">{{ $plan['tier'] }}</div>
                        <div class="pricing-name">{{ $plan['name'] }}</div>
                        <div class="pricing-divider"></div>
                                                @if(!empty($plan['price']))
                                                    <div class="pricing-price gradient-text">{{ $plan['price'] }}<span class="currency">/tahun</span></div>
                                                    <div class="pricing-period">Tagihan per tahun &middot; Batal kapan saja</div>
                                                @else
                                                    <div class="pricing-price" style="font-size:26px;color:var(--blue);">Hubungi Kami</div>
                                                    <div class="pricing-period">Harga disesuaikan kebutuhan Anda</div>
                                                @endif
                        <ul class="pricing-list">
                            @foreach ($plan['features'] as $feat)
                                <li><span class="check">✓</span> {{ $feat }}</li>
                            @endforeach
                        </ul>
                        <a href="#kontak" class="{{ $plan['featured'] ? 'btn-primary' : 'btn-secondary' }}"
                            style="text-align:center;justify-content:center;">
                            Mulai Sekarang
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

@endsection

@push('scripts')
    <script>
        // Testimonials toggle
        function showTestimonials() {
            document.getElementById('testimonialCards').classList.remove('hide');
            document.getElementById('showBtn').classList.add('active');
            document.getElementById('hideBtn').classList.remove('active');
        }

        function hideTestimonials() {
            document.getElementById('testimonialCards').classList.add('hide');
            document.getElementById('hideBtn').classList.add('active');
            document.getElementById('showBtn').classList.remove('active');
        }

        // Counter 0 → 100%
        let pct = 0;
        const counterEl = document.getElementById('statPaperless');
        if (counterEl) {
            const iv = setInterval(() => {
                pct++;
                counterEl.textContent = pct + '%';
                if (pct >= 100) clearInterval(iv);
            }, 18);
        }

        // Typing effect
        function typeText(id, text, speed = 110) {
            const el = document.getElementById(id);
            if (!el) return;
            let i = 0;
            const go = () => {
                if (i < text.length) {
                    el.textContent += text[i++];
                    setTimeout(go, speed);
                }
            };
            go();
        }
        window.addEventListener('load', () => {
            setTimeout(() => typeText('statRealtime', 'Real-time'), 500);
            setTimeout(() => typeText('statMulti', 'Multi Platform'), 1800);
        });
    </script>
@endpush
