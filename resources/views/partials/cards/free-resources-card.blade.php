<a href="@php the_permalink() @endphp" class="work-card post-card subject-card" data-aos="fade-up" data-aos-offset="300" data-aos-duration="1000">
  <div class="inner-card">
    <div class="circle-icon">{!! wp_get_attachment_image( get_field('icon'), 'full', false, array('data-object-fit'=>'cover')) !!}</div>
    <div class="inner-text">
      <div class="left-text text-center">
        <h2>@php the_title() @endphp</h2>
        <button class="btn btn-white btn-pink-hover">See Free @php the_title() @endphp Resources</button>
      </div>
    </div>
  </div>
</a>