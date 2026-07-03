/*!
 * ABC Nepal TV — Header Navigation
 * File: header-nav.js
 * Enqueue via functions.php (in footer, defer):
 *   wp_enqueue_script('abc-header-nav', get_template_directory_uri().'/header-nav.js', array(), null, true);
 */
(function () {
    'use strict';

    /* ── Helper: run when DOM is ready ── */
    function onDOMLoaded(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            fn();
        }
    }

    onDOMLoaded(function () {

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

        /* ── Province Tab Switching ── */
        var provinceTabs = document.querySelectorAll('.nyt-ptab');
        if (provinceTabs.length) {
            provinceTabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    var key = this.getAttribute('data-ptab');
                    var section = this.closest('.nyt-province-section');
                    if (!section) return;
                    
                    // Update tabs
                    section.querySelectorAll('.nyt-ptab').forEach(function (t) {
                        t.classList.remove('active');
                        t.setAttribute('aria-selected', 'false');
                    });
                    this.classList.add('active');
                    this.setAttribute('aria-selected', 'true');
                    
                    // Update panels
                    section.querySelectorAll('.nyt-province-panel').forEach(function (panel) {
                        panel.classList.remove('active');
                        panel.setAttribute('aria-hidden', 'true');
                    });
                    var activePanel = section.querySelector('.nyt-province-panel[data-ptab="' + key + '"]');
                    if (activePanel) {
                        activePanel.classList.add('active');
                        activePanel.setAttribute('aria-hidden', 'false');
                    }
                });
                
                // Keyboard navigation for tabs
                provinceTabs.forEach(function (tab) {
                    tab.addEventListener('keydown', function (e) {
                        var tabs = Array.from(provinceTabs);
                        var index = tabs.indexOf(this);
                        if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                            e.preventDefault();
                            var next = tabs[(index + 1) % tabs.length];
                            next.focus();
                        } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                            e.preventDefault();
                            var prev = tabs[(index - 1 + tabs.length) % tabs.length];
                            prev.focus();
                        }
                    });
                });
            });
        }
    });

})();