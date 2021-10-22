<div class="contact-details-shortcode">
  <ul>
    @if(get_field('contact_address','option'))
      <li><i class="far fa-map-pin"></i><strong>{{get_field('contact_address','option')}}</strong></li>
    @endif
    @if(get_field('contact_phone','option'))
      @php $phone = preg_replace('/\s+/', '', get_field('contact_phone','option')); @endphp
      <li class="phone"><i class="far fa-phone-rotary"></i><a href="tel:{{$phone}}" target="_blank">{{get_field('contact_phone','option')}}</a></li>
    @endif
    @if(get_field('contact_email','option'))
      <li class="email"><i class="far fa-envelope"></i><a href="mailto:{{get_field('contact_email','option')}}" target="_blank">{{get_field('contact_email','option')}}</a></li>
    @endif
  </ul>
</div>