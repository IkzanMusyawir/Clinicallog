@php
    $ctaVisible = old('cta_visible', $landing->cta_visible ?? true);
    @endphp
    <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $ctaVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $ctaVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;"
        id="ctaToggleBox">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;border-radius:12px;background:{{ $ctaVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;"
                id="ctaToggleIconBox">
                <x-icon name="{{ $ctaVisible ? 'eye' : 'eye-off' }}" style="color:{{ $ctaVisible ? '#34d399' : '#f87171' }}"
                    id="ctaToggleIcon" />
            </div>
            <div>
                <div style="font-size:14px;font-weight:600;color:#1e293b;" id="ctaToggleTitle">
                    {{ $ctaVisible ? 'Seksi CTA Aktif' : 'Seksi CTA Nonaktif' }}
                </div>
                <div style="font-size:12px;color:#475569;margin-top:2px;" id="ctaToggleDesc">
                    {{ $ctaVisible ? 'Seksi CTA ditampilkan di landing page.' : 'Seksi CTA disembunyikan dari
                    landing page.' }}
                </div>
            </div>
        </div>
        <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
            <input type="checkbox" name="cta_visible" value="1" {{ $ctaVisible ? 'checked' : '' }}
                style="opacity:0;width:0;height:0;position:absolute;" id="ctaVisibleCheckbox"
                onchange="updateCtaToggle(this.checked)">
            <span
                style="position:absolute;inset:0;border-radius:14px;background:{{ $ctaVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;"
                id="ctaToggleTrack"></span>
            <span
                style="position:absolute;top:3px;{{ $ctaVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;"
                id="ctaToggleKnob"></span>
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
                <textarea id="cta_title" name="cta_title" class="form-input"
                    style="min-height:80px;">{{ old('cta_title', $landing->cta_title ?? 'Digitalisasi Pembelajaran Klinis Bersama ClinicalLog') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="cta_description">Deskripsi CTA</label>
                <textarea id="cta_description" name="cta_description" class="form-input"
                    style="min-height:80px;">{{ old('cta_description', $landing->cta_description ?? 'Tingkatkan kualitas pendidikan kedokteran dengan platform Medical Data & E-Logbook yang terintegrasi dan mudah digunakan.') }}</textarea>
            </div>
        </div>
    </div>
