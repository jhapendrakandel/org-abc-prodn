(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var block = document.querySelector('.abc-video-player-block');
        if (!block) return;

        var mainMedia   = document.getElementById('abc-main-player-media');
        var mainTitle   = document.getElementById('abc-main-player-title');
        var mainLink    = document.getElementById('abc-main-player-link');
        var mainDesc    = document.getElementById('abc-main-player-desc');
        var mainDate    = document.getElementById('abc-main-player-date');
        var strip       = document.getElementById('abc-video-strip');
        var stripItems  = strip ? strip.querySelectorAll('.abc-strip-item') : [];
        var prevBtn     = document.querySelector('.abc-strip-prev');
        var nextBtn     = document.querySelector('.abc-strip-next');

        function renderPlayer(videoId, thumbUrl) {
            if (videoId) {
                mainMedia.innerHTML =
                    '<iframe src="https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0" ' +
                    'frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" ' +
                    'allowfullscreen></iframe>';
            } else {
                mainMedia.innerHTML =
                    '<img class="abc-main-player-thumb" src="' + thumbUrl + '" alt="">';
            }
        }

        function selectItem(item) {
            var videoId = item.getAttribute('data-video-id');
            var thumb   = item.getAttribute('data-thumb');
            var title   = item.getAttribute('data-title');
            var desc    = item.getAttribute('data-desc');
            var date    = item.getAttribute('data-date');
            var link    = item.getAttribute('data-link');

            renderPlayer(videoId, thumb);

            if (mainTitle) mainTitle.textContent = title;
            if (mainLink) { mainLink.textContent = title; mainLink.href = link; }
            if (mainDesc) mainDesc.textContent = desc;
            if (mainDate) mainDate.textContent = date;

            stripItems.forEach(function (el) { el.classList.remove('active'); });
            item.classList.add('active');

            // Scroll the selected thumbnail into view within the strip
            item.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        }

        // Clicking the big thumbnail/play button on first load starts playback
        var playBtn = block.querySelector('.abc-main-play-btn');
        if (playBtn) {
            playBtn.addEventListener('click', function (e) {
                e.preventDefault();
                var videoId = document.getElementById('abc-main-player').getAttribute('data-video-id');
                renderPlayer(videoId, null);
            });
        }

        stripItems.forEach(function (item) {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                selectItem(item);
            });
        });

        // Prev/Next scroll buttons for the thumbnail strip
        function scrollStrip(direction) {
            if (!strip) return;
            var scrollAmount = strip.clientWidth * 0.8 * direction;
            strip.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
        if (prevBtn) prevBtn.addEventListener('click', function () { scrollStrip(-1); });
        if (nextBtn) nextBtn.addEventListener('click', function () { scrollStrip(1); });
    });
})();