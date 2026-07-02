/*!
 * ABC Nepal TV — Header Navigation
 * File: header-nav.js
 * Enqueue via functions.php (in footer, defer):
 *   wp_enqueue_script('abc-header-nav', get_template_directory_uri().'/header-nav.js', array(), null, true);
 */
(function () {
    'use strict';

    /* ── Wait for DOM ── */
    document.addEventListener('DOMContentLoaded', function () {

        /* ── Elements ── */
        var btn  = document.getElementById('abc-hamburger');
        var nav  = document.querySelector('.main-navigation');
        var overlay = document.getElementById('abc-nav-overlay');
        var body = document.body;

        if (!btn || !nav) return;   /* safety guard */

        /* ── State ── */
        var isOpen = false;

        /* ── Open menu ── */
        function openMenu() {
            isOpen = true;
            btn.setAttribute('aria-expanded', 'true');
            nav.classList.add('is-open');
            if (overlay) overlay.classList.add('is-open');
            body.classList.add('nav-is-open');          /* scroll lock */
            body.style.overflow = 'hidden';

            /* Move focus to first menu link */
            var firstLink = nav.querySelector('a');
            if (firstLink) {
                setTimeout(function () { firstLink.focus(); }, 50);
            }
        }

        /* ── Close menu ── */
        function closeMenu() {
            isOpen = false;
            btn.setAttribute('aria-expanded', 'false');
            nav.classList.remove('is-open');
            if (overlay) overlay.classList.remove('is-open');
            body.classList.remove('nav-is-open');
            body.style.overflow = '';
            btn.focus();            /* return focus to toggle button */
        }

        /* ── Toggle ── */
        function toggleMenu() {
            if (isOpen) { closeMenu(); } else { openMenu(); }
        }

        /* ── Button click ── */
        btn.addEventListener('click', toggleMenu);

        /* ── Overlay click = close ── */
        if (overlay) {
            overlay.addEventListener('click', closeMenu);
        }

        /* ── Keyboard: Escape closes ── */
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && isOpen) {
                closeMenu();
            }
        });

        /* ── Focus trap inside drawer (mobile) ── */
        nav.addEventListener('keydown', function (e) {
            if (!isOpen || e.key !== 'Tab') return;
            if (window.innerWidth > 900) return;   /* only trap on mobile */

            var focusable = nav.querySelectorAll(
                'a[href], button, [tabindex]:not([tabindex="-1"])'
            );
            if (!focusable.length) return;

            var first = focusable[0];
            var last  = focusable[focusable.length - 1];

            if (e.shiftKey) {
                /* Shift+Tab: if on first, wrap to last */
                if (document.activeElement === first) {
                    e.preventDefault();
                    last.focus();
                }
            } else {
                /* Tab: if on last, wrap to first */
                if (document.activeElement === last) {
                    e.preventDefault();
                    first.focus();
                }
            }
        });

        /* ── Close on resize to desktop ── */
        window.addEventListener('resize', function () {
            if (window.innerWidth > 900 && isOpen) {
                closeMenu();
            }
        });

        /* ── Close when a menu link is clicked (SPA-safe) ── */
        var menuLinks = nav.querySelectorAll('.main-menu a');
        menuLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 900 && isOpen) {
                    closeMenu();
                }
            });
        });

        /* ── Scroll: add shadow class to header ── */
        var header = document.querySelector('.site-header');
        if (header) {
            window.addEventListener('scroll', function () {
                if (window.scrollY > 4) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            }, { passive: true });
        }
    });

})();