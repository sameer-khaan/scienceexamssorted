/* eslint-disable */
import anime from 'animejs/lib/anime.es.js';

jQuery(document).ready(function($) {
    $('.magic-underline').wrapInner('<span></span>');
    $(".magic-underline > span").each(function(index, el) {
        var words = $(el).text().split(" ");
        $(el).empty();
        $.each(words, function(i, v) {
            $(el).append($('<span class="no-break">').text(v));
            if(i !== (words.length - 1)) {
                $(el).append(' ');
            }
        });

        $(el).children('.no-break').each(function(index, el) {
            var textWrapper = $(el)[0];
            textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
        });
    });

    $('.magic-underline').on('inview', function(event, isInView) {
        event.preventDefault();
        if (isInView && !$(this).hasClass('animated')) {
            $(this).addClass('animated');

            anime.timeline({loop: false})
              .add({
                targets: $(this).find('.letter').toArray(),
                scale: [4,1],
                opacity: [0,1],
                translateZ: 0,
                easing: 'easeOutExpo',
                duration: 500,
                delay: (el, i) => 70*i
              });
        } else {
           $(this).removeClass('animated');
        }
    });
});