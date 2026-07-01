
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// ─── Swup — SPA-like Page Transitions ───
import Swup from 'swup';

// ─── Sidebar active state — berdasarkan URL ───
function updateSidebarActive() {
    // Normalize path: remove trailing slash and query strings
    var path = window.location.pathname.replace(/\/+$/, '');

    // Mapping: href → apakah path cocok
    // Dashboard: exact match `/admin/dashboard`
    // Appointment: exact match `/admin/appointments` atau sub-path `/admin/appointments/...`
    // Users: exact match `/admin/users` atau sub-path `/admin/users/...`
    function isExactOrSubPath(href) {
        if (href === '#') return false;
        if (href === '/') return path === '';
        if (path === href) return true;
        // Match sub-pages like /admin/appointments/5
        if (href !== '/' && path.startsWith(href + '/')) return true;
        return false;
    }

    document.querySelectorAll('.adm-nav-item').forEach(function(item) {
        var href = item.getAttribute('href');
        if (href && href !== '#') {
            if (isExactOrSubPath(href)) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        }
    });

    // Landing Page dropdown wrapper
    var landingWrapper = document.querySelector('.adm-nav-dropdown-wrapper');
    if (landingWrapper) {
        var onLandingPage = path.indexOf('/admin/landing') > -1;
        if (onLandingPage) {
            landingWrapper.classList.add('open');
            var parentItem = landingWrapper.querySelector('.adm-nav-item');
            if (parentItem) parentItem.classList.add('active');
        } else {
            landingWrapper.classList.remove('open');
            var parentItem = landingWrapper.querySelector('.adm-nav-item');
            if (parentItem) parentItem.classList.remove('active');
        }
    }
}

// ─── Swup setup ───
document.addEventListener('DOMContentLoaded', function () {
    // Initial active — override Blade jika ada kesalahan
    updateSidebarActive();

    const swup = new Swup({
        containers: ['#swup'],
        animateHistoryBrowsing: true,
    });

    // ─── Re-init after each page transition ───
    swup.on('contentReplaced', function () {
        updateSidebarActive();

        // Re-run Lucide icons
        if (window.lucide) lucide.createIcons();

        // Re-init Alpine (if any new components)
        if (window.Alpine) Alpine.initTree(document.getElementById('swup'));

        // Re-init header clock
        var clockEl = document.getElementById('headerTime');
        if (clockEl) {
            var now = new Date();
            clockEl.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }

        // Re-init flash alert dismiss (re-attach click handler)
        var flashAlert = document.getElementById('flashAlert');
        if (flashAlert && !flashAlert.dataset.handlerAttached) {
            flashAlert.dataset.handlerAttached = '1';
            var closeBtn = flashAlert.querySelector('.adm-alert-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    flashAlert.classList.add('dismissing');
                    setTimeout(function () { flashAlert.remove(); }, 350);
                });
            }
        }

        // Scroll to top smoothly
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
