@if ( $featured )
  <div class="container-fluid p-0">
    <div class="search-grid columns-2"> 
      @foreach( $featured as $term )
        @include('partials.cards.tax-card')
      @endforeach
      <div class="post-card blank"></div>
      <div class="post-card blank"></div>
      <div class="post-card blank"></div>
    </div>
  </div>
@endif