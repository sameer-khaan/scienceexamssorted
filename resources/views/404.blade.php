@extends('layouts.app')

@section('content')
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
  @endif
@endsection
