import Rellax from 'rellax';
import MagicGrid from './../magic-grid.js';
import AOS from 'aos';

export default {
  init() {
    // JavaScript to be fired on all pages
    // $('.paroller-el').paroller();

    // $( window ).resize(function() {
    //   setTimeout(function() {
    //     $( window ).trigger('scroll');
    //   }, 1000)
    // });
    // eslint-disable-next-line
    var rellax = new Rellax('.rellax');

    AOS.init();

    jQuery(document).ready(function($) {
      $('.wp-block-columns.full-width').removeClass('full-width').wrap('<div class="full-width"><div class="container-fluid"></div></div>');
      $('.two-columns.full-width').removeClass('full-width').wrap('<div class="full-width"><div class="container-fluid"></div></div>');

      if($('.two-columns').length > 0) {
        let magicGrid = new MagicGrid({
          container: '.two-columns .wp-block-group__inner-container', // Required. Can be a class, id, or an HTMLElement.
          static: true, // Required for static content.
          gutter: 40,
          maxColumns: 2,
          useMin: true,
        });

        magicGrid.listen();

        $(window).on('load', function () {
          magicGrid.positionItems();
        });
      }
      
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
