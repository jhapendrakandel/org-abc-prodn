/* ============================================================
   ABC Nepal TV — Marquee Ticker Speed Control
   File: ticker-marquee.js
   Append to header-nav.js, or enqueue separately after it.

   Sets animation-duration proportional to content width so the
   scroll speed feels consistent regardless of how many ticker
   items the admin has added.
============================================================ */
(function () {
    function initTicker() {
        var content = document.getElementById('abc-ticker-content');
        if (!content) return;

        // Pixels per second — tune this for faster/slower scroll
        var PX_PER_SECOND = 60;

        function setDuration() {
            // Content is duplicated 2x for the seamless loop,
            // so one full loop = half of scrollWidth.
            var loopWidth = content.scrollWidth / 2;
            var duration = Math.max(loopWidth / PX_PER_SECOND, 8); // floor of 8s
            content.style.animationDuration = duration + 's';
        }

        // Wait a tick for fonts/layout to settle before measuring
        window.requestAnimationFrame(function () {
            setTimeout(setDuration, 50);
        });

        window.addEventListener('resize', setDuration);

        // Pause marquee when tab is not visible (saves CPU/battery)
        document.addEventListener('visibilitychange', function () {
            content.style.animationPlayState = document.hidden ? 'paused' : 'running';
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTicker);
    } else {
        initTicker();
    }
})();