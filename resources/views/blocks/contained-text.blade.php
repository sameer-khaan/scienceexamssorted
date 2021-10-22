{{--
  Title: Contained text
  Description: Contained text block.
  Category: thync
  Icon: editor-aligncenter
  Keywords: contained editor text
  Mode: edit
  Align: full
  SupportsAlign: false
  SupportsMode: true
  SupportsMultiple: true
--}}
<div data-{{ $block['id'] }} class="{{ $block['classes'] }} @include('partials.background-classes') contained-text-block full-width">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="no-last-margin">
          {!! get_field('text_content') !!}
        </div>
      </div>
    </div>
  </div>
</div>
@include('partials.background-styling')