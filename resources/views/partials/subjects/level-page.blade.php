@if(get_query_var('post_type') == "ses_activities" || get_query_var('post_type') == "ses_exam_paper")

  @while (have_posts()) @php the_post() @endphp
    @include('partials.cards.level-card')
    @php $GLOBALS["terms_count"] ++; @endphp
  @endwhile

@elseif(get_query_var('post_type') == "ses_six_marks")
  @php 
    global $wp;
    $base_url =  home_url( $wp->request );

    $terms = get_terms(array(
      'taxonomy' => 'ses_exam_board',
      'orderby' => 'menu_order'
    ));
  @endphp
  @if($terms)
    @foreach($terms as $term)
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
        @php $link = $base_url . '/board/' . $term->slug @endphp
        @include('partials.cards.board-card')
        @php $GLOBALS["terms_count"] ++; @endphp
      @endif
    @endforeach
  @endif
@endif