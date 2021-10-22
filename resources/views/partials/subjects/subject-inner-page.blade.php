@php
  $terms = get_terms(array(
    'taxonomy' => 'ses_level',
    'orderby' => 'menu_order'
  ));
  global $wp;

  $base_url_chemistry =  home_url('/subject/biology');
  $base_url_biology =  home_url('/subject/chemistry');
  $url =  home_url( $wp->request ); 
  function nth_strpos($str, $substr, $n, $stri = false)
{
    if ($stri) {
        $str = strtolower($str);
        $substr = strtolower($substr);
    }
    $ct = 0;
    $pos = 0;
    while (($pos = strpos($str, $substr, $pos)) !== false) {
        if (++$ct == $n) {
            return $pos;
        }
        $pos++;
    }
    return false;
}

$finalurl = substr($url,0,nth_strpos($url, '/', 5, true));
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
      ))
    @endphp
    @if(count($posts))
 @if($count == 1) 
 	 @if($finalurl == $base_url_biology)
     @php $link = $base_url_biology . '/activities/level/' . $term->slug @endphp
        @if( $url==$link || $link==substr($url,0,nth_strpos($url, '/', 8, true))) 
          @php $activeClass = "active"; @endphp
			@elseif($url == $base_url_biology . '/activities/level/a-level/' || $link==substr($url,0,nth_strpos($url, '/', 8, true)))
				 @php $activeClass = "active"; @endphp
		@else
		  @php $activeClass = ""; @endphp
        @endif 
    @else
	 @php $link = $base_url_chemistry . '/activities/level/' . $term->slug @endphp
       @if(strpos($url , "activities")==true)
        @php $activeClass = "active";  @endphp
		@else
		  @php $activeClass = ""; @endphp
       @endif 
   	@endif
      @include('partials.cards.subject-card-inner')
      @php $GLOBALS["terms_count"] ++; ++$count;@endphp

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
	@if($finalurl == $base_url_biology )
     @php $link = $base_url_biology . '/six-mark-questions/level/' . $term->slug @endphp
      @if(strpos( $url , "six-mark-questions" )==true) 
        @php $activeClass = "active";  @endphp
		@else
		  @php $activeClass = ""; @endphp
       @endif 
    @else
	 @php $link = $base_url_chemistry . '/six-mark-questions/level/' . $term->slug @endphp
     @if(strpos($url , "six-mark-questions" )==true) 
 @php $activeClass = "active";  @endphp
	@else
		  @php $activeClass = ""; @endphp
       @endif 
   	@endif
     @include('partials.cards.subject-card-inner')
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
	@if($finalurl == $base_url_biology )
     @php $link = $base_url_biology . '/notes-and-exam-questions/level/' . $term->slug @endphp
      @if(strpos( $url , "notes-and-exam-questions" )==true) 
 @php $activeClass = "active";  @endphp
	@else
		  @php $activeClass = ""; @endphp
       @endif 
    @else
	 @php $link = $base_url_chemistry . '/notes-and-exam-questions/level/' . $term->slug @endphp
     @if(strpos($url , "notes-and-exam-questions")==true) 
 @php $activeClass = "active";  @endphp
	@else
		  @php $activeClass = ""; @endphp
       @endif 
   	@endif
      @include('partials.cards.subject-card-inner')
      @php $GLOBALS["terms_count"] ++; @endphp
    @endif
  @endforeach
@endif