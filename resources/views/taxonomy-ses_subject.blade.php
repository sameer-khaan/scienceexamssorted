@extends('layouts.app')

@section('content')
@php $GLOBALS["terms_count"] = 0; @endphp
@if(get_query_var('page_levels')=="subject")
  @php
    $url = false;
    $term = get_queried_object();
    $image_id = get_field( 'page_background_image', $term );
    if($image_id) {
      $url = wp_get_attachment_image_src($image_id, 'main');
      if($url) {
        $url = $url[0];
      }
    }
  @endphp
  @if($url)
    <div class="full-width white-row global-padding" style="background-image: url('{{$url}}'); background-size: cover; background-position: center; overflow: hidden;">
  @else
    <div class="full-width global-padding">
  @endif
@else
  <div class="full-width global-padding">
@endif

  <div class="container">
    <div class="search-grid">
      @if(get_query_var('page_levels')=="subject")
        @include('partials.subjects.subject-page')
      @elseif(get_query_var('page_levels')=="level")
		@include('partials.subjects.subject-inner-page')
		<div class="secondLayer" style="width: 100%;display: flex;justify-content: center;">@include('partials.subjects.level-page')</div>
      @elseif(get_query_var('page_levels')=="board")
        @php
          $post_type = "ses_six_marks";
          $posts = get_posts(array(
            'tax_query' => array(
              array(
                'taxonomy' => 'ses_level',
                'field'    => 'slug',
                'terms'    => array( get_query_var('ses_level') )
              ),
              array(
                'taxonomy' => 'ses_exam_board',
                'field'    => 'slug',
                'terms'    => array( get_query_var('ses_exam_board') )
              ),
              array(
                'taxonomy' => 'ses_subject',
                'field'    => 'slug',
                'terms'    => array( get_query_var('ses_subject') )
              )
            ),
            'post_type' => $post_type,
            'orderby' => 'menu_order',
          ));
          $GLOBALS["terms_count"] = count($posts);
        @endphp
        @foreach ( $posts as $post ) {
          @php
            wp_redirect ( get_permalink ( $post->ID ) );
            exit;
          @endphp
        @endforeach
      @endif
      @if($GLOBALS["terms_count"] > 2) 
        <div class="post-card blank"></div>
        <div class="post-card blank"></div>
        <div class="post-card blank"></div>
      @endif
    </div>
  </div>
</div>

@endsection
