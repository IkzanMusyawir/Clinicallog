@php
    $pricingVisible = old('pricing_visible', $landing->pricing_visible ?? true);
    @endphp
    <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $pricingVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $pricingVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;"
        id="pricingToggleBox">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;border-radius:12px;background:{{ $pricingVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;"
                id="pricingToggleIconBox">
                <x-icon name="{{ $pricingVisible ? 'eye' : 'eye-off' }}" style="color:{{ $pricingVisible ? '#34d399' : '#f87171' }}"
                    id="pricingToggleIcon" />
            </div>
            <div>
                <div style="font-size:14px;font-weight:600;color:#1e293b;" id="pricingToggleTitle">
                    {{ $pricingVisible ? 'Seksi Paket Harga Aktif' : 'Seksi Paket Harga Nonaktif' }}
                </div>
                <div style="font-size:12px;color:#475569;margin-top:2px;" id="pricingToggleDesc">
                    {{ $pricingVisible ? 'Seksi paket harga ditampilkan di landing page dan navigasi.' : 'Seksi
                    paket harga disembunyikan dari landing page dan navigasi.' }}
                </div>
            </div>
        </div>
        <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
            <input type="checkbox" name="pricing_visible" value="1" {{ $pricingVisible ? 'checked' : '' }}
                style="opacity:0;width:0;height:0;position:absolute;" id="pricingVisibleCheckbox"
                onchange="updatePricingToggle(this.checked)">
            <span
                style="position:absolute;inset:0;border-radius:14px;background:{{ $pricingVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;"
                id="pricingToggleTrack"></span>
            <span
                style="position:absolute;top:3px;{{ $pricingVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;"
                id="pricingToggleKnob"></span>
        </label>
    </div>

    <div class="glass-card glass">
        <div class="cms-section-header" style="justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="cms-section-bar" style="background:linear-gradient(180deg,#34d399,#22D3EE);"></span>
                Paket Harga
            </div>
            <button type="button" class="btn-secondary btn-sm" onclick="addPricingPlan()">
                <x-icon name="plus" /> Tambah Paket
            </button>
        </div>
        <p class="form-hint" style="margin-bottom:20px;">Setiap fitur di dalam paket dipisahkan dengan baris baru
            (Enter).</p>

        <div id="pricingContainer">
            @php
            $pricingItems = old('pricing_plans', $landing->pricing_plans ?? [
            ['tier' => 'Starter', 'name' => 'Department', 'price' => 'Rp25 Juta', 'featured' => false, 'features' =>
            ['Maks 100 mahasiswa', 'Maks 5 dosen', 'Dashboard basic', 'Support email']],
            ['tier' => 'Populer', 'name' => 'Faculty', 'price' => 'Rp50 Juta', 'featured' => true, 'features' =>
            ['Unlimited mahasiswa', 'Unlimited dosen', 'Integrasi SIAKAD', 'Dashboard Analytics', 'Priority
            support']],
            ['tier' => 'Enterprise', 'name' => 'University', 'price' => 'Rp75 Juta', 'featured' => false, 'features'
            => ['Multi-fakultas', 'Central Admin', 'Custom Reporting', 'Training & Support', 'SLA Guarantee']],
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
                            <label class="form-label">Harga <span
                                    style="font-weight:400;color:#94a3b8;">(opsional)</span></label>
                            <input type="text" name="pricing_plans[{{ $i }}][price]" class="form-input"
                                value="{{ $p['price'] ?? '' }}" placeholder="Rp25 Juta">
                            <div style="font-size:11px;color:#94a3b8;margin-top:4px;">Kosongkan → tampil "Hubungi
                                Kami"</div>
                        </div>
                        <div style="width:80px;text-align:center;">
                            <label class="form-label">Populer</label>
                            <div style="padding-top:8px;">
                                <input type="checkbox" name="pricing_plans[{{ $i }}][featured]" value="1" {{
                                    !empty($p['featured']) ? 'checked' : '' }}
                                    style="width:18px;height:18px;accent-color:#0369A1;">
                            </div>
                        </div>
                        <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                            <button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">
                                <x-icon name="arrow-up" />
                            </button>
                            <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                                <x-icon name="arrow-down" />
                            </button>
                            <button type="button" class="btn-icon danger cms-remove-btn"
                                onclick="confirmRemoveRepeaterItem(this, 'paket harga')" title="Hapus">
                                <x-icon name="trash-2" />
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:12px;">
                        <label class="form-label">Fitur (satu per baris)</label>
                        <textarea name="pricing_plans[{{ $i }}][features_text]" class="form-input"
                            style="min-height:90px;"
                            placeholder="Fitur 1&#10;Fitur 2&#10;Fitur 3">{{ is_array($p['features'] ?? null) ? implode("\n", $p['features']) : ($p['features_text'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
