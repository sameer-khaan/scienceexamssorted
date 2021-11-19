@php
global $wp;
$url = home_url($wp->request);
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
                'terms' => [get_query_var('ses_tier')],
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
                'terms' => [get_query_var('ses_exam_board')],
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
@if ($posts)
    @foreach ($posts as $post)
        @php
        if(get_query_var('post_type') == "ses_six_marks") {
            wp_redirect ( get_permalink ( $post->ID ) );
            exit;
        }
        @endphp
        @if (strpos($url, $post->post_name) == true)
            @php $activeClass = "active";  @endphp
        @else
            @php $activeClass = ""; @endphp
        @endif
        <a href="{{ get_permalink($post->ID) }}" class="work-card post-card subject-card level-card {{$activeClass}} customStyle" data-aos="fade-up" data-aos-offset="150" data-aos-duration="1000">
            {!! $post->post_title !!}
        </a>
        @php $GLOBALS["terms_count"] ++; @endphp
    @endforeach
@endif
