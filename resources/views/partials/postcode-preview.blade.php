 <a href="{{ get_the_permalink() }}" class="work-card post-card" data-aos="fade-up" data-aos-offset="300" data-aos-duration="1000" @if(!$show_card) data-do-nothing="true" @endif>
 	<div class="inner-card">
 		@if(!$postcode_entered || !$valid)
 			@php
 				$matched_text = '<i class="far fa-map-marker-exclamation"></i> Please enter a valid postcode';
	    	$matched_css = '';
 			@endphp
 		@else
	 		@if($matched)
	 			@php
	    		$matched_text = '<i class="far fa-check"></i> Available';
	    		$matched_css = 'available';
	    	@endphp
	  	@else
	  		@if(get_field('no_match') == "Make not available")
	  			@php
	    			$matched_text = '<i class="far fa-times"></i> Not available';
	    			$matched_css = '';
	    		@endphp
	  		@else
	  			@php
	    			$matched_text = '<i class="far fa-map-marker-exclamation"></i> Collection in Maldon only';
	    			$matched_css = 'collection';
	    		@endphp
	  		@endif
	  	@endif
	  @endif
 		<div class="available-hold {{$matched_css}}">
 			{!!$matched_text!!}
 		</div>
    <div class="image-hold">
      <div class="image">
      	@if(get_field('postcode_image'))
          @php
            $image_id = get_field('postcode_image');
          @endphp
          <div class="featured">
            {!! wp_get_attachment_image($image_id, 'main', false, array('data-object-fit'=>'contain')) !!}
          </div>
        @endif
      </div>
    </div>
    <div class="inner-text">
      <div class="left-text">
        <h3>@php the_field('postcode_title', get_the_id()) @endphp</h3>
        @php the_field('postcode_description', get_the_id()) @endphp
        @if($matched)
        	<button class="btn btn-white">Learn more &amp; order</button>
        @else
        	<button class="btn btn-white">Learn more</button>
        @endif
      </div>
    </div>
  </div>
 </a>