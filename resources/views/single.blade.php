@extends('layouts.app')

@section('content')
         <div class="secondLayer" style="width: 100%;display: flex;justify-content: center; margin-top:100px;">@include('partials.subjects.subject-inner-page')</div>

		<div class="secondLayer" style="width: 100%;display: flex;justify-content: center;">@include('partials.subjects.level-inner-page')</div>

  @while(have_posts()) @php the_post() @endphp
    @include('partials.content-single-'.get_post_type())
  @endwhile
@endsection
