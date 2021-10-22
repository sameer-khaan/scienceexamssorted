<div class="footer-social">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <h3>Follow us:</h3>
        <div class="social-icons">
          @include('partials.social')
        </div>
      </div>
    </div>
  </div>
</div>
<footer class="website-footer">
  <div class="container">
    <div class="row">
      <div class="col-12">
        @php
          $image = get_field('footer_logo','option');
          $size = 'full'; // (thumbnail, medium, large, full or custom size)
          
          if( $image ) {
            echo '<a href="'.get_home_url().'" class="footer-logo">' . wp_get_attachment_image( $image, $size, false, array('class'=>'style-svg')  ) . '</a>';
          }
        @endphp 
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <nav class="footer-nav">
          <span>&copy; {{ date('Y') }} - {!! get_bloginfo('name') !!}</span>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <nav class="footer-nav">
          @if (has_nav_menu('footer_navigation_1'))
            {!! wp_nav_menu(['theme_location' => 'footer_navigation_1', 'menu_class' => 'nav', 'after'=>'<span class="sep">|</span>']) !!}
          @endif
        </nav>
      </div>
    </div>
    <div class="row bottom-footer">
      <div class="col-12">
        <span><a href="https://thync.uk/" target="_blank">Website by Thync Creative</a></span>
      </div>
    </div>
  </div>
</footer>