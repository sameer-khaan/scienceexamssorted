{{--
  Title: Boxes with icon
  Description: Boxes with an icon above it
  Category: thync
  Icon: screenoptions
  Keywords: group buttons
  Mode: edit
  Align: full
  SupportsAlign: false
  SupportsMode: true
  SupportsMultiple: true
--}}
<div data-{{ $block['id'] }} class="{{ $block['classes'] }} @include('partials.background-classes') boxes-icon full-width">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">
         @if(have_rows('boxes'))
          <div class="boxes-hold">
            @while(have_rows('boxes'))
              @php
                the_row();
              @endphp
              <div class="box-outer" data-aos="fade-up" data-aos-offset="120" data-aos-delay="50" data-aos-duration="700"  data-aos-easing="ease-in-out-cubic">
                @if(get_sub_field('the_icon'))
                  <div class="icon">
                    <div class="image">
                      {!! wp_get_attachment_image( get_sub_field('the_icon'), 'full', false) !!}
                    </div>
                  </div>
                @endif
                <div class="box-inner">
                  <div class="content">
                    @php the_sub_field('content') @endphp
                  </div>
                </div>
              </div>
            @endwhile
          </div>
        @endif
      </div>
    </div>
  </div>
  @include('partials.background-styling')
</div>