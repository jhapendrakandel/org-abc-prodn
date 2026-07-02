/**
 * ABC Nepal — Live Updates
 * Localized via abcLiveUpdate.ajaxUrl and abcLiveUpdate.nonce
 */
(function () {
    'use strict';

    var POLL_MS  = 15000;   // poll every 15 seconds
    var TICK_MS  = 60000;   // refresh timestamps every minute
    var WORDS_THRESHOLD = 40;

    var feed     = document.getElementById('live-feed');
    var statusEl = document.getElementById('live-status');
    var countEl  = document.getElementById('live-count');
    var lastIdEl = document.getElementById('live-last-id');

    if (!feed || !lastIdEl) { return; }

    var ajaxUrl  = (typeof abcLiveUpdate !== 'undefined') ? abcLiveUpdate.ajaxUrl : '/wp-admin/admin-ajax.php';
    var nonce    = (typeof abcLiveUpdate !== 'undefined') ? abcLiveUpdate.nonce   : '';

    var lastId      = parseInt(lastIdEl.content, 10) || 0;
    var totalNew    = 0;
    var retryDelay  = POLL_MS;

    // ── Helpers ──────────────────────────────────────────────────────────────

    function timeAgo(ts) {
        var diff = Math.floor(Date.now() / 1000) - ts;
        if (diff < 60)    { return 'just now'; }
        if (diff < 3600)  { return Math.floor(diff / 60)   + ' min ago'; }
        if (diff < 86400) { return Math.floor(diff / 3600)  + ' hr ago'; }
        return                     Math.floor(diff / 86400) + ' d ago';
    }

    function refreshTimestamps() {
        document.querySelectorAll('.time-ago[data-timestamp]').forEach(function (el) {
            var ts = parseInt(el.dataset.timestamp, 10);
            if (!isNaN(ts)) { el.textContent = timeAgo(ts); }
        });
    }

    function setStatus(text, state) {
        if (!statusEl) { return; }
        statusEl.textContent   = text;
        statusEl.dataset.state = state;
    }

    function showToast(count) {
        var old = document.getElementById('live-toast');
        if (old) { old.remove(); }
        var t = document.createElement('div');
        t.id        = 'live-toast';
        t.className = 'live-toast';
        t.textContent = count === 1 ? '1 new update' : count + ' new updates';
        document.body.appendChild(t);
        requestAnimationFrame(function () { t.classList.add('visible'); });
        setTimeout(function () {
            t.classList.remove('visible');
            setTimeout(function () { t.remove(); }, 400);
        }, 3500);
    }

    function attachShowMore(entry) {
        var btn     = entry.querySelector('.show-more-btn');
        var content = entry.querySelector('.update-content');
        if (!btn || !content) { return; }
        content.classList.add('collapsed');
        btn.setAttribute('aria-expanded', 'false');
        btn.addEventListener('click', function () {
            var expanded = content.classList.toggle('collapsed') === false;
            btn.textContent = expanded ? 'Show less' : 'Show more';
            btn.setAttribute('aria-expanded', String(expanded));
        });
    }

    function prependEntries(html) {
        var wrap = document.createElement('div');
        wrap.innerHTML = html;
        var entries = Array.from(wrap.querySelectorAll('.update-entry'));

        entries.sort(function (a, b) {
            return parseInt(b.dataset.id, 10) - parseInt(a.dataset.id, 10);
        });

        entries.forEach(function (entry) {
            var content   = entry.querySelector('.update-content');
            var wordCount = content ? (content.textContent || '').trim().split(/\s+/).filter(Boolean).length : 0;
            if (wordCount > WORDS_THRESHOLD) {
                attachShowMore(entry);
            } else {
                var btn = entry.querySelector('.show-more-btn');
                if (btn) { btn.remove(); }
            }
            entry.classList.add('entry-new');
            setTimeout(function () { entry.classList.remove('entry-new'); }, 3000);
            feed.insertBefore(entry, feed.firstChild);
        });

        if (entries.length > 0) {
            var topId = parseInt(entries[0].dataset.id, 10);
            if (topId > lastId) {
                lastId = topId;
                lastIdEl.content = String(lastId);
            }
        }
    }

    // ── Polling ──────────────────────────────────────────────────────────────

    function poll() {
        setStatus('Checking\u2026', 'checking');

        var url = ajaxUrl
            + '?action=get_live_updates'
            + '&last_id=' + lastId
            + '&nonce='   + encodeURIComponent(nonce);

        fetch(url, { credentials: 'same-origin' })
            .then(function (res) {
                if (!res.ok) { throw new Error('HTTP ' + res.status); }
                return res.json();
            })
            .then(function (data) {
                retryDelay = POLL_MS;
                if (data.success && data.html) {
                    var count = data.count || 1;
                    totalNew += count;
                    prependEntries(data.html);
                    refreshTimestamps();
                    showToast(count);
                    if (countEl) {
                        countEl.textContent = totalNew > 0
                            ? totalNew + ' new update' + (totalNew === 1 ? '' : 's')
                            : '';
                    }
                }
                setStatus('Live', 'ok');
            })
            .catch(function () {
                retryDelay = Math.min(retryDelay * 2, 120000);
                setStatus('Reconnecting\u2026', 'error');
            })
            .finally(function () {
                setTimeout(poll, retryDelay);
            });
    }

    // ── Init ─────────────────────────────────────────────────────────────────

    // Attach show-more to entries already on the page
    document.querySelectorAll('.update-entry').forEach(function (entry) {
        var content   = entry.querySelector('.update-content');
        var wordCount = content ? (content.textContent || '').trim().split(/\s+/).filter(Boolean).length : 0;
        if (wordCount > WORDS_THRESHOLD) {
            attachShowMore(entry);
        } else {
            var btn = entry.querySelector('.show-more-btn');
            if (btn) { btn.remove(); }
        }
    });

    refreshTimestamps();
    setStatus('Live', 'ok');
    setInterval(refreshTimestamps, TICK_MS);
    setTimeout(poll, POLL_MS);

}());