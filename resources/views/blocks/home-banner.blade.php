{{--
  Title: Banner used on homepage
  Description: Banner with background image and text
  Category: thync
  Icon: format-video
  Keywords: video banner content
  Mode: edit
  Align: full
  SupportsAlign: false
  SupportsMode: true
  SupportsMultiple: true
--}}
<div data-{{ $block['id'] }} class="{{ $block['classes'] }} home-page-intro full-width">
  <div class="left-content">
    <div class="inner-content">
      <div class="white-row">
        @php
          the_field('banner_content');
        @endphp
      </div>
      @if(have_rows('ctas'))
        @php
          $first = true;
        @endphp
        <div class="button-group">
          @while(have_rows('ctas'))
            @php the_row(); @endphp
            @if(get_sub_field('link'))
              @php
                $link = get_sub_field('link');
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
              @endphp

              <a class="btn {{ $first ? 'btn-white' : 'btn-primary' }}" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
              @php
                $first = false;
              @endphp
            @endif
          @endwhile 
        </div>
      @endif
    </div>
  </div>
  @if(get_field('banner_video'))
    <div class="banner-video">
      <div class="inner-video">
        <video autoplay muted loop playsinline class="banner-video"><source src="{{get_field('banner_video')}}" type="video/mp4"></video>
      </div>
    </div>
  @else
    <div class="image">
      {!! wp_get_attachment_image( get_field('banner_image'), 'main', false, array('data-object-fit'=>'cover')) !!}
    </div>
  @endif
</div>
<style type="text/css">
  @if(get_field('background_colour'))
    [data-{{$block['id']}}] {
      background-color: {{get_field('background_colour')}};
    }
  @endif
</style>