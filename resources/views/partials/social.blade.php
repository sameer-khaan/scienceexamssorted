@php
  if(get_field('facebook_url', 'option')) {
    echo '<a href="'.get_field('facebook_url', 'option').'" target="_blank"><i class="fab fa-facebook"></i></a>';
  }

  if(get_field('instagram_url', 'option')) {
    echo '<a href="'.get_field('instagram_url', 'option').'" target="_blank"><i class="fab fa-instagram"></i></a>';
  }

  if(get_field('twitter_url', 'option')) {
    echo '<a href="'.get_field('twitter_url', 'option').'" target="_blank"><i class="fab fa-twitter"></i></a>';
  }

  if(get_field('linkedin_url', 'option')) {
    echo '<a href="'.get_field('linkedin_url', 'option').'" target="_blank"><i class="fab fa-linkedin"></i></a>';
  }

  if(get_field('tripadvisor_url', 'option')) {
    echo '<a href="'.get_field('tripadvisor_url', 'option').'" target="_blank"><i class="fab fa-tripadvisor"></i></a>';
  }
@endphp