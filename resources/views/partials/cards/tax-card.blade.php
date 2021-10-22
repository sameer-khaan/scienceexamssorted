<a href="{!! get_term_link($term) !!}" class="work-card post-card subject-card level-card" data-aos="fade-up" data-aos-offset="300" data-aos-duration="1000">
  <div class="inner-card">
    <div class="inner-text">
      <div class="left-text text-center">
        <h2>{!! $term->name !!}</h2>
        <button class="btn btn-white">View</button>
      </div>
    </div>
  </div>
</a>