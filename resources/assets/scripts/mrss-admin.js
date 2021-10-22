/* eslint-disable no-useless-escape */
import Pikaday from 'pikaday/pikaday.js';

jQuery(document).ready(function($) {
  // $('select[name="delivery_date"]').append('<option value="">Custom</option>');
  $.urlParam = function(name){
      var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
      if (results==null){
         return null;
      }
      else{
         return results[1] || 0;
      }
  }

  $('select[name="delivery_date"]').before('<input name="custom_delivery_date" type="text" class="custom-delivery-date" value="" placeholder="Custom date">');

  if($.urlParam('custom_delivery_date')) {
    $('body input[name="custom_delivery_date"]').val($.urlParam('custom_delivery_date'));
  }

  if($.urlParam('delivery_date')) {
    if(!$('select[name="delivery_date"] option[value="'+ $.urlParam('delivery_date') +'"]').length > 0) {
      var appendstring = '<option class="custom-delivery-date-option" value="'+ $.urlParam('delivery_date') + '">' + $.urlParam('delivery_date') + '</option>';
      $('select[name="delivery_date"]').append(appendstring);
      $('select[name="delivery_date"] option[value="'+ $.urlParam('delivery_date') +'"]').attr('selected', 'selected');
    }
  }

  var picker = new Pikaday({ 
    field: $('body .custom-delivery-date')[0],
    onSelect: function() {
      $('.custom-delivery-date-option').remove();
      var appendstring = '<option class="custom-delivery-date-option" value="'+ picker.toString('YYYYMMDD') + '">' + picker.toString('DD/MM/YYYY') + '</option>';
      $('select[name="delivery_date"]').append(appendstring);
      $('select[name="delivery_date"]').val(picker.toString('YYYYMMDD'));
    },
  });

});
