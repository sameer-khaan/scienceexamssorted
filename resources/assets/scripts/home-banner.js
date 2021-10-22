jQuery(document).ready(function($) {
  // First we get the viewport height and we multiple it by 1% to get a value for a vh unit
  let vh = window.innerHeight * 0.01;
  // Then we set the value in the --vh custom property to the root of the document
  document.documentElement.style.setProperty('--vh', `${vh}px`);
  var width = $(window).width();

  window.addEventListener('resize', () => {
    // We execute the same script as before
    if ($(window).width() !== width) {
      let vh = window.innerHeight * 0.01;
      document.documentElement.style.setProperty('--vh', `${vh}px`);
      width = $(window).width();
    }
  });
});