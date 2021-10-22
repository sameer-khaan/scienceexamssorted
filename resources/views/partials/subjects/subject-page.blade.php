@php
  $terms = get_terms(array(
    'taxonomy' => 'ses_level',
    'orderby' => 'menu_order'
  ));
  global $wp;
  $base_url =  home_url( $wp->request );
@endphp

@if($terms)
	@php    $count = 1; @endphp
  @foreach($terms as $term)
    @php
		
      $post_type = "ses_activities";
      $posts = get_posts(array(
        'tax_query' => array(
          array(
            'taxonomy' => 'ses_level',
            'field'    => 'slug',
            'terms'    => array( $term->slug )
          ),
          array(
            'taxonomy' => 'ses_subject',
            'field'    => 'slug',
            'terms'    => array( get_query_var('ses_subject') )
          )
        ),
        'post_type' => $post_type
      ));
    @endphp

    @if(count($posts))
		@if($count == 1) 
			@php $link = $base_url . '/activities/level/' . $term->slug @endphp
			@include('partials.cards.subject-card')
			@php $GLOBALS["terms_count"] ++; ++$count; @endphp
		@endif
    @endif

    @php
      $post_type = "ses_six_marks";
      $six_marks = get_posts(array(
        'tax_query' => array(
          array(
            'taxonomy' => 'ses_level',
            'field'    => 'slug',
            'terms'    => array( $term->slug )
          )
        ),
        'post_type' => $post_type
      ));
    @endphp
    @if(count($six_marks))
      @php $link = $base_url . '/six-mark-questions/level/' . $term->slug @endphp
      @include('partials.cards.subject-card')
      @php $GLOBALS["terms_count"] ++; @endphp
    @endif

    @php
      $post_type = "ses_exam_paper";
      $papers = get_posts(array(
        'tax_query' => array(
          array(
            'taxonomy' => 'ses_level',
            'field'    => 'slug',
            'terms'    => array( $term->slug )
          )
        ),
        'post_type' => $post_type
      ));
    @endphp
    @if(count($papers))
      @php $link = $base_url . '/notes-and-exam-questions/level/' . $term->slug @endphp
      @include('partials.cards.subject-card')
      @php $GLOBALS["terms_count"] ++; @endphp
    @endif
  @endforeach
@endif
