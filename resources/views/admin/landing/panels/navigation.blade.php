@php
    $navbarVisible = old('navbar_visible', $landing->navbar_visible ?? true);
    @endphp
    <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $navbarVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $navbarVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;"
        id="navbarToggleBox">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;border-radius:12px;background:{{ $navbarVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;"
                id="navbarToggleIconBox">
                <x-icon name="{{ $navbarVisible ? 'eye' : 'eye-off' }}"
                    style="color:{{ $navbarVisible ? '#34d399' : '#f87171' }};"
                    id="navbarToggleIcon" />
            </div>
            <div>
                <div style="font-size:14px;font-weight:600;color:#1e293b;" id="navbarToggleTitle">
                    {{ $navbarVisible ? 'Navbar Aktif' : 'Navbar Nonaktif' }}
                </div>
                <div style="font-size:12px;color:#475569;margin-top:2px;" id="navbarToggleDesc">
                    {{ $navbarVisible ? 'Navbar ditampilkan di landing page.' : 'Navbar disembunyikan dari landing page.' }}
                </div>
            </div>
        </div>
        <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
            <input type="checkbox" name="navbar_visible" value="1" {{ $navbarVisible ? 'checked' : '' }}
                style="opacity:0;width:0;height:0;position:absolute;" id="navbarVisibleCheckbox"
                onchange="updateNavbarToggle(this.checked)">
            <span
                style="position:absolute;inset:0;border-radius:14px;background:{{ $navbarVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;"
                id="navbarToggleTrack"></span>
            <span
                style="position:absolute;top:3px;{{ $navbarVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;"
                id="navbarToggleKnob"></span>
        </label>
    </div>

<div class="admin-grid-1-1-5">
        <div class="glass-card glass">
            <div class="cms-section-header">
                <span class="cms-section-bar" style="background:linear-gradient(180deg,#0369A1,#22D3EE);"></span>
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
            <div
                style="font-size:14px;font-weight:600;color:#38bdf8;margin-bottom:12px;display:flex;align-items:center;gap:6px;">
                <x-icon name="help-circle" /> Panduan Link Navigasi
            </div>
            <p style="font-size:12px;color:#94a3b8;line-height:1.5;margin-bottom:10px;">
                Untuk mengarahkan navigasi ke bagian tertentu di halaman utama, gunakan format anchor ID (diawali
                tanda #) berikut:
            </p>
            <ul style="font-size:12px;color:#cbd5e1;padding-left:16px;line-height:1.8;">
                <li><strong>#beranda</strong> : Bagian Atas / Hero</li>
                <li><strong>#tentang</strong> : Seksi Tentang Kami</li>
                <li><strong>#keunggulan</strong> : Seksi Keunggulan</li>
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
                    <span class="cms-section-bar"
                        style="background:linear-gradient(180deg,#22d3ee,#818cf8);"></span>
                    Menu Link Navigasi
                </div>
                <button type="button" class="btn-secondary btn-sm" onclick="addNavLink()">
                    <x-icon name="plus" /> Tambah Link
                </button>
            </div>
            <p class="form-hint" style="margin-bottom:20px;">Atur link menu yang ada di navbar. Link bisa berupa
                anchor (seperti #tentang) atau URL lengkap.</p>

            <div id="navLinksContainer">
                @php
                $navLinksItems = old('navbar_links', $landing->navbar_links ?? [
                ['label' => 'Beranda', 'url' => '#beranda'],
                ['label' => 'Tentang', 'url' => '#tentang'],
                ['label' => 'Keunggulan', 'url' => '#keunggulan'],
                ['label' => 'Fitur', 'url' => '#fitur'],
                ['label' => 'Dashboard', 'url' => '#dashboard'],
                ['label' => 'Cara Kerja', 'url' => '#cara-kerja'],
                ['label' => 'Harga', 'url' => '#pricing'],
                ['label' => 'Testimoni', 'url' => '#testimoni'],
                ['label' => 'Kontak', 'url' => '#kontak'],
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
                                <x-icon name="arrow-up" />
                            </button>
                            <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                                <x-icon name="arrow-down" />
                            </button>
                            <button type="button" class="btn-icon danger cms-remove-btn"
                                onclick="confirmRemoveRepeaterItem(this, 'menu')" title="Hapus">
                                <x-icon name="trash-2" />
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
                Pastikan pengaturan berbagi di Google Drive telah diatur ke <strong>"Siapa saja yang memiliki link
                    dapat melihat/mengunduh"</strong> (Anyone with link can view).
            </p>
            <div class="form-group">
                <label class="form-label" for="terms_gdrive_url">Link Google Drive S&K (Syarat & Ketentuan)</label>
                <input type="text" id="terms_gdrive_url" name="terms_gdrive_url" class="form-input"
                    value="{{ old('terms_gdrive_url', $landing->terms_gdrive_url ?? '') }}"
                    placeholder="https://drive.google.com/file/d/.../view?usp=sharing">
            </div>
            <div class="form-group">
                <label class="form-label" for="privacy_gdrive_url">Link Google Drive K&P (Kebijakan &
                    Privasi)</label>
                <input type="text" id="privacy_gdrive_url" name="privacy_gdrive_url" class="form-input"
                    value="{{ old('privacy_gdrive_url', $landing->privacy_gdrive_url ?? '') }}"
                    placeholder="https://drive.google.com/file/d/.../view?usp=sharing">
            </div>
        </div>

    </div>
