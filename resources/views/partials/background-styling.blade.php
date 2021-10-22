@if(get_field('background_colour') || get_field('background_image') || get_field('parallax_background'))
  <style>
    [data-{{ $block['id'] }}] {
      @if(get_field('background_colour'))
        background-color: {{get_field('background_colour')}};
      @endif
      @if(get_field('parallax_background'))
        background-attachment: fixed;
      @endif
      @if(get_field('background_image'))
        @php 
          $url = wp_get_attachment_image_src(get_field('background_image'), 'main');
          if($url) {
            $url = $url[0];
          }
        @endphp
        @if($url)
          background-image: url("{{$url}}");
          background-size: cover;
          background-position: center;
        @endif
      @endif
    }

    @if(get_field('parallax_background'))
      @media only screen and (max-width: {{get_field('mobile_breakpoint','option')}}px) {
        [data-{{ $block['id'] }}] {
          background-attachment: scroll !important;
        }
      }
    @endif
  </style>
@endif