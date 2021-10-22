<div class="post-card product-card" data-aos="fade-up" data-aos-offset="300" data-aos-duration="1000">
  <a href="{{ get_the_permalink() }}" class="inner-card">
    <div class="image-hold">
      <div class="image">
        @if(has_post_thumbnail())
          @php
            $image_id = get_post_thumbnail_id($image_id);
          @endphp
          <div class="featured">
            {!! wp_get_attachment_image($image_id, 'main', false, array('data-object-fit'=>'cover')) !!}
          </div>
        @endif
      </div>
    </div>
    <div class="inner-text">
      <div class="left-text">
        <h3>@php the_title() @endphp</h3>
        @php global $product; @endphp
        @if ( $price_html = $product->get_price_html() )
          <span class="price h4"><?php echo $price_html; ?></span>
        @endif
      </div>
    </div>
  </a>
  <div class="add-to-cart-hold">
    @php 
      echo apply_filters(
        'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
        sprintf(
          '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
          esc_url( $product->add_to_cart_url() ),
          esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
          esc_attr( isset( $args['class'] ) ? $args['class'] . 'btn btn-primary' : 'btn btn-primary' ),
          isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
          esc_html( $product->add_to_cart_text() )
        ),
        $product,
        $args
      );
    @endphp
  </div>
</div>