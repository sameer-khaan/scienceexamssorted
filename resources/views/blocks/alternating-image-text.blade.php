{{--
  Title: Alternating image and text
  Description: Alternating image and text rows
  Category: thync
  Icon: analytics
  Keywords: text image alternate
  Mode: edit
  Align: full
  SupportsAlign: false
  SupportsMode: true
  SupportsMultiple: true
--}}
<div data-{{ $block['id'] }} class="{{ $block['classes'] }} @include('partials.background-classes') full-width alternating-image-and-text-block @if(get_field('start_left')) reverse @endif">
  <div class="container">
    <div class="the-rows" style="position: relative; z-index: 3;">
      @if( have_rows('rows') )
        @while ( have_rows('rows') )
          @php the_row(); @endphp
          <div class="row lg-gutter align-items-center justify-content-center">
            <div class="col-12 col-md-5">
              <div class="image @if(get_field('add_border')) add-border @endif">
                {!! wp_get_attachment_image( get_sub_field('image'), 'full', false) !!}
              </div>
            </div>
            <div class="col-12 col-md-7">
              <div class="text">
                {!! get_sub_field('content') !!}
              </div>
            </div>
          </div>
        @endwhile
      @endif
    </div>
  </div>
</div>

@include('partials.background-styling')