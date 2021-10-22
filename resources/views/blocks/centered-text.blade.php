{{--
  Title: Centered text
  Description: Centered text block.
  Category: thync
  Icon: editor-aligncenter
  Keywords: Centered text
  Mode: edit
  Align: full
  SupportsAlign: false
  SupportsMode: true
  SupportsMultiple: true
--}}
<div data-{{ $block['id'] }} class="{{ $block['classes'] }} @include('partials.background-classes') centered-text-block full-width">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 {{ get_field('larger_width') ? "col-lg-11 col-xl-9" : "col-lg-10 col-xl-8"}} text-center">
        <div class="no-last-margin">
          {!! get_field('text_content') !!}
        </div>
      </div>
    </div>
  </div>
</div>
@include('partials.background-styling')