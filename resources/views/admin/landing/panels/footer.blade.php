<div class="glass-card glass">
        <div class="cms-section-header">
            <span class="cms-section-bar" style="background:linear-gradient(180deg,#475569,#1e293b);"></span>
            Deskripsi Footer
        </div>
        <div class="form-group">
            <label class="form-label" for="footer_description">Teks Deskripsi Footer</label>
            <textarea id="footer_description" name="footer_description" class="form-input"
                style="min-height:90px;"
                placeholder="Platform Medical Data & E-Logbook untuk mendukung pendidikan klinis yang lebih digital, terukur, dan terintegrasi.">{{ old('footer_description', $landing->footer_description ?? 'Platform Medical Data & E-Logbook untuk mendukung pendidikan klinis yang lebih digital, terukur, dan terintegrasi.') }}</textarea>
            <p class="form-hint">Teks pendek di bawah logo pada bagian footer website.</p>
        </div>
    </div>

    <div class="glass-card glass" style="margin-top:20px;">
        <div class="cms-section-header" style="justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="cms-section-bar" style="background:linear-gradient(180deg,#0ea5e9,#0369A1);"></span>
                Link Media Sosial
            </div>
            <button type="button" class="btn-secondary btn-sm" onclick="addSocialLink()">
                <x-icon name="plus" /> Tambah Sosial Media
            </button>
        </div>
        <p class="form-hint" style="margin-bottom:20px;">Masukkan URL lengkap akun media sosial. Anda bisa mengatur urutan link dengan drag & drop.</p>

        <div id="socialLinksContainer">
            @php
            $socialLinksItems = old('social_links', $landing->social_links ?? [
                ['platform' => 'linkedin', 'url' => 'https://linkedin.com/company/clinicallog'],
                ['platform' => 'instagram', 'url' => 'https://instagram.com/clinicallog'],
                ['platform' => 'youtube', 'url' => 'https://youtube.com/@clinicallog'],
            ]);
            @endphp
            @foreach ($socialLinksItems as $i => $item)
            <div class="cms-repeater-item" data-index="{{ $i }}">
                <div class="cms-repeater-row">
                    <div style="flex:1;">
                        <label class="form-label">Platform Sosial Media</label>
                        <select name="social_links[{{ $i }}][platform]" class="form-input">
                            <option value="linkedin" {{ ($item['platform'] ?? '') === 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                            <option value="instagram" {{ ($item['platform'] ?? '') === 'instagram' ? 'selected' : '' }}>Instagram</option>
                            <option value="youtube" {{ ($item['platform'] ?? '') === 'youtube' ? 'selected' : '' }}>YouTube</option>
                            <option value="facebook" {{ ($item['platform'] ?? '') === 'facebook' ? 'selected' : '' }}>Facebook</option>
                            <option value="twitter" {{ ($item['platform'] ?? '') === 'twitter' ? 'selected' : '' }}>Twitter / X</option>
                            <option value="tiktok" {{ ($item['platform'] ?? '') === 'tiktok' ? 'selected' : '' }}>TikTok</option>
                            <option value="whatsapp" {{ ($item['platform'] ?? '') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                            <option value="globe" {{ ($item['platform'] ?? '') === 'globe' ? 'selected' : '' }}>Website / Globe</option>
                        </select>
                    </div>
                    <div style="flex:2;">
                        <label class="form-label">URL Profil Lengkap</label>
                        <input type="text" name="social_links[{{ $i }}][url]" class="form-input" 
                            value="{{ $item['url'] ?? '' }}"
                            placeholder="Masukkan Link">
                    </div>
                    <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                        <button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">
                            <x-icon name="arrow-up" />
                        </button>
                        <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                            <x-icon name="arrow-down" />
                        </button>
                        <button type="button" class="btn-icon danger cms-remove-btn" 
                            onclick="confirmRemoveRepeaterItem(this, 'sosial media')" title="Hapus">
                            <x-icon name="trash-2" />
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
