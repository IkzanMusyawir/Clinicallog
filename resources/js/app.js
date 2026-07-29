import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Swup from 'swup';

function updateSidebarActive() {
    var path = window.location.pathname.replace(/\/+$/, '');
    document.querySelectorAll('.adm-nav-item').forEach(function(item) {
        item.classList.remove('active');
    });
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
    var pathMatch = null;
    document.querySelectorAll('.adm-nav-item').forEach(function(item) {
        var href = item.getAttribute('href');
        if (!href || href === '#') return;
        var linkPath = href.replace(/^https?:\/\/[^\/]+/, '');
        if (linkPath === '') linkPath = '/';
        if (linkPath === path || (linkPath !== '/' && path.startsWith(linkPath + '/'))) {
            pathMatch = item;
        }
    });
    if (pathMatch && !pathMatch.classList.contains('active')) {
        pathMatch.classList.add('active');
    }
}

function domReady(fn) {
    if (document.readyState !== 'loading') { fn(); }
    else { document.addEventListener('DOMContentLoaded', fn); }
}
domReady(updateSidebarActive);

document.addEventListener('DOMContentLoaded', function () {
    updateSidebarActive();

    const swup = new Swup({
        containers: ['#swup'],
        animateHistoryBrowsing: true,
        ignoreVisit: (url) => url.includes('/realtime-status'),
    });
    window._swup = swup;

    // ─── Swup Hover & Eager Preloader for Admin Navigation ───
    function preloadUrl(url) {
        if (!url || url === '#' || url.startsWith('javascript:') || url.includes('logout') || url.includes('realtime-status')) return;
        const cleanUrl = url.split('#')[0];
        if (swup.cache.has(cleanUrl)) return;
        
        fetch(cleanUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            swup.cache.set(cleanUrl, {
                url: cleanUrl,
                html: html
            });
            // Seed for all section hashes so that clicking any sidebar sub-menu is instant
            if (cleanUrl.includes('landing-page')) {
                const hashes = ['#hero', '#navigation', '#about', '#features', '#benefits', '#dashboard_tab', '#steps', '#testimonials', '#pricing', '#cta', '#footer'];
                hashes.forEach(hash => {
                    swup.cache.set(cleanUrl + hash, {
                        url: cleanUrl + hash,
                        html: html
                    });
                });
            }
        })
        .catch(err => console.warn('[Preload] Failed to preload:', cleanUrl, err));
    }

    function initHoverPreload() {
        document.querySelectorAll('.adm-nav-item, .adm-nav-sub-item').forEach(link => {
            let targetUrl = link.getAttribute('href');
            if (!targetUrl || targetUrl === '#') {
                if (link.classList.contains('adm-nav-sub-item') && link.dataset.section) {
                    targetUrl = '/admin/landing-page';
                } else {
                    return;
                }
            }
            
            const triggerPreload = () => {
                preloadUrl(targetUrl);
            };
            
            link.addEventListener('mouseenter', triggerPreload, { once: true });
            link.addEventListener('touchstart', triggerPreload, { once: true });
        });
    }

    function eagerPreloadAdminPages() {
        const pagesToPreload = [
            '/admin/landing-page',
            '/admin/appointments',
            '/admin/users',
            '/admin/dashboard'
        ];
        pagesToPreload.forEach((page, index) => {
            setTimeout(() => {
                preloadUrl(page);
            }, 1000 + (index * 250));
        });
    }

    // Intercept mutative fetch requests to clear Swup cache and ensure fresh data
    if (!window._fetchIntercepted) {
        window._fetchIntercepted = true;
        const originalFetch = window.fetch;
        window.fetch = function(...args) {
            const options = args[1];
            if (options && options.method && ['POST', 'PUT', 'DELETE', 'PATCH'].includes(options.method.toUpperCase())) {
                if (window._swup && window._swup.cache) {
                    window._swup.cache.clear();
                }
            }
            return originalFetch.apply(this, args);
        };
    }

    initHoverPreload();
    eagerPreloadAdminPages();
    swup.hooks.on('page:view', () => {
        initHoverPreload();
        eagerPreloadAdminPages();
    });

    var navProgress = document.getElementById('navProgress');

    // ─── Before content replace: cleanup + loading bar ───
    swup.hooks.on('content:replace', function () {
        try {
            if (navProgress) {
                navProgress.style.opacity = '1';
                navProgress.style.width = '60%';
            }
            var toastContainer = document.getElementById('toastContainer');
            if (toastContainer) toastContainer.innerHTML = '';
            // Close any open status dropdowns before Swup swaps the content
            document.querySelectorAll('.status-dropdown.open').forEach(function(d) {
                d.classList.remove('open');
                var m = document.querySelector('.status-menu[data-dropdown-id="' + d.dataset.id + '"]');
                if (m) { m.classList.remove('open'); d.appendChild(m); }
            });
        } catch (e) {
            console.warn('[Swup] Cleanup error:', e);
        }
    });

    // ─── After page view: update UI + complete loading ───
    swup.hooks.on('page:view', function () {
        try {
            if (navProgress) {
                navProgress.style.width = '100%';
                setTimeout(function() {
                    navProgress.style.opacity = '0';
                    navProgress.style.width = '0';
                }, 400);
            }
            updateSidebarActive();
            if (window.lucide) lucide.createIcons();
            var swupEl = document.getElementById('swup');
            if (window.Alpine && swupEl && swupEl.querySelector('[x-data]')) {
                Alpine.initTree(swupEl);
            }
            var breadcrumbEl = document.querySelector('.adm-breadcrumb-current');
            if (breadcrumbEl && document.title) {
                breadcrumbEl.textContent = document.title.split(' — ')[0];
            }
            var clockEl = document.getElementById('headerTime');
            if (clockEl) {
                clockEl.textContent = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            }
            window.scrollTo({ top: 0, behavior: 'smooth' });

            // ─── Init Landing Page CMS after Swup navigation ───
            if (typeof initLandingPageCMS === 'function') {
                try { initLandingPageCMS(); } catch(e) { console.warn('[Landing CMS]', e); }
            }
        } catch (e) {
            console.warn('[Swup] Page view error:', e);
        }
        // Re-seed last appointment ID so badge stays accurate after navigation
        if (window.pollAppointments) {
            window.pollAppointments();
        }
    });

    // ─── Initial Page Load Initialization ───
    if (typeof initLandingPageCMS === 'function') {
        try { initLandingPageCMS(); } catch(e) {}
    }
});
