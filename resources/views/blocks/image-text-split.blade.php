{{--
  Title: Text and image split screen
  Description: Text one side and an the other.
  Category: thync
  Icon: format-image
  Keywords: text image clip mask split
  Mode: edit
  Align: full
  SupportsAlign: false
  SupportsMode: true
  SupportsMultiple: true
--}}
<div data-{{ $block['id'] }} class="{{ $block['classes'] }} full-width text-image-split-block {{ get_field('image_left') ? "image-left" : "" }} {{ get_field('make_text_white') ? "white-row" : "" }}">
  <div class="content">
    <div class="content-inner">{!! get_field('block_content') !!}</div>
  </div>
  <div class="image">
    @if( ! empty( get_field('image') ) )
      @include('partials.svg.image-clip')
      {!! wp_get_attachment_image( get_field('image'), 'full', false, array('data-object-fit'=>'cover')) !!}
    @endif
  </div>
</div>

<style type="text/css">
  @if(get_field('text_background_colour'))
    [data-{{$block['id']}}] {
      background-color: {{get_field('text_background_colour')}} !important;
    }

    [data-{{$block['id']}}] .image-split-clip path {
      fill: {{get_field('text_background_colour')}};
    }

    [data-{{$block['id']}}] .image-split-clip-mobile path {
      fill: {{get_field('text_background_colour')}};
    }
  @endif
</style>