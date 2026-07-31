/* ─── Core Utilities ─── */

function iconSvg(name, extra) {
    var cls = extra ? ' ' + extra : '';
    var p = '';
    switch (name) {
        case 'plus': p = '<path d="M12 5v14"/><path d="M5 12h14"/>'; break;
        case 'grip-vertical': p = '<path d="M9 5v2"/><path d="M9 11v2"/><path d="M9 17v2"/><path d="M15 5v2"/><path d="M15 11v2"/><path d="M15 17v2"/>'; break;
        case 'arrow-up': p = '<path d="M12 19V5"/><path d="M5 12l7-7 7 7"/>'; break;
        case 'arrow-down': p = '<path d="M12 5v14"/><path d="M19 12l-7 7-7-7"/>'; break;
        case 'trash-2': p = '<path d="M3 6h18"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>'; break;
        case 'loader-circle': p = '<path d="M21 12a9 9 0 11-6.22-8.56"/>'; break;
        case 'upload-cloud': p = '<path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><path d="M17 8l-5-5-5 5"/><path d="M12 3v12"/>'; break;
        case 'eye': p = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'; break;
        case 'eye-off': p = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>'; break;
        case 'check': p = '<polyline points="20 6 9 17 4 12"/>'; break;
        default: return '';
    }
    return '<svg class="' + cls + '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:1em;height:1em;display:inline-block;vertical-align:middle;">' + p + '</svg>';
}

function showToast(message, type, duration) {
    if (type === undefined) type = 'success';
    if (duration === undefined) duration = 4000;
    var container = document.getElementById('toastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'toast-container';
        document.body.appendChild(container);
    }
    var toast = document.createElement('div');
    toast.className = 'toast toast-' + type;
    var iconSvg = type === 'success'
        ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>'
        : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>';
    toast.innerHTML = iconSvg + '<span>' + message + '</span><button class="toast-close" onclick="dismissToast(this.parentElement)">&times;</button>';
    container.appendChild(toast);
    setTimeout(function () { dismissToast(toast); }, duration);
}

function dismissToast(el) {
    if (!el || el.classList.contains('toast-out')) return;
    el.classList.add('toast-out');
    el.addEventListener('animationend', function () { el.remove(); });
}

function dismissAlert(el) {
    if (!el || el.classList.contains('dismissing')) return;
    el.classList.add('dismissing');
    var removeAfter = function (e) {
        if (e.target !== el) return;
        el.removeEventListener('transitionend', removeAfter);
        el.remove();
    };
    el.addEventListener('transitionend', removeAfter);
}

function ajaxSubmit(form, options) {
    if (options === undefined) options = {};
    var method = form.method ? form.method.toUpperCase() : 'POST';
    var action = form.action;
    var formData = new FormData(form);
    var submitBtn = form.querySelector('[type="submit"]');
    var originalBtnHTML = submitBtn ? submitBtn.innerHTML : '';

    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="animation:spin 1s linear infinite"><path d="M21 12a9 9 0 1 1-6.22-8.56"/></svg> Menyimpan...';
    }

    fetch(action, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData
    })
        .then(function (response) {
            return response.json().then(function (data) {
                return { status: response.status, body: data };
            });
        })
        .then(function (res) {
            if (res.status >= 200 && res.status < 300 && res.body.success) {
                showToast(res.body.message || 'Berhasil disimpan!', 'success');
                if (options.onSuccess) options.onSuccess(res.body);
            } else if (res.body.errors) {
                var msgs = Object.values(res.body.errors).flat().join(', ');
                showToast(msgs, 'error', 6000);
                if (options.onError) options.onError(res.body);
            } else {
                showToast(res.body.message || 'Terjadi kesalahan.', 'error');
                if (options.onError) options.onError(res.body);
            }
        })
        .catch(function (err) {
            showToast('Koneksi gagal. Silakan coba lagi.', 'error');
            if (options.onError) options.onError(err);
        })
        .finally(function () {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHTML;
            }
            if (options.onComplete) options.onComplete();
        });
}

function ajaxAction(url, method, data, options) {
    if (options === undefined) options = {};
    var body = new FormData();
    body.append('_token', CSRF_TOKEN);
    if (method !== 'POST') body.append('_method', method);
    if (data) {
        Object.keys(data).forEach(function (key) {
            body.append(key, data[key]);
        });
    }

    fetch(url, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: body
    })
        .then(function (response) {
            return response.json().then(function (d) {
                return { status: response.status, body: d };
            });
        })
        .then(function (res) {
            if (res.status >= 200 && res.status < 300 && res.body.success) {
                if (!options.silent) showToast(res.body.message || 'Berhasil!', 'success');
                if (options.onSuccess) options.onSuccess(res.body);
            } else if (res.body.errors) {
                var msgs = Object.values(res.body.errors).flat().join(', ');
                showToast(msgs, 'error', 6000);
                if (options.onError) options.onError(res.body);
            } else {
                if (!options.silent) showToast(res.body.message || 'Terjadi kesalahan.', 'error');
                if (options.onError) options.onError(res.body);
            }
        })
        .catch(function (err) {
            showToast('Koneksi gagal. Silakan coba lagi.', 'error');
            if (options.onError) options.onError(err);
        });
}

/* ─── Sidebar ─── */

function toggleSidebar() {
    document.getElementById('admLayout').classList.toggle('sidebar-open');
    document.getElementById('admOverlay').classList.toggle('active');
}

function closeSidebar() {
    document.getElementById('admLayout').classList.remove('sidebar-open');
    document.getElementById('admOverlay').classList.remove('active');
}

function toggleLandingDropdown(e) {
    e.preventDefault();
    var wrapper = e.currentTarget.closest('.adm-nav-dropdown-wrapper');
    wrapper.classList.toggle('open');
    
}

/* ─── Appointments: Update Status ─── */

function updateAppointmentStatus(id, newStatus, selectEl) {
    var parent = selectEl.closest('.status-select');
    parent.style.opacity = '.5';
    ajaxAction(APP_URL + '/admin/appointments/' + id + '/status', 'PATCH', { status: newStatus }, {
        onSuccess: function () {
            parent.className = 'status-select ' + newStatus;
            parent.style.opacity = '';
            parent.querySelector('.status-text').textContent = {
                pending: 'Pending', done: 'Selesai', cancelled: 'Batal'
            }[newStatus];
        },
        onError: function () {
            parent.style.opacity = '';
            showToast('Gagal memperbarui status', 'error');
        }
    });
}

/* ─── Landing Page CMS ─── */

window._panelCache = {};

function hideSkeleton() {
    var s = document.querySelector('.adm-skeleton.active');
    if (s) s.classList.remove('active');
}

function switchTab(tabName) {
    document.querySelectorAll('.cms-panel').forEach(function (p) {
        p.style.display = 'none';
        p.classList.remove('cms-panel-animate');
    });
    var target = document.getElementById('panel-' + tabName);
    if (!target) { hideSkeleton(); return; }

    if (target.innerHTML.trim() !== '') {
        target.style.display = '';
        void target.offsetWidth;
        target.classList.add('cms-panel-animate');
        hideSkeleton();
        return;
    }

    target.innerHTML = '<div class="cms-panel-loading">Memuat...</div>';
    target.style.display = '';

    if (window._panelCache[tabName]) {
        target.innerHTML = window._panelCache[tabName];
        void target.offsetWidth;
        target.classList.add('cms-panel-animate');
        initPanelFeatures(tabName);
        hideSkeleton();
        return;
    }

    var timedOut = false;
    var timer = setTimeout(function () { timedOut = true; hideSkeleton(); }, 8000);

    fetch(APP_URL + '/admin/landing-page/panel/' + tabName, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
    })
    .then(function (r) { if (!r.ok) throw new Error(r.status); return r.text(); })
    .then(function (html) {
        if (timedOut) return;
        clearTimeout(timer);
        window._panelCache[tabName] = html;
        target.innerHTML = html;
        void target.offsetWidth;
        target.classList.add('cms-panel-animate');
        initPanelFeatures(tabName);
        hideSkeleton();
    })
    .catch(function () {
        clearTimeout(timer);
        target.innerHTML = '<div class="cms-panel-loading">Gagal memuat panel. <a href="javascript:void(0)" onclick="switchTab(\'' + tabName + '\')" style="color:#38bdf8;">Coba lagi</a></div>';
        hideSkeleton();
    });
}

function initPanelFeatures(tabName) {
    if (tabName === 'hero' || !tabName) {
        if (document.getElementById('hero_image')) {
            setupImagePreview('hero_image', 'heroPreview', 'heroPreviewImg', 'heroPreviewName', 'heroUploadZone');
            setupImagePreview('about_image', 'aboutPreview', 'aboutPreviewImg', 'aboutPreviewName', 'aboutUploadZone');
            setupImagePreview('dashboard_image', 'dashboardPreview', 'dashboardPreviewImg', 'dashboardPreviewName', 'dashboardUploadZone');
        }
    }
}

function goToLandingSection(sectionId) {
    if (window.location.href.indexOf('admin/landing-page') === -1) {
        window._landingTarget = sectionId;
        if (window._swup) {
            window._swup.navigate(APP_URL + '/admin/landing-page');
        } else {
            window.location.href = APP_URL + '/admin/landing-page/#' + sectionId;
        }
        return;
    }

    history.replaceState(null, null, '#' + sectionId);

    document.querySelectorAll('.adm-nav-sub-item').forEach(function (el) {
        el.classList.remove('active');
    });
    var activeItem = document.querySelector('.adm-nav-sub-item[data-section="' + sectionId + '"]');
    if (activeItem) activeItem.classList.add('active');

    if (typeof switchTab === 'function') {
        switchTab(sectionId);
    }
}

function initLandingPageCMS() {
    initPanelFeatures('hero');
    var target = window._landingTarget || window.location.hash.slice(1) || 'hero';
    delete window._landingTarget;
    goToLandingSection(target);
}

function setupImagePreview(inputId, previewBoxId, previewImgId, previewNameId, zoneId) {
    var input = document.getElementById(inputId);
    var previewBox = document.getElementById(previewBoxId);
    var previewImg = document.getElementById(previewImgId);
    var previewName = document.getElementById(previewNameId);
    var zone = document.getElementById(zoneId);

    if (!input || !zone) return;

    var newInput = input.cloneNode(true);
    input.parentNode.replaceChild(newInput, input);
    var newZone = zone.cloneNode(true);
    zone.parentNode.replaceChild(newZone, zone);

    newInput.addEventListener('change', function () {
        var file = newInput.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function (e) {
            previewImg.src = e.target.result;
            previewName.textContent = file.name;
            previewBox.style.display = '';
        };
        reader.readAsDataURL(file);
    });

    newZone.addEventListener('dragover', function (e) { e.preventDefault(); newZone.style.borderColor = 'rgba(56,189,248,.7)'; });
    newZone.addEventListener('dragleave', function () { newZone.style.borderColor = ''; });
    newZone.addEventListener('drop', function (e) {
        e.preventDefault();
        newZone.style.borderColor = '';
        if (e.dataTransfer.files.length) {
            newInput.files = e.dataTransfer.files;
            newInput.dispatchEvent(new Event('change'));
        }
    });
}

function previewTestiImg(input, idx) {
    var file = input.files[0];
    if (!file) return;

    var card = document.querySelector('[data-index="' + idx + '"]');
    if (card) {
        var urlInput = card.querySelector('input[name="testimonials[' + idx + '][img_url]"]');
        if (urlInput) urlInput.value = '';
    }

    var reader = new FileReader();
    reader.onload = function (e) {
        var box = document.getElementById('testiPreview_' + idx);
        var img = document.getElementById('testiPreviewImg_' + idx);
        var name = document.getElementById('testiPreviewName_' + idx);
        if (box && img && name) {
            img.src = e.target.result;
            name.textContent = file.name;
            box.style.display = '';
        }
    };
    reader.readAsDataURL(file);
}

function removeTestiPhotoInstant(idx) {
    var deleteInput = document.getElementById('delete_testi_img_' + idx);
    if (deleteInput) deleteInput.value = '1';

    var card = document.querySelector('[data-index="' + idx + '"]');
    if (card) {
        var hiddenImg = card.querySelector('input[name="testimonials[' + idx + '][img]"]');
        if (hiddenImg) hiddenImg.value = '';

        var urlInput = card.querySelector('input[name="testimonials[' + idx + '][img_url]"]');
        if (urlInput) urlInput.value = '';
    }

    var fileInput = document.getElementById('testi_img_' + idx);
    if (fileInput) fileInput.value = '';

    var previewBox = document.getElementById('testiPreview_' + idx);
    if (previewBox) {
        previewBox.style.display = 'none';
        var previewImg = document.getElementById('testiPreviewImg_' + idx);
        if (previewImg) previewImg.src = '';
    }

    var currentBox = document.getElementById('currentTestiPhoto_' + idx);
    if (currentBox) currentBox.style.display = 'none';
}

/* ─── Repeater Utilities ─── */

function reindexRepeater(containerElement) {
    var items = containerElement.querySelectorAll('.cms-repeater-item');
    items.forEach(function (item, index) {
        item.setAttribute('data-index', index);
        var inputs = item.querySelectorAll('input, textarea, select');
        inputs.forEach(function (input) {
            var name = input.getAttribute('name');
            if (name) {
                var newName = name.replace(/\[\d+\]/, '[' + index + ']');
                input.setAttribute('name', newName);
            }
        });
    });
}

function confirmRemoveRepeaterItem(btn, label) {
    var msg = label ? ('Hapus ' + label + ' ini?') : 'Hapus item ini?';
    if (!confirm(msg)) return;
    var item = btn.closest('.cms-repeater-item');
    var container = item.parentNode;
    item.style.transition = 'opacity .3s, transform .3s';
    item.style.opacity = '0';
    item.style.transform = 'translateX(-20px)';
    setTimeout(function () { item.remove(); reindexRepeater(container); }, 300);
}

function moveItemUp(btn) {
    var item = btn.closest('.cms-repeater-item');
    var prev = item.previousElementSibling;
    if (prev) {
        var parent = item.parentNode;
        parent.insertBefore(item, prev);
        reindexRepeater(parent);
    }
}

function moveItemDown(btn) {
    var item = btn.closest('.cms-repeater-item');
    var next = item.nextElementSibling;
    if (next) {
        var parent = item.parentNode;
        parent.insertBefore(next, item);
        reindexRepeater(parent);
    }
}

/* ─── Add Repeater Functions ─── */

function addNavLink() {
    var containerElement = document.getElementById('navLinksContainer');
    if (!containerElement) return;
    var navLinkIdx = containerElement.children.length;
    var html = '<div class="cms-repeater-item" data-index="' + navLinkIdx + '">' +
        '<div class="cms-repeater-row">' +
        '<div style="flex:1;"><label class="form-label">Label Menu</label>' +
        '<input type="text" name="navbar_links[' + navLinkIdx + '][label]" class="form-input" placeholder="Contoh: Beranda"></div>' +
        '<div style="flex:1.5;"><label class="form-label">Link Target (URL / Anchor ID)</label>' +
        '<input type="text" name="navbar_links[' + navLinkIdx + '][url]" class="form-input" placeholder="Contoh: #beranda"></div>' +
        '<div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">' +
        '<button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">' + iconSvg("arrow-up") + '</button>' +
        '<button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">' + iconSvg("arrow-down") + '</button>' +
        '<button type="button" class="btn-icon danger cms-remove-btn" onclick="confirmRemoveRepeaterItem(this, \'menu\')" title="Hapus">' + iconSvg("trash-2") + '</button>' +
        '</div></div></div>';
    containerElement.insertAdjacentHTML('beforeend', html);
    reindexRepeater(containerElement);
    showToast('Menu berhasil ditambahkan', 'success');
}

function addAboutPoint() {
    var containerElement = document.getElementById('aboutPointsContainer');
    if (!containerElement) return;
    var pointIdx = containerElement.children.length;
    var html = '<div class="cms-repeater-item" data-index="' + pointIdx + '">' +
        '<div class="cms-repeater-row">' +
        '<div style="flex:1;"><label class="form-label">Teks Poin</label>' +
        '<input type="text" name="about_points[' + pointIdx + '][text]" class="form-input" placeholder="Tuliskan keunggulan..."></div>' +
        '<div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">' +
        '<button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">' + iconSvg("arrow-up") + '</button>' +
        '<button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">' + iconSvg("arrow-down") + '</button>' +
        '<button type="button" class="btn-icon danger cms-remove-btn" onclick="confirmRemoveRepeaterItem(this, \'poin keunggulan\')" title="Hapus">' + iconSvg("trash-2") + '</button>' +
        '</div></div></div>';
    containerElement.insertAdjacentHTML('beforeend', html);
    reindexRepeater(containerElement);
    showToast('Poin keunggulan berhasil ditambahkan', 'success');
}

function addBenefit() {
    var containerElement = document.getElementById('benefitsContainer');
    if (!containerElement) return;
    var benefitIdx = containerElement.children.length;
    var html = '<div class="cms-repeater-item" data-index="' + benefitIdx + '">' +
        '<div class="cms-repeater-row">' +
        '<div style="width:120px;"><label class="form-label">Icon</label>' +
        '<input type="text" name="benefits[' + benefitIdx + '][icon]" class="form-input" placeholder="icon-name"></div>' +
        '<div style="flex:1;"><label class="form-label">Judul</label>' +
        '<input type="text" name="benefits[' + benefitIdx + '][title]" class="form-input" placeholder="Judul keunggulan..."></div>' +
        '<div style="flex:1.5;"><label class="form-label">Deskripsi</label>' +
        '<input type="text" name="benefits[' + benefitIdx + '][description]" class="form-input" placeholder="Deskripsi singkat..."></div>' +
        '<div style="width:100px;"><label class="form-label">Statistik</label>' +
        '<input type="text" name="benefits[' + benefitIdx + '][stat]" class="form-input" placeholder="cth: 10x lebih cepat"></div>' +
        '<div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">' +
        '<button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">' + iconSvg("arrow-up") + '</button>' +
        '<button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">' + iconSvg("arrow-down") + '</button>' +
        '<button type="button" class="btn-icon danger cms-remove-btn" onclick="confirmRemoveRepeaterItem(this, \'keunggulan\')" title="Hapus">' + iconSvg("trash-2") + '</button>' +
        '</div></div></div>';
    containerElement.insertAdjacentHTML('beforeend', html);
    reindexRepeater(containerElement);
    showToast('Keunggulan berhasil ditambahkan', 'success');
}

function addStep() {
    var containerElement = document.getElementById('stepsContainer');
    if (!containerElement) return;
    var stepIdx = containerElement.children.length;
    var html = '<div class="cms-repeater-item" data-index="' + stepIdx + '">' +
        '<div class="cms-repeater-row" style="align-items:flex-start;">' +
        '<div style="width:120px;"><label class="form-label">Icon</label>' +
        '<input type="text" name="steps[' + stepIdx + '][icon]" class="form-input" placeholder="icon-name"></div>' +
        '<div style="flex:1;"><label class="form-label">Judul</label>' +
        '<input type="text" name="steps[' + stepIdx + '][title]" class="form-input" placeholder="Judul langkah..."></div>' +
        '<div style="flex:1.5;"><label class="form-label">Deskripsi</label>' +
        '<input type="text" name="steps[' + stepIdx + '][desc]" class="form-input" placeholder="Deskripsi langkah..."></div>' +
        '<div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">' +
        '<button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">' + iconSvg("arrow-up") + '</button>' +
        '<button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">' + iconSvg("arrow-down") + '</button>' +
        '<button type="button" class="btn-icon danger cms-remove-btn" onclick="confirmRemoveRepeaterItem(this, \'langkah\')" title="Hapus">' + iconSvg("trash-2") + '</button>' +
        '</div></div></div>';
    containerElement.insertAdjacentHTML('beforeend', html);
    reindexRepeater(containerElement);
    showToast('Langkah berhasil ditambahkan', 'success');
}

function addTestimonial() {
    var containerElement = document.getElementById('testimonialsContainer');
    if (!containerElement) return;
    var testiIdx = containerElement.children.length;
    var html = '<div class="cms-repeater-item" data-index="' + testiIdx + '">' +
        '<div class="cms-repeater-card">' +
        '<div class="cms-repeater-row" style="align-items:flex-start;">' +
        '<div style="flex:1;"><label class="form-label">Nama</label>' +
        '<input type="text" name="testimonials[' + testiIdx + '][name]" class="form-input" placeholder="Nama lengkap..."></div>' +
        '<div style="flex:1;"><label class="form-label">Jabatan/Role</label>' +
        '<input type="text" name="testimonials[' + testiIdx + '][role]" class="form-input" placeholder="Jabatan..."></div>' +
        '<div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">' +
        '<button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">' + iconSvg("arrow-up") + '</button>' +
        '<button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">' + iconSvg("arrow-down") + '</button>' +
        '<button type="button" class="btn-icon danger cms-remove-btn" onclick="confirmRemoveRepeaterItem(this, \'testimoni\')" title="Hapus">' + iconSvg("trash-2") + '</button>' +
        '</div></div>' +
        '<div class="form-group" style="margin-top:12px;">' +
        '<label class="form-label">Kutipan</label>' +
        '<textarea name="testimonials[' + testiIdx + '][quote]" class="form-input" style="min-height:70px;" placeholder="Tuliskan kutipan testimoni..."></textarea></div>' +
        '<div class="form-group">' +
        '<label class="form-label">Foto</label>' +
        '<input type="hidden" name="testimonials[' + testiIdx + '][img]" value="">' +
        '<input type="hidden" name="testimonials[' + testiIdx + '][delete_img]" id="delete_testi_img_' + testiIdx + '" value="0">' +
        '<div class="upload-zone" style="cursor:pointer;" onclick="document.getElementById(\'testi_img_' + testiIdx + '\').click()">' +
        iconSvg("upload-cloud") +
        '<div style="font-size:12px;font-weight:600;color:#94a3b8;margin-bottom:2px;">Klik atau drag & drop foto</div>' +
        '<div style="font-size:11px;color:#64748b;">JPG, PNG, WebP (maks 2MB)</div>' +
        '<div id="testiPreview_' + testiIdx + '" style="display:none;margin-top:8px;text-align:center;">' +
        '<img id="testiPreviewImg_' + testiIdx + '" src="" alt="" style="width:56px;height:56px;object-fit:cover;border-radius:10px;margin:0 auto;display:block;">' +
        '<div id="testiPreviewName_' + testiIdx + '" style="font-size:11px;color:#22d3ee;text-align:center;margin-top:4px;"></div>' +
        '<button type="button" class="btn-icon danger btn-sm" style="display:inline-flex;align-items:center;gap:4px;font-size:11px;padding:4px 8px;width:auto;margin:6px auto 0;" onclick="removeTestiPhotoInstant(' + testiIdx + '); event.stopPropagation();">' +
        iconSvg("trash-2") + ' Hapus</button></div></div>' +
        '<input type="file" id="testi_img_' + testiIdx + '" name="testimonials[' + testiIdx + '][img_file]" accept=".jpg,.jpeg,.png,.webp" style="display:none;" onchange="previewTestiImg(this, ' + testiIdx + ')">' +
        '<div style="margin-top:8px;font-size:11px;color:#64748b;">Atau masukkan URL:</div>' +
        '<input type="text" name="testimonials[' + testiIdx + '][img_url]" class="form-input" placeholder="https://example.com/foto.jpg" style="margin-top:4px;">' +
        '</div></div></div>';
    containerElement.insertAdjacentHTML('beforeend', html);
    reindexRepeater(containerElement);
    showToast('Testimoni berhasil ditambahkan', 'success');
}

function addPricingPlan() {
    var containerElement = document.getElementById('pricingContainer');
    if (!containerElement) return;
    var pricingIdx = containerElement.children.length;
    var html = '<div class="cms-repeater-item" data-index="' + pricingIdx + '">' +
        '<div class="cms-repeater-card">' +
        '<div class="cms-repeater-row" style="align-items:flex-start;">' +
        '<div style="width:130px;"><label class="form-label">Tier</label>' +
        '<input type="text" name="pricing_plans[' + pricingIdx + '][tier]" class="form-input" placeholder="Starter"></div>' +
        '<div style="flex:1;"><label class="form-label">Nama Paket</label>' +
        '<input type="text" name="pricing_plans[' + pricingIdx + '][name]" class="form-input" placeholder="Department"></div>' +
        '<div style="width:160px;"><label class="form-label">Harga <span style="font-weight:400;color:#94a3b8;">(opsional)</span></label>' +
        '<input type="text" name="pricing_plans[' + pricingIdx + '][price]" class="form-input" placeholder="Rp25 Juta">' +
        '<div style="font-size:11px;color:#94a3b8;margin-top:4px;">Kosongkan &rarr; tampil &ldquo;Hubungi Kami&rdquo;</div></div>' +
        '<div style="width:80px;text-align:center;"><label class="form-label">Populer</label>' +
        '<div style="padding-top:8px;"><input type="checkbox" name="pricing_plans[' + pricingIdx + '][featured]" value="1" style="width:18px;height:18px;accent-color:#2563eb;"></div></div>' +
        '<div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">' +
        '<button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">' + iconSvg("arrow-up") + '</button>' +
        '<button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">' + iconSvg("arrow-down") + '</button>' +
        '<button type="button" class="btn-icon danger cms-remove-btn" onclick="confirmRemoveRepeaterItem(this, \'paket harga\')" title="Hapus">' + iconSvg("trash-2") + '</button>' +
        '</div></div>' +
        '<div class="form-group" style="margin-top:12px;">' +
        '<label class="form-label">Fitur (satu per baris)</label>' +
        '<textarea name="pricing_plans[' + pricingIdx + '][features_text]" class="form-input" style="min-height:90px;" placeholder="Fitur 1&#10;Fitur 2&#10;Fitur 3"></textarea></div></div></div>';
    containerElement.insertAdjacentHTML('beforeend', html);
    reindexRepeater(containerElement);
    showToast('Paket harga berhasil ditambahkan', 'success');
}

function addSocialLink() {
    var containerElement = document.getElementById('socialLinksContainer');
    if (!containerElement) return;
    var linkIdx = containerElement.children.length;
    var html = '<div class="cms-repeater-item" data-index="' + linkIdx + '">' +
        '<div class="cms-repeater-row">' +
        '<div style="flex:1;"><label class="form-label">Platform Sosial Media</label>' +
        '<select name="social_links[' + linkIdx + '][platform]" class="form-input">' +
        '<option value="linkedin">LinkedIn</option>' +
        '<option value="instagram">Instagram</option>' +
        '<option value="youtube">YouTube</option>' +
        '<option value="facebook">Facebook</option>' +
        '<option value="twitter">Twitter / X</option>' +
        '<option value="tiktok">TikTok</option>' +
        '<option value="whatsapp">WhatsApp</option>' +
        '<option value="globe">Website / Globe</option></select></div>' +
        '<div style="flex:2;"><label class="form-label">URL Profil Lengkap</label>' +
        '<input type="text" name="social_links[' + linkIdx + '][url]" class="form-input" placeholder="Masukkan Link"></div>' +
        '<div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">' +
        '<button type="button" class="btn-icon" onclick="moveItemUp(this)" title="Naik">' + iconSvg("arrow-up") + '</button>' +
        '<button type="button" class="btn-icon" onclick="moveItemDown(this)" title="Turun">' + iconSvg("arrow-down") + '</button>' +
        '<button type="button" class="btn-icon danger cms-remove-btn" onclick="confirmRemoveRepeaterItem(this, \'sosial media\')" title="Hapus">' + iconSvg("trash-2") + '</button>' +
        '</div></div></div>';
    containerElement.insertAdjacentHTML('beforeend', html);
    reindexRepeater(containerElement);
    showToast('Tautan sosial media berhasil ditambahkan', 'success');
}

/* ─── Toggle Visibility (defined in toggles.js) ─── */

/* ─── Appointment Management ─── */

function deleteAppointment(url, btn) {
    if (!confirm('Apakah Anda yakin ingin menghapus appointment ini?')) return;
    var row = btn.closest('tr');
    ajaxAction(url, 'DELETE', {}, {
        onSuccess: function () {
            if (row) {
                row.style.transition = 'opacity .3s, transform .3s';
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';
                setTimeout(function () { row.remove(); }, 300);
            }
        }
    });
}

function copyAppointmentInfo(info, btn) {
    var text = 'Detail Pengajuan Demo ClinicalLog:\n' +
        'Nama: ' + info.name + '\n' +
        'Institusi: ' + info.institution + '\n' +
        'WhatsApp: ' + info.whatsapp + '\n' +
        'Email: ' + info.email + '\n' +
        'Jadwal: ' + info.date + ', Pukul ' + info.time + ' WIB\n' +
        'Catatan: ' + info.notes;

    navigator.clipboard.writeText(text).then(function () {
        showToast('Info pemohon berhasil disalin!', 'success');
        var icon = btn.querySelector('i');
        if (icon) {
            var origHTML = icon.innerHTML;
            icon.innerHTML = iconSvg('check');
            icon.style.color = '#34d399';
            setTimeout(function () {
                icon.innerHTML = origHTML;
                icon.style.color = '';
            }, 2000);
        }
    }).catch(function (err) {
        showToast('Gagal menyalin info', 'error');
    });
}

/* ─── Real-Time Appointment Polling ─── */

window._lastAppointmentId = 0;
window._lastPendingCount = 0;

window.pollAppointments = function pollAppointments() {
    fetch('/admin/appointments/realtime-status', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (data.pending_count !== undefined) {
                var badge = document.getElementById('appointmentsBadge');
                if (badge) {
                    badge.textContent = data.pending_count;
                    badge.style.display = data.pending_count > 0 ? '' : 'none';
                }

                if (data.latest_id > window._lastAppointmentId) {
                    showToast('Ada appointment baru masuk!', 'success');

                    var tableBody = document.getElementById('appointments-table-body');
                    if (tableBody) {
                        fetch(window.location.href, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        })
                            .then(function (res) { return res.text(); })
                            .then(function (html) {
                                var parser = new DOMParser();
                                var doc = parser.parseFromString(html, 'text/html');
                                var newTableBody = doc.getElementById('appointments-table-body');
                                if (newTableBody) {
                                    tableBody.innerHTML = newTableBody.innerHTML;
                                    

                                    var firstRow = tableBody.querySelector('tr');
                                    if (firstRow) {
                                        firstRow.style.backgroundColor = 'rgba(52, 211, 153, 0.1)';
                                        firstRow.style.transition = 'background-color 1s ease';
                                        setTimeout(function () {
                                            firstRow.style.backgroundColor = '';
                                        }, 2000);
                                    }
                                }
                            })
                            .catch(function (err) { console.warn('[Realtime] Table refresh failed:', err); });
                    }
                }

                window._lastAppointmentId = data.latest_id;
                window._lastPendingCount = data.pending_count;
            }
        })
        .catch(function (err) { console.warn('[Realtime] Polling failed:', err); });
};

/* ─── Feature Management ─── */

function autoSaveFeature(input) {
    var id = input.dataset.id;
    var field = input.dataset.field;
    var value = input.value;
    var data = { _method: 'PUT' };
    data[field] = value;
    ajaxAction('/admin/features/' + id, 'POST', data, {
        silent: true,
        onError: function (res) {
            if (res && res.errors) {
                var msgs = Object.values(res.errors).flat().join(', ');
                showToast(msgs, 'error', 6000);
            }
        }
    });
}

function addFeatureItem() {
    ajaxAction(APP_URL + '/admin/features', 'POST', {
        title: '',
        description: ''
    }, {
        onSuccess: function (res) {
            if (res && res.feature) {
                var feature = res.feature;
                var container = document.getElementById('featuresContainer');
                if (!container) return;
                var html = '<div class="cms-repeater-item cms-sortable-item" data-id="' + feature.id + '" data-sort="' + feature.sort_order + '">' +
                    '<div class="cms-repeater-row">' +
                    '<div style="width:130px;flex-shrink:0;"><input type="text" class="form-input" value="' + (feature.icon_name || '') + '" placeholder="icon-name" data-field="icon_name" data-id="' + feature.id + '" oninput="this.dataset.dirty=\'1\'" onblur="autoSaveFeature(this)"></div>' +
                    '<div style="flex:1;min-width:120px;"><input type="text" class="form-input" value="' + feature.title + '" placeholder="Nama fitur..." data-field="title" data-id="' + feature.id + '" oninput="this.dataset.dirty=\'1\'" onblur="autoSaveFeature(this)"></div>' +
                    '<div style="flex:1.5;min-width:160px;"><input type="text" class="form-input" value="' + feature.description + '" placeholder="Deskripsi..." data-field="description" data-id="' + feature.id + '" oninput="this.dataset.dirty=\'1\'" onblur="autoSaveFeature(this)"></div>' +
                    '<div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">' +
                    '<button type="button" class="btn-icon" onclick="moveFeatureUp(this)">' + iconSvg("arrow-up") + '</button>' +
                    '<button type="button" class="btn-icon" onclick="moveFeatureDown(this)">' + iconSvg("arrow-down") + '</button>' +
                    '<button type="button" class="btn-icon danger" onclick="deleteFeatureItem(this, ' + feature.id + ')">' + iconSvg("trash-2") + '</button>' +
                    '</div></div></div>';
                container.insertAdjacentHTML('beforeend', html);
            }
        },
        onError: function () {
            showToast('Gagal menambahkan fitur baru', 'error');
        }
    });
}

function deleteFeatureItem(btn, id) {
    if (!id) { confirmRemoveRepeaterItem(btn, 'fitur'); return; }
    if (!confirm('Hapus fitur ini?')) return;
    var item = btn.closest('.cms-repeater-item');
    ajaxAction(APP_URL + '/admin/features/' + id, 'DELETE', {}, {
        onSuccess: function () {
            item.style.transition = 'opacity .3s, transform .3s';
            item.style.opacity = '0';
            item.style.transform = 'translateX(-20px)';
            setTimeout(function () { item.remove(); }, 300);
        },
        onError: function () {
            showToast('Gagal menghapus fitur', 'error');
        }
    });
}

function moveFeatureUp(btn) {
    var item = btn.closest('.cms-repeater-item');
    var prev = item.previousElementSibling;
    if (prev) { item.parentNode.insertBefore(item, prev); saveFeatureSortOrder(); }
}

function moveFeatureDown(btn) {
    var item = btn.closest('.cms-repeater-item');
    var next = item.nextElementSibling;
    if (next) { next.parentNode.insertBefore(next, item); saveFeatureSortOrder(); }
}

function saveFeatureSortOrder() {
    var items = document.querySelectorAll('#featuresContainer .cms-sortable-item');
    var ids = [];
    items.forEach(function (el) {
        var id = el.dataset.id;
        if (id && id !== 'new') ids.push(id);
    });
    if (ids.length === 0) return;
    ajaxAction('/admin/features/sort-order', 'POST', { ids: ids }, {
        onError: function () { showToast('Gagal menyimpan urutan', 'error'); }
    });
}

/* ─── Smooth Hash Link Scrolling ─── */

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            var href = link.getAttribute('href');
            if (!href || href.length < 2) return;
            var targetId = href.substring(1);
            var targetEl = document.getElementById(targetId);
            if (targetEl) {
                e.preventDefault();
                targetEl.scrollIntoView({ behavior: 'smooth' });
                history.pushState(null, '', href);
            }
        });
    });
    if (window.location.hash) {
        var targetId = window.location.hash.substring(1);
        var targetEl = document.getElementById(targetId);
        if (targetEl) {
            setTimeout(function () {
                targetEl.scrollIntoView({ behavior: 'smooth' });
            }, 150);
        }
    }
});

/* ─── Status Dropdown: Close on outside click ─── */
/* ─── Global Submit: Landing Page Form ─── */

document.addEventListener('submit', function (e) {
    if (e.target && e.target.id === 'landingPageForm') {
        e.preventDefault();
        document.querySelectorAll('#featuresContainer input[data-dirty="1"]').forEach(function (el) {
            autoSaveFeature(el);
            delete el.dataset.dirty;
        });
        ajaxSubmit(e.target, {
            onSuccess: function () {}
        });
    }
});

/* ─── DOMContentLoaded Initialization ─── */

function updateSidebarActive() {
    var path = window.location.pathname.replace(/\/+$/, '');
    var landingWrapper = document.querySelector('.adm-nav-dropdown-wrapper');
    if (landingWrapper) {
        var landingParent = landingWrapper.querySelector('.adm-nav-item');
        if (path.indexOf('/admin/landing') > -1) {
            landingWrapper.classList.add('open');
            if (landingParent) landingParent.classList.add('active');
        } else {
            landingWrapper.classList.remove('open');
            if (landingParent) landingParent.classList.remove('active');
            landingWrapper.querySelectorAll('.adm-nav-sub-item.active').forEach(function(el) {
                el.classList.remove('active');
            });
        }
    }
    document.querySelectorAll('.adm-nav-item').forEach(function(item) {
        item.classList.remove('active');
    });
    document.querySelectorAll('.adm-nav-item').forEach(function(item) {
        var href = item.getAttribute('href');
        if (!href || href === '#') return;
        var linkPath = href.replace(/^https?:\/\/[^\/]+/, '');
        if (linkPath === '') linkPath = '/';
        if (linkPath === path || (linkPath !== '/' && path.startsWith(linkPath + '/'))) {
            item.classList.add('active');
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    var navProgress = document.getElementById('navProgress');
    var swupEl = document.getElementById('swup');
    
    if (swupEl && typeof Swup !== 'undefined') {
        window._swup = new Swup({
            containers: ['#swup'],
            animateHistoryBrowsing: true,
            ignoreVisit: function(url) { return url.includes('/realtime-status'); }
        });

        window._swup.hooks.on('link:click', function() {
            if (navProgress) {
                navProgress.style.opacity = '1';
                navProgress.style.width = '20%';
            }
        });

        window._swup.hooks.on('content:replace', function() {
            if (navProgress) navProgress.style.width = '60%';
            var toastContainer = document.getElementById('toastContainer');
            if (toastContainer) toastContainer.innerHTML = '';
        });

        window._swup.hooks.on('page:view', function() {
            if (navProgress) {
                navProgress.style.width = '100%';
                setTimeout(function() {
                    navProgress.style.opacity = '0';
                    navProgress.style.width = '0';
                }, 400);
            }
            updateSidebarActive();
            var clockEl = document.getElementById('headerTime');
            if (clockEl) {
                clockEl.textContent = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            }
            window.scrollTo({ top: 0, behavior: 'smooth' });
            if (window.location.pathname.indexOf('/admin/landing-page') > -1 && typeof initLandingPageCMS === 'function') {
                try { initLandingPageCMS(); } catch(e) {}
            }
            ['flashSuccess', 'flashError'].forEach(function (id) {
                var el = document.getElementById(id);
                if (el) setTimeout(function () { dismissAlert(el); }, 4000);
            });
            if (window.location.pathname.indexOf('/admin/appointments') > -1) {
                if (typeof window.pollAppointments === 'function') window.pollAppointments();
            }
        });
    }

    updateSidebarActive();

    var clockEl = document.getElementById('headerTime');
    function tick() {
        if (!clockEl) return;
        var now = new Date();
        clockEl.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    }
    tick();
    setInterval(tick, 30000);

    ['flashSuccess', 'flashError'].forEach(function (id) {
        var el = document.getElementById(id);
        if (el) setTimeout(function () { dismissAlert(el); }, 4000);
    });

    if (window.location.href.indexOf('admin/landing') > -1) {
        var wrapper = document.querySelector('.adm-nav-dropdown-wrapper');
        if (wrapper) wrapper.classList.add('open');
        var hash = window.location.hash.slice(1);
        if (hash) {
            var activeItem = document.querySelector('.adm-nav-sub-item[data-section="' + hash + '"]');
            if (activeItem) activeItem.classList.add('active');
            if (typeof switchTab === 'function') switchTab(hash);
        }
    }

    if (window.location.pathname.indexOf('/admin/appointments') > -1) {
        window.pollAppointments();
        if (!window._appointmentPollingInterval) {
            window._appointmentPollingInterval = setInterval(window.pollAppointments, 15000);
        }
    }

    document.querySelectorAll('.adm-nav a[href^="' + APP_URL + '/admin"], .adm-nav a[href^="/admin"]').forEach(function (a) {
        var t;
        a.addEventListener('mouseenter', function () {
            t = setTimeout(function () {
                if (!a.dataset.pf) { a.dataset.pf = '1'; fetch(a.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } }); }
            }, 80);
        });
        a.addEventListener('mouseleave', function () { clearTimeout(t); });
    });

    var adminPages = ['/admin/dashboard','/admin/landing-page','/admin/appointments','/admin/users'].filter(function(u){return window.location.pathname!==u});
    setTimeout(function () {
        adminPages.forEach(function(u){
            fetch(u,{headers:{'X-Requested-With':'XMLHttpRequest','Accept':'text/html'}}).then(function(r){
                if (r.ok) r.text().then(function(h){
                    if (window._swup && window._swup.cache && typeof window._swup.cache.cacheUrl === 'function') {
                        window._swup.cache.cacheUrl(u, h);
                    }
                });
            });
        });
    }, 2000);
});

document.addEventListener('click', function (e) {
    var link = e.target.closest('.adm-nav-item[href], .adm-nav-sub-item[href]');
    if (!link) return;
    var href = link.getAttribute('href');
    if (!href || href === '#') return;
    var cur = window.location.pathname.replace(/\/+$/, '');
    var lk = href.replace(/^https?:\/\/[^\/]+/, '').replace(/\/+$/, '');
    if (lk === cur) {
        e.preventDefault();
        e.stopPropagation();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}, true);


