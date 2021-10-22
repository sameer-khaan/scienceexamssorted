jQuery(document).ready(function($) {

  // Hide Header on on scroll down
  var st;
  var lastScrollTop = 0;
  var delta = 5;
  var navbarHeight = $('header.main-header').outerHeight();

  requestAnimationFrame(updateNav);

  function updateNav() {
    
    if($('body').hasClass('transparent-header')) {
      navbarHeight = 2;
    } else {
      navbarHeight = $('header.main-header').outerHeight();
    }

    hasScrolled();

    st = $(window).scrollTop();

    if (st >= $('header.main-header').outerHeight()) {
      $('body').addClass('scroll');
    } else {
      $('body').removeClass('scroll');
    }

    requestAnimationFrame(updateNav);
  }

  function hasScrolled() {
    
    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta)
      return;
    
    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
    if (st > lastScrollTop && st > navbarHeight){
        // Scroll Down
        $('header.main-header').removeClass('nav-down').addClass('nav-up');
    } else {
        // Scroll Up
        if(st + $(window).height() < $(document).height()) {
          $('header.main-header').removeClass('nav-up').addClass('nav-down');
        }
    }
    
    lastScrollTop = st;
  }

  $('.menu-toggle').click(function(event) {
    event.preventDefault();

    if(!$('body').hasClass('nav-closing')) {
      $(this).toggleClass('is-active');
      $('body').toggleClass('nav-open');

      if(!$('body').hasClass('nav-open')) {
        $('body').addClass('nav-closing');

        setTimeout(function(){
          $('body').removeClass('nav-closing');
        }, 1200);
      }
    }
    //$('nav.nav-primary').css('top', $('header.main-header').outerHeight());
  });

  $('li.menu-item-has-children > a').click(function(event) {
    event.preventDefault();
    $(this).parent().toggleClass('sub-open');
  });

  var siteNavigation = $('.main-header .nav');
  
  siteNavigation.find( 'a' ).on( 'focus blur', function() {
    $( this ).parents( 'li' ).toggleClass( 'focus' );
  });
});