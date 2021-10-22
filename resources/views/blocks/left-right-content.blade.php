{{--
  Title: Left & right bordered content
  Description: Text on left and text on right in a border.
  Category: thync
  Icon: image-flip-horizontal
  Keywords: text image clip mask split
  Mode: edit
  Align: full
  SupportsAlign: false
  SupportsMode: true
  SupportsMultiple: true
--}}

<div data-{{ $block['id'] }} class="{{ $block['classes'] }} @include('partials.background-classes') left-right-text-block full-width">
  <div class="container">
    <div class="row lg-gutter justify-content-center align-items-stretch">
      <div class="col-12 col-md-6">
        <div class="inner-text no-last-margin">
          {!! get_field('left_content') !!}
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="inner-text no-last-margin">
          {!! get_field('right_content') !!}
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
  @if(get_field('border_colour'))
    [data-{{$block['id']}}] .inner-text {
      border-color: {{get_field('border_colour')}} !important;
    }
  @endif
</style>
@include('partials.background-styling')