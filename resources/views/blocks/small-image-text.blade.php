{{--
  Title: Circular image and text
  Description: Text one side and a small circle image the other.
  Category: thync
  Icon: format-image
  Keywords: text image clip mask split
  Mode: edit
  Align: full
  SupportsAlign: false
  SupportsMode: true
  SupportsMultiple: true
--}}

<div  data-{{ $block['id'] }} class="{{ $block['classes'] }} @include('partials.background-classes') full-width text-image-circle-block @if(get_field('start_left')) reverse @endif">
  <div class="container">
    <div class="the-rows" style="position: relative; z-index: 3;">
      <div class="row lg-gutter align-items-center justify-content-center">
        <div class="col-12 text-center col-md-auto">
          <div class="image">
            {!! wp_get_attachment_image( get_field('image'), 'full', false) !!}
          </div>
        </div>
        <div class="col-12 col-md-8 col-xl-6">
          <div class="text">
            {!! get_field('block_content') !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('partials.background-styling')