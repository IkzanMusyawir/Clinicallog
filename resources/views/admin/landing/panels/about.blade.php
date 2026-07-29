@php
    $aboutVisible = old('about_visible', $landing->about_visible ?? true);
    @endphp
    <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $aboutVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $aboutVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;"
        id="aboutToggleBox">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;border-radius:12px;background:{{ $aboutVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;"
                id="aboutToggleIconBox">
                <x-icon name="{{ $aboutVisible ? 'eye' : 'eye-off' }}"
                    style="color:{{ $aboutVisible ? '#34d399' : '#f87171' }};"
                    id="aboutToggleIcon" />
            </div>
            <div>
                <div style="font-size:14px;font-weight:600;color:#1e293b;" id="aboutToggleTitle">
                    {{ $aboutVisible ? 'Seksi Tentang Aktif' : 'Seksi Tentang Nonaktif' }}
                </div>
                <div style="font-size:12px;color:#475569;margin-top:2px;" id="aboutToggleDesc">
                    {{ $aboutVisible ? 'Seksi tentang kami ditampilkan di landing page dan navigasi.' : 'Seksi
                    tentang kami disembunyikan dari landing page dan navigasi.' }}
                </div>
            </div>
        </div>
        <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
            <input type="checkbox" name="about_visible" value="1" {{ $aboutVisible ? 'checked' : '' }}
                style="opacity:0;width:0;height:0;position:absolute;" id="aboutVisibleCheckbox"
                onchange="updateAboutToggle(this.checked)">
            <span
                style="position:absolute;inset:0;border-radius:14px;background:{{ $aboutVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;"
                id="aboutToggleTrack"></span>
            <span
                style="position:absolute;top:3px;{{ $aboutVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;"
                id="aboutToggleKnob"></span>
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
                <textarea id="about_description" name="about_description" class="form-input"
                    style="min-height:150px;">{{ old('about_description', $landing->about_description ?? '') }}</textarea>
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
                    <x-icon name="image" class="inline" />
                    Gambar saat ini
                </div>
            </div>
            <div style="margin: 10px 0 16px;">
                <label
                    style="display:inline-flex;align-items:center;gap:8px;font-size:13px;color:#ef4444;cursor:pointer;font-weight:500;">
                    <input type="checkbox" name="delete_about_image" value="1"
                        style="width:16px;height:16px;accent-color:#ef4444;cursor:pointer;">
                    <x-icon name="trash-2" class="inline" /> Hapus gambar saat
                    ini
                </label>
                <p style="font-size:11px;color:#94a3b8;margin-top:4px;padding-left:24px;">* Centang checkbox ini,
                    lalu klik tombol <strong>"Simpan Semua Perubahan"</strong> di bagian bawah halaman untuk
                    menghapus gambar.</p>
            </div>
            @endif

            <div class="upload-zone" id="aboutUploadZone" onclick="document.getElementById('about_image').click()">
                <x-icon name="upload-cloud" class="block" style="color:#38bdf8;margin:0 auto 10px;" />
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

<div class="glass-card glass" style="margin-top: 20px;">
        <div class="cms-section-header" style="justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="cms-section-bar" style="background:linear-gradient(180deg,#0EA5E9,#22D3EE);"></span>
                Poin Keunggulan (Checklist Tentang)
            </div>
            <button type="button" class="btn-secondary btn-sm" onclick="addAboutPoint()">
                <x-icon name="plus" /> Tambah Poin
            </button>
        </div>
        <p class="form-hint" style="margin-bottom:20px;">Kelola daftar poin checklist keunggulan yang tampil dengan tanda centang (✓) di bagian Tentang ClinicalLog. Seret (drag) untuk urut ulang.</p>

        <div id="aboutPointsContainer">
            @php
            $aboutPointsItems = old('about_points', $landing->about_points ?? [
                ['text' => 'Mendukung pembelajaran klinis yang lebih terukur dan efisien dengan data yang akurat.'],
                ['text' => 'Memudahkan pemantauan mahasiswa oleh dosen dan dokter pembimbing secara real-time.'],
                ['text' => 'Menyediakan data evaluasi yang rapi, akurat, dan siap dianalisis kapan saja.']
            ]);
            @endphp
            @foreach ($aboutPointsItems as $i => $point)
            <div class="cms-repeater-item" data-index="{{ $i }}">
                <div class="cms-repeater-row">
                    <div style="flex:1;">
                        <label class="form-label">Teks Poin</label>
                        <input type="text" name="about_points[{{ $i }}][text]" class="form-input"
                            value="{{ $point['text'] ?? '' }}" placeholder="Tuliskan keunggulan...">
                    </div>
                    <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                        <button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">
                            <x-icon name="arrow-up" />
                        </button>
                        <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                            <x-icon name="arrow-down" />
                        </button>
                        <button type="button" class="btn-icon danger cms-remove-btn"
                            onclick="confirmRemoveRepeaterItem(this, 'poin keunggulan')" title="Hapus">
                            <x-icon name="trash-2" />
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
