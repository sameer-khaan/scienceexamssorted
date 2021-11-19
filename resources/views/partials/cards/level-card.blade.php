@php
global $wp;
$url = home_url($wp->request . '/');
$post_url = get_permalink();
@endphp

@if ($url == $post_url)
    @php $activeClass = "active"; @endphp
@else
    @php $activeClass = ""; @endphp
@endif

<a href="@php echo $post_url @endphp" class="work-card post-card customStyle subject-card level-card @php echo $activeClass @endphp" data-aos="fade-up" data-aos-offset="150" data-aos-duration="1000">


    @if (get_post_type() == 'ses_activities')
        @php
            // $terms = get_the_terms(get_the_id(), 'ses_tier' );
            $terms = wp_get_post_terms(get_the_id(), 'ses_tier', ['orderby' => 'term_order']);
            $term = array_pop($terms);
        @endphp
        {!! $term->name !!}

    @else
        @php the_title() @endphp
    @endif

</a>
