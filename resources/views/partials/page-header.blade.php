@if(!get_field('hide_sub-banner') || is_search())
@if(is_home())
  @php $image_id = get_option( 'page_for_posts' ) @endphp
@elseif(is_tax('ses_subject'))
  @php
    $term = get_queried_object();
    $image_id = get_field( 'featured_image', $term );
  @endphp
@elseif(function_exists('is_shop') && is_shop())
  @php $image_id = wc_get_page_id( 'shop' ); @endphp
@elseif(is_archive())
  @php
    $post_type = get_post_type();
    if ( $post_type )
    {
        $post_type_data = get_post_type_object( $post_type );
        $post_type_slug = $post_type_data->rewrite['slug'];
        $slug = $post_type_slug;
        $page = get_page_by_path( $slug );
        if($page) {
          $image_id = $page;
        } 
    }
  @endphp
@else
  @php $image_id = get_the_id() @endphp
@endif
@php 
  if(!is_tax('ses_subject')) {
    $image_id = get_post_thumbnail_id($image_id);
  }
@endphp
<div class="page-header full-width white-row">
  <div class="container-fluid p-0">
    <div class="row align-content-center">
      <div class="col-12 col-md-7">
        <div class="title-breadcumbs">
          <h1 class="h2">{!! App::title() !!}</h1>
          @if ( function_exists('yoast_breadcrumb') ) 
            @php yoast_breadcrumb( '<div id="breadcrumbs">','</div>' ); @endphp
          @endif
        </div>
      </div>
      @if($image_id)
        <div class="col-12 col-md-5 image-outer">
          @include('partials.svg.header-clip')
          <div class="object-image">
            {!! wp_get_attachment_image($image_id, 'large', false, array('data-object-fit'=>'cover')) !!}
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
@endif