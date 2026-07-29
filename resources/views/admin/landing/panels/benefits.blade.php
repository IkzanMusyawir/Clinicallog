@php
    $benefitsVisible = old('benefits_visible', $landing->benefits_visible ?? true);
    @endphp
    <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $benefitsVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $benefitsVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;"
        id="benefitsToggleBox">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;border-radius:12px;background:{{ $benefitsVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;"
                id="benefitsToggleIconBox">
                <x-icon name="{{ $benefitsVisible ? 'eye' : 'eye-off' }}"
                    style="color:{{ $benefitsVisible ? '#34d399' : '#f87171' }};"
                    id="benefitsToggleIcon" />
            </div>
            <div>
                <div style="font-size:14px;font-weight:600;color:#1e293b;" id="benefitsToggleTitle">
                    {{ $benefitsVisible ? 'Seksi Keunggulan Aktif' : 'Seksi Keunggulan Nonaktif' }}
                </div>
                <div style="font-size:12px;color:#475569;margin-top:2px;" id="benefitsToggleDesc">
                    {{ $benefitsVisible ? 'Seksi keunggulan ditampilkan di landing page.' : 'Seksi keunggulan
                    disembunyikan dari landing page.' }}
                </div>
            </div>
        </div>
        <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
            <input type="checkbox" name="benefits_visible" value="1" {{ $benefitsVisible ? 'checked' : '' }}
                style="opacity:0;width:0;height:0;position:absolute;" id="benefitsVisibleCheckbox"
                onchange="updateBenefitsToggle(this.checked)">
            <span
                style="position:absolute;inset:0;border-radius:14px;background:{{ $benefitsVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;"
                id="benefitsToggleTrack"></span>
            <span
                style="position:absolute;top:3px;{{ $benefitsVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;"
                id="benefitsToggleKnob"></span>
        </label>
    </div>

    <div class="glass-card glass">
        <div class="cms-section-header" style="justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="cms-section-bar" style="background:linear-gradient(180deg,#f59e0b,#ef4444);"></span>
                Keunggulan
            </div>
            <button type="button" class="btn-secondary btn-sm" onclick="addBenefit()">
                <x-icon name="plus" /> Tambah
            </button>
        </div>
        <p class="form-hint" style="margin-bottom:20px;">Atur keunggulan yang ditampilkan di landing page. Icon
            menggunakan nama dari <a href="https://lucide.dev/icons/" target="_blank" style="color:#38bdf8;">Lucide
                Icons</a>.</p>

        <div id="benefitsContainer">
            @php
            $benefitsItems = old('benefits', $landing->benefits ?? [
            ['icon' => 'zap', 'title' => 'Efisiensi proses', 'description' => 'Catat aktivitas klinis langsung dari smartphone, tanpa perlu kertas dan alat tulis fisik.', 'stat' => '10x lebih cepat'],
            ['icon' => 'radar', 'title' => 'Monitoring real-time', 'description' => 'Pantau progress kompetensi mahasiswa secara langsung dari dashboard dosen.', 'stat' => '24/7 akses'],
            ['icon' => 'file-check', 'title' => 'Dokumentasi digital', 'description' => 'Semua data tersimpan rapi, mudah diakses kapan saja untuk laporan dan evaluasi.', 'stat' => '100% paperless'],
            ['icon' => 'users', 'title' => 'Kolaborasi terpadu', 'description' => 'Mahasiswa, dosen, dan institusi terhubung dalam satu platform terintegrasi.', 'stat' => '360° terintegrasi'],
            ]);
            @endphp
            @foreach ($benefitsItems as $i => $b)
            <div class="cms-repeater-item" data-index="{{ $i }}">
                <div class="cms-repeater-row">
                    <div style="width:120px;">
                        <label class="form-label">Icon</label>
                        <input type="text" name="benefits[{{ $i }}][icon]" class="form-input"
                            value="{{ $b['icon'] ?? '' }}" placeholder="icon-name">
                    </div>
                    <div style="flex:1;">
                        <label class="form-label">Judul</label>
                        <input type="text" name="benefits[{{ $i }}][title]" class="form-input"
                            value="{{ $b['title'] ?? '' }}" placeholder="Judul keunggulan...">
                    </div>
                    <div style="flex:1.5;">
                        <label class="form-label">Deskripsi</label>
                        <input type="text" name="benefits[{{ $i }}][description]" class="form-input"
                            value="{{ $b['description'] ?? '' }}" placeholder="Deskripsi singkat...">
                    </div>
                    <div style="width:100px;">
                        <label class="form-label">Statistik</label>
                        <input type="text" name="benefits[{{ $i }}][stat]" class="form-input"
                            value="{{ $b['stat'] ?? '' }}" placeholder="cth: 10x lebih cepat">
                    </div>
                    <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                        <button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">
                            <x-icon name="arrow-up" />
                        </button>
                        <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                            <x-icon name="arrow-down" />
                        </button>
                        <button type="button" class="btn-icon danger cms-remove-btn"
                            onclick="confirmRemoveRepeaterItem(this, 'keunggulan')" title="Hapus">
                            <x-icon name="trash-2" />
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
