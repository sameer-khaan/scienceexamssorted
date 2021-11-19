@extends('layouts.app')

@section('content')
    <div class="secondLayer" style="width: 100%;display: flex;justify-content: center; margin-top:100px;">@include('partials.subjects.subject-inner-page')</div>

    <div class="secondLayer" data="1" style="width: 100%;display: flex;justify-content: center;">@include('partials.subjects.level-inner-page')</div>

    @if(get_query_var('post_type') != "ses_six_marks")
      <div class="secondLayer" data="3" style="width: 100%;display: flex;justify-content: center;">@include('partials.subjects.level-2-page')</div>
    @endif

    @while (have_posts()) @php the_post() @endphp
        @include('partials.content-single-'.get_post_type())
    @endwhile
@endsection
