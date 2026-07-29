<div class="cms-panel" id="panel-hero">
    <div class="admin-grid-1-1">
        <div class="glass-card glass">
            <div class="cms-section-header">
                <span class="cms-section-bar" style="background:linear-gradient(180deg,#0369A1,#22D3EE);"></span>
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
                <p class="form-hint">Gunakan Enter untuk baris baru.
                    Contoh:<br>Transformasi<br>Pendidikan<br>Kedokteran Digital</p>
            </div>

            <div class="form-group">
                <label class="form-label" for="hero_description">Deskripsi Hero</label>
                <textarea id="hero_description" name="hero_description" class="form-input"
                    style="min-height:100px;">{{ old('hero_description', $landing->hero_description ?? '') }}</textarea>
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
                    <x-icon name="image" class="inline" />
                    Gambar saat ini
                </div>
            </div>
            <div style="margin: 10px 0 16px;">
                <label
                    style="display:inline-flex;align-items:center;gap:8px;font-size:13px;color:#ef4444;cursor:pointer;font-weight:500;">
                    <input type="checkbox" name="delete_hero_image" value="1"
                        style="width:16px;height:16px;accent-color:#ef4444;cursor:pointer;">
                    <x-icon name="trash-2" class="inline" /> Hapus gambar saat
                    ini
                </label>
                <p style="font-size:11px;color:#94a3b8;margin-top:4px;padding-left:24px;">* Centang checkbox ini,
                    lalu klik tombol <strong>"Simpan Semua Perubahan"</strong> di bagian bawah halaman untuk
                    menghapus gambar.</p>
            </div>
            @endif

            <div class="upload-zone" id="heroUploadZone" onclick="document.getElementById('hero_image').click()">
                <x-icon name="upload-cloud" class="block" style="color:#38bdf8;margin:0 auto 10px;" />
                <div style="font-weight:600;color:#94a3b8;margin-bottom:4px;">Klik atau drag & drop gambar hero
                </div>
                <div style="font-size:12px;color:#64748b;">JPG, PNG, WebP (maks 2MB)</div>
                <div id="heroPreview" style="display:none;margin-top:12px;">
                    <img id="heroPreviewImg" src="" alt=""
                        style="width:100%;max-height:160px;object-fit:cover;border-radius:10px;margin:0 auto;display:block;">
                    <div id="heroPreviewName"
                        style="font-size:12px;color:#22d3ee;text-align:center;margin-top:6px;">
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
