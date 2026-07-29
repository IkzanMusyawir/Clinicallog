@php
    $dashboardVisible = old('dashboard_visible', $landing->dashboard_visible ?? true);
    @endphp
    <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $dashboardVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $dashboardVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;"
        id="dashboardToggleBox">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;border-radius:12px;background:{{ $dashboardVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;"
                id="dashboardToggleIconBox">
                <x-icon name="{{ $dashboardVisible ? 'eye' : 'eye-off' }}" style="color:{{ $dashboardVisible ? '#34d399' : '#f87171' }}"
                    id="dashboardToggleIcon" />
            </div>
            <div>
                <div style="font-size:14px;font-weight:600;color:#1e293b;" id="dashboardToggleTitle">
                    {{ $dashboardVisible ? 'Seksi Dashboard Aktif' : 'Seksi Dashboard Nonaktif' }}
                </div>
                <div style="font-size:12px;color:#475569;margin-top:2px;" id="dashboardToggleDesc">
                    {{ $dashboardVisible ? 'Seksi dashboard preview ditampilkan di landing page dan navigasi.' :
                    'Seksi dashboard preview disembunyikan dari landing page dan navigasi.' }}
                </div>
            </div>
        </div>
        <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
            <input type="checkbox" name="dashboard_visible" value="1" {{ $dashboardVisible ? 'checked' : '' }}
                style="opacity:0;width:0;height:0;position:absolute;" id="dashboardVisibleCheckbox"
                onchange="updateDashboardToggle(this.checked)">
            <span
                style="position:absolute;inset:0;border-radius:14px;background:{{ $dashboardVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;"
                id="dashboardToggleTrack"></span>
            <span
                style="position:absolute;top:3px;{{ $dashboardVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;"
                id="dashboardToggleKnob"></span>
        </label>
    </div>

    <div class="admin-grid-1-1">
        <div class="glass-card glass">
            <div class="cms-section-header">
                <span class="cms-section-bar" style="background:linear-gradient(180deg,#0369A1,#22D3EE);"></span>
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
                <textarea id="dashboard_description" name="dashboard_description" class="form-input"
                    style="min-height:150px;"
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
                    <x-icon name="image" class="inline" />
                    Gambar saat ini
                </div>
            </div>
            <div style="margin: 10px 0 16px;">
                <label
                    style="display:inline-flex;align-items:center;gap:8px;font-size:13px;color:#ef4444;cursor:pointer;font-weight:500;">
                    <input type="checkbox" name="delete_dashboard_image" value="1"
                        style="width:16px;height:16px;accent-color:#ef4444;cursor:pointer;">
                    <x-icon name="trash-2" class="inline" /> Hapus gambar saat
                    ini
                </label>
                <p style="font-size:11px;color:#94a3b8;margin-top:4px;padding-left:24px;">* Centang checkbox ini,
                    lalu klik tombol <strong>"Simpan Semua Perubahan"</strong> di bagian bawah halaman untuk
                    menghapus gambar.</p>
            </div>
            @endif

            <div class="upload-zone" id="dashboardUploadZone"
                onclick="document.getElementById('dashboard_image').click()">
                <x-icon name="upload-cloud" style="margin:0 auto 10px;color:#38bdf8" class="block" />
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
