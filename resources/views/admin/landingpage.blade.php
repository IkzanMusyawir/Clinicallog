@extends('layouts.admin')

@section('title', 'Edit Landing Page')

@push('head')
<style>
    @keyframes tabFadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .cms-panel-animate {
        animation: tabFadeIn .28s cubic-bezier(.4,0,.2,1) both;
    }
    .cms-tab {
        transition: all .2s cubic-bezier(.4,0,.2,1);
    }
    .cms-tab:hover:not(.active) {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(37,99,235,.15);
    }
    .cms-tab.active {
        transition: background .25s, color .25s, box-shadow .25s, transform .2s;
    }
</style>
@endpush

@section('content')

    <div class="admin-topbar">
        <div>
            <h1 class="admin-page-title">Edit Landing Page</h1>
            <p class="admin-page-sub">Kelola semua konten halaman utama website Anda</p>
        </div>
        <a href="{{ route('home') }}" class="btn-secondary btn-sm" target="_blank">
            <i data-lucide="eye" style="width:14px;height:14px;"></i>
            Preview Website
        </a>
    </div>

    <form method="POST" action="{{ route('admin.landing.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ═══ Section Nav Tabs ═══ --}}
        <div class="cms-tabs glass-card glass" style="padding:6px 12px;margin-bottom:20px;overflow:hidden;">
            <div class="cms-tabs-container">
                <button type="button" class="cms-tab active" onclick="switchTab('hero', this)">
                    <i data-lucide="home" style="width:14px;height:14px;"></i> Hero
                </button>
                <button type="button" class="cms-tab" onclick="switchTab('navigation', this)">
                    <i data-lucide="navigation" style="width:14px;height:14px;"></i> Navigasi
                </button>
                <button type="button" class="cms-tab" onclick="switchTab('about', this)">
                    <i data-lucide="info" style="width:14px;height:14px;"></i> Tentang
                </button>
                <button type="button" class="cms-tab" onclick="switchTab('features', this)">
                    <i data-lucide="star" style="width:14px;height:14px;"></i> Fitur
                </button>
                <button type="button" class="cms-tab" onclick="switchTab('benefits', this)">
                    <i data-lucide="award" style="width:14px;height:14px;"></i> Keunggulan
                </button>
                <button type="button" class="cms-tab" onclick="switchTab('dashboard_tab', this)">
                    <i data-lucide="monitor" style="width:14px;height:14px;"></i> Dashboard
                </button>
                <button type="button" class="cms-tab" onclick="switchTab('steps', this)">
                    <i data-lucide="list-ordered" style="width:14px;height:14px;"></i> Cara Kerja
                </button>
                <button type="button" class="cms-tab" onclick="switchTab('testimonials', this)">
                    <i data-lucide="message-square" style="width:14px;height:14px;"></i> Testimoni
                </button>
                <button type="button" class="cms-tab" onclick="switchTab('pricing', this)">
                    <i data-lucide="credit-card" style="width:14px;height:14px;"></i> Harga
                </button>
                <button type="button" class="cms-tab" onclick="switchTab('cta', this)">
                    <i data-lucide="megaphone" style="width:14px;height:14px;"></i> CTA
                </button>
            </div>
        </div>


        {{-- ═══════════════════════════════════════════
             TAB: HERO
        ═══════════════════════════════════════════ --}}
        <div class="cms-panel" id="panel-hero">
            <div class="admin-grid-1-1">
                <div class="glass-card glass">
                    <div class="cms-section-header">
                        <span class="cms-section-bar" style="background:linear-gradient(180deg,#2563eb,#06b6d4);"></span>
                        Konten Hero
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hero_badge">Teks Badge</label>
                        <input type="text" id="hero_badge" name="hero_badge" class="form-input"
                            value="{{ old('hero_badge', $landing->hero_badge ?? 'Platform E-Logbook Kedokteran #1 Indonesia') }}"
                            placeholder="Platform E-Logbook Kedokteran #1 Indonesia">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hero_title">Judul Utama</label>
                        <textarea id="hero_title" name="hero_title" class="form-input" style="min-height:100px;"
                            placeholder="Masukkan judul utama hero...">{{ old('hero_title', $landing->hero_title ?? '') }}</textarea>
                        <p class="form-hint">Gunakan Enter untuk baris baru. Contoh:<br>Transformasi<br>Pendidikan<br>Kedokteran Digital</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hero_description">Deskripsi Hero</label>
                        <textarea id="hero_description" name="hero_description" class="form-input" style="min-height:100px;">{{ old('hero_description', $landing->hero_description ?? '') }}</textarea>
                    </div>

                    <div class="admin-grid-1-1-sm">
                        <div class="form-group">
                            <label class="form-label" for="hero_cta_primary">Tombol Utama</label>
                            <input type="text" id="hero_cta_primary" name="hero_cta_primary" class="form-input"
                                value="{{ old('hero_cta_primary', $landing->hero_cta_primary ?? 'Minta Demo Gratis') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="hero_cta_secondary">Tombol Kedua</label>
                            <input type="text" id="hero_cta_secondary" name="hero_cta_secondary" class="form-input"
                                value="{{ old('hero_cta_secondary', $landing->hero_cta_secondary ?? 'Lihat Fitur') }}">
                        </div>
                    </div>
                </div>

                <div class="glass-card glass">
                    <div class="cms-section-header">
                        <span class="cms-section-bar" style="background:linear-gradient(180deg,#22d3ee,#818cf8);"></span>
                        Gambar Hero
                    </div>

                    @if (isset($landing) && $landing->hero_image)
                        <div class="cms-current-image">
                            <img src="{{ asset('storage/' . $landing->hero_image) }}" alt="Hero Image">
                            <div class="cms-current-image-label">
                                <i data-lucide="image" style="width:12px;height:12px;display:inline;"></i>
                                Gambar saat ini
                            </div>
                        </div>
                        <div style="margin: 10px 0 16px;">
                            <label style="display:inline-flex;align-items:center;gap:8px;font-size:13px;color:#ef4444;cursor:pointer;font-weight:500;">
                                <input type="checkbox" name="delete_hero_image" value="1" style="width:16px;height:16px;accent-color:#ef4444;cursor:pointer;">
                                <i data-lucide="trash-2" style="width:14px;height:14px;display:inline;"></i> Hapus gambar saat ini
                            </label>
                            <p style="font-size:11px;color:#94a3b8;margin-top:4px;padding-left:24px;">* Centang checkbox ini, lalu klik tombol <strong>"Simpan Semua Perubahan"</strong> di bagian bawah halaman untuk menghapus gambar.</p>
                        </div>
                    @endif

                    <div class="upload-zone" id="heroUploadZone" onclick="document.getElementById('hero_image').click()">
                        <i data-lucide="upload-cloud"
                            style="width:28px;height:28px;margin:0 auto 10px;display:block;color:#38bdf8;"></i>
                        <div style="font-weight:600;color:#94a3b8;margin-bottom:4px;">Klik atau drag & drop gambar hero
                        </div>
                        <div style="font-size:12px;color:#64748b;">JPG, PNG, WebP (maks 2MB)</div>
                        <div id="heroPreview" style="display:none;margin-top:12px;">
                            <img id="heroPreviewImg" src="" alt=""
                                style="width:100%;max-height:160px;object-fit:cover;border-radius:10px;margin:0 auto;display:block;">
                            <div id="heroPreviewName" style="font-size:12px;color:#22d3ee;text-align:center;margin-top:6px;">
                            </div>
                        </div>
                    </div>
                    <input type="file" id="hero_image" name="hero_image" accept=".jpg,.jpeg,.png,.webp"
                        style="display:none;">
                    @error('hero_image')
                        <p style="font-size:12px;color:#f87171;margin-top:5px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>


        {{-- ═══════════════════════════════════════════
             TAB: NAVIGASI
        ═══════════════════════════════════════════ --}}
        <div class="cms-panel" id="panel-navigation" style="display:none;">
            <div class="admin-grid-1-1-5">
                <div class="glass-card glass">
                    <div class="cms-section-header">
                        <span class="cms-section-bar" style="background:linear-gradient(180deg,#2563eb,#06b6d4);"></span>
                        Tombol CTA Navbar
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="navbar_cta_text">Teks Tombol CTA</label>
                        <input type="text" id="navbar_cta_text" name="navbar_cta_text" class="form-input"
                            value="{{ old('navbar_cta_text', $landing->navbar_cta_text ?? 'Minta Demo') }}"
                            placeholder="Minta Demo">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="navbar_cta_url">Link/Target Tombol CTA</label>
                        <input type="text" id="navbar_cta_url" name="navbar_cta_url" class="form-input"
                            value="{{ old('navbar_cta_url', $landing->navbar_cta_url ?? '#kontak') }}"
                            placeholder="#kontak">
                    </div>
                </div>

                <div class="glass-card glass" style="margin-top: 20px; border-color: rgba(56,189,248,0.2);">
                    <div style="font-size:14px;font-weight:600;color:#38bdf8;margin-bottom:12px;display:flex;align-items:center;gap:6px;">
                        <i data-lucide="help-circle" style="width:16px;height:16px;"></i> Panduan Link Navigasi
                    </div>
                    <p style="font-size:12px;color:#94a3b8;line-height:1.5;margin-bottom:10px;">
                        Untuk mengarahkan navigasi ke bagian tertentu di halaman utama, gunakan format anchor ID (diawali tanda #) berikut:
                    </p>
                    <ul style="font-size:12px;color:#cbd5e1;padding-left:16px;line-height:1.8;">
                        <li><strong>#beranda</strong> : Bagian Atas / Hero</li>
                        <li><strong>#tentang</strong> : Seksi Tentang Kami</li>
                        <li><strong>#fitur</strong> : Seksi Fitur Unggulan</li>
                        <li><strong>#dashboard</strong> : Seksi Pratinjau Dashboard</li>
                        <li><strong>#cara-kerja</strong> : Seksi Cara Kerja / Alur</li>
                        <li><strong>#testimoni</strong> : Seksi Testimoni</li>
                        <li><strong>#pricing</strong> : Seksi Paket Harga</li>
                        <li><strong>#kontak</strong> : Bagian Kontak / CTA Bawah</li>
                    </ul>
                    <p style="font-size:11px;color:#64748b;margin-top:8px;line-height:1.4;">
                        * Anda juga bisa mengisi dengan link eksternal penuh (misal: <em>https://google.com</em>).
                    </p>
                </div>

                <div class="glass-card glass">
                    <div class="cms-section-header" style="justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span class="cms-section-bar" style="background:linear-gradient(180deg,#22d3ee,#818cf8);"></span>
                            Menu Link Navigasi
                        </div>
                        <button type="button" class="btn-secondary btn-sm" onclick="addNavLink()">
                            <i data-lucide="plus" style="width:14px;height:14px;"></i> Tambah Link
                        </button>
                    </div>
                    <p class="form-hint" style="margin-bottom:20px;">Atur link menu yang ada di navbar. Link bisa berupa anchor (seperti #tentang) atau URL lengkap.</p>

                    <div id="navLinksContainer">
                        @php
                            $navLinksItems = old('navbar_links', $landing->navbar_links ?? [
                                ['label' => 'Beranda',    'url' => '#beranda'],
                                ['label' => 'Tentang',    'url' => '#tentang'],
                                ['label' => 'Fitur',      'url' => '#fitur'],
                                ['label' => 'Dashboard',  'url' => '#dashboard'],
                                ['label' => 'Cara Kerja', 'url' => '#cara-kerja'],
                                ['label' => 'Harga',      'url' => '#pricing'],
                                ['label' => 'Testimoni',  'url' => '#testimoni'],
                                ['label' => 'Kontak',     'url' => '#kontak'],
                            ]);
                        @endphp
                        @foreach ($navLinksItems as $i => $link)
                            <div class="cms-repeater-item" data-index="{{ $i }}">
                                <div class="cms-repeater-row">
                                    <div style="flex:1;">
                                        <label class="form-label">Label Menu</label>
                                        <input type="text" name="navbar_links[{{ $i }}][label]" class="form-input"
                                            value="{{ $link['label'] ?? '' }}" placeholder="Contoh: Beranda">
                                    </div>
                                    <div style="flex:1.5;">
                                        <label class="form-label">Link Target (URL / Anchor ID)</label>
                                        <input type="text" name="navbar_links[{{ $i }}][url]" class="form-input"
                                            value="{{ $link['url'] ?? '' }}" placeholder="Contoh: #beranda">
                                    </div>
                                    <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                                        <button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">
                                            <i data-lucide="arrow-up" style="width:14px;height:14px;"></i>
                                        </button>
                                        <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                                            <i data-lucide="arrow-down" style="width:14px;height:14px;"></i>
                                        </button>
                                        <button type="button" class="btn-icon danger cms-remove-btn" onclick="const container = this.closest('.cms-repeater-item').parentNode; this.closest('.cms-repeater-item').remove(); reindexRepeater(container);" title="Hapus">
                                            <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- GDrive Links card --}}
                <div class="glass-card glass">
                    <div class="cms-section-header">
                        <span class="cms-section-bar" style="background:linear-gradient(180deg,#818cf8,#c084fc);"></span>
                        Dokumen Legal (Google Drive)
                    </div>
                    <p class="form-hint" style="margin-bottom:20px; line-height: 1.5;">
                        Simpan link Google Drive untuk unduhan file PDF dokumen legal Anda. 
                        Pastikan pengaturan berbagi di Google Drive telah diatur ke <strong>"Siapa saja yang memiliki link dapat melihat/mengunduh"</strong> (Anyone with link can view).
                    </p>
                    <div class="form-group">
                        <label class="form-label" for="terms_gdrive_url">Link Google Drive S&K (Syarat & Ketentuan)</label>
                        <input type="text" id="terms_gdrive_url" name="terms_gdrive_url" class="form-input"
                            value="{{ old('terms_gdrive_url', $landing->terms_gdrive_url ?? '') }}"
                            placeholder="https://drive.google.com/file/d/.../view?usp=sharing">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="privacy_gdrive_url">Link Google Drive K&P (Kebijakan & Privasi)</label>
                        <input type="text" id="privacy_gdrive_url" name="privacy_gdrive_url" class="form-input"
                            value="{{ old('privacy_gdrive_url', $landing->privacy_gdrive_url ?? '') }}"
                            placeholder="https://drive.google.com/file/d/.../view?usp=sharing">
                    </div>
                </div>

            </div>
        </div>


        {{-- ═══════════════════════════════════════════
             TAB: ABOUT
        ═══════════════════════════════════════════ --}}
        <div class="cms-panel" id="panel-about" style="display:none;">
            {{-- Toggle Visibility --}}
            @php
                $aboutVisible = old('about_visible', $landing->about_visible ?? true);
            @endphp
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $aboutVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $aboutVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;" id="aboutToggleBox">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;border-radius:12px;background:{{ $aboutVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;" id="aboutToggleIconBox">
                        <i data-lucide="{{ $aboutVisible ? 'eye' : 'eye-off' }}" style="width:20px;height:20px;color:{{ $aboutVisible ? '#34d399' : '#f87171' }};" id="aboutToggleIcon"></i>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:600;color:#1e293b;" id="aboutToggleTitle">
                            {{ $aboutVisible ? 'Seksi Tentang Aktif' : 'Seksi Tentang Nonaktif' }}
                        </div>
                        <div style="font-size:12px;color:#475569;margin-top:2px;" id="aboutToggleDesc">
                            {{ $aboutVisible ? 'Seksi tentang kami ditampilkan di landing page dan navigasi.' : 'Seksi tentang kami disembunyikan dari landing page dan navigasi.' }}
                        </div>
                    </div>
                </div>
                <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
                    <input type="checkbox" name="about_visible" value="1" {{ $aboutVisible ? 'checked' : '' }}
                        style="opacity:0;width:0;height:0;position:absolute;" id="aboutVisibleCheckbox"
                        onchange="updateAboutToggle(this.checked)">
                    <span style="position:absolute;inset:0;border-radius:14px;background:{{ $aboutVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;" id="aboutToggleTrack"></span>
                    <span style="position:absolute;top:3px;{{ $aboutVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;" id="aboutToggleKnob"></span>
                </label>
            </div>

            <div class="admin-grid-1-1">
                <div class="glass-card glass">
                    <div class="cms-section-header">
                        <span class="cms-section-bar" style="background:linear-gradient(180deg,#22d3ee,#818cf8);"></span>
                        Konten Tentang
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_title">Judul</label>
                        <input type="text" id="about_title" name="about_title" class="form-input"
                            value="{{ old('about_title', $landing->about_title ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_description">Deskripsi</label>
                        <textarea id="about_description" name="about_description" class="form-input" style="min-height:150px;">{{ old('about_description', $landing->about_description ?? '') }}</textarea>
                    </div>
                </div>

                <div class="glass-card glass">
                    <div class="cms-section-header">
                        <span class="cms-section-bar" style="background:linear-gradient(180deg,#818cf8,#c084fc);"></span>
                        Gambar Tentang
                    </div>

                    @if (isset($landing) && $landing->about_image)
                        <div class="cms-current-image">
                            <img src="{{ asset('storage/' . $landing->about_image) }}" alt="About Image">
                            <div class="cms-current-image-label">
                                <i data-lucide="image" style="width:12px;height:12px;display:inline;"></i>
                                Gambar saat ini
                            </div>
                        </div>
                        <div style="margin: 10px 0 16px;">
                            <label style="display:inline-flex;align-items:center;gap:8px;font-size:13px;color:#ef4444;cursor:pointer;font-weight:500;">
                                <input type="checkbox" name="delete_about_image" value="1" style="width:16px;height:16px;accent-color:#ef4444;cursor:pointer;">
                                <i data-lucide="trash-2" style="width:14px;height:14px;display:inline;"></i> Hapus gambar saat ini
                            </label>
                            <p style="font-size:11px;color:#94a3b8;margin-top:4px;padding-left:24px;">* Centang checkbox ini, lalu klik tombol <strong>"Simpan Semua Perubahan"</strong> di bagian bawah halaman untuk menghapus gambar.</p>
                        </div>
                    @endif

                    <div class="upload-zone" id="aboutUploadZone"
                        onclick="document.getElementById('about_image').click()">
                        <i data-lucide="upload-cloud"
                            style="width:28px;height:28px;margin:0 auto 10px;display:block;color:#38bdf8;"></i>
                        <div style="font-weight:600;color:#94a3b8;margin-bottom:4px;">Klik atau drag & drop gambar tentang
                        </div>
                        <div style="font-size:12px;color:#64748b;">JPG, PNG, WebP (maks 2MB)</div>
                        <div id="aboutPreview" style="display:none;margin-top:12px;">
                            <img id="aboutPreviewImg" src="" alt=""
                                style="width:100%;max-height:160px;object-fit:cover;border-radius:10px;margin:0 auto;display:block;">
                            <div id="aboutPreviewName"
                                style="font-size:12px;color:#22d3ee;text-align:center;margin-top:6px;">
                            </div>
                        </div>
                    </div>
                    <input type="file" id="about_image" name="about_image" accept=".jpg,.jpeg,.png,.webp"
                        style="display:none;">
                    @error('about_image')
                        <p style="font-size:12px;color:#f87171;margin-top:5px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>


        {{-- ═══════════════════════════════════════════
             TAB: FEATURES
        ═══════════════════════════════════════════ --}}
        <div class="cms-panel" id="panel-features" style="display:none;">
            {{-- Toggle Visibility --}}
            @php
                $featuresVisible = old('features_visible', $landing->features_visible ?? true);
            @endphp
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $featuresVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $featuresVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;" id="featuresToggleBox">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;border-radius:12px;background:{{ $featuresVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;" id="featuresToggleIconBox">
                        <i data-lucide="{{ $featuresVisible ? 'eye' : 'eye-off' }}" style="width:20px;height:20px;color:{{ $featuresVisible ? '#34d399' : '#f87171' }};" id="featuresToggleIcon"></i>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:600;color:#1e293b;" id="featuresToggleTitle">
                            {{ $featuresVisible ? 'Seksi Fitur Aktif' : 'Seksi Fitur Nonaktif' }}
                        </div>
                        <div style="font-size:12px;color:#475569;margin-top:2px;" id="featuresToggleDesc">
                            {{ $featuresVisible ? 'Seksi fitur unggulan ditampilkan di landing page dan navigasi.' : 'Seksi fitur unggulan disembunyikan dari landing page dan navigasi.' }}
                        </div>
                    </div>
                </div>
                <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
                    <input type="checkbox" name="features_visible" value="1" {{ $featuresVisible ? 'checked' : '' }}
                        style="opacity:0;width:0;height:0;position:absolute;" id="featuresVisibleCheckbox"
                        onchange="updateFeaturesToggle(this.checked)">
                    <span style="position:absolute;inset:0;border-radius:14px;background:{{ $featuresVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;" id="featuresToggleTrack"></span>
                    <span style="position:absolute;top:3px;{{ $featuresVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;" id="featuresToggleKnob"></span>
                </label>
            </div>

            <div class="glass-card glass">
                <div class="cms-section-header" style="justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span class="cms-section-bar" style="background:linear-gradient(180deg,#2563eb,#06b6d4);"></span>
                        Fitur Unggulan
                    </div>
                    <a href="{{ route('admin.features.create') }}" class="btn-secondary btn-sm">
                        <i data-lucide="plus" style="width:14px;height:14px;"></i> Tambah
                    </a>
                </div>
                <p class="form-hint" style="margin-bottom:20px;">Kelola item fitur unggulan yang ditampilkan di landing page. Icon menggunakan nama dari <a href="https://lucide.dev/icons/" target="_blank" style="color:#38bdf8;">Lucide Icons</a>.</p>

                @if($features->count())
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th style="width:44px;">No</th>
                                    <th style="width:52px;">Icon</th>
                                    <th>Nama Fitur</th>
                                    <th>Deskripsi</th>
                                    <th style="width:90px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($features as $feature)
                                    <tr>
                                        <td>
                                            <div style="width:32px;height:32px;border-radius:8px;background:rgba(37,99,235,.1);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#60a5fa;">
                                                {{ $feature->sort_order }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($feature->icon_name)
                                                <div style="width:40px;height:40px;border-radius:10px;background:rgba(37,99,235,.15);border:1px solid rgba(37,99,235,.2);display:flex;align-items:center;justify-content:center;">
                                                    <i data-lucide="{{ $feature->icon_name }}" style="width:20px;height:20px;color:#60a5fa;"></i>
                                                </div>
                                            @elseif($feature->icon)
                                                <div style="width:40px;height:40px;border-radius:10px;background:rgba(37,99,235,.15);border:1px solid rgba(37,99,235,.2);display:flex;align-items:center;justify-content:center;overflow:hidden;">
                                                    <img src="{{ asset('storage/' . $feature->icon) }}" alt="" style="width:24px;height:24px;object-fit:contain;">
                                                </div>
                                            @else
                                                <div style="width:40px;height:40px;border-radius:10px;background:rgba(37,99,235,.1);border:1px solid rgba(37,99,235,.15);display:flex;align-items:center;justify-content:center;">
                                                    <i data-lucide="image" style="width:16px;height:16px;color:#64748b;"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td style="font-weight:500;">{{ $feature->title }}</td>
                                        <td style="max-width:300px;">
                                            <span style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;font-size:13px;color:#64748b;">
                                                {{ $feature->description }}
                                            </span>
                                        </td>
                                        <td>
                                            <div style="display:flex;gap:6px;">
                                                <a href="{{ route('admin.features.edit', $feature->id) }}" class="btn-icon" title="Edit">
                                                    <i data-lucide="edit-2" style="width:13px;height:13px;"></i>
                                                </a>
                                                <button type="button" class="btn-icon danger" title="Hapus"
                                                    onclick="if(confirm('Hapus fitur ini?')) { const f = document.getElementById('delete-feature-form'); f.action = '{{ route('admin.features.destroy', $feature->id) }}'; f.submit(); }">
                                                    <i data-lucide="trash-2" style="width:13px;height:13px;"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if(method_exists($features, 'links') && $features->hasPages())
                        <div style="margin-top:20px;padding-top:16px;border-top:1px solid rgba(0,0,0,.06);">
                            {{ $features->links() }}
                        </div>
                    @endif
                @else
                    <div style="text-align:center;padding:48px 20px;">
                        <div style="width:56px;height:56px;border-radius:16px;background:rgba(37,99,235,.1);margin:0 auto 14px;display:flex;align-items:center;justify-content:center;">
                            <i data-lucide="layers" style="width:24px;height:24px;color:#60a5fa;"></i>
                        </div>
                        <p style="font-size:14px;color:#64748b;margin-bottom:16px;">Belum ada fitur. Tambahkan fitur pertama.</p>
                        <a href="{{ route('admin.features.create') }}" class="btn-primary btn-sm">
                            <i data-lucide="plus" style="width:14px;height:14px;"></i> Tambah Fitur Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>


        {{-- ═══════════════════════════════════════════
             TAB: BENEFITS
        ═══════════════════════════════════════════ --}}
        <div class="cms-panel" id="panel-benefits" style="display:none;">
            {{-- Toggle Visibility --}}
            @php
                $benefitsVisible = old('benefits_visible', $landing->benefits_visible ?? true);
            @endphp
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $benefitsVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $benefitsVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;" id="benefitsToggleBox">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;border-radius:12px;background:{{ $benefitsVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;" id="benefitsToggleIconBox">
                        <i data-lucide="{{ $benefitsVisible ? 'eye' : 'eye-off' }}" style="width:20px;height:20px;color:{{ $benefitsVisible ? '#34d399' : '#f87171' }};" id="benefitsToggleIcon"></i>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:600;color:#1e293b;" id="benefitsToggleTitle">
                            {{ $benefitsVisible ? 'Seksi Keunggulan Aktif' : 'Seksi Keunggulan Nonaktif' }}
                        </div>
                        <div style="font-size:12px;color:#475569;margin-top:2px;" id="benefitsToggleDesc">
                            {{ $benefitsVisible ? 'Seksi keunggulan ditampilkan di landing page.' : 'Seksi keunggulan disembunyikan dari landing page.' }}
                        </div>
                    </div>
                </div>
                <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
                    <input type="checkbox" name="benefits_visible" value="1" {{ $benefitsVisible ? 'checked' : '' }}
                        style="opacity:0;width:0;height:0;position:absolute;" id="benefitsVisibleCheckbox"
                        onchange="updateBenefitsToggle(this.checked)">
                    <span style="position:absolute;inset:0;border-radius:14px;background:{{ $benefitsVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;" id="benefitsToggleTrack"></span>
                    <span style="position:absolute;top:3px;{{ $benefitsVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;" id="benefitsToggleKnob"></span>
                </label>
            </div>

            <div class="glass-card glass">
                <div class="cms-section-header" style="justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span class="cms-section-bar" style="background:linear-gradient(180deg,#f59e0b,#ef4444);"></span>
                        Keunggulan
                    </div>
                    <button type="button" class="btn-secondary btn-sm" onclick="addBenefit()">
                        <i data-lucide="plus" style="width:14px;height:14px;"></i> Tambah
                    </button>
                </div>
                <p class="form-hint" style="margin-bottom:20px;">Atur keunggulan yang ditampilkan di landing page. Icon menggunakan nama dari <a href="https://lucide.dev/icons/" target="_blank" style="color:#38bdf8;">Lucide Icons</a>.</p>

                <div id="benefitsContainer">
                    @php
                        $benefitsItems = old('benefits', $landing->benefits ?? [
                            ['icon' => 'zap', 'title' => 'Efisiensi proses pendidikan kedokteran'],
                            ['icon' => 'radar', 'title' => 'Monitoring dan evaluasi secara real-time'],
                            ['icon' => 'file-check', 'title' => 'Dokumentasi digital tanpa kertas'],
                            ['icon' => 'users', 'title' => 'Kolaborasi mahasiswa dan dokter pembimbing'],
                        ]);
                    @endphp
                    @foreach ($benefitsItems as $i => $b)
                        <div class="cms-repeater-item" data-index="{{ $i }}">
                            <div class="cms-repeater-row">
                                <div style="width:120px;">
                                    <label class="form-label">Icon</label>
                                    <input type="text" name="benefits[{{ $i }}][icon]" class="form-input"
                                        value="{{ $b['icon'] ?? 'zap' }}" placeholder="zap">
                                </div>
                                <div style="flex:1;">
                                    <label class="form-label">Judul</label>
                                    <input type="text" name="benefits[{{ $i }}][title]" class="form-input"
                                        value="{{ $b['title'] ?? '' }}" placeholder="Judul keunggulan...">
                                </div>
                                    <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                                        <button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">
                                            <i data-lucide="arrow-up" style="width:14px;height:14px;"></i>
                                        </button>
                                        <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                                            <i data-lucide="arrow-down" style="width:14px;height:14px;"></i>
                                        </button>
                                        <button type="button" class="btn-icon danger cms-remove-btn" onclick="const container = this.closest('.cms-repeater-item').parentNode; this.closest('.cms-repeater-item').remove(); reindexRepeater(container);" title="Hapus">
                                            <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                        </button>
                                    </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        {{-- ═══════════════════════════════════════════
             TAB: DASHBOARD
        ═══════════════════════════════════════════ --}}
        <div class="cms-panel" id="panel-dashboard_tab" style="display:none;">
            {{-- Toggle Visibility --}}
            @php
                $dashboardVisible = old('dashboard_visible', $landing->dashboard_visible ?? true);
            @endphp
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $dashboardVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $dashboardVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;" id="dashboardToggleBox">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;border-radius:12px;background:{{ $dashboardVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;" id="dashboardToggleIconBox">
                        <i data-lucide="{{ $dashboardVisible ? 'eye' : 'eye-off' }}" style="width:20px;height:20px;color:{{ $dashboardVisible ? '#34d399' : '#f87171' }};" id="dashboardToggleIcon"></i>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:600;color:#1e293b;" id="dashboardToggleTitle">
                            {{ $dashboardVisible ? 'Seksi Dashboard Aktif' : 'Seksi Dashboard Nonaktif' }}
                        </div>
                        <div style="font-size:12px;color:#475569;margin-top:2px;" id="dashboardToggleDesc">
                            {{ $dashboardVisible ? 'Seksi dashboard preview ditampilkan di landing page dan navigasi.' : 'Seksi dashboard preview disembunyikan dari landing page dan navigasi.' }}
                        </div>
                    </div>
                </div>
                <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
                    <input type="checkbox" name="dashboard_visible" value="1" {{ $dashboardVisible ? 'checked' : '' }}
                        style="opacity:0;width:0;height:0;position:absolute;" id="dashboardVisibleCheckbox"
                        onchange="updateDashboardToggle(this.checked)">
                    <span style="position:absolute;inset:0;border-radius:14px;background:{{ $dashboardVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;" id="dashboardToggleTrack"></span>
                    <span style="position:absolute;top:3px;{{ $dashboardVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;" id="dashboardToggleKnob"></span>
                </label>
            </div>

            <div class="admin-grid-1-1">
                <div class="glass-card glass">
                    <div class="cms-section-header">
                        <span class="cms-section-bar" style="background:linear-gradient(180deg,#2563eb,#06b6d4);"></span>
                        Konten Dashboard Preview
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="dashboard_title">Judul Seksi Dashboard</label>
                        <input type="text" id="dashboard_title" name="dashboard_title" class="form-input"
                            value="{{ old('dashboard_title', $landing->dashboard_title ?? 'Dashboard ClinicalLog') }}"
                            placeholder="Dashboard ClinicalLog">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="dashboard_description">Deskripsi Seksi Dashboard</label>
                        <textarea id="dashboard_description" name="dashboard_description" class="form-input" style="min-height:150px;"
                            placeholder="Tuliskan penjelasan singkat mengenai dashboard... (Contoh: Tampilan dashboard akan hadir pada versi berikutnya.)">{{ old('dashboard_description', $landing->dashboard_description ?? '') }}</textarea>
                    </div>
                </div>

                <div class="glass-card glass">
                    <div class="cms-section-header">
                        <span class="cms-section-bar" style="background:linear-gradient(180deg,#22d3ee,#818cf8);"></span>
                        Gambar Screenshot Dashboard
                    </div>

                    @if (isset($landing) && $landing->dashboard_image)
                        <div class="cms-current-image">
                            <img src="{{ asset('storage/' . $landing->dashboard_image) }}" alt="Dashboard Image">
                            <div class="cms-current-image-label">
                                <i data-lucide="image" style="width:12px;height:12px;display:inline;"></i>
                                Gambar saat ini
                            </div>
                        </div>
                        <div style="margin: 10px 0 16px;">
                            <label style="display:inline-flex;align-items:center;gap:8px;font-size:13px;color:#ef4444;cursor:pointer;font-weight:500;">
                                <input type="checkbox" name="delete_dashboard_image" value="1" style="width:16px;height:16px;accent-color:#ef4444;cursor:pointer;">
                                <i data-lucide="trash-2" style="width:14px;height:14px;display:inline;"></i> Hapus gambar saat ini
                            </label>
                            <p style="font-size:11px;color:#94a3b8;margin-top:4px;padding-left:24px;">* Centang checkbox ini, lalu klik tombol <strong>"Simpan Semua Perubahan"</strong> di bagian bawah halaman untuk menghapus gambar.</p>
                        </div>
                    @endif

                    <div class="upload-zone" id="dashboardUploadZone"
                        onclick="document.getElementById('dashboard_image').click()">
                        <i data-lucide="upload-cloud"
                            style="width:28px;height:28px;margin:0 auto 10px;display:block;color:#38bdf8;"></i>
                        <div style="font-weight:600;color:#94a3b8;margin-bottom:4px;">Klik atau drag & drop gambar dashboard
                        </div>
                        <div style="font-size:12px;color:#64748b;">JPG, PNG, WebP (maks 2MB)</div>
                        <div id="dashboardPreview" style="display:none;margin-top:12px;">
                            <img id="dashboardPreviewImg" src="" alt=""
                                style="width:100%;max-height:160px;object-fit:cover;border-radius:10px;margin:0 auto;display:block;">
                            <div id="dashboardPreviewName"
                                style="font-size:12px;color:#22d3ee;text-align:center;margin-top:6px;">
                            </div>
                        </div>
                    </div>
                    <input type="file" id="dashboard_image" name="dashboard_image" accept=".jpg,.jpeg,.png,.webp"
                        style="display:none;">
                    @error('dashboard_image')
                        <p style="font-size:12px;color:#f87171;margin-top:5px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>


        {{-- ═══════════════════════════════════════════
             TAB: STEPS
        ═══════════════════════════════════════════ --}}
        <div class="cms-panel" id="panel-steps" style="display:none;">
            {{-- Toggle Visibility --}}
            @php
                $stepsVisible = old('steps_visible', $landing->steps_visible ?? true);
            @endphp
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $stepsVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $stepsVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;" id="stepsToggleBox">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;border-radius:12px;background:{{ $stepsVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;" id="stepsToggleIconBox">
                        <i data-lucide="{{ $stepsVisible ? 'eye' : 'eye-off' }}" style="width:20px;height:20px;color:{{ $stepsVisible ? '#34d399' : '#f87171' }};" id="stepsToggleIcon"></i>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:600;color:#1e293b;" id="stepsToggleTitle">
                            {{ $stepsVisible ? 'Seksi Cara Kerja Aktif' : 'Seksi Cara Kerja Nonaktif' }}
                        </div>
                        <div style="font-size:12px;color:#475569;margin-top:2px;" id="stepsToggleDesc">
                            {{ $stepsVisible ? 'Seksi alur/cara kerja ditampilkan di landing page dan navigasi.' : 'Seksi alur/cara kerja disembunyikan dari landing page dan navigasi.' }}
                        </div>
                    </div>
                </div>
                <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
                    <input type="checkbox" name="steps_visible" value="1" {{ $stepsVisible ? 'checked' : '' }}
                        style="opacity:0;width:0;height:0;position:absolute;" id="stepsVisibleCheckbox"
                        onchange="updateStepsToggle(this.checked)">
                    <span style="position:absolute;inset:0;border-radius:14px;background:{{ $stepsVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;" id="stepsToggleTrack"></span>
                    <span style="position:absolute;top:3px;{{ $stepsVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;" id="stepsToggleKnob"></span>
                </label>
            </div>

            <div class="glass-card glass">
                <div class="cms-section-header" style="justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span class="cms-section-bar" style="background:linear-gradient(180deg,#2563eb,#06b6d4);"></span>
                        Cara Kerja
                    </div>
                    <button type="button" class="btn-secondary btn-sm" onclick="addStep()">
                        <i data-lucide="plus" style="width:14px;height:14px;"></i> Tambah
                    </button>
                </div>
                <p class="form-hint" style="margin-bottom:20px;">Atur langkah-langkah cara kerja. Nomor urut otomatis berdasarkan posisi. Icon menggunakan nama dari <a href="https://lucide.dev/icons/" target="_blank" style="color:#38bdf8;">Lucide Icons</a>.</p>

                <div id="stepsContainer">
                    @php
                        $stepsItems = old('steps', $landing->steps ?? [
                            ['icon' => 'clipboard-edit', 'num' => '01', 'title' => 'Catat Aktivitas Klinis', 'desc' => 'Mahasiswa mencatat kasus dan aktivitas klinis secara digital langsung dari smartphone.'],
                            ['icon' => 'qr-code', 'num' => '02', 'title' => 'Verifikasi QR Code', 'desc' => 'Aktivitas diverifikasi oleh pembimbing dengan scan QR Code yang aman dan cepat.'],
                            ['icon' => 'line-chart', 'num' => '03', 'title' => 'Pantau Kompetensi', 'desc' => 'Progress kompetensi mahasiswa terpantau secara real-time oleh dosen dan institusi.'],
                            ['icon' => 'file-bar-chart', 'num' => '04', 'title' => 'Laporan & Evaluasi', 'desc' => 'Data tersaji rapi untuk laporan otomatis dan pengambilan keputusan berbasis data.'],
                        ]);
                    @endphp
                    @foreach ($stepsItems as $i => $s)
                        <div class="cms-repeater-item" data-index="{{ $i }}">
                            <div class="cms-repeater-row" style="align-items:flex-start;">
                                <div style="width:120px;">
                                    <label class="form-label">Icon</label>
                                    <input type="text" name="steps[{{ $i }}][icon]" class="form-input"
                                        value="{{ $s['icon'] ?? 'clipboard-edit' }}" placeholder="clipboard-edit">
                                </div>
                                <div style="flex:1;">
                                    <label class="form-label">Judul</label>
                                    <input type="text" name="steps[{{ $i }}][title]" class="form-input"
                                        value="{{ $s['title'] ?? '' }}" placeholder="Judul langkah...">
                                </div>
                                <div style="flex:1.5;">
                                    <label class="form-label">Deskripsi</label>
                                    <input type="text" name="steps[{{ $i }}][desc]" class="form-input"
                                        value="{{ $s['desc'] ?? '' }}" placeholder="Deskripsi langkah...">
                                </div>
                                    <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                                        <button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">
                                            <i data-lucide="arrow-up" style="width:14px;height:14px;"></i>
                                        </button>
                                        <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                                            <i data-lucide="arrow-down" style="width:14px;height:14px;"></i>
                                        </button>
                                        <button type="button" class="btn-icon danger cms-remove-btn" onclick="const container = this.closest('.cms-repeater-item').parentNode; this.closest('.cms-repeater-item').remove(); reindexRepeater(container);" title="Hapus">
                                            <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                        </button>
                                    </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        {{-- ═══════════════════════════════════════════
             TAB: TESTIMONIALS
        ═══════════════════════════════════════════ --}}
        <div class="cms-panel" id="panel-testimonials" style="display:none;">
            {{-- Toggle Visibility --}}
            @php
                $testiVisible = old('testimonials_visible', $landing->testimonials_visible ?? true);
            @endphp
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $testiVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $testiVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;" id="testiToggleBox">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;border-radius:12px;background:{{ $testiVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;" id="testiToggleIconBox">
                        <i data-lucide="{{ $testiVisible ? 'eye' : 'eye-off' }}" style="width:20px;height:20px;color:{{ $testiVisible ? '#34d399' : '#f87171' }};" id="testiToggleIcon"></i>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:600;color:#1e293b;" id="testiToggleTitle">
                            {{ $testiVisible ? 'Testimoni Aktif' : 'Testimoni Nonaktif' }}
                        </div>
                        <div style="font-size:12px;color:#475569;margin-top:2px;" id="testiToggleDesc">
                            {{ $testiVisible ? 'Seksi testimoni ditampilkan di landing page dan navigasi.' : 'Seksi testimoni disembunyikan dari landing page dan navigasi.' }}
                        </div>
                    </div>
                </div>
                <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
                    <input type="checkbox" name="testimonials_visible" value="1" {{ $testiVisible ? 'checked' : '' }}
                        style="opacity:0;width:0;height:0;position:absolute;" id="testiVisibleCheckbox"
                        onchange="updateTestiToggle(this.checked)">
                    <span style="position:absolute;inset:0;border-radius:14px;background:{{ $testiVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;" id="testiToggleTrack"></span>
                    <span style="position:absolute;top:3px;{{ $testiVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;" id="testiToggleKnob"></span>
                </label>
            </div>

            <div class="glass-card glass">
                <div class="cms-section-header" style="justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span class="cms-section-bar" style="background:linear-gradient(180deg,#818cf8,#c084fc);"></span>
                        Testimoni
                    </div>
                    <button type="button" class="btn-secondary btn-sm" onclick="addTestimonial()">
                        <i data-lucide="plus" style="width:14px;height:14px;"></i> Tambah
                    </button>
                </div>
                <div id="testimonialsContainer">
                    @php
                        $testiItems = old('testimonials', $landing->testimonials ?? [
                            ['quote' => 'ClinicalLog membantu kami memantau perkembangan mahasiswa dengan jauh lebih cepat dan terstruktur.', 'name' => 'dr. Andi Prasetyo, Sp.PD', 'role' => 'Dosen Fakultas Kedokteran', 'img' => 'https://images.pexels.com/photos/5452293/pexels-photo-5452293.jpeg?auto=compress&cs=tinysrgb&w=400'],
                            ['quote' => 'Dengan verifikasi digital dan monitoring real-time, aktivitas mahasiswa menjadi lebih transparan.', 'name' => 'dr. Maya Wulandari', 'role' => 'Dokter Pembimbing Klinik', 'img' => 'https://images.pexels.com/photos/8376281/pexels-photo-8376281.jpeg?auto=compress&cs=tinysrgb&w=400'],
                            ['quote' => 'Aplikasi ini membuat pencatatan aktivitas jauh lebih praktis.', 'name' => 'Nadia Azzahra', 'role' => 'Mahasiswa Kedokteran', 'img' => 'https://images.pexels.com/photos/27392533/pexels-photo-27392533.jpeg?auto=compress&cs=tinysrgb&w=400'],
                        ]);
                    @endphp
                    @foreach ($testiItems as $i => $t)
                        <div class="cms-repeater-item" data-index="{{ $i }}">
                            <div class="cms-repeater-card">
                                <div class="cms-repeater-row" style="align-items:flex-start;">
                                    <div style="flex:1;">
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="testimonials[{{ $i }}][name]" class="form-input"
                                            value="{{ $t['name'] ?? '' }}" placeholder="Nama lengkap...">
                                    </div>
                                    <div style="flex:1;">
                                        <label class="form-label">Jabatan/Role</label>
                                        <input type="text" name="testimonials[{{ $i }}][role]" class="form-input"
                                            value="{{ $t['role'] ?? '' }}" placeholder="Jabatan...">
                                    </div>
                                    <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                                        <button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">
                                            <i data-lucide="arrow-up" style="width:14px;height:14px;"></i>
                                        </button>
                                        <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                                            <i data-lucide="arrow-down" style="width:14px;height:14px;"></i>
                                        </button>
                                        <button type="button" class="btn-icon danger cms-remove-btn" onclick="const container = this.closest('.cms-repeater-item').parentNode; this.closest('.cms-repeater-item').remove(); reindexRepeater(container);" title="Hapus">
                                            <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top:12px;">
                                    <label class="form-label">Kutipan</label>
                                    <textarea name="testimonials[{{ $i }}][quote]" class="form-input" style="min-height:70px;" placeholder="Tuliskan kutipan testimoni...">{{ $t['quote'] ?? '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">URL Foto</label>
                                    <input type="text" name="testimonials[{{ $i }}][img]" class="form-input"
                                        value="{{ $t['img'] ?? '' }}" placeholder="https://example.com/foto.jpg">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        {{-- ═══════════════════════════════════════════
             TAB: PRICING
        ═══════════════════════════════════════════ --}}
        <div class="cms-panel" id="panel-pricing" style="display:none;">
            {{-- Toggle Visibility --}}
            @php
                $pricingVisible = old('pricing_visible', $landing->pricing_visible ?? true);
            @endphp
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $pricingVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $pricingVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;" id="pricingToggleBox">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;border-radius:12px;background:{{ $pricingVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;" id="pricingToggleIconBox">
                        <i data-lucide="{{ $pricingVisible ? 'eye' : 'eye-off' }}" style="width:20px;height:20px;color:{{ $pricingVisible ? '#34d399' : '#f87171' }};" id="pricingToggleIcon"></i>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:600;color:#1e293b;" id="pricingToggleTitle">
                            {{ $pricingVisible ? 'Seksi Paket Harga Aktif' : 'Seksi Paket Harga Nonaktif' }}
                        </div>
                        <div style="font-size:12px;color:#475569;margin-top:2px;" id="pricingToggleDesc">
                            {{ $pricingVisible ? 'Seksi paket harga ditampilkan di landing page dan navigasi.' : 'Seksi paket harga disembunyikan dari landing page dan navigasi.' }}
                        </div>
                    </div>
                </div>
                <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
                    <input type="checkbox" name="pricing_visible" value="1" {{ $pricingVisible ? 'checked' : '' }}
                        style="opacity:0;width:0;height:0;position:absolute;" id="pricingVisibleCheckbox"
                        onchange="updatePricingToggle(this.checked)">
                    <span style="position:absolute;inset:0;border-radius:14px;background:{{ $pricingVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;" id="pricingToggleTrack"></span>
                    <span style="position:absolute;top:3px;{{ $pricingVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;" id="pricingToggleKnob"></span>
                </label>
            </div>

            <div class="glass-card glass">
                <div class="cms-section-header" style="justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span class="cms-section-bar" style="background:linear-gradient(180deg,#34d399,#06b6d4);"></span>
                        Paket Harga
                    </div>
                    <button type="button" class="btn-secondary btn-sm" onclick="addPricingPlan()">
                        <i data-lucide="plus" style="width:14px;height:14px;"></i> Tambah Paket
                    </button>
                </div>
                <p class="form-hint" style="margin-bottom:20px;">Setiap fitur di dalam paket dipisahkan dengan baris baru (Enter).</p>

                <div id="pricingContainer">
                    @php
                        $pricingItems = old('pricing_plans', $landing->pricing_plans ?? [
                            ['tier' => 'Starter', 'name' => 'Department', 'price' => 'Rp25 Juta', 'featured' => false, 'features' => ['Maks 100 mahasiswa', 'Maks 5 dosen', 'Dashboard basic', 'Support email']],
                            ['tier' => 'Populer', 'name' => 'Faculty', 'price' => 'Rp50 Juta', 'featured' => true, 'features' => ['Unlimited mahasiswa', 'Unlimited dosen', 'Integrasi SIAKAD', 'Dashboard Analytics', 'Priority support']],
                            ['tier' => 'Enterprise', 'name' => 'University', 'price' => 'Rp75 Juta', 'featured' => false, 'features' => ['Multi-fakultas', 'Central Admin', 'Custom Reporting', 'Training & Support', 'SLA Guarantee']],
                        ]);
                    @endphp
                    @foreach ($pricingItems as $i => $p)
                        <div class="cms-repeater-item" data-index="{{ $i }}">
                            <div class="cms-repeater-card">
                                <div class="cms-repeater-row" style="align-items:flex-start;">
                                    <div style="width:130px;">
                                        <label class="form-label">Tier</label>
                                        <input type="text" name="pricing_plans[{{ $i }}][tier]" class="form-input"
                                            value="{{ $p['tier'] ?? '' }}" placeholder="Starter">
                                    </div>
                                    <div style="flex:1;">
                                        <label class="form-label">Nama Paket</label>
                                        <input type="text" name="pricing_plans[{{ $i }}][name]" class="form-input"
                                            value="{{ $p['name'] ?? '' }}" placeholder="Department">
                                    </div>
                                    <div style="width:160px;">
                                        <label class="form-label">Harga <span style="font-weight:400;color:#94a3b8;">(opsional)</span></label>
                                        <input type="text" name="pricing_plans[{{ $i }}][price]" class="form-input"
                                            value="{{ $p['price'] ?? '' }}" placeholder="Rp25 Juta">
                                        <div style="font-size:11px;color:#94a3b8;margin-top:4px;">Kosongkan → tampil "Hubungi Kami"</div>
                                    </div>
                                    <div style="width:80px;text-align:center;">
                                        <label class="form-label">Populer</label>
                                        <div style="padding-top:8px;">
                                            <input type="checkbox" name="pricing_plans[{{ $i }}][featured]" value="1"
                                                {{ !empty($p['featured']) ? 'checked' : '' }}
                                                style="width:18px;height:18px;accent-color:#2563eb;">
                                        </div>
                                    </div>
                                    <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                                        <button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">
                                            <i data-lucide="arrow-up" style="width:14px;height:14px;"></i>
                                        </button>
                                        <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                                            <i data-lucide="arrow-down" style="width:14px;height:14px;"></i>
                                        </button>
                                        <button type="button" class="btn-icon danger cms-remove-btn" onclick="const container = this.closest('.cms-repeater-item').parentNode; this.closest('.cms-repeater-item').remove(); reindexRepeater(container);" title="Hapus">
                                            <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top:12px;">
                                    <label class="form-label">Fitur (satu per baris)</label>
                                    <textarea name="pricing_plans[{{ $i }}][features_text]" class="form-input" style="min-height:90px;"
                                        placeholder="Fitur 1&#10;Fitur 2&#10;Fitur 3">{{ is_array($p['features'] ?? null) ? implode("\n", $p['features']) : ($p['features_text'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        {{-- ═══════════════════════════════════════════
             TAB: CTA
        ═══════════════════════════════════════════ --}}
        <div class="cms-panel" id="panel-cta" style="display:none;">
            {{-- Toggle Visibility --}}
            @php
                $ctaVisible = old('cta_visible', $landing->cta_visible ?? true);
            @endphp
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $ctaVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $ctaVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;" id="ctaToggleBox">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;border-radius:12px;background:{{ $ctaVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;" id="ctaToggleIconBox">
                        <i data-lucide="{{ $ctaVisible ? 'eye' : 'eye-off' }}" style="width:20px;height:20px;color:{{ $ctaVisible ? '#34d399' : '#f87171' }};" id="ctaToggleIcon"></i>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:600;color:#1e293b;" id="ctaToggleTitle">
                            {{ $ctaVisible ? 'Seksi CTA Aktif' : 'Seksi CTA Nonaktif' }}
                        </div>
                        <div style="font-size:12px;color:#475569;margin-top:2px;" id="ctaToggleDesc">
                            {{ $ctaVisible ? 'Seksi CTA ditampilkan di landing page.' : 'Seksi CTA disembunyikan dari landing page.' }}
                        </div>
                    </div>
                </div>
                <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
                    <input type="checkbox" name="cta_visible" value="1" {{ $ctaVisible ? 'checked' : '' }}
                        style="opacity:0;width:0;height:0;position:absolute;" id="ctaVisibleCheckbox"
                        onchange="updateCtaToggle(this.checked)">
                    <span style="position:absolute;inset:0;border-radius:14px;background:{{ $ctaVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;" id="ctaToggleTrack"></span>
                    <span style="position:absolute;top:3px;{{ $ctaVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;" id="ctaToggleKnob"></span>
                </label>
            </div>

            <div class="glass-card glass">
                <div class="cms-section-header">
                    <span class="cms-section-bar" style="background:linear-gradient(180deg,#f59e0b,#ef4444);"></span>
                    Call to Action
                </div>

                <div class="admin-grid-1-1">
                    <div class="form-group">
                        <label class="form-label" for="cta_title">Judul CTA</label>
                        <textarea id="cta_title" name="cta_title" class="form-input" style="min-height:80px;">{{ old('cta_title', $landing->cta_title ?? 'Digitalisasi Pembelajaran Klinis Bersama ClinicalLog') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="cta_description">Deskripsi CTA</label>
                        <textarea id="cta_description" name="cta_description" class="form-input" style="min-height:80px;">{{ old('cta_description', $landing->cta_description ?? 'Tingkatkan kualitas pendidikan kedokteran dengan platform Medical Data & E-Logbook yang terintegrasi dan mudah digunakan.') }}</textarea>
                    </div>
                </div>
            </div>
        </div>


        {{-- ═══ SAVE BUTTON ═══ --}}
        <div class="cms-save-bar glass-card glass" style="padding: 10px 18px; margin-top: 10px; box-shadow: 0 -10px 30px rgba(15, 23, 42, 0.04);">
            <div class="flex flex-col sm:flex-row gap-2.5">
                <button type="submit" class="btn-primary w-full sm:w-auto flex-1" style="padding: 10px 20px; font-size: 13px;">
                    <i data-lucide="save" style="width:14px;height:14px;"></i>
                    Simpan Semua Perubahan
                </button>
                <a href="{{ route('home') }}" class="btn-secondary w-full sm:w-auto flex-1" target="_blank" style="text-align:center; padding: 10px 20px; font-size: 13px;">
                    <i data-lucide="external-link" style="width:14px;height:14px;"></i>
                    Preview Website
                </a>
            </div>
        </div>
    </form>

    <form id="delete-feature-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

@endsection

@push('scripts')
    <script>
        // ─── Tab switching ───
        function switchTab(tabName, btn) {
            // Hide all panels
            document.querySelectorAll('.cms-panel').forEach(p => {
                p.style.display = 'none';
                p.classList.remove('cms-panel-animate');
            });
            // Show target panel with animation
            const target = document.getElementById('panel-' + tabName);
            target.style.display = '';
            // Force reflow so animation re-triggers
            void target.offsetWidth;
            target.classList.add('cms-panel-animate');
            // Toggle active button
            document.querySelectorAll('.cms-tab').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            // Re-init lucide icons in newly shown panel
            if (window.lucide) lucide.createIcons();
        }

        // ─── Image preview helper ───
        function setupImagePreview(inputId, previewBoxId, previewImgId, previewNameId, zoneId) {
            const input = document.getElementById(inputId);
            const previewBox = document.getElementById(previewBoxId);
            const previewImg = document.getElementById(previewImgId);
            const previewName = document.getElementById(previewNameId);
            const zone = document.getElementById(zoneId);

            if (!input || !zone) return;

            input.addEventListener('change', () => {
                const file = input.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImg.src = e.target.result;
                    previewName.textContent = file.name;
                    previewBox.style.display = '';
                };
                reader.readAsDataURL(file);
            });

            zone.addEventListener('dragover', (e) => { e.preventDefault(); zone.style.borderColor = 'rgba(56,189,248,.7)'; });
            zone.addEventListener('dragleave', () => { zone.style.borderColor = ''; });
            zone.addEventListener('drop', (e) => {
                e.preventDefault();
                zone.style.borderColor = '';
                if (e.dataTransfer.files.length) {
                    input.files = e.dataTransfer.files;
                    input.dispatchEvent(new Event('change'));
                }
            });
        }

        setupImagePreview('hero_image', 'heroPreview', 'heroPreviewImg', 'heroPreviewName', 'heroUploadZone');
        setupImagePreview('about_image', 'aboutPreview', 'aboutPreviewImg', 'aboutPreviewName', 'aboutUploadZone');
        setupImagePreview('dashboard_image', 'dashboardPreview', 'dashboardPreviewImg', 'dashboardPreviewName', 'dashboardUploadZone');

        // ─── Repeater Reordering Helpers ───
        function reindexRepeater(containerElement) {
            const items = containerElement.querySelectorAll('.cms-repeater-item');
            items.forEach((item, index) => {
                item.setAttribute('data-index', index);
                const inputs = item.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        const newName = name.replace(/\[\d+\]/, '[' + index + ']');
                        input.setAttribute('name', newName);
                    }
                });
            });
        }

        function moveItemUp(btn) {
            const item = btn.closest('.cms-repeater-item');
            const containerElement = item.parentNode;
            const previous = item.previousElementSibling;
            if (previous && previous.classList.contains('cms-repeater-item')) {
                containerElement.insertBefore(item, previous);
                reindexRepeater(containerElement);
            }
        }

        function moveItemDown(btn) {
            const item = btn.closest('.cms-repeater-item');
            const containerElement = item.parentNode;
            const next = item.nextElementSibling;
            if (next && next.classList.contains('cms-repeater-item')) {
                containerElement.insertBefore(next, item);
                reindexRepeater(containerElement);
            }
        }

        // ─── Repeater: Navigasi ───
        let navLinkIdx = {{ count($navLinksItems) }};
        function addNavLink() {
            const containerElement = document.getElementById('navLinksContainer');
            const html = `
                <div class="cms-repeater-item" data-index="${navLinkIdx}">
                    <div class="cms-repeater-row">
                        <div style="flex:1;">
                            <label class="form-label">Label Menu</label>
                            <input type="text" name="navbar_links[${navLinkIdx}][label]" class="form-input" placeholder="Contoh: Beranda">
                        </div>
                        <div style="flex:1.5;">
                            <label class="form-label">Link Target (URL / Anchor ID)</label>
                            <input type="text" name="navbar_links[${navLinkIdx}][url]" class="form-input" placeholder="Contoh: #beranda">
                        </div>
                        <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                            <button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
                            </button>
                            <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                            </button>
                            <button type="button" class="btn-icon danger cms-remove-btn" onclick="const c = this.closest('.cms-repeater-item').parentNode; this.closest('.cms-repeater-item').remove(); reindexRepeater(c);" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </div>
                </div>`;
            containerElement.insertAdjacentHTML('beforeend', html);
            reindexRepeater(containerElement);
            navLinkIdx++;
        }

        // ─── Repeater: Benefits ───
        let benefitIdx = {{ count($benefitsItems) }};
        function addBenefit() {
            const containerElement = document.getElementById('benefitsContainer');
            const html = `
                <div class="cms-repeater-item" data-index="${benefitIdx}">
                    <div class="cms-repeater-row">
                        <div style="width:120px;">
                            <label class="form-label">Icon</label>
                            <input type="text" name="benefits[${benefitIdx}][icon]" class="form-input" value="zap" placeholder="zap">
                        </div>
                        <div style="flex:1;">
                            <label class="form-label">Judul</label>
                            <input type="text" name="benefits[${benefitIdx}][title]" class="form-input" placeholder="Judul keunggulan...">
                        </div>
                        <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                            <button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
                            </button>
                            <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                            </button>
                            <button type="button" class="btn-icon danger cms-remove-btn" onclick="const c = this.closest('.cms-repeater-item').parentNode; this.closest('.cms-repeater-item').remove(); reindexRepeater(c);" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </div>
                </div>`;
            containerElement.insertAdjacentHTML('beforeend', html);
            reindexRepeater(containerElement);
            benefitIdx++;
        }

        // ─── Repeater: Steps ───
        let stepIdx = {{ count($stepsItems) }};
        function addStep() {
            const containerElement = document.getElementById('stepsContainer');
            const html = `
                <div class="cms-repeater-item" data-index="${stepIdx}">
                    <div class="cms-repeater-row" style="align-items:flex-start;">
                        <div style="width:120px;">
                            <label class="form-label">Icon</label>
                            <input type="text" name="steps[${stepIdx}][icon]" class="form-input" value="clipboard-edit" placeholder="clipboard-edit">
                        </div>
                        <div style="flex:1;">
                            <label class="form-label">Judul</label>
                            <input type="text" name="steps[${stepIdx}][title]" class="form-input" placeholder="Judul langkah...">
                        </div>
                        <div style="flex:1.5;">
                            <label class="form-label">Deskripsi</label>
                            <input type="text" name="steps[${stepIdx}][desc]" class="form-input" placeholder="Deskripsi langkah...">
                        </div>
                        <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                            <button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
                            </button>
                            <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                            </button>
                            <button type="button" class="btn-icon danger cms-remove-btn" onclick="const c = this.closest('.cms-repeater-item').parentNode; this.closest('.cms-repeater-item').remove(); reindexRepeater(c);" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </div>
                </div>`;
            containerElement.insertAdjacentHTML('beforeend', html);
            reindexRepeater(containerElement);
            stepIdx++;
        }

        // ─── Repeater: Testimonials ───
        let testiIdx = {{ count($testiItems) }};
        function addTestimonial() {
            const containerElement = document.getElementById('testimonialsContainer');
            const html = `
                <div class="cms-repeater-item" data-index="${testiIdx}">
                    <div class="cms-repeater-card">
                        <div class="cms-repeater-row" style="align-items:flex-start;">
                            <div style="flex:1;">
                                <label class="form-label">Nama</label>
                                <input type="text" name="testimonials[${testiIdx}][name]" class="form-input" placeholder="Nama lengkap...">
                            </div>
                            <div style="flex:1;">
                                <label class="form-label">Jabatan/Role</label>
                                <input type="text" name="testimonials[${testiIdx}][role]" class="form-input" placeholder="Jabatan...">
                            </div>
                            <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                                <button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
                                </button>
                                <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                                </button>
                                <button type="button" class="btn-icon danger cms-remove-btn" onclick="const c = this.closest('.cms-repeater-item').parentNode; this.closest('.cms-repeater-item').remove(); reindexRepeater(c);" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:12px;">
                            <label class="form-label">Kutipan</label>
                            <textarea name="testimonials[${testiIdx}][quote]" class="form-input" style="min-height:70px;" placeholder="Tuliskan kutipan testimoni..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">URL Foto</label>
                            <input type="text" name="testimonials[${testiIdx}][img]" class="form-input" placeholder="https://example.com/foto.jpg">
                        </div>
                    </div>
                </div>`;
            containerElement.insertAdjacentHTML('beforeend', html);
            reindexRepeater(containerElement);
            testiIdx++;
        }

        // ─── Repeater: Pricing ───
        let pricingIdx = {{ count($pricingItems) }};
        function addPricingPlan() {
            const containerElement = document.getElementById('pricingContainer');
            const html = `
                <div class="cms-repeater-item" data-index="${pricingIdx}">
                    <div class="cms-repeater-card">
                        <div class="cms-repeater-row" style="align-items:flex-start;">
                            <div style="width:130px;">
                                <label class="form-label">Tier</label>
                                <input type="text" name="pricing_plans[${pricingIdx}][tier]" class="form-input" placeholder="Starter">
                            </div>
                            <div style="flex:1;">
                                <label class="form-label">Nama Paket</label>
                                <input type="text" name="pricing_plans[${pricingIdx}][name]" class="form-input" placeholder="Department">
                            </div>
                            <div style="width:160px;">
                                <label class="form-label">Harga <span style="font-weight:400;color:#94a3b8;">(opsional)</span></label>
                                <input type="text" name="pricing_plans[${pricingIdx}][price]" class="form-input" placeholder="Rp25 Juta">
                                <div style="font-size:11px;color:#94a3b8;margin-top:4px;">Kosongkan → tampil &ldquo;Hubungi Kami&rdquo;</div>
                            </div>
                            <div style="width:80px;text-align:center;">
                                <label class="form-label">Populer</label>
                                <div style="padding-top:8px;">
                                    <input type="checkbox" name="pricing_plans[${pricingIdx}][featured]" value="1" style="width:18px;height:18px;accent-color:#2563eb;">
                                </div>
                            </div>
                            <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                                <button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
                                </button>
                                <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                                </button>
                                <button type="button" class="btn-icon danger cms-remove-btn" onclick="const c = this.closest('.cms-repeater-item').parentNode; this.closest('.cms-repeater-item').remove(); reindexRepeater(c);" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:12px;">
                            <label class="form-label">Fitur (satu per baris)</label>
                            <textarea name="pricing_plans[${pricingIdx}][features_text]" class="form-input" style="min-height:90px;" placeholder="Fitur 1&#10;Fitur 2&#10;Fitur 3"></textarea>
                        </div>
                    </div>
                </div>`;
            containerElement.insertAdjacentHTML('beforeend', html);
            reindexRepeater(containerElement);
            pricingIdx++;
        }
        // ─── Toggle Testimoni Visibility ───
        function updateTestiToggle(isChecked) {
            const box = document.getElementById('testiToggleBox');
            const iconBox = document.getElementById('testiToggleIconBox');
            const icon = document.getElementById('testiToggleIcon');
            const title = document.getElementById('testiToggleTitle');
            const desc = document.getElementById('testiToggleDesc');
            const track = document.getElementById('testiToggleTrack');
            const knob = document.getElementById('testiToggleKnob');

            if (isChecked) {
                box.style.borderColor = 'rgba(52,211,153,.25)';
                box.style.background = 'rgba(52,211,153,.06)';
                iconBox.style.background = 'rgba(52,211,153,.15)';
                icon.setAttribute('data-lucide', 'eye');
                icon.style.color = '#34d399';
                title.textContent = 'Testimoni Aktif';
                desc.textContent = 'Seksi testimoni ditampilkan di landing page dan navigasi.';
                track.style.background = '#34d399';
                knob.style.left = '27px';
            } else {
                box.style.borderColor = 'rgba(248,113,113,.25)';
                box.style.background = 'rgba(248,113,113,.06)';
                iconBox.style.background = 'rgba(248,113,113,.15)';
                icon.setAttribute('data-lucide', 'eye-off');
                icon.style.color = '#f87171';
                title.textContent = 'Testimoni Nonaktif';
                desc.textContent = 'Seksi testimoni disembunyikan dari landing page dan navigasi.';
                track.style.background = 'rgba(100,116,139,.4)';
                knob.style.left = '3px';
            }
            // Re-render icon
            icon.innerHTML = '';
            lucide.createIcons({ nodes: [icon] });
        }

        // ─── Generic Toggle Helper ───
        function updateToggleGeneric(sectionName, isChecked, activeTitle, inactiveTitle, activeDesc, inactiveDesc) {
            const box = document.getElementById(sectionName + 'ToggleBox');
            const iconBox = document.getElementById(sectionName + 'ToggleIconBox');
            const icon = document.getElementById(sectionName + 'ToggleIcon');
            const title = document.getElementById(sectionName + 'ToggleTitle');
            const desc = document.getElementById(sectionName + 'ToggleDesc');
            const track = document.getElementById(sectionName + 'ToggleTrack');
            const knob = document.getElementById(sectionName + 'ToggleKnob');

            if (isChecked) {
                box.style.borderColor = 'rgba(52,211,153,.25)';
                box.style.background = 'rgba(52,211,153,.06)';
                iconBox.style.background = 'rgba(52,211,153,.15)';
                icon.setAttribute('data-lucide', 'eye');
                icon.style.color = '#34d399';
                title.textContent = activeTitle;
                desc.textContent = activeDesc;
                track.style.background = '#34d399';
                knob.style.left = '27px';
            } else {
                box.style.borderColor = 'rgba(248,113,113,.25)';
                box.style.background = 'rgba(248,113,113,.06)';
                iconBox.style.background = 'rgba(248,113,113,.15)';
                icon.setAttribute('data-lucide', 'eye-off');
                icon.style.color = '#f87171';
                title.textContent = inactiveTitle;
                desc.textContent = inactiveDesc;
                track.style.background = 'rgba(100,116,139,.4)';
                knob.style.left = '3px';
            }
            // Re-render icon
            icon.innerHTML = '';
            lucide.createIcons({ nodes: [icon] });
        }

        function updateAboutToggle(isChecked) {
            updateToggleGeneric('about', isChecked, 'Seksi Tentang Aktif', 'Seksi Tentang Nonaktif', 'Seksi tentang kami ditampilkan di landing page dan navigasi.', 'Seksi tentang kami disembunyikan dari landing page dan navigasi.');
        }
        function updateFeaturesToggle(isChecked) {
            updateToggleGeneric('features', isChecked, 'Seksi Fitur Aktif', 'Seksi Fitur Nonaktif', 'Seksi fitur unggulan ditampilkan di landing page dan navigasi.', 'Seksi fitur unggulan disembunyikan dari landing page dan navigasi.');
        }
        function updateBenefitsToggle(isChecked) {
            updateToggleGeneric('benefits', isChecked, 'Seksi Keunggulan Aktif', 'Seksi Keunggulan Nonaktif', 'Seksi keunggulan ditampilkan di landing page.', 'Seksi keunggulan disembunyikan dari landing page.');
        }
        function updateDashboardToggle(isChecked) {
            updateToggleGeneric('dashboard', isChecked, 'Seksi Dashboard Aktif', 'Seksi Dashboard Nonaktif', 'Seksi dashboard preview ditampilkan di landing page dan navigasi.', 'Seksi dashboard preview disembunyikan dari landing page dan navigasi.');
        }
        function updateStepsToggle(isChecked) {
            updateToggleGeneric('steps', isChecked, 'Seksi Cara Kerja Aktif', 'Seksi Cara Kerja Nonaktif', 'Seksi alur/cara kerja ditampilkan di landing page dan navigasi.', 'Seksi alur/cara kerja disembunyikan dari landing page dan navigasi.');
        }
        function updatePricingToggle(isChecked) {
            updateToggleGeneric('pricing', isChecked, 'Seksi Paket Harga Aktif', 'Seksi Paket Harga Nonaktif', 'Seksi paket harga ditampilkan di landing page dan navigasi.', 'Seksi paket harga disembunyikan dari landing page dan navigasi.');
        }
        function updateCtaToggle(isChecked) {
            updateToggleGeneric('cta', isChecked, 'Seksi CTA Aktif', 'Seksi CTA Nonaktif', 'Seksi CTA ditampilkan di landing page.', 'Seksi CTA disembunyikan dari landing page.');
        }
    </script>
@endpush
