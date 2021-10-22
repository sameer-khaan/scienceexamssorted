{{--
  Title: Clip
  Description: Colour clipping svg used for design
  Category: ewds
  Icon: star-half
  Keywords: clip mask svg shape
  Mode: preview
  Align: full
  SupportsAlign: false
  SupportsMode: true
  SupportsMultiple: true
--}}

<div data-{{ $block['id'] }} class="clip-block full-width {{ $block['classes'] }} {{ get_field('reverse_curve') ? "reverse" : "" }}">
  <div class="clip-hold">
    @include('partials.svg.row-clip')
  </div>
</div>


<style type="text/css">
  @if(get_field('background_colour'))
    [data-{{$block['id']}}] svg path {
      fill: {{get_field('background_colour')}} !important;
    }
  @endif
  @if(get_field('margin_bottom'))
    @media only screen and (min-width: {{( get_field('mobile_breakpoint', 'option') + 1 )}}px) {
      body:not(.wp-admin) [data-{{$block['id']}}] {
        margin-bottom: {{get_field('margin_bottom')}}px;
      }
    }
  @endif
  @if(get_field('margin_bottom_mobile'))
    @media only screen and (max-width: {{ get_field('mobile_breakpoint', 'option') }}px) {
      body:not(.wp-admin) [data-{{$block['id']}}] {
        margin-bottom: {{get_field('margin_bottom_mobile')}}px;
      }
    }
  @endif
  @if(get_field('margin_top'))
    @media only screen and (min-width: {{( get_field('mobile_breakpoint', 'option') + 1 )}}px) {
      body:not(.wp-admin) [data-{{$block['id']}}] {
        margin-top: {{get_field('margin_top')}}px;
      }
    }
  @endif
  @if(get_field('margin_top_mobile'))
    @media only screen and (max-width: {{ get_field('mobile_breakpoint', 'option') }}px) {
      body:not(.wp-admin) [data-{{$block['id']}}] {
        margin-top: {{get_field('margin_top_mobile')}}px;
      }
    }
  @endif
</style>