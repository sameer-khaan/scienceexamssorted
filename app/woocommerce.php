<?php


add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

//remove food_delivery from default shop page
function remove_food_products_pre_get_posts_query( $q ) {
    $tax_query = (array) $q->get( 'tax_query' );

    $tax_query[] = array(
      'taxonomy' => 'product_cat',
      'field'    => 'slug',
      'terms'    => array('food-delivery', 'nationwide-food-delivery', 'food-truck-collection'),
      'operator' => 'NOT IN',
    );


    $q->set( 'tax_query', $tax_query );

}
add_action( 'woocommerce_product_query', 'remove_food_products_pre_get_posts_query' );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

add_action( 'woocommerce_after_single_product_summary' , 'output_order_table', 20);
function output_order_table() {
  global $product;
  if ( is_product() && has_term( 'food-delivery', 'product_cat' ) ) {
    echo '<div style="clear:both; padding-top: 60px;">';
    echo '<h3>Our other local food items:</h3>';
    echo do_shortcode('[product_table category="food-delivery"]');
    echo '</div>';
  }

  if ( is_product() && has_term( 'food-truck-collection', 'product_cat' ) ) {
    echo '<div style="clear:both; padding-top: 60px;">';
    echo '<h3>Our other food truck items for pre-order:</h3>';
    echo do_shortcode('[product_table category="food-truck-collection"]');
    echo '</div>';
  }

  if ( is_product() && has_term( 'nationwide-food-delivery', 'product_cat' ) ) {
    echo '<div style="clear:both; padding-top: 60px;">';
    echo '<h3>Our other nationwide food items:</h3>';
    echo do_shortcode('[product_table category="nationwide-food-delivery"]');
    echo '</div>';
  }
}

/********************************************
           WOOCOMMERCE FILTERS
********************************************/


if ( class_exists( 'WooCommerce' ) ) {

  //remove rating from archive loop
  remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating' );



  //change archive prices to "FROM: XX"
  function wc_ninja_custom_variable_price( $price, $product ) {
      // Main Price
      $prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
      $price = $prices[0] !== $prices[1] ? sprintf( __( 'From %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );

      // Sale Price
      $prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
      sort( $prices );
      $saleprice = $prices[0] !== $prices[1] ? sprintf( __( 'From %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );

      if ( $price !== $saleprice ) {
          $price = '' . $saleprice . ' ' . $price . '';
      }
      
      return $price;
  }
  add_filter( 'woocommerce_variable_sale_price_html', __NAMESPACE__.'\\wc_ninja_custom_variable_price', 10, 2 );
  add_filter( 'woocommerce_variable_price_html', __NAMESPACE__.'\\wc_ninja_custom_variable_price', 10, 2 );




  //remove woocommerce breadcrums
  add_action( 'init', __NAMESPACE__.'\\jk_remove_wc_breadcrumbs' );
  function jk_remove_wc_breadcrumbs() {
      remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
  }


  //remove sidebar on product page
  add_action( 'wp', __NAMESPACE__.'\\bbloomer_remove_sidebar_product_pages' );
  function bbloomer_remove_sidebar_product_pages() {
      if (is_product()) {
          remove_action('woocommerce_sidebar','woocommerce_get_sidebar',10);
      }
  }


  //remove short description and move bullet points to content
  function remove_short_description() {
      remove_meta_box( 'postexcerpt', 'product', 'normal');
  }
  //add_action('add_meta_boxes', __NAMESPACE__.'\\remove_short_description', 999);

  //remove product sku
  //add_filter( 'wc_product_sku_enabled', '__return_false' );

  add_filter( 'woocommerce_show_page_title', '__return_false' );

  //change shipping to delivery
  add_filter('gettext', __NAMESPACE__.'\\translate_reply');
  add_filter('ngettext', __NAMESPACE__.'\\translate_reply');
  function translate_reply($translated) {
      $translated = str_ireplace('Shipping', 'Delivery', $translated);
      return $translated;
  }
  add_filter( 'woocommerce_shipping_package_name' , __NAMESPACE__.'\\woocommerce_replace_text_shipping_to_delivery', 10, 3);
  function woocommerce_replace_text_shipping_to_delivery($package_name, $i, $package){
      return sprintf( _nx( 'Delivery', 'Delivery %d', ( $i + 1 ), 'shipping packages', 'put-here-you-domain-i18n' ), ( $i + 1 ) );
  }



  //remove picture link woocommerce
  function custom_themify_single_product_image_html( $html, $post_id ) {
      return get_the_post_thumbnail( $post_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
  }
  add_filter('woocommerce_single_product_image_html', __NAMESPACE__.'\\custom_themify_single_product_image_html', 10, 2);



  //move the coupon placement in checkout
  // remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
  // add_action( 'woocommerce_after_checkout_form', 'woocommerce_checkout_coupon_form' );



  //move variation price on single product page
  function move_variation_price() {
      if(is_product()) {
          global $product;
          $id = $product->get_id();
          if(function_exists ('\get_product_addons')){
              $product_addons = \get_product_addons($id);
              if ( is_array( $product_addons ) && count( $product_addons ) > 0 ) {
                  remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
                  add_action( 'woocommerce-product-addons_end', 'woocommerce_single_variation', 9 );
              }
          }
      }
  }
  add_action( 'woocommerce_before_add_to_cart_form', __NAMESPACE__.'\\move_variation_price' );



  //add my basket text before basket loop
  add_action( 'woocommerce_before_cart_contents', __NAMESPACE__.'\\my_basket_text', 2 );

  function my_basket_text() {
      echo '<h3>My basket</h3>';
  }



  //remove cross sells from basket
  remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');



  //change empty cart message
  //add_filter( 'wc_empty_cart_message', __NAMESPACE__.'\\custom_wc_empty_cart_message_1' );
  remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );

  function custom_wc_empty_cart_message_1() {
    return '';
  }

  add_action( 'woocommerce_cart_is_empty', __NAMESPACE__.'\\custom_wc_empty_cart_message',20);

  function custom_wc_empty_cart_message() {
    echo '
    <div class="empty-basket">';
      if(get_field('empty_basket_image','option')) {
        echo '<img src="'.wp_get_attachment_url(get_field('empty_basket_image','option')).'" alt="Empty Basket" /><br>';
      }
    echo  'Your basket is currently empty.
    </div>';
    echo '<div class="text-center"><a class="btn btn-primary" style="margin-bottom: 20px;" href="'.get_permalink( wc_get_page_id( 'myaccount' ) ).'">My Account</a></div>';
  }


  //update the product tabs
  add_filter( 'woocommerce_product_tabs', __NAMESPACE__.'\\woo_change_product_tabs', 98 );
  function woo_change_product_tabs( $tabs ) {

      unset( $tabs['description'] );        // Remove the description tab
      unset( $tabs['reviews'] );      // Remove the reviews tab
      unset( $tabs['additional_information'] );   // Remove the additional information tab
      $tabs['product_description']['title'] = __( 'Product description' );
      $tabs['product_description']['callback'] = __NAMESPACE__.'\\content_tab';    // Custom description callback

      global $product;
      
      if($product->is_type('bargetrust_trip')):

          $terms = get_the_terms( $product->get_id() , 'trip_category' );
          if($terms) {
              foreach ( $terms as $term ) {
                  if(get_field('trip_category_tab_title', $term)) {
                      $tabs[$term->slug]['title'] = __( get_field('trip_category_tab_title', $term) );
                      $tabs[$term->slug]['callback'] = __NAMESPACE__.'\\trip_category_tab';    // Custom description callback
                      $tabs[$term->slug]['term'] = $term;
                  }
              } 
          }

          $tabs['boarding_details']['title'] = __( 'Boarding details' );
          $tabs['boarding_details']['callback'] = __NAMESPACE__.'\\boarding_tab';    // Custom description callback

      endif;
      return $tabs;
  }

  function trip_category_tab($param, $args) {
      echo "<h3>". get_field('trip_category_tab_title', $args['term']) ."</h3>";
      echo '<div class="trip-details-text">' . the_field('trip_category_details', $args['term']) . "</div>";

      $images = get_field('trip_category_gallery', $args['term']);

      if( $images ) {
        echo '<div class="slider-hold">
          <ul id="slider" class="slider '.$args['term']->slug.'-for">';
            foreach( $images as $image ):
              echo '<li>
                    <img src="'.$image['url'].'" alt="'.$image['alt'] .'" />
                    <p>'.$image['caption'].'</p>
                  </li>';
            endforeach;
          echo '</ul>
          <ul id="carousel" class="slider '.$args['term']->slug.'-nav slider-nav">';
            foreach( $images as $image ):
              echo '<li>
                <img src="' . $image['sizes']['slider-thumbnail'] . '" alt="' . $image['alt'] . '" />
              </li>';
            endforeach;
          echo '</ul>
        </div>';

        echo '
          <script type="text/javascript">
            jQuery(document).ready(function($) {
              $(".'.$args['term']->slug.'-for").slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                fade: true,
                asNavFor: ".'.$args['term']->slug.'-nav",
                adaptiveHeight: true
              });

              $(".'.$args['term']->slug.'-nav").slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                asNavFor: ".'.$args['term']->slug.'-for",
                dots: true,
                centerMode: true,
                focusOnSelect: true
              });

              $("body").on(\'click\', \'.wc-tabs\', function( e ) {
                setTimeout(function() {
                    $(".'.$args['term']->slug.'-nav")[0].slick.refresh();
                    $(".'.$args['term']->slug.'-for")[0].slick.refresh();
                }, 500);
              });
            });


          </script>
        ';
      }
  }

  function content_tab() {
      if(get_the_content()=="") {
          echo '<p>No additional information</p>';
      } else {
          the_content();
      }
  }

  function boarding_tab() {
      if(get_field('boarding_details_text')=="") {
          the_field('boarding_details_text', "option");
      } else {
          the_field('boarding_details_text');
      }
  }


  //add shop link to yoast breadcrumbs for woocommerce pages. 
  add_filter( 'wpseo_breadcrumb_links', __NAMESPACE__.'\\wpseo_breadcrumb_add_woo_shop_link' );
  function wpseo_breadcrumb_add_woo_shop_link( $links ) {
      global $post;
      if ( is_woocommerce() ) {
          $breadcrumb[] = array(
              'url' => get_permalink( wc_get_page_id( 'shop' ) ),
              'text' => 'Shop',
          );
          array_splice( $links, 1, -2, $breadcrumb );
      }
      return $links;
  }


  //remove upsells
  remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

  //remove crosssells 
  remove_action( 'woocommerce_after_single_product_summary', 'output_crosssells', 19 );

  //change related products text
  function custom_related_products_text( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
      case 'Related products' :
        $translated_text = __( 'Other products', 'woocommerce' );
        break;
    }
    return $translated_text;
  }
  add_filter( 'gettext',  __NAMESPACE__.'\\custom_related_products_text', 20, 3 );



  //change number of realted products
  add_filter( 'woocommerce_output_related_products_args', __NAMESPACE__.'\\change_number_related_products', 9999 );
   
  function change_number_related_products( $args ) {
      $args['posts_per_page'] = 3; // # of related products
      $args['columns'] = 3; // # of columns per row
      $args['orderby'] = 'menu_order date';
      $args['meta_query'] = array (
          array(
              'key'     => 'hide_in_related_products',
              'value'   => 'true',
          ),
      );
    

      return $args;
      
  }

  remove_action( 'woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title', 10 );
  add_action('woocommerce_shop_loop_item_title', __NAMESPACE__.'\\abChangeProductsTitle', 10 );
  //add_action('woocommerce_single_product_summary', __NAMESPACE__.'\\abChangeProductsTitle', 10 );
      

  function abChangeProductsTitle() {
      echo '<h3 class="woocommerce-loop-product_title">' . get_the_title() . '</h3>';
  }


  //add_action( 'woocommerce_after_shop_loop_item_title', __NAMESPACE__.'\\add_short_to_woocommerce_loop', 5 );
   
  function add_short_to_woocommerce_loop() {
      echo '<div class="excerpt">';
          the_excerpt();
      echo '</div>';
  }

  // change to 3 products per row
  add_filter('loop_shop_columns', __NAMESPACE__.'\\loop_columns');
  if (!function_exists('loop_columns')) {
      function loop_columns() {
          return 3; // 3 products per row
      }
  }

  //remove product meta
  remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );




  add_action( 'init', __NAMESPACE__.'\\expire_old_bargetrust_trips_posts' );
  function expire_old_bargetrust_trips_posts() {
      $today = date('Ymd');

      $meta_query[] = array(
          'key'     => 'start_date',
          'value'   => $today,
          'compare' => '<',
          'type'    => 'DATE'
      );

      $tax_query[] = array(
          'taxonomy' => 'product_type',
          'field'    => 'slug',
          'terms'    => 'bargetrust_trip',
          'operator' => 'IN',
      );

      $args = array(
          'post_type' => 'product',
          'order' => 'ASC',
          'posts_per_page' => -1,
          'meta_key' => 'start_date',
          'meta_query' => $meta_query,
          'tax_query' => $tax_query,
      );

      $posts = get_posts( $args );

      if($posts) {
          foreach ( $posts as $post ) {
              wp_trash_post( $post->ID );
          }
      }

  }



  /* Change coupon to voucher */
  add_filter( 'gettext', __NAMESPACE__.'\\woocommerce_rename_coupon_field_on_cart', 10, 3 );
  add_filter( 'gettext', __NAMESPACE__.'\\woocommerce_rename_coupon_field_on_cart', 10, 3 );
  add_filter('woocommerce_coupon_error', __NAMESPACE__.'\\rename_coupon_label', 10, 3);
  add_filter('woocommerce_coupon_message', __NAMESPACE__.'\\rename_coupon_label', 10, 3);
  add_filter('woocommerce_cart_totals_coupon_label', __NAMESPACE__.'\\rename_coupon_label',10, 1);


  function woocommerce_rename_coupon_field_on_cart( $translated_text, $text, $text_domain ) {
    // bail if not modifying frontend woocommerce text
    if ( is_admin() || 'woocommerce' !== $text_domain ) {
      return $translated_text;
    }
    if ( 'Coupon:' === $text ) {
      $translated_text = 'Voucher Code:';
    }

    if ('Coupon has been removed.' === $text){
      $translated_text = 'Voucher code has been removed.';
    }

    if ( 'Apply coupon' === $text ) {
      $translated_text = 'Apply Voucher';
    }

    if ( 'Coupon code' === $text ) {
      $translated_text = 'Voucher Code';
    
    }
    if ( 'Have a coupon?' === $text ) {
      $translated_text = 'Have a voucher?';
    } 

    if ( 'If you have a coupon code, please apply it below.' === $text ) {
      $translated_text = 'If you have a voucher code, please apply it below.';
    } 

    return $translated_text;
  }



  function rename_coupon_label($err, $err_code=null, $something=null){

    $err = str_ireplace("Coupon","Offer Code ",$err);

    return $err;
  }
}

//make proceed to checkout button white
remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 ); 
add_action('woocommerce_proceed_to_checkout', __NAMESPACE__.'\\sm_woo_custom_checkout_button_text',20);

function sm_woo_custom_checkout_button_text() {
    $checkout_url = WC()->cart->get_checkout_url();
  ?>
       <a href="<?php echo $checkout_url; ?>" class="checkout-button button alt wc-forward btn btn-primary"><?php  _e( 'Proceed to Payment', 'woocommerce' ); ?></a> 
  <?php
}

function cw_change_product_html( $price_html, $product ) {
  if(has_term( array('people-voucher'), 'product_cat', $product->id )) {
    $price_html = $price_html . ' per person (min 2 people)';
  }
  return $price_html;
}
add_filter( 'woocommerce_get_price_html', 'cw_change_product_html', 10, 2 );

function iconic_modify_delivery_slots_labels( $labels, $order ) {
  $chosen_shipping = $order ? iconic_get_order_shipping_method( $order ) : iconic_get_selected_shipping_method();

  if ( ! $chosen_shipping ) {
    return $labels;
  }

  if ( substr($chosen_shipping, 0, strlen('local_pickup')) === 'local_pickup') {
    $labels['details'] = __( 'Collection Details', 'iconic' );
    $labels['date'] = __( 'Collection Date', 'iconic' );
    $labels['select_date'] = __( 'Select a collection date', 'iconic' );
    $labels['choose_date'] = __( 'Please choose a date for your collection.', 'iconic' );
    $labels['choose_time_slot'] = __( 'Please choose a time slot for your collection.', 'iconic' );
  }

  return $labels;
}

add_filter( 'iconic_wds_labels', __NAMESPACE__.'\\iconic_modify_delivery_slots_labels', 10, 2 );

function iconic_get_order_shipping_method( $order ) {
  $chosen_methods = $order->get_shipping_methods();

  if ( empty( $chosen_methods ) ) {
    return false;
  }

  $chosen_shipping = array_shift( $chosen_methods );
  return sprintf( '%s:%s', $chosen_shipping->get_method_id(), $chosen_shipping->get_instance_id() );
}

/**
 * Get selected shipping method.
 *
 * @return string|bool
 */
function iconic_get_selected_shipping_method() {
  if ( is_admin() ) {
    return false;
  }

  $chosen_methods  = WC()->session->get( 'chosen_shipping_methods' );

  if ( empty( $chosen_methods ) ) {
    return false;
  }

  return $chosen_methods[0];
}

/**
 * Adds Delivery date and time slot to the "Shipping Method" section of invoices and packing lists
 * 'Show shipping method' should be enabled for invoices!
 *
 * @param string    $shipping      the shipping method text
 * @param string    $document_type the type of document being viewed
 * @param \WC_Order $order         the order object the document is for
 *
 * @return string the updated shipping string
 */
function iconic_pip_add_delivery_date_shipping( $shipping, $document_type, $order ) {
  // if you want to only add this to invoices, you can add another check for document type
  // if ( 'invoice' !== $document_type ) { return $shipping; }

  // bail if Delivery Slots plugin is not active
  if ( ! class_exists( 'jckWooDeliverySlots' ) ) {
    return $shipping;
  }

  $order_id  = is_callable( array( $order, 'get_id' ) ) ? $order->get_id() : $order->id;
  $date      = get_post_meta( $order_id, 'jckwds_date', true );
  $time_slot = get_post_meta( $order_id, 'jckwds_timeslot', true );

  if ( $date ) {
    $shipping .= '<p>';
    $shipping .= sprintf( __( 'Delivery/Collection Date: %s', 'iconic' ), $date );

    if ( $time_slot ) {
      $shipping .= sprintf( ' %s %s', __( 'at', 'iconic' ), $time_slot );
    }

    $shipping .= '</p>';
  }

  return $shipping;
}

add_filter( 'wc_pip_document_shipping_method', __NAMESPACE__.'\\iconic_pip_add_delivery_date_shipping', 10, 3 );

add_filter( 'woocommerce_default_address_fields', __NAMESPACE__.'\\custom_override_default_checkout_fields', 10, 1 );
function custom_override_default_checkout_fields( $address_fields ) {
    $address_fields['address_2']['placeholder'] = __( 'Address line 2', 'woocommerce' );

    return $address_fields;
}

// Reposition Checkout Addons to under Order Notes
function sv_wc_checkout_addons_change_position() {
  return 'woocommerce_after_order_notes';
}
add_filter( 'wc_checkout_add_ons_position', __NAMESPACE__.'\\sv_wc_checkout_addons_change_position' );

function sv_edit_my_memberships_actions( $actions, $user_membership ) {
  // remove the "Cancel" action for members
  // print_r($actions);

  $enddate = $user_membership->get_end_date();
  $current_date = date("Y-m-d H:i:s", strtotime("+30 days"));

  if($enddate <= $current_date) {
    $actions['renew'] = [
      'url'  => $user_membership->get_renew_membership_url(),
      'name' => __( 'Renew', 'woocommerce-memberships' ),
    ];
  }

  unset( $actions['cancel'] );
  return $actions;
}
add_filter( 'wc_memberships_members_area_my-memberships_actions', __NAMESPACE__.'\\sv_edit_my_memberships_actions', 2, 10 );
add_filter( 'wc_memberships_members_area_my-membership-details_actions', __NAMESPACE__.'\\sv_edit_my_memberships_actions', 2, 10 );


add_action( 'template_redirect', __NAMESPACE__.'\\skip_cart_redirect' );
function skip_cart_redirect(){

    // Redirect to checkout (when cart is not empty)
    if ( ! WC()->cart->is_empty() && is_cart() ) {
        wp_safe_redirect( wc_get_checkout_url() ); 
        exit();
    }
    // Redirect to shop if cart is empty
    elseif ( WC()->cart->is_empty() && is_cart() ) {
        wp_safe_redirect( '/sign-up' );
        exit();
    }

    if(is_product() || is_product_tag() || is_product_category() || is_shop()) {
      wp_safe_redirect( '/sign-up' ); 
      exit();
    }
}


add_action( 'woocommerce_account_dashboard', __NAMESPACE__.'\\dashboard_endpoint_content' );
function dashboard_endpoint_content() {
  $taxonomy = 'ses_subject';
  $taxonomy_terms = get_terms( $taxonomy, array(
      'hide_empty' => 1
  ));
  echo "<h3>Choose a subject to view resources</h3>";
  echo \App\template('partials.shortcodes.tax-card-hold', array('featured'=>$taxonomy_terms ));
}

add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );