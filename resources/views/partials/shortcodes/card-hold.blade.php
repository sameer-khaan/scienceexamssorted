@if ( $featured->have_posts() )
  <div class="full-width">
    <div class="container-fluid">
      <div class="search-grid"> 
        @while ( $featured->have_posts() )
          @php 
            $featured->the_post();
          @endphp
          @include('partials.cards.card')
        @endwhile
        @if($featured->found_posts > 2) 
          <div class="post-card blank"></div>
          <div class="post-card blank"></div>
          <div class="post-card blank"></div>
        @endif
      </div>
    </div>
  </div>
  @php 
    wp_reset_postdata();
  @endphp
@endif