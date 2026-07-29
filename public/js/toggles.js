/* ─── Toggle Visibility (standalone, independent of admin.js) ─── */

var _togglePaths = {
    eye: ['M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z', 'M12 9a3 3 0 100 6 3 3 0 000-6z'],
    'eye-off': ['M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94', 'M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19', 'M1 1l22 22']
};

function _setSvgPaths(svgEl, name) {
    if (!svgEl) return;
    while (svgEl.firstChild) svgEl.removeChild(svgEl.firstChild);
    var paths = _togglePaths[name];
    if (paths) {
        for (var i = 0; i < paths.length; i++) {
            var p = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            p.setAttribute('d', paths[i]);
            svgEl.appendChild(p);
        }
    }
}

function updateToggleGeneric(sectionName, isChecked, activeTitle, inactiveTitle, activeDesc, inactiveDesc) {
    var box = document.getElementById(sectionName + 'ToggleBox');
    if (!box) return;
    var iconBox = document.getElementById(sectionName + 'ToggleIconBox');
    var icon = document.getElementById(sectionName + 'ToggleIcon');
    var title = document.getElementById(sectionName + 'ToggleTitle');
    var desc = document.getElementById(sectionName + 'ToggleDesc');
    var track = document.getElementById(sectionName + 'ToggleTrack');
    var knob = document.getElementById(sectionName + 'ToggleKnob');

    if (isChecked) {
        box.style.borderColor = 'rgba(52,211,153,.25)';
        box.style.background = 'rgba(52,211,153,.06)';
        iconBox.style.background = 'rgba(52,211,153,.15)';
        _setSvgPaths(icon, 'eye');
        icon.style.color = '#34d399';
        title.textContent = activeTitle;
        desc.textContent = activeDesc;
        track.style.background = '#34d399';
        knob.style.left = '27px';
    } else {
        box.style.borderColor = 'rgba(248,113,113,.25)';
        box.style.background = 'rgba(248,113,113,.06)';
        iconBox.style.background = 'rgba(248,113,113,.15)';
        _setSvgPaths(icon, 'eye-off');
        icon.style.color = '#f87171';
        title.textContent = inactiveTitle;
        desc.textContent = inactiveDesc;
        track.style.background = 'rgba(100,116,139,.4)';
        knob.style.left = '3px';
    }
}

function updateTestiToggle(isChecked) {
    updateToggleGeneric('testi', isChecked, 'Testimoni Aktif', 'Testimoni Nonaktif', 'Seksi testimoni ditampilkan di landing page dan navigasi.', 'Seksi testimoni disembunyikan dari landing page dan navigasi.');
}

function updateAboutToggle(isChecked) {
    updateToggleGeneric('about', isChecked, 'Seksi Tentang Aktif', 'Seksi Tentang Nonaktif', 'Seksi tentang kami ditampilkan di landing page dan navigasi.', 'Seksi tentang kami disembunyikan dari landing page dan navigasi.');
}

function updateFeaturesToggle(isChecked) {
    updateToggleGeneric('features', isChecked, 'Seksi Fitur Aktif', 'Seksi Fitur Nonaktif', 'Seksi fitur unggulan ditampilkan di landing page dan navigasi.', 'Seksi fitur unggulan disembunyikan dari landing page dan navigasi.');
}

function updateBenefitsToggle(isChecked) {
    updateToggleGeneric('benefits', isChecked, 'Seksi Keunggulan Aktif', 'Seksi Keunggulan Nonaktif', 'Seksi keunggulan ditampilkan di landing page.', 'Seksi keunggulan disembunyikan dari landing page.');
}

function updateDashboardToggle(isChecked) {
    updateToggleGeneric('dashboard', isChecked, 'Seksi Dashboard Aktif', 'Seksi Dashboard Nonaktif', 'Seksi dashboard preview ditampilkan di landing page dan navigasi.', 'Seksi dashboard preview disembunyikan dari landing page dan navigasi.');
}

function updateStepsToggle(isChecked) {
    updateToggleGeneric('steps', isChecked, 'Seksi Cara Kerja Aktif', 'Seksi Cara Kerja Nonaktif', 'Seksi alur/cara kerja ditampilkan di landing page dan navigasi.', 'Seksi alur/cara kerja disembunyikan dari landing page dan navigasi.');
}

function updatePricingToggle(isChecked) {
    updateToggleGeneric('pricing', isChecked, 'Seksi Paket Harga Aktif', 'Seksi Paket Harga Nonaktif', 'Seksi paket harga ditampilkan di landing page dan navigasi.', 'Seksi paket harga disembunyikan dari landing page dan navigasi.');
}

function updateCtaToggle(isChecked) {
    updateToggleGeneric('cta', isChecked, 'Seksi CTA Aktif', 'Seksi CTA Nonaktif', 'Seksi CTA ditampilkan di landing page.', 'Seksi CTA disembunyikan dari landing page.');
}

function updateNavbarToggle(isChecked) {
    updateToggleGeneric('navbar', isChecked, 'Navbar Aktif', 'Navbar Nonaktif', 'Navbar ditampilkan di landing page.', 'Navbar disembunyikan dari landing page.');
}
