@php
    $testiVisible = old('testimonials_visible', $landing->testimonials_visible ?? true);
    @endphp
    <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin-bottom:20px;border-radius:14px;border:1px solid {{ $testiVisible ? 'rgba(52,211,153,.25)' : 'rgba(248,113,113,.25)' }};background:{{ $testiVisible ? 'rgba(52,211,153,.06)' : 'rgba(248,113,113,.06)' }};transition:all .3s;"
        id="testiToggleBox">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;border-radius:12px;background:{{ $testiVisible ? 'rgba(52,211,153,.15)' : 'rgba(248,113,113,.15)' }};display:flex;align-items:center;justify-content:center;"
                id="testiToggleIconBox">
                <x-icon name="{{ $testiVisible ? 'eye' : 'eye-off' }}" style="color:{{ $testiVisible ? '#34d399' : '#f87171' }}"
                    id="testiToggleIcon" />
            </div>
            <div>
                <div style="font-size:14px;font-weight:600;color:#1e293b;" id="testiToggleTitle">
                    {{ $testiVisible ? 'Testimoni Aktif' : 'Testimoni Nonaktif' }}
                </div>
                <div style="font-size:12px;color:#475569;margin-top:2px;" id="testiToggleDesc">
                    {{ $testiVisible ? 'Seksi testimoni ditampilkan di landing page dan navigasi.' : 'Seksi
                    testimoni disembunyikan dari landing page dan navigasi.' }}
                </div>
            </div>
        </div>
        <label style="position:relative;display:inline-block;width:52px;height:28px;cursor:pointer;flex-shrink:0;">
            <input type="checkbox" name="testimonials_visible" value="1" {{ $testiVisible ? 'checked' : '' }}
                style="opacity:0;width:0;height:0;position:absolute;" id="testiVisibleCheckbox"
                onchange="updateTestiToggle(this.checked)">
            <span
                style="position:absolute;inset:0;border-radius:14px;background:{{ $testiVisible ? '#34d399' : 'rgba(100,116,139,.4)' }};transition:all .3s;cursor:pointer;"
                id="testiToggleTrack"></span>
            <span
                style="position:absolute;top:3px;{{ $testiVisible ? 'left:27px' : 'left:3px' }};width:22px;height:22px;border-radius:11px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:all .3s;"
                id="testiToggleKnob"></span>
        </label>
    </div>

    <div class="glass-card glass">
        <div class="cms-section-header" style="justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="cms-section-bar" style="background:linear-gradient(180deg,#818cf8,#c084fc);"></span>
                Testimoni
            </div>
            <button type="button" class="btn-secondary btn-sm" onclick="addTestimonial()">
                <x-icon name="plus" /> Tambah
            </button>
        </div>
        <div id="testimonialsContainer">
            @php
            $testiItems = old('testimonials', $landing->testimonials ?? [
            ['quote' => 'ClinicalLog membantu kami memantau perkembangan mahasiswa dengan jauh lebih cepat dan
            terstruktur.', 'name' => 'dr. Andi Prasetyo, Sp.PD', 'role' => 'Dosen Fakultas Kedokteran', 'img' =>
            'https://images.pexels.com/photos/5452293/pexels-photo-5452293.jpeg?auto=compress&cs=tinysrgb&w=400'],
            ['quote' => 'Dengan verifikasi digital dan monitoring real-time, aktivitas mahasiswa menjadi lebih
            transparan.', 'name' => 'dr. Maya Wulandari', 'role' => 'Dokter Pembimbing Klinik', 'img' =>
            'https://images.pexels.com/photos/8376281/pexels-photo-8376281.jpeg?auto=compress&cs=tinysrgb&w=400'],
            ['quote' => 'Aplikasi ini membuat pencatatan aktivitas jauh lebih praktis.', 'name' => 'Nadia Azzahra',
            'role' => 'Mahasiswa Kedokteran', 'img' =>
            'https://images.pexels.com/photos/27392533/pexels-photo-27392533.jpeg?auto=compress&cs=tinysrgb&w=400'],
            ]);
            @endphp
            @foreach ($testiItems as $i => $t)
            <div class="cms-repeater-item" data-index="{{ $i }}">
                <div class="cms-repeater-card">
                    <div class="cms-repeater-row" style="align-items:flex-start;">
                        <div style="flex:1;">
                            <label class="form-label">Nama</label>
                            <input type="text" name="testimonials[{{ $i }}][name]" class="form-input"
                                value="{{ $t['name'] ?? '' }}" placeholder="Nama lengkap...">
                        </div>
                        <div style="flex:1;">
                            <label class="form-label">Jabatan/Role</label>
                            <input type="text" name="testimonials[{{ $i }}][role]" class="form-input"
                                value="{{ $t['role'] ?? '' }}" placeholder="Jabatan...">
                        </div>
                        <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                            <button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">
                                <x-icon name="arrow-up" />
                            </button>
                            <button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">
                                <x-icon name="arrow-down" />
                            </button>
                            <button type="button" class="btn-icon danger cms-remove-btn"
                                onclick="confirmRemoveRepeaterItem(this, 'testimoni')" title="Hapus">
                                <x-icon name="trash-2" />
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:12px;">
                        <label class="form-label">Kutipan</label>
                        <textarea name="testimonials[{{ $i }}][quote]" class="form-input" style="min-height:70px;"
                            placeholder="Tuliskan kutipan testimoni...">{{ $t['quote'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Foto</label>

                        <input type="hidden" name="testimonials[{{ $i }}][img]" value="{{ $t['img'] ?? '' }}">

                        @if(!empty($t['img']) && !str_starts_with($t['img'], 'http'))
                        <div style="margin-bottom:10px;" id="currentTestiPhoto_{{ $i }}">
                            <div
                                style="display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:12px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);">
                                <img src="{{ asset('storage/' . $t['img']) }}" alt=""
                                    style="width:48px;height:48px;border-radius:10px;object-fit:cover;">
                                <div>
                                    <div style="font-size:12px;color:#94a3b8;">Foto saat ini</div>
                                </div>
                                <button type="button" class="btn-icon danger btn-sm" style="display:inline-flex;align-items:center;gap:6px;font-size:12px;padding:6px 12px;width:auto;margin-left:auto;" onclick="removeTestiPhotoInstant({{ $i }})">
                                    <x-icon name="trash-2" /> Hapus Foto
                                </button>
                            </div>
                            <input type="hidden" name="testimonials[{{ $i }}][delete_img]" id="delete_testi_img_{{ $i }}" value="0">
                        </div>
                        @elseif(!empty($t['img']))
                        <div
                            style="display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:12px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);margin-bottom:10px;" id="currentTestiPhoto_{{ $i }}">
                            <img src="{{ $t['img'] }}" alt=""
                                style="width:48px;height:48px;border-radius:10px;object-fit:cover;">
                            <div>
                                <div style="font-size:11px;color:#64748b;word-break:break-all;max-width:300px;">{{ $t['img'] }}</div>
                                <div style="font-size:11px;color:#94a3b8;margin-top:2px;">URL eksternal</div>
                            </div>
                            <button type="button" class="btn-icon danger btn-sm" style="display:inline-flex;align-items:center;gap:6px;font-size:12px;padding:6px 12px;width:auto;margin-left:auto;" onclick="removeTestiPhotoInstant({{ $i }})">
                                <x-icon name="trash-2" /> Hapus Foto
                            </button>
                            <input type="hidden" name="testimonials[{{ $i }}][delete_img]" id="delete_testi_img_{{ $i }}" value="0">
                        </div>
                        @else
                        <input type="hidden" name="testimonials[{{ $i }}][delete_img]" id="delete_testi_img_{{ $i }}" value="0">
                        @endif

                        <div class="upload-zone" style="cursor:pointer;"
                            onclick="document.getElementById('testi_img_{{ $i }}').click()">
                            <x-icon name="upload-cloud" style="margin:0 auto 8px;color:#38bdf8" class="block" />
                            <div style="font-size:12px;font-weight:600;color:#94a3b8;margin-bottom:2px;">Klik atau
                                drag & drop foto</div>
                            <div style="font-size:11px;color:#64748b;">JPG, PNG, WebP (maks 2MB)</div>
                            <div id="testiPreview_{{ $i }}" style="display:none;margin-top:8px;text-align:center;">
                                <img id="testiPreviewImg_{{ $i }}" src="" alt=""
                                    style="width:56px;height:56px;object-fit:cover;border-radius:10px;margin:0 auto;display:block;">
                                <div id="testiPreviewName_{{ $i }}"
                                    style="font-size:11px;color:#22d3ee;text-align:center;margin-top:4px;"></div>
                                <button type="button" class="btn-icon danger btn-sm" style="display:inline-flex;align-items:center;gap:4px;font-size:11px;padding:4px 8px;width:auto;margin:6px auto 0;" onclick="removeTestiPhotoInstant({{ $i }}); event.stopPropagation();">
                                    <x-icon name="trash-2" /> Hapus
                                </button>
                            </div>
                        </div>
                        <input type="file" id="testi_img_{{ $i }}" name="testimonials[{{ $i }}][img_file]"
                            accept=".jpg,.jpeg,.png,.webp" style="display:none;"
                            onchange="previewTestiImg(this, {{ $i }})">

                        <div style="margin-top:8px;font-size:11px;color:#64748b;">Atau masukkan URL:</div>
                        <input type="text" name="testimonials[{{ $i }}][img_url]" class="form-input"
                            value="{{ !empty($t['img']) && str_starts_with($t['img'], 'http') ? $t['img'] : '' }}"
                            placeholder="https://example.com/foto.jpg" style="margin-top:4px;">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
