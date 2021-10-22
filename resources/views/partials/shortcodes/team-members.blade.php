@if ( $the_query->have_posts() )
  <div class="team-members">
    @while ( $the_query->have_posts() )
      @php 
        $the_query->the_post();
        $image_id = get_post_thumbnail_id(get_the_id());
      @endphp
      <div class="team-member">
        <div class="image-outer">
          <div class="image">
            @if($image_id)
              {!! wp_get_attachment_image($image_id, 'large', false) !!}
            @else
              {!! wp_get_attachment_image(get_field('blank_team_member_image', 'option'), 'large', false) !!}
            @endif
          </div>
        </div>
        <div class="text">
          <div class="title">
            <h3 class="h4 text-center">{{ get_the_title() }}</h3>
            @if(get_field('job_title'))
              <div class="job-title">{!! get_field('job_title') !!}</div>
            @endif
          </div>
          @if(get_field('email_address'))
            <div class="email"><a href="mailto:{{get_field('email_address')}}"><i class="far fa-envelope-open-text"></i>Email me</a></div>
          @endif
        </div>
      </div>
    @endwhile
    <div class="team-member blank"></div>
    <div class="team-member blank"></div>
    <div class="team-member blank"></div>
  </div>
@endif
@php 
  wp_reset_postdata();
@endphp