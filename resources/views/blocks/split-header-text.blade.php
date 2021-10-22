{{--
  Title: Split header text
  Description: Hader on left, text on right.
  Category: thync
  Icon: align-right
  Keywords: left right header text heading
  Mode: edit
  Align: full
  SupportsAlign: false
  SupportsMode: true
  SupportsMultiple: true
--}}
<div data-{{ $block['id'] }} class="split-header-block {{ $block['classes'] }} @include('partials.background-classes') full-width">
  <div class="container">
    <div class="row justify-content-center lg-gutter">
      <div class="col-12 col-lg-4 col-xl-4">
        <div class="content-hold">
          <div class="inner-content no-last-margin text-left text-md-right">
            {!! get_field('left_header') !!}
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-8 col-xl-8">
        <div class="no-last-margin">
          {!! get_field('right_content') !!}
        </div>
      </div>
    </div>
  </div>
</div>
@include('partials.background-styling')