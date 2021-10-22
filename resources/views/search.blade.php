@extends('layouts.app')

@section('content')

  @if (!have_posts())
    <div class="global-padding full-width">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 text-center">
            <h1>No posts found</h1>
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
    <div class="full-width global-padding" style="overflow: hidden;">
      <div class="container">
        <div class="search-grid"> 
          @while(have_posts()) @php the_post() @endphp
            @include('partials.content-search')
          @endwhile
          <div class="post-card blank"></div>
          <div class="post-card blank"></div>
        </div>
      </div>
    </div>
  @endif

  {!! get_the_posts_navigation() !!}
@endsection
