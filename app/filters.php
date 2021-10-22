<?php

namespace App;

use setasign\FpdiProtection\FpdiProtection;


function pdfEncrypt ($origFile, $destFile){


    $pdf = new FpdiProtection();
    

    //calculate the number of pages from the original document
    $pagecount = $pdf->setSourceFile($origFile);

    // copy all pages from the old unprotected pdf in the new one
    for ($loop = 1; $loop <= $pagecount; $loop++) {
        $tplidx = $pdf->importPage($loop);
        $pdf->addPage();
        $pdf->useTemplate($tplidx);
    }

    // protect the new pdf file, and allow no printing, copy etc and leave only reading allowed
    
    $pdf->setProtection(
        FpdiProtection::PERM_PRINT | FpdiProtection::PERM_COPY,
        '',
        uniqid()
    );

    // $pdf->Output($destFile, 'F');

    return $pdf;
}

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    if (get_field('transparent_header') && !is_search()) {
        $classes[] = 'transparent-header';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    collect(['get_header', 'wp_head'])->each(function ($tag) {
        ob_start();
        do_action($tag);
        $output = ob_get_clean();
        remove_all_actions($tag);
        add_action($tag, function () use ($output) {
            echo $output;
        });
    });
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory().'/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Render comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );

    $data = collect(get_body_class())->reduce(function ($data, $class) use ($comments_template) {
        return apply_filters("sage/template/{$class}/data", $data, $comments_template);
    }, []);

    $theme_template = locate_template(["views/{$comments_template}", $comments_template]);

    if ($theme_template) {
        echo template($theme_template, $data);
        return get_stylesheet_directory().'/index.php';
    }

    return $comments_template;
}, 100);

function add_to_nav_items($items, $args) {
    if($args->menu->slug=='primary-navigation'):
      global $woocommerce;
      if($woocommerce):
          $items = $items . '<li class="cart-link-hold d-none d-xl-inline-block"><a href="'.$woocommerce->cart->get_cart_url().'" class="cart-link"><i class="far fa-shopping-bag"></i><span class="basket-count">' . WC()->cart->get_cart_contents_count() .'</span></a></li>';
      endif;
    endif;
  return $items;
}
//add_filter('wp_nav_menu_items',__NAMESPACE__.'\\add_to_nav_items', 10, 2);

add_filter('wpcf7_autop_or_not', '__return_false');

add_filter('wc_pip_document_customer_note', __NAMESPACE__.'\\add_gift_message_to_delivery_packing_slip', 10, 3);
function add_gift_message_to_delivery_packing_slip($shipping_address, $order_id, $type) {
    if(function_exists ('wc_checkout_add_ons')) {
        $add_ons = wc_checkout_add_ons()->get_order_add_ons( $order_id );
        if(is_array($add_ons)) {
            foreach ($add_ons as $key => $addon) {
               if(isset($addon['name'])) {
                if($addon['name'] == 'Gift message') {
                    $shipping_address = $shipping_address . "</br> <strong>Gift message:</strong> " . $addon['value'];
                }
               }
            }
        }
    }
    return $shipping_address;
}

//disable spam check if contact form is checkin
add_filter('wpcf7_spam', __NAMESPACE__.'\\disable_recaptcha_checkin', 10, 1);
function disable_recaptcha_checkin($spam) {
    if(strpos($_SERVER['REQUEST_URI'], '/3569/feedback') !== false || strpos($_SERVER['REQUEST_URI'], '/3719/feedback')){
        return false;
    } else {
        return $spam;
    }
}

add_filter('enter_title_here',  __NAMESPACE__.'\\change_six_mark_title_place_holder' , 20 , 2 );
function change_six_mark_title_place_holder($title , $post){

    if( $post->post_type == 'ses_six_marks' ){
        $my_title = "Enter Topic";
        return $my_title;
    }

    if( $post->post_type == 'ses_exam_paper' ){
        $my_title = "Enter Exam Paper";
        return $my_title;
    }

    return $title;
}

add_filter('acf/upload_prefilter', __NAMESPACE__.'\\my_acf_upload_prefilter', 10, 3);
function my_acf_upload_prefilter( $errors, $file, $field ) {

    $prepend = "secure_";
    if( !current_user_can('manage_options') ) {
        $errors[] = __( 'Only administrators may upload attachments' );
    }

    if(substr($field['name'], 0, strlen($prepend)) === $prepend) {
       //this filter changes directory just for item being uploaded
       add_filter('upload_dir', __NAMESPACE__.'\\documents_upload_directory');
    }
    
    // return
    return $errors;
    
}

function documents_upload_directory( $param ){
    $mydir = '/secure-documents';

    $param['path'] = $param['basedir'] . $mydir;
    $param['url'] = $param['baseurl'] . $mydir;

    return $param;
}

add_filter('acf/load_value', __NAMESPACE__.'\\secure_document_url_filter', 10, 3);
function secure_document_url_filter( $value, $post_id, $field ) {
    $prepend = "secure_";

    $starts_with = (substr($field['name'], 0, strlen($prepend)) === $prepend ? true : false);
    $contains = (str_contains($field['name'], '_secure_') ? true : false);

    //if is admin and the field name starts with secure_
    if(is_admin() && ($starts_with || $contains)) {
       add_filter( 'wp_get_attachment_url', __NAMESPACE__.'\\filter_url_of_file', 10, 2);
    }
    return $value;
}

function filter_url_of_file( $url, $attachment_id  ) {
    //return download url
    return get_download_link($attachment_id);
}

add_action('init', __NAMESPACE__.'\\fake_download_link');
function fake_download_link() {
  $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
  if ( $url_path === 'download-file' ) {
    if(function_exists('wc_memberships_get_user_active_memberships')) {
      $user_id = get_current_user_id();
      $memberships = wc_memberships_get_user_active_memberships( $user_id );
      if ( ! empty( $memberships ) ) {
         // load the file if exists
        $doc_id = $_GET['the_document'];

        if(!$doc_id) {
            echo "No file ID supplied";
            die(); 
        }

        $file_location = get_attached_file($doc_id);

        if($file_location) {
            $temp = tempnam(sys_get_temp_dir(), 'prefix');
            if (file_exists($file_location)) {
                update_user_meta($user_id, 'downloaded_' . $doc_id, true);
                //if pdf make sure it's password protected
                if(mime_content_type ($file_location) == 'application/pdf') {
                    $pdf = pdfEncrypt($file_location, $temp );
                    $pdf->Output(basename($file_location), 'D');
                    // header('Content-Description: File Transfer');
                    // header('Content-Type: application/octet-stream');
                    // header('Content-Disposition: attachment; filename='.basename($file_location));
                    // header('Expires: 0');
                    // header('Cache-Control: must-revalidate');
                    // header('Pragma: public');
                    // header('Content-Length: ' . filesize($temp));
                    // ob_clean();
                    // flush();
                    // readfile($file_location);
                } else {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename='.basename($file_location));
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file_location));
                    ob_clean();
                    flush();
                    readfile($file_location);
                }
               
            }
            fclose($temp);
            die();
        } else {
            echo "File not found";
            die(); 
        }

        echo "File not found"; 
        die();
      } else {
        redirect_to_restricted_page();
      }
    }
  }
}

function redirect_to_restricted_page() {
  if(function_exists('wc_memberships')) {
    $page_id = wc_memberships()->get_restrictions_instance()->get_restricted_content_redirect_page_id();
    if($page_id) {
      wp_redirect( get_permalink($page_id) );
      exit;
    }
  }
  wp_redirect( '/' );
  exit;
}

function modify_post_title( $post_id) {
  $post_id =  get_the_ID();
  if (get_post_type($post_id) == "ses_activities") {

    $title = "";

    $levels = get_the_terms($post_id, 'ses_level' );
    if($levels) {
        $level = array_pop($levels);
        $title .= $level->name;
    }


    $tiers = get_the_terms($post_id, 'ses_tier' );
    if($tiers) {
        $tier = array_pop($tiers);
        $title .= " - " . $tier->name;
    }

    $subjects = get_the_terms($post_id, 'ses_subject' );
    if($subjects) {
        $subject = array_pop($subjects);
        $title .= " - " . $subject->name;
    }
    
    global $wpdb;
    $wpdb->update( $wpdb->posts, array( 'post_title' =>  $title ), array( 'ID' => $post_id ) );

  }
}
add_action( 'save_post', __NAMESPACE__.'\\modify_post_title', 99, 1);


add_filter('wpseo_breadcrumb_links', __NAMESPACE__.'\\change_wordpress_breadcrumb', 1, 10);
function change_wordpress_breadcrumb($crumbs) {
    
    if(get_query_var('page_levels')=="level") {
        // $inserted
        // array_splice( $crumbs, $last, 0, $inserted );
        $level = get_term_by('slug', get_query_var('ses_level'), 'ses_level');
        $level = $level->name;

        $last = count($crumbs) - 1;
        $base_url = $crumbs[$last];

        $post_type = get_post_type();
        $post_object = get_post_type_object( $post_type );
        $last = count($crumbs) - 1;

        if ( $post_type == 'ses_activities' ) {
            $post_type_slug = 'activities';
        } else if ( $post_type == 'ses_exam_paper' ) {
            $post_type_slug = 'notes-and-exam-questions';
        } else if ( $post_type == 'ses_six_marks' ) {
            $post_type_slug = 'six-mark-questions';
        }

        $crumbs[] = array(
            'url' => $base_url['url'],
            'text' => $post_object->labels->name
        );

        $crumbs[] = array(
            'url' => $base_url['url'] . 'level/' . get_query_var('ses_level') . '/',
            'text' => $level
        );
    }

    if(get_query_var('page_levels')=="content") {
        
        $base_url = $crumbs[$last]['url'];

        if(get_query_var('ses_subject')) {
            $last = count($crumbs) - 1;
            $subject = get_term_by('slug', get_query_var('ses_subject'), 'ses_subject');
            $subject_url = get_term_link(get_query_var('ses_subject'), 'ses_subject');
            $subject = $subject->name;
            $base_url = $subject_url;
            
            $crumb_new = array(array(
                'url' => $base_url,
                'text' => $subject
            ));

            array_splice( $crumbs, $last, 0, $crumb_new  );
        }

        if(get_query_var('ses_level')) {
            $post_type = get_post_type();
            $post_object = get_post_type_object( $post_type );
            $last = count($crumbs) - 1;

            if ( $post_type == 'ses_activities' ) {
                $post_type_slug = 'activities';
            } else if ( $post_type == 'ses_exam_paper' ) {
                $post_type_slug = 'notes-and-exam-questions';
            } else if ( $post_type == 'ses_six_marks' ) {
                $post_type_slug = 'six-mark-questions';
            }

            $crumb_new = array(array(
                'url' => $base_url,
                'text' => $post_object->labels->name
            ));
            array_splice( $crumbs, $last, 0, $crumb_new  );

            $last = count($crumbs) - 1;
            $level = get_term_by('slug', get_query_var('ses_level'), 'ses_level');
            $level = $level->name;
            $base_url = $base_url . $post_type_slug . '/level/' . get_query_var('ses_level') . '/';
            
            $crumb_new = array(array(
                'url' => $base_url,
                'text' => $level
            ));

            array_splice( $crumbs, $last, 0, $crumb_new  );
        }

        if(get_query_var('ses_exam_board')) {
            $last = count($crumbs) - 1;
            $exam = get_term_by('slug', get_query_var('ses_exam_board'), 'ses_exam_board');
            $exam = $exam->name;
            $base_url = $base_url . 'board/' . get_query_var('ses_exam_board') . '/';

            $crumb_new = array(array(
                'url' => $base_url,
                'text' => $exam
            ));

            array_splice( $crumbs, $last, 0, $crumb_new  );
        }

    }

    return $crumbs;
}

// remove SkyVerge support dashboard
add_action( 'admin_menu', function() { remove_menu_page( 'skyverge' ); }, 99 );

// remove dashboard stylesheet
add_action( 'admin_enqueue_scripts', function() { wp_dequeue_style( 'sv-wordpress-plugin-admin-menus' ); }, 20 );

