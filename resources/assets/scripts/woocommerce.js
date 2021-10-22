jQuery(document).ready(function($) {
  var loading_ul_html = '<div class="loading_ul_html"><strong>Please select a delivery/collection date first</strong></div>';
  $('.jckwds-delivery-time .woocommerce-input-wrapper').after(loading_ul_html);

  $('#jckwds-delivery-date').change(function() {
    $('.loading_ul_html').html('<strong>Loading available times...</strong>');
  });

  $('body').on('timeslots_loaded', function() {
    // $('#jckwds-delivery-time').hide();
    var ul_html = '';
    $('#jckwds-delivery-time > option').each(function(index, el) {
      if($(el).val() != '0') {
        ul_html += '<li data-value="'+$(el).val()+'">' + $(el).text() + '</li>';
      }
      if($(el).val() == '0') {
        $('.loading_ul_html').html('<strong>' + $(el).text() + '</strong>');
        $('.loading_ul_html').show();
      }
    });

    $('.delivery-time-ul').remove();
    $('.loading_ul_html').after('<ul class="delivery-time-ul">' + ul_html + '</ul>');

    
  });

  $('body').on('click', 'ul.delivery-time-ul li', function() {
    var the_val = $(this).attr('data-value');
    $('ul.delivery-time-ul li').removeClass('active');
    $(this).addClass('active')
    $('#jckwds-delivery-time').val(the_val);
    $('#jckwds-delivery-time').trigger('change');
    $('.loading_ul_html').hide();
  });

  setTimeout(function() {
    $('.cart_totals').stick_in_parent({
      'offset_top': 150,
    });
  }, 3000);
  

  // $('.checkout-review-hold').stick_in_parent({
  //   'offset_top': 150,
  // });

  $('form.woocommerce-cart-form input[name="update_cart"],form.woocommerce-cart-form input[name="apply_coupon"], form.woocommerce-cart-form a.remove').click(function() {
    $('.cart_totals').trigger('sticky_kit:detach');
  });

  jQuery(document.body).on('change', '.qty-multi-select', function(event) {
    event.preventDefault();
    $(this).prev('input').val($(this).val());
    $(this).prev('input').trigger( 'keyup' );
  });

  jQuery( document.body ).on( 'updated_cart_totals', function() { 
    
    //$('.cart_totals').trigger('sticky_kit:detach');
    $('.cart_totals').stick_in_parent({
      'offset_top': 150,
    });
  });
});