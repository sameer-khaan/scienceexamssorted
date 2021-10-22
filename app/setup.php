<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_register_script( 'dummy-handle-header', '' );
    wp_enqueue_script( 'dummy-handle-header' );
    wp_add_inline_script( 'dummy-handle-header', 'var $ = jQuery.noConflict();' );
    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);
    wp_localize_script( 'sage/main.js', 'ajax_object' , array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    wp_enqueue_style( 'adobe-fonts', 'https://use.typekit.net/vgc8ioh.css', false );
    wp_enqueue_script('sage/font-awesome.js', "https://kit.fontawesome.com/0c0595052f.js", null, null, true);
    wp_enqueue_script('instashow', asset_path('instashow/elfsight-instagram-feed.js'), ['jquery'], null, true);
    
    wp_enqueue_script('sage/pollyfill', "https://polyfill.io/v3/polyfill.min.js?features=Object.getOwnPropertySymbols%2CObject.getOwnPropertyNames%2CObject.getOwnPropertyDescriptors%2CObject.getOwnPropertyDescriptor%2CObject.getPrototypeOf%2CNumber.isInteger", null, null, true);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}, 100);

add_action('enqueue_block_editor_assets', function () {
     wp_enqueue_style('sage/gutenberg.css', asset_path('styles/gutenberg.css'), false, null);
});

add_action('admin_enqueue_scripts', function () {
     wp_enqueue_style('sage/mrss-admin.css', asset_path('styles/mrss-admin.css'), false, null);
});

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
        'footer_navigation_1' => __('Footer Navigation 1', 'sage'),
        'footer_navigation_2' => __('Footer Navigation 2', 'sage'),
        'footer_navigation_3' => __('Footer Navigation 3', 'sage')
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer', 'sage'),
        'id'            => 'sidebar-footer'
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });
});


if( function_exists('acf_add_options_page') ) {
    acf_add_options_page('Theme options');
}

function thync_block_categories( $categories, $post ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'thync',
                'title' => __( 'Thync Blocks', 'sage' ),
                'icon'  => 'wordpress',
            ),
        )
    );
}
add_filter( 'block_categories', __NAMESPACE__ . '\\thync_block_categories', 10, 2 );

// Callback function to insert 'styleselect' into the $buttons array
function my_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
// Register our callback to the appropriate filter
add_filter('mce_buttons_2', __NAMESPACE__ . '\\my_mce_buttons_2');

// Callback function to filter the MCE settings
function my_mce_before_init_insert_formats( $init_array ) {  
    // Define the style_formats array
    $style_formats = array(  
        // Each array child is a format with it's own settings
        array(  
            'title' => 'Button',  
            'selector' => 'a',  
            'classes' => 'btn btn-primary'             
        ),
        array(  
            'title' => 'Light button',  
            'selector' => 'a',  
            'classes' => 'btn btn-white'             
        ),
        array(  
            'title' => 'Red button',  
            'selector' => 'a',  
            'classes' => 'btn btn-red'             
        ),
        array(  
            'title' => 'Underline',  
            'selector' => 'h1, h2, h3, h4, h5',  
            'classes' => 'magic-underline'             
        ),
    );  
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );  

    return $init_array;  
 
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', __NAMESPACE__ . '\\my_mce_before_init_insert_formats' );

add_shortcode('featured_events', function($atts) {
    $args = array(
        'post_type' => 'mrss_event',
        'posts_per_page' => 3,
        'orderby' => 'menu_order'
    );

    $featured = new \WP_Query( $args );
    wp_reset_postdata();
    return \App\template('partials.shortcodes.card-hold', array('featured'=>$featured));
});

add_shortcode('latest_posts', function($atts) {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 3
    );

    $featured = new \WP_Query( $args );
    wp_reset_postdata();
    return \App\template('partials.shortcodes.card-hold', array('featured'=>$featured));
});

add_shortcode('booking_widget', function($atts) {
    return '<div id="rd-widget-frame" style="margin: auto;"></div>';
});

add_shortcode('contact_details', function($atts) {
    return \App\template('partials.shortcodes.contact-details-shortcode');
});

add_shortcode('social_links', function($atts) {
    return \App\template('partials.shortcodes.social-links');
});

add_shortcode('shop_featured_products', function($atts) {
    $meta_query  = WC()->query->get_meta_query();
    $tax_query   = WC()->query->get_tax_query();
    $tax_query[] = array(
        'taxonomy' => 'product_visibility',
        'field'    => 'name',
        'terms'    => 'featured',
        'operator' => 'IN',
    );
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 3,
        'orderby' => 'menu_order',
        'meta_query'  =>  $meta_query,
        'tax_query'  =>  $tax_query
    );

    $featured = new \WP_Query( $args );
    wp_reset_postdata();
    return \App\template('partials.shortcodes.card-hold', array('featured'=>$featured));
});


add_shortcode('postcode_search', function($atts) {
    return \App\template('partials.shortcodes.postcode-search');
});


function my_pre_get_posts( $query )
{
    // validate
    if( is_admin() )
    {
        return $query;
    }


    if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'mrss_event' )
    {
        $query->set('orderby', 'meta_value_num');
        $query->set('meta_key', 'event_date');
        $query->set('order', 'ASC');
        $meta_query = array(
            'relation' => 'OR',
            array(
                'key' => 'event_date',
                'value' => date('Ymd'),
                'type' => 'DATE',
                'compare' => '>='
            ),
            array(
                'key' => 'event_date',
                'compare' => '=',
                'value' => ''
            ),
        );
        $query->set('meta_query', $meta_query);
    }

    // always return
    return $query;

}

add_action('pre_get_posts', __NAMESPACE__ . '\\my_pre_get_posts');

add_action( 'wp_ajax_get_postcode_products',  __NAMESPACE__ . '\\get_postcode_products' );
add_action( 'wp_ajax_nopriv_get_postcode_products',  __NAMESPACE__ . '\\get_postcode_products' );

function get_postcode_products() {

    $page = get_page_by_path( 'order' );

    $args = array(
      'post_type'      => 'page',
      'posts_per_page' => -1,
      'post_parent'    => $page->ID,
      'order'          => 'ASC',
      'orderby'        => 'menu_order'
    );
    $pages = new \WP_Query( $args );
    wp_reset_postdata();

    if( $pages->have_posts() ) {
        while( $pages->have_posts() ) {
            $pages->the_post();

            $matched = false;
            $postcodes = get_field('postcodes', get_the_id());
            $postcodes = array_filter( array_map( 'strtoupper', array_map( 'wc_clean', explode( "\n", $postcodes ) ) ) );
            $postcode_input = strtoupper(wc_clean($_POST['postcode']));
            $objects = array();
            $i = 1;

            foreach ( $postcodes as $index => $postcode ) {
              $object = new \stdClass();
              $object->id = $i;
              $object->postcode = $postcode;
              $objects[] = $object;
              $i++;
            }

            $matches = \wc_postcode_location_matcher( $postcode_input, $objects, 'id', 'postcode', 'GB');

            if ( $matches ) {
              $matched = true;
            }

            if($postcode_input!="") {
                $postcode_entered = true;
            }

            $show_card = false;

            $valid = false;

            if( \WC_Validation::is_postcode( $postcode_input, 'GB' )) {
                $valid = true;
            }

            if(!$postcode_entered || !$valid) {
                $show_card = false;
            } else {
                if($matched) {
                    $show_card = true;
                } else {
                    if(get_field('no_match') != "Make not available") {
                        $show_card = true;
                    }
                }
            }
            

            echo \App\template('partials.postcode-preview', array('postcode_entered'=>$postcode_entered, 'show_card'=>$show_card, 'matched'=>$matched, 'valid'=>$valid));
        }
        wp_reset_postdata();
    }

    echo '<div class="post-card blank"></div>
        <div class="post-card blank"></div>
        <div class="post-card blank"></div>';

    die();
}

add_shortcode('team_members', function($atts) {
    $args = array(
        'post_type' => 'team_member',
        'orderby' => 'menu_order',
        'posts_per_page' => -1,
    );
    $the_query = new \WP_Query( $args );
    return \App\template('partials.shortcodes.team-members', array('the_query' => $the_query));
});

require dirname(__FILE__) . '/cpt.php';
require dirname(__FILE__) . '/woocommerce.php';

function sign_up_button_url() {
    return '/sign-up-start';
}

add_action('wp_loaded', __NAMESPACE__.'\\do_sign_up_start');
function do_sign_up_start() {
  $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
  if ( $url_path === 'sign-up-start' ) {
    if(function_exists('wc_memberships_get_user_active_memberships')) {
      $memberships = wc_memberships_get_user_active_memberships( $user_id );
      if ( empty( $memberships ) ) {
        WC()->cart->add_to_cart( 284 );
        wp_safe_redirect( wc_get_checkout_url() );
        exit();
      } else {
        wp_redirect( 'my-account' );
        exit;
      }
    }
  }
}
