@if(get_post_type() == 'product' && !is_search())
  @include('partials.cards.product')
@else
  <a href="{{ get_the_permalink() }}" class="work-card post-card" data-aos="fade-up" data-aos-offset="300" data-aos-duration="1000">
      <div class="inner-card">
        <div class="image-hold">
          <div class="image">
            @if(has_post_thumbnail())
              @php
                $image_id = get_post_thumbnail_id($image_id);
              @endphp
            @else
              @php
                $image_id = get_field('no_image', 'option');
              @endphp
            @endif
            <div class="featured">
              {!! wp_get_attachment_image($image_id, 'main', false, array('data-object-fit'=>'cover')) !!}
            </div>
          </div>
          @if(get_post_type() == 'post')
            <div class="date-hold">
              @php 
                // Load field value.
                $date_string = get_the_date('jS F Y');

                // Create DateTime object from value (formats must match).
                $date = DateTime::createFromFormat('jS F Y', $date_string);

                $day = $date->format('j');
                $month = $date->format('M');
              @endphp
              <div class="day">{{$day}}</div>
              <div class="month">{{$month}}</div>
            </div>
          @endif
        </div>
        <div class="inner-text">
          <div class="left-text">
            <h2>@php the_title() @endphp</h2>
            @if(get_post_type() == 'mrss_event')
              @if(get_field('snippet'))
                @php the_field('snippet') @endphp
              @endif
              @if(get_field('price_text'))
                <h4>@php the_field('price_text') @endphp</h4>
              @endif
            @endif
            {{-- <ul>
              @if(is_search())
                @php 
                  $type = "";
                  $post_type = get_post_type_object(get_post_type());
                  if($post_type) {
                    $type = $post_type->labels->singular_name;
                  }
                @endphp
                <li><i class="far fa-tag"></i><strong>Type:</strong> {{$type}}</li>
              @endif
              @if(get_post_type() == 'post')
                <li><i class="far fa-clock"></i> {{ get_the_date() }}</li>
              @endif
              @if(get_post_type() == 'mrss_event')
                @if(get_field('event_date'))
                  <li><i class="far fa-calendar-alt"></i>{{get_field('event_date')}}</li>
                @endif
                @if(get_field('event_time'))
                  <li><i class="far fa-clock"></i>{{get_field('event_time')}}</li>
                @endif
              @endif
            </ul> --}}
          </div>
        </div>
      </div>
  </a>
@endif