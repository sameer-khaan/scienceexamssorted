const ajax_url = window.ajax_object.ajax_url || false;

function delay(callback, ms) {
  var timer = 0;
  return function() {
    var context = this, args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      callback.apply(context, args);
    }, ms || 0);
  };
}

function get_products() {
  $.ajax({
    type: 'POST',
    url: ajax_url,
    data: { action: 'get_postcode_products', postcode: $('#postcode-input').val() },
    beforeSend: function() {
      $('.search-grid').html('');
      $('#postcode-loading').show();
    },
    success: function(data) {
      $('.search-grid').html(data);
    },
    complete: function() {
      $('#postcode-loading').hide();
    },
  });
}

jQuery(document).ready(function($) {
  if($('#postcode-input').length > 0) {
    get_products();

    $('#postcode-input').keyup(delay(function () {
      get_products();
    }, 500));
  }

  // $('body').on('click', '[data-do-nothing="true"]', function(event) {
  //   event.preventDefault();
  // });
});
