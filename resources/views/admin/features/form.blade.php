@extends('layouts.admin')

@section('title', isset($feature) ? 'Edit Fitur' : 'Tambah Fitur')

@section('content')

    <div class="admin-topbar">
        <div>
            <h1 class="admin-page-title">{{ isset($feature) ? 'Edit Fitur' : 'Tambah Fitur Baru' }}</h1>
            <p class="admin-page-sub">
                {{ isset($feature) ? 'Perbarui informasi fitur' : 'Tambahkan fitur ClinicalLog ke landing page' }}</p>
        </div>
        <a href="{{ route('admin.landing.edit') }}" class="btn-secondary btn-sm">
            <i data-lucide="arrow-left" style="width:14px;height:14px;"></i>
            Kembali
        </a>
    </div>

    <div style="display:grid;grid-template-columns:1fr 380px;gap:24px;align-items:flex-start;">

        {{-- ── Form ── --}}
        <div class="glass-card glass">
            <form method="POST"
                action="{{ isset($feature) ? route('admin.features.update', $feature->id) : route('admin.features.store') }}"
                enctype="multipart/form-data">
                @csrf
                @if (isset($feature))
                    @method('PUT')
                @endif

                {{-- Title --}}
                <div class="form-group">
                    <label class="form-label" for="title">Nama Fitur <span style="color:#f87171;">*</span></label>
                    <input type="text" id="title" name="title" class="form-input"
                        value="{{ old('title', $feature->title ?? '') }}" placeholder="cth: E-Logbook Digital" required>
                    @error('title')
                        <p style="font-size:12px;color:#f87171;margin-top:5px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi <span style="color:#f87171;">*</span></label>
                    <textarea id="description" name="description" class="form-input"
                        placeholder="Jelaskan fitur ini secara singkat dan jelas..." required>{{ old('description', $feature->description ?? '') }}</textarea>
                    @error('description')
                        <p style="font-size:12px;color:#f87171;margin-top:5px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Icon Name (Lucide) --}}
                <div class="form-group">
                    <label class="form-label" for="icon_name">Nama Icon (Lucide) <span style="font-weight:400;color:#64748b;">— Rekomendasi</span></label>
                    <input type="text" id="icon_name" name="icon_name" class="form-input"
                        value="{{ old('icon_name', $feature->icon_name ?? '') }}" placeholder="cth: clipboard-list, stethoscope, heart-pulse">
                    <p class="form-hint" style="margin-top:6px;">
                        Ketik nama icon dari <a href="https://lucide.dev/icons/" target="_blank" style="color:#38bdf8;font-weight:600;">Lucide Icons ↗</a>.
                        Cari icon yang sesuai, lalu copy namanya (contoh: <code style="background:rgba(255,255,255,.08);padding:2px 6px;border-radius:4px;font-size:12px;color:#22d3ee;">clipboard-list</code>).
                    </p>

                    {{-- Live preview --}}
                    <div id="iconPreviewBox" style="margin-top:12px;display:{{ old('icon_name', $feature->icon_name ?? '') ? '' : 'none' }};">
                        <div style="display:flex;align-items:center;gap:12px;padding:12px 14px;border-radius:12px;background:rgba(37,99,235,.08);border:1px solid rgba(37,99,235,.15);">
                            <div style="width:48px;height:48px;border-radius:12px;background:rgba(37,99,235,.15);display:flex;align-items:center;justify-content:center;color:#60a5fa;">
                                <i id="iconPreviewIcon" data-lucide="{{ old('icon_name', $feature->icon_name ?? 'star') }}" style="width:24px;height:24px;"></i>
                            </div>
                            <div>
                                <div style="font-size:13px;font-weight:600;color:#94a3b8;">Preview Icon</div>
                                <div id="iconPreviewName" style="font-size:12px;color:#64748b;margin-top:2px;">{{ old('icon_name', $feature->icon_name ?? '') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Separator --}}
                <div style="display:flex;align-items:center;gap:12px;margin:20px 0;">
                    <div style="flex:1;height:1px;background:rgba(255,255,255,.08);"></div>
                    <span style="font-size:12px;color:#64748b;font-weight:500;">ATAU upload gambar icon</span>
                    <div style="flex:1;height:1px;background:rgba(255,255,255,.08);"></div>
                </div>

                {{-- Icon upload (alternative) --}}
                <div class="form-group">
                    <label class="form-label">Upload Icon (Opsional)</label>
                    <p class="form-hint" style="margin-bottom:10px;">Jika sudah mengisi nama icon Lucide di atas, upload ini akan diabaikan.</p>

                    {{-- Existing uploaded icon --}}
                    @if (isset($feature) && $feature->icon)
                        <div
                            style="display:flex;align-items:center;gap:12px;margin-bottom:12px;padding:12px 14px;border-radius:12px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);">
                            <div
                                style="width:48px;height:48px;border-radius:10px;background:rgba(37,99,235,.15);display:flex;align-items:center;justify-content:center;">
                                <img src="{{ asset('storage/' . $feature->icon) }}" alt="Icon saat ini"
                                    style="width:32px;height:32px;object-fit:contain;">
                            </div>
                            <div>
                                <div style="font-size:13px;font-weight:500;color:#94a3b8;">Icon upload saat ini</div>
                                <div style="font-size:12px;color:#64748b;margin-top:2px;">Upload icon baru untuk mengganti
                                </div>
                            </div>
                        </div>
                        <div style="margin-bottom:12px;">
                            <label style="display:inline-flex;align-items:center;gap:8px;font-size:13px;color:#ef4444;cursor:pointer;font-weight:500;">
                                <input type="checkbox" name="delete_icon" value="1" style="width:16px;height:16px;accent-color:#ef4444;cursor:pointer;">
                                <i data-lucide="trash-2" style="width:14px;height:14px;display:inline;"></i> Hapus icon upload saat ini
                            </label>
                        </div>
                    @endif

                    {{-- Drop zone --}}
                    <div class="upload-zone" id="uploadZone" onclick="document.getElementById('icon').click()">
                        <i data-lucide="upload-cloud"
                            style="width:28px;height:28px;margin:0 auto 10px;display:block;color:#38bdf8;"></i>
                        <div style="font-weight:600;color:#94a3b8;margin-bottom:4px;">Klik atau drag & drop icon</div>
                        <div style="font-size:12px;color:#64748b;">SVG, PNG, JPG (maks 2MB)</div>
                        <div id="uploadPreview" style="display:none;margin-top:12px;">
                            <img id="previewImg" src="" alt=""
                                style="width:56px;height:56px;object-fit:contain;margin:0 auto;display:block;border-radius:10px;background:rgba(255,255,255,.05);">
                            <div id="previewName" style="font-size:12px;color:#22d3ee;text-align:center;margin-top:6px;">
                            </div>
                        </div>
                    </div>
                    <input type="file" id="icon" name="icon" accept=".svg,.png,.jpg,.jpeg" style="display:none;">
                    @error('icon')
                        <p style="font-size:12px;color:#f87171;margin-top:5px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Sort order --}}
                <div class="form-group">
                    <label class="form-label" for="sort_order">Urutan Tampil</label>
                    @php
                        $maxOrder = isset($feature) ? $totalFeatures : $totalFeatures + 1;
                        $defaultOrder = isset($feature) ? $feature->sort_order : $totalFeatures + 1;
                    @endphp
                    <input type="number" id="sort_order" name="sort_order" class="form-input"
                        value="{{ old('sort_order', $defaultOrder) }}" min="1" max="{{ $maxOrder }}">
                    <p class="form-hint" style="margin-top:6px;">
                        Posisi 1 = paling atas. Saat ini ada <strong>{{ $maxOrder }}</strong> posisi tersedia.
                        @if(isset($feature))
                            Posisi saat ini: <strong>{{ $feature->sort_order }}</strong>. Mengubah posisi akan otomatis menggeser fitur lain.
                        @else
                            Fitur baru akan ditambahkan di posisi terakhir jika tidak diubah.
                        @endif
                    </p>
                </div>

                {{-- Submit --}}
                <div style="display:flex;gap:10px;padding-top:8px;">
                    <button type="submit" class="btn-primary">
                        <i data-lucide="{{ isset($feature) ? 'save' : 'plus-circle' }}"
                            style="width:14px;height:14px;"></i>
                        {{ isset($feature) ? 'Simpan Perubahan' : 'Tambah Fitur' }}
                    </button>
                    <a href="{{ route('admin.landing.edit') }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>

        {{-- ── Tips panel ── --}}
        <div>
            <div class="glass" style="border-radius:18px;padding:22px;">
                <h3
                    style="font-size:14px;font-weight:700;color:#f0f6ff;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                    <i data-lucide="lightbulb" style="width:15px;height:15px;color:#fbbf24;"></i>
                    Tips Penulisan
                </h3>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:10px;">
                    <li style="font-size:13px;color:#94a3b8;display:flex;gap:8px;line-height:1.5;">
                        <span style="color:#22d3ee;flex-shrink:0;margin-top:1px;">•</span>
                        Nama fitur singkat dan deskriptif (maks 4 kata)
                    </li>
                    <li style="font-size:13px;color:#94a3b8;display:flex;gap:8px;line-height:1.5;">
                        <span style="color:#22d3ee;flex-shrink:0;margin-top:1px;">•</span>
                        Deskripsi 1–2 kalimat, fokus pada manfaat pengguna
                    </li>
                    <li style="font-size:13px;color:#94a3b8;display:flex;gap:8px;line-height:1.5;">
                        <span style="color:#22d3ee;flex-shrink:0;margin-top:1px;">•</span>
                        Gunakan urutan tampil untuk mengatur posisi di landing page
                    </li>
                </ul>
            </div>

            {{-- Lucide icon guide --}}
            <div class="glass" style="border-radius:18px;padding:22px;margin-top:16px;border-color:rgba(56,189,248,.2);">
                <h3
                    style="font-size:14px;font-weight:700;color:#38bdf8;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                    <i data-lucide="info" style="width:15px;height:15px;"></i>
                    Panduan Icon Lucide
                </h3>
                <p style="font-size:13px;color:#94a3b8;line-height:1.6;margin-bottom:12px;">
                    Kunjungi <a href="https://lucide.dev/icons/" target="_blank" style="color:#38bdf8;font-weight:600;">lucide.dev/icons ↗</a> untuk mencari icon. Cukup copy nama icon-nya saja.
                </p>
                <div style="font-size:12px;color:#64748b;margin-bottom:8px;font-weight:600;">Contoh nama icon populer:</div>
                <div style="display:flex;flex-wrap:wrap;gap:6px;">
                    @foreach(['clipboard-list', 'stethoscope', 'shield-check', 'bar-chart-3', 'users', 'file-text', 'heart-pulse', 'qr-code', 'monitor', 'lock'] as $iconEx)
                        <span style="display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:8px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);font-size:11px;color:#cbd5e1;cursor:pointer;" onclick="document.getElementById('icon_name').value='{{ $iconEx }}'; document.getElementById('icon_name').dispatchEvent(new Event('input'));">
                            <i data-lucide="{{ $iconEx }}" style="width:13px;height:13px;color:#60a5fa;"></i>
                            {{ $iconEx }}
                        </span>
                    @endforeach
                </div>
            </div>

            @if (isset($feature))
                <div class="glass"
                    style="border-radius:18px;padding:22px;margin-top:16px;border-color:rgba(248,113,113,.2);">
                    <h3
                        style="font-size:14px;font-weight:700;color:#fca5a5;margin-bottom:12px;display:flex;align-items:center;gap:8px;">
                        <i data-lucide="trash-2" style="width:15px;height:15px;"></i>
                        Hapus Fitur
                    </h3>
                    <p style="font-size:13px;color:#94a3b8;margin-bottom:14px;line-height:1.5;">Tindakan ini tidak dapat
                        dibatalkan dan fitur akan dihapus dari landing page.</p>
                    <form method="POST" action="{{ route('admin.features.destroy', $feature->id) }}"
                        onsubmit="return confirm('Yakin ingin menghapus fitur ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            style="width:100%;padding:10px;border-radius:10px;border:1px solid rgba(248,113,113,.3);background:rgba(248,113,113,.1);color:#fca5a5;font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;font-family:inherit;transition:all .2s;"
                            onmouseover="this.style.background='rgba(248,113,113,.2)'"
                            onmouseout="this.style.background='rgba(248,113,113,.1)'">
                            <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                            Hapus Fitur Ini
                        </button>
                    </form>
                </div>
            @endif
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        // Icon name live preview
        const iconNameInput = document.getElementById('icon_name');
        const iconPreviewBox = document.getElementById('iconPreviewBox');
        const iconPreviewIcon = document.getElementById('iconPreviewIcon');
        const iconPreviewName = document.getElementById('iconPreviewName');

        let debounceTimer;
        iconNameInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const val = iconNameInput.value.trim();
                if (val) {
                    iconPreviewBox.style.display = '';
                    iconPreviewName.textContent = val;
                    // Re-render the icon
                    iconPreviewIcon.setAttribute('data-lucide', val);
                    iconPreviewIcon.innerHTML = '';
                    lucide.createIcons({ nodes: [iconPreviewIcon] });
                } else {
                    iconPreviewBox.style.display = 'none';
                }
            }, 300);
        });

        // Icon upload preview
        const iconInput = document.getElementById('icon');
        const previewBox = document.getElementById('uploadPreview');
        const previewImg = document.getElementById('previewImg');
        const previewNm = document.getElementById('previewName');

        iconInput.addEventListener('change', () => {
            const file = iconInput.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                previewNm.textContent = file.name;
                previewBox.style.display = '';
            };
            reader.readAsDataURL(file);
        });

        // Drag & drop
        const zone = document.getElementById('uploadZone');
        zone.addEventListener('dragover', (e) => {
            e.preventDefault();
            zone.style.borderColor = 'rgba(56,189,248,.7)';
        });
        zone.addEventListener('dragleave', () => {
            zone.style.borderColor = '';
        });
        zone.addEventListener('drop', (e) => {
            e.preventDefault();
            zone.style.borderColor = '';
            if (e.dataTransfer.files.length) {
                iconInput.files = e.dataTransfer.files;
                iconInput.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endpush
