<header class="main-header">
  <div class="container-fluid">
    <?php
      $logo_svg = get_field('header_logo','option');
      $logo_svg = $logo_svg['ID'];
    ?>
    <div class="row align-items-center justify-content-between">
      <div class="col-6 col-md-3 col-lg-6 col-xl-auto brand-hold">
        <div class="brand" >
          <a href="{{ home_url('/') }}"></a>
          {{-- <img src="{{$logo_svg}}" class="style-svg" alt="{{ get_bloginfo('name', 'display') }}" /> --}}
          @php
            if(get_attached_file($logo_svg)) {
              include(get_attached_file($logo_svg));
            }
          @endphp
        </div>
      </div>
      <div class="col-6 col-md-9 col-lg-6 col-xl-auto nav-hold text-right">
        <div class="header-cart-hold">
          <div class="nav-hold">
            <div class="nav-primary">
              @if (has_nav_menu('primary_navigation'))
                {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
              @endif
            </div>
            <div class="mobile-nav-contact-details">
              {{-- @include('partials.svg.nav-mobile-clip') --}}
              <div class="contact-details">
                <div class="social-links">@include('partials.social')</div>
                <ul>
                  @if(get_field('contact_phone','option'))
                    @php $phone = preg_replace('/\s+/', '', get_field('contact_phone','option')); @endphp
                    <li><a href="tel:{{$phone}}" target="_blank"><i class="far fa-phone-rotary"></i>{{get_field('contact_phone','option')}}</a></li>
                  @endif
                  @if(get_field('contact_email','option'))
                    <li><a href="mailto:{{get_field('contact_email','option')}}" target="_blank"><i class="far fa-envelope"></i>{{get_field('contact_email','option')}}</a></li>
                  @endif
                  @if(get_field('contact_address','option'))
                    <li class="address"><i class="far fa-map-marker-alt"></i>{{get_field('contact_address','option')}}</li>
                  @endif
                </ul>
              </div>
            </div>
          </div>
          <div class="header-cart">
          </div>
          <button class="hamburger hamburger--collapse menu-toggle d-inline-block d-xl-none" type="button">
            <span class="hamburger-box">
              <span class="hamburger-inner"></span>
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>
</header>