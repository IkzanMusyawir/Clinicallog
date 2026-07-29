@php
    $stepsVisible = old('steps_visible', $landing->steps_visible ?? true);
    @endphp
    <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $stepsVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $stepsVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;"
        id="stepsToggleBox">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;border-radius:12px;background:{{ $stepsVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;"
                id="stepsToggleIconBox">
                <x-icon name="{{ $stepsVisible ? 'eye' : 'eye-off' }}" style="color:{{ $stepsVisible ? '#34d399' : '#f87171' }}"
                    id="stepsToggleIcon" />
            </div>
            <div>
                <div style="font-size:14px;font-weight:600;color:#1e293b;" id="stepsToggleTitle">
                    {{ $stepsVisible ? 'Seksi Cara Kerja Aktif' : 'Seksi Cara Kerja Nonaktif' }}
                </div>
                <div style="font-size:12px;color:#475569;margin-top:2px;" id="stepsToggleDesc">
                    {{ $stepsVisible ? 'Seksi alur/cara kerja ditampilkan di landing page dan navigasi.' : 'Seksi
                    alur/cara kerja disembunyikan dari landing page dan navigasi.' }}
                </div>
            </div>
        </div>
        <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
            <input type="checkbox" name="steps_visible" value="1" {{ $stepsVisible ? 'checked' : '' }}
                style="opacity:0;width:0;height:0;position:absolute;" id="stepsVisibleCheckbox"
                onchange="updateStepsToggle(this.checked)">
            <span
                style="position:absolute;inset:0;border-radius:14px;background:{{ $stepsVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;"
                id="stepsToggleTrack"></span>
            <span
                style="position:absolute;top:3px;{{ $stepsVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;"
                id="stepsToggleKnob"></span>
        </label>
    </div>

    <div class="glass-card glass">
        <div class="cms-section-header" style="justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="cms-section-bar" style="background:linear-gradient(180deg,#0369A1,#22D3EE);"></span>
                Cara Kerja
            </div>
            <button type="button" class="btn-secondary btn-sm" onclick="addStep()">
                <x-icon name="plus" /> Tambah
            </button>
        </div>
        <p class="form-hint" style="margin-bottom:20px;">Atur langkah-langkah cara kerja. Nomor urut otomatis
            berdasarkan posisi. Icon menggunakan nama dari <a href="https://lucide.dev/icons/" target="_blank"
                style="color:#38bdf8;">Lucide Icons</a>.</p>

        <div id="stepsContainer">
            @php
            $stepsItems = old('steps', $landing->steps ?? [
            ['icon' => 'clipboard-edit', 'num' => '01', 'title' => 'Catat Aktivitas Klinis', 'desc' => 'Mahasiswa
            mencatat kasus dan aktivitas klinis secara digital langsung dari smartphone.'],
            ['icon' => 'qr-code', 'num' => '02', 'title' => 'Verifikasi QR Code', 'desc' => 'Aktivitas diverifikasi
            oleh pembimbing dengan scan QR Code yang aman dan cepat.'],
            ['icon' => 'line-chart', 'num' => '03', 'title' => 'Pantau Kompetensi', 'desc' => 'Progress kompetensi
            mahasiswa terpantau secara real-time oleh dosen dan institusi.'],
            ['icon' => 'file-bar-chart', 'num' => '04', 'title' => 'Laporan & Evaluasi', 'desc' => 'Data tersaji
            rapi untuk laporan otomatis dan pengambilan keputusan berbasis data.'],
            ]);
            @endphp
            @foreach ($stepsItems as $i => $s)
            <div class="cms-repeater-item" data-index="{{ $i }}">
                <div class="cms-repeater-row" style="align-items:flex-start;">
                    <div style="width:120px;">
                        <label class="form-label">Icon</label>
                        <input type="text" name="steps[{{ $i }}][icon]" class="form-input"
                            value="{{ $s['icon'] ?? '' }}" placeholder="icon-name">
                    </div>
                    <div style="flex:1;">
                        <label class="form-label">Judul</label>
                        <input type="text" name="steps[{{ $i }}][title]" class="form-input"
                            value="{{ $s['title'] ?? '' }}" placeholder="Judul langkah...">
                    </div>
                    <div style="flex:1.5;">
                        <label class="form-label">Deskripsi</label>
                        <input type="text" name="steps[{{ $i }}][desc]" class="form-input"
                            value="{{ $s['desc'] ?? '' }}" placeholder="Deskripsi langkah...">
                    </div>
                    <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                        <button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">
                            <x-icon name="arrow-up" />
                        </button>
                        <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                            <x-icon name="arrow-down" />
                        </button>
                        <button type="button" class="btn-icon danger cms-remove-btn"
                            onclick="confirmRemoveRepeaterItem(this, 'langkah')" title="Hapus">
                            <x-icon name="trash-2" />
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
