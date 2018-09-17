(function ($, Drupal, drupalSettings) {
  'use strict';

  if (drupalSettings.postcode !== undefined) {

    $(document).ready(function () {
      $.ajax({
        async: true,
        type: 'GET',
        url: "/manifesto-test/get-weather",
        data: {postcode: drupalSettings.postcode},

        success: function (data, textStatus, jQxhr) {

          if (data.weatherState !== undefined) {

            var placeholderEl = $('#weather-widget');

            if (placeholderEl.length) {
              placeholderEl.removeClass('hidden').find('p')
                .html(data.weatherState);
            }

          }
        },
        error: function (jqXhr, textStatus, errorThrown) {

        },
        complete: function (data) {

        }
      });
    });

  }

})(jQuery, Drupal, drupalSettings);




