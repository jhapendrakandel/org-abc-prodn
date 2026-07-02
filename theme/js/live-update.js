(function ($) {
    'use strict';

    function getCurrentTopic(button) {
        var buttonTopic = button.data('topic');
        var feedTopic = $('#live-feed').data('topic');
        var urlTopic = new URLSearchParams(window.location.search).get('topic');

        return buttonTopic || feedTopic || urlTopic || '';
    }

    $(function () {
        var button = $('#load-more-btn');

        if (!button.length) {
            return;
        }

        button.on('click', function () {
            var currentButton = $(this);
            var page = parseInt(currentButton.data('page'), 10) || 2;
            var originalText = currentButton.text();

            currentButton.prop('disabled', true).text('लोड हुँदैछ...');

            $.ajax({
                url: abcLiveUpdate.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'load_more_updates',
                    nonce: abcLiveUpdate.nonce,
                    page: page,
                    topic: getCurrentTopic(currentButton)
                },
                success: function (response) {
                    if ($.trim(response) !== '') {
                        $('#live-feed').append(response);
                        currentButton.data('page', page + 1);
                        currentButton.prop('disabled', false).text(originalText);
                    } else {
                        currentButton.text('सबै अपडेटहरू देखाइसकियो।');
                    }
                },
                error: function () {
                    currentButton.prop('disabled', false).text('फेरि प्रयास गर्नुहोस्');
                }
            });
        });
    });
}(jQuery));
