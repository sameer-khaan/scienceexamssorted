{{--
  Title: Group of buttons
  Description: Group of buttons
  Category: thync
  Icon: admin-links
  Keywords: group buttons
  Mode: edit
  Align: full
  SupportsAlign: false
  SupportsMode: true
  SupportsMultiple: true
--}}
<div data-{{ $block['id'] }} class="{{ $block['classes'] }} @include('partials.background-classes') buttons-group full-width">
  <div class="container-fluid">
    <div class="row justify-content-center lg-gutter">
      <div class="col-12 col-xl-10">
        <div class="links-hold">
          @if(have_rows('links'))
            @while(have_rows('links'))
              @php
                the_row();
                $link = get_sub_field('link');
                if( $link ): 
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                endif
              @endphp
              @if($link)
                <a class="btn btn-primary" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><span><?php echo esc_html( $link_title ); ?></span></a>
              @endif
            @endwhile
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@include('partials.background-styling')