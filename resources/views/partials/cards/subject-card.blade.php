<a href="{{ $link }}" class="work-card post-card subject-card" data-aos="fade-up" data-aos-offset="300" data-aos-duration="1000">
  <div class="inner-card">
    <div class="circle-icon"><h3>{{$term->name}}</h3></div>
    <div class="inner-text">
      <div class="left-text text-center">
        @php
          $object = get_post_type_object( $post_type );
        @endphp
        <h2>{!!$object->label!!}</h2>
        {!! $object->description !!}
        <button class="btn btn-white btn-pink-hover">{!! $object->labels->view_items !!}</button>
      </div>
    </div>
  </div>
</a>