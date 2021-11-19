@php
global $wp;
$url = home_url($wp->request);

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

if(get_query_var('post_type') == 'ses_activities') {

    $terms = get_terms([
        'taxonomy' => 'ses_tier',
        'orderby' => 'menu_order',
    ]);

} else if(get_query_var('post_type') == "ses_six_marks" || get_query_var('post_type') == "ses_exam_paper") {

    $terms = get_terms([
        'taxonomy' => 'ses_exam_board',
        'orderby' => 'menu_order',
    ]);
}
@endphp

@if ($terms)
    @foreach ($terms as $term)
        @php
            $post_type = get_query_var('post_type');
            if(get_query_var('post_type') == 'ses_activities'){
                $posts = get_posts([
                    'tax_query' => [
                        [
                            'taxonomy' => 'ses_level',
                            'field' => 'slug',
                            'terms' => [get_query_var('ses_level')],
                        ],
                        [
                            'taxonomy' => 'ses_tier',
                            'field' => 'slug',
                            'terms' => [$term->slug],
                        ],
                        [
                            'taxonomy' => 'ses_subject',
                            'field' => 'slug',
                            'terms' => [get_query_var('ses_subject')],
                        ],
                    ],
                    'post_type' => $post_type,
                    'orderby' => 'menu_order',
                ]);
            }
            else if (get_query_var('post_type') == "ses_six_marks" || get_query_var('post_type') == "ses_exam_paper") {
                $posts = get_posts([
                    'tax_query' => [
                        [
                            'taxonomy' => 'ses_level',
                            'field' => 'slug',
                            'terms' => [get_query_var('ses_level')],
                        ],
                        [
                            'taxonomy' => 'ses_exam_board',
                            'field' => 'slug',
                            'terms' => [$term->slug],
                        ],
                        [
                            'taxonomy' => 'ses_subject',
                            'field' => 'slug',
                            'terms' => [get_query_var('ses_subject')],
                        ],
                    ],
                    'post_type' => $post_type,
                    'orderby' => 'menu_order',
                ]);
            }
        @endphp

        @if (count($posts))
            @php
                $link = substr($url,0,$pos) .'/'.$term->slug;
            @endphp
            @if (strpos($url, $term->slug) == true)
                @php $activeClass = "active";  @endphp
            @else
                @php $activeClass = ""; @endphp
            @endif
            @include('partials.cards.board-card')
            @php $GLOBALS["terms_count"] ++; @endphp
        @endif
    @endforeach
@endif