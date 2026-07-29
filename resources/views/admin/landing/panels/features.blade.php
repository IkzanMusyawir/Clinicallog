@php
    $featuresVisible = old('features_visible', $landing->features_visible ?? true);
    @endphp
    <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $featuresVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $featuresVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;"
        id="featuresToggleBox">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;border-radius:12px;background:{{ $featuresVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;"
                id="featuresToggleIconBox">
                <x-icon name="{{ $featuresVisible ? 'eye' : 'eye-off' }}"
                    style="color:{{ $featuresVisible ? '#34d399' : '#f87171' }};"
                    id="featuresToggleIcon" />
            </div>
            <div>
                <div style="font-size:14px;font-weight:600;color:#1e293b;" id="featuresToggleTitle">
                    {{ $featuresVisible ? 'Seksi Fitur Aktif' : 'Seksi Fitur Nonaktif' }}
                </div>
                <div style="font-size:12px;color:#475569;margin-top:2px;" id="featuresToggleDesc">
                    {{ $featuresVisible ? 'Seksi fitur unggulan ditampilkan di landing page dan navigasi.' : 'Seksi
                    fitur unggulan disembunyikan dari landing page dan navigasi.' }}
                </div>
            </div>
        </div>
        <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
            <input type="checkbox" name="features_visible" value="1" {{ $featuresVisible ? 'checked' : '' }}
                style="opacity:0;width:0;height:0;position:absolute;" id="featuresVisibleCheckbox"
                onchange="updateFeaturesToggle(this.checked)">
            <span
                style="position:absolute;inset:0;border-radius:14px;background:{{ $featuresVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;"
                id="featuresToggleTrack"></span>
            <span
                style="position:absolute;top:3px;{{ $featuresVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;"
                id="featuresToggleKnob"></span>
        </label>
    </div>

    <div class="glass-card glass">
        <div class="cms-section-header" style="justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="cms-section-bar" style="background:linear-gradient(180deg,#0369A1,#22D3EE);"></span>
                Fitur Unggulan
            </div>
            <button type="button" class="btn-secondary btn-sm" onclick="addFeatureItem()">
                <x-icon name="plus" /> Tambah
            </button>
        </div>
        <p class="form-hint" style="margin-bottom:20px;">Kelola item fitur unggulan. Seret (drag) untuk urut ulang,
            klik field untuk edit (otomatis tersimpan). Icon menggunakan nama dari <a
                href="https://lucide.dev/icons/" target="_blank" style="color:#38bdf8;">Lucide Icons</a>.</p>

        <div id="featuresContainer">
            @foreach($features as $feature)
            <div class="cms-repeater-item cms-sortable-item" data-id="{{ $feature->id }}"
                data-sort="{{ $feature->sort_order }}">
                <div class="cms-repeater-row">
                    <div style="width:130px;flex-shrink:0;">
                        <input type="text" class="form-input" value="{{ $feature->icon_name ?? '' }}"
                            placeholder="icon-name" data-field="icon_name" data-id="{{ $feature->id }}"
                            onblur="autoSaveFeature(this)">
                    </div>
                    <div style="flex:1;min-width:120px;">
                        <input type="text" class="form-input" value="{{ $feature->title }}"
                            placeholder="Nama fitur..." data-field="title" data-id="{{ $feature->id }}"
                            onblur="autoSaveFeature(this)">
                    </div>
                    <div style="flex:1.5;min-width:160px;">
                        <input type="text" class="form-input" value="{{ $feature->description }}"
                            placeholder="Deskripsi..." data-field="description" data-id="{{ $feature->id }}"
                            onblur="autoSaveFeature(this)">
                    </div>
                    <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                        <button type="button" class="btn-icon" onclick="moveFeatureUp(this)" title="Naik">
                            <x-icon name="arrow-up" />
                        </button>
                        <button type="button" class="btn-icon" onclick="moveFeatureDown(this)" title="Turun">
                            <x-icon name="arrow-down" />
                        </button>
                        <button type="button" class="btn-icon danger" title="Hapus"
                            onclick="deleteFeatureItem(this, {{ $feature->id }})">
                            <x-icon name="trash-2" />
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
