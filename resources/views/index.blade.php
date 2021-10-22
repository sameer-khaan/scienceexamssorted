@extends('layouts.app')

@section('content')

  @if(is_archive())
    @php
      $post_type = get_post_type();
      if ( $post_type )
      {
          $post_type_data = get_post_type_object( $post_type );
          $post_type_slug = $post_type_data->rewrite['slug'];
          $slug = $post_type_slug;
          $page = get_page_by_path( $slug );
          if($page) {
            $your_query = new WP_Query( array( 'page_id' => $page->ID ) );
            // "loop" through query (even though it's just one page)
            if($your_query->have_posts()) {
              while ( $your_query->have_posts() ) : $your_query->the_post();
                  the_content();
              endwhile;
            }
            // reset post data (important!)
            wp_reset_postdata();
          }
      }
    @endphp
  @endif

  @if (!have_posts())
    <div class="global-padding full-width">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 text-center">
            <h1>Nothing found</h1>
            <a href="/" class="btn btn-primary">Go home</a>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <div class="global-padding full-width">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-md-8 col-xl-5">
            {!! get_search_form(false) !!}
          </div>
        </div>
      </div>
    </div>
  
  
  @else
    <div class="full-width">
      <div class="container">
        <div class="search-grid"> 
          @while (have_posts()) @php the_post() @endphp
            @if(is_post_type_archive( 'ses_free_resources' ))
              @include('partials.cards.free-resources-card')
            @else
              @include('partials.content-'.get_post_type())
            @endif
          @endwhile

          @if($GLOBALS['wp_query']->post_count > 2) 
            <div class="post-card blank"></div>
            <div class="post-card blank"></div>
            <div class="post-card blank"></div>
          @endif
        </div>
      </div>
    </div>

  @endif

  {!! get_the_posts_navigation() !!}
@endsection
