{{--
  Title:  Process
  Description: Process block
  Category: thync
  Icon: randomize
  Keywords: process animated
  Mode: edit
  Align: full
  SupportsAlign: false
  SupportsMode: true
  SupportsMultiple: true
--}}
<div  data-{{ $block['id'] }} class="{{ $block['classes'] }} @include('partials.background-classes') full-width vantage-process-block">
  <div class="container-fluid">
    @if(get_field('content_before'))
      <div class="row">
        <div class="col-12">
          <div class="content-before no-last-margin">
            @php the_field('content_before') @endphp
          </div>
        </div>
      </div>
    @endif

    <div class="row">
      <div class="col-12">
        <div class="process-hold">
          @include('partials.svg.process-line')
          <ul>
            <li>
              <div class="circle">
                <div class="image-hold">
                  @php $image_id = get_field('step_1_image') @endphp
                  @if($image_id)
                    {!! wp_get_attachment_image($image_id, 'main', false, array('data-object-fit' => 'contain')); !!}
                  @endif
                </div>
              </div>
              <div data-aos="fade-up" data-aos-offset="120" data-aos-delay="50" data-aos-duration="700"  data-aos-easing="ease-in-out-cubic">@php the_field('step_1') @endphp</div>
            </li>
            <li>
              <div class="circle">
                <div class="image-hold">
                  @php $image_id = get_field('step_2_image') @endphp
                  @if($image_id)
                    {!! wp_get_attachment_image($image_id, 'main', false, array('data-object-fit' => 'contain')); !!}
                  @endif
                </div>
              </div>
              <div data-aos="fade-up" data-aos-offset="120" data-aos-delay="50" data-aos-duration="700"  data-aos-easing="ease-in-out-cubic">@php the_field('step_2') @endphp</div>
            </li>
            <li>
              <div class="circle">
                <div class="image-hold">
                  @php $image_id = get_field('step_3_image') @endphp
                  @if($image_id)
                    {!! wp_get_attachment_image($image_id, 'main', false, array('data-object-fit' => 'contain')); !!}
                  @endif
                </div>
              </div>
              <div data-aos="fade-up" data-aos-offset="120" data-aos-delay="50" data-aos-duration="700"  data-aos-easing="ease-in-out-cubic">@php the_field('step_3') @endphp</div>
            </li>
            <li>
              <div class="circle">
                <div class="image-hold">
                  @php $image_id = get_field('step_4_image') @endphp
                  @if($image_id)
                    {!! wp_get_attachment_image($image_id, 'main', false, array('data-object-fit' => 'contain')); !!}
                  @endif
                </div>
              </div>
              <div data-aos="fade-up" data-aos-offset="120" data-aos-delay="50" data-aos-duration="700"  data-aos-easing="ease-in-out-cubic">@php the_field('step_4') @endphp</div>
            </li>
          </ul>
        </div>
      </div>
    </div>


    @if(get_field('content_after'))
      <div class="row">
        <div class="col-12">
          <div class="content-after no-last-margin">
            @php the_field('content_after') @endphp
          </div>
        </div>
      </div>
    @endif
  </div>
  @include('partials.background-styling')
</div>