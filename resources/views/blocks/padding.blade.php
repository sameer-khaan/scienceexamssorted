{{--
  Title: Vertical padding
  Description: Vertical padding for layouts. Leave values blank for default padding
  Category: thync
  Icon: sort
  Keywords: padding pad
  Mode: preview
  Align: full
  SupportsAlign: false
  SupportsMode: true
  SupportsMultiple: true
--}}

<div data-{{ $block['id'] }} class="block-padding full-width {{ $block['classes'] }}"></div>


<style type="text/css">
  @if(get_field('padding_height'))
    @media only screen and (min-width: {{( get_field('mobile_breakpoint', 'option') + 1 )}}px) {
      body:not(.wp-admin) [data-{{$block['id']}}] {
        height: {{get_field('padding_height')}}px;
      }
    }
  @endif
  @if(get_field('padding_height_mobile'))
    @media only screen and (max-width: {{get_field('mobile_breakpoint','option')}}px) {
      body:not(.wp-admin) [data-{{$block['id']}}] {
        height: {{get_field('padding_height_mobile')}}px;
      }
    }
  @endif
  @if(get_field('background_colour'))
    [data-{{$block['id']}}] {
      background-color: {{get_field('background_colour')}};
    }
  @endif
</style>