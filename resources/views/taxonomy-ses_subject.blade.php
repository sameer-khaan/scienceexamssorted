@extends('layouts.app')

@section('content')
    @php $GLOBALS["terms_count"] = 0; @endphp
    @if (get_query_var('page_levels') == 'subject')
        @php
            $url = false;
            $term = get_queried_object();
            $image_id = get_field('page_background_image', $term);
            if ($image_id) {
                $url = wp_get_attachment_image_src($image_id, 'main');
                if ($url) {
                    $url = $url[0];
                }
            }
        @endphp
        @if ($url)
            <div class="full-width white-row global-padding"
                style="background-image: url('{{ $url }}'); background-size: cover; background-position: center; overflow: hidden;">
            @else
                <div class="full-width global-padding ">
        @endif
    @else
        <div class="full-width global-padding ">
    @endif

    <div class="container">
        <div class="search-grid">
            @if (get_query_var('page_levels') == 'subject')
                @include('partials.subjects.subject-page')
            @elseif(get_query_var('page_levels')=="level" || get_query_var('page_levels')=="board")
                @include('partials.subjects.subject-inner-page')
                <div class="secondLayer" data="2" style="width: 100%;display: flex;justify-content: center;">@include('partials.subjects.level-page')</div>
                @if(get_query_var('page_levels')=="board")
                  <div class="secondLayer" data="3" style="width: 100%;display: flex;justify-content: center;">@include('partials.subjects.level-2-page')</div>
                @endif
            @endif
            @if ($GLOBALS['terms_count'] > 2)
                <div class="post-card blank"></div>
                <div class="post-card blank"></div>
                <div class="post-card blank"></div>
            @endif
        </div>

    </div>
    </div>

@endsection
