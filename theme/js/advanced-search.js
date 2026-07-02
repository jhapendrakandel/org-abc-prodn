/**
 * ABC Nepal TV — Advanced Search JS v2
 * File: js/advanced-search.js
 */

(function () {
    'use strict';

    var form        = document.getElementById('abcs-form');
    var fromInput   = document.getElementById('abcs-from');
    var toInput     = document.getElementById('abcs-to');
    var dateInput   = document.getElementById('abcs-date');
    var rangeError  = document.getElementById('abcs-range-error');
    var submitBtn   = document.getElementById('abcs-submit');
    var filterPanel = document.getElementById('abcs-filters');
    var toggleBtn   = document.getElementById('abcs-toggle-filters');
    var pagedInput  = document.getElementById('abcs-paged-input');
    var overlay     = document.getElementById('abcs-results-overlay');
    var closeBtn    = document.getElementById('abcs-results-close');

    if (!form) return;

    var MAX_DAYS = 5;

    /* ── Date range validation ── */
    function validateRange() {
        if (!fromInput || !toInput) return true;
        var from = fromInput.value;
        var to   = toInput.value;

        if (!from || !to) { hideError(); return true; }

        var d_from = new Date(from);
        var d_to   = new Date(to);

        if (d_to < d_from) {
            showError('सुरुको मिति अन्तिम मितिभन्दा पछि हुन सक्दैन।');
            return false;
        }

        var diffDays = Math.round((d_to - d_from) / 86400000);

        if (diffDays > MAX_DAYS) {
            showError('मिति दायरा ५ दिनभन्दा बढी हुन सक्दैन। तपाईंले ' + diffDays + ' दिन चयन गर्नुभएको छ।');
            return false;
        }

        hideError();
        return true;
    }

    function showError(msg) {
        if (!rangeError) return;
        rangeError.removeAttribute('hidden');
        rangeError.textContent = msg;
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';
            submitBtn.style.cursor = 'not-allowed';
        }
    }

    function hideError() {
        if (!rangeError) return;
        rangeError.setAttribute('hidden', '');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '';
            submitBtn.style.cursor = '';
        }
    }

    if (fromInput) fromInput.addEventListener('change', validateRange);
    if (toInput)   toInput.addEventListener('change', validateRange);

    /* ── Mutual exclusion: specific date vs range ── */
    if (dateInput) {
        dateInput.addEventListener('change', function () {
            if (dateInput.value) {
                if (fromInput) fromInput.value = '';
                if (toInput)   toInput.value   = '';
                hideError();
            }
        });
    }

    function clearSpecificDate() {
        if (dateInput && dateInput.value) dateInput.value = '';
    }
    if (fromInput) fromInput.addEventListener('change', clearSpecificDate);
    if (toInput)   toInput.addEventListener('change', clearSpecificDate);

    /* ── Form submit guard ── */
    form.addEventListener('submit', function (e) {
        if (pagedInput) pagedInput.value = '1';
        if (!validateRange()) {
            e.preventDefault();
            if (rangeError) rangeError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    /* ── Filter panel toggle ── */
    if (toggleBtn && filterPanel) {
        toggleBtn.addEventListener('click', function () {
            var expanded = toggleBtn.getAttribute('aria-expanded') === 'true';
            if (expanded) {
                filterPanel.setAttribute('hidden', '');
                toggleBtn.setAttribute('aria-expanded', 'false');
            } else {
                filterPanel.removeAttribute('hidden');
                toggleBtn.setAttribute('aria-expanded', 'true');
            }
        });
    }

    /* ── Close results overlay ── */
    if (closeBtn && overlay) {
        closeBtn.addEventListener('click', function () {
            overlay.style.display = 'none';
        });
    }

    // Close overlay when clicking outside the panel
    if (overlay) {
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
    }

    // Close overlay on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay) {
            overlay.style.display = 'none';
        }
    });

})();