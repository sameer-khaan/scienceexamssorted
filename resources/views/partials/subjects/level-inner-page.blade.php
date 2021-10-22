@if(get_query_var('post_type') == "ses_activities" || get_query_var('post_type') == "ses_exam_paper")

    @while (have_posts()) @php the_post() @endphp

		@include('partials.cards.level-card')
		@php $GLOBALS["terms_count"] ++; @endphp

   @endwhile

@elseif(get_query_var('post_type') == "ses_six_marks")

  @php 
    global $wp;
    $url =  home_url( $wp->request );

	$str = strtolower($url);
    $substr = strtolower('/');
    $ct = 0;
    $pos = 0;
    while (($pos = strpos($str, $substr, $pos)) !== false) {
        if (++$ct == 9) {
            $pos;
			break;
        }
        $pos++;
	}

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
		@if($flag == false)
        	@php $link = substr($url,0,$pos) .'/aqa';  $flag = true; @endphp
			@if(strpos($url , "aqa")==true) 
			  @php $activeClass = "active";  @endphp
				 @else
			  @php $activeClass = ""; @endphp
		   @endif 
		@else
 		@php $link = substr($url,0,$pos) .'/edexcel'  @endphp
			@if(strpos($url , "edexcel")==true) 
			  @php $activeClass = "active";  @endphp
				 @else
			  @php $activeClass = ""; @endphp
		   @endif 
		 @endif
        @include('partials.cards.board-card')
        @php $GLOBALS["terms_count"] ++; @endphp
      @endif
    @endforeach
  @endif
@endif