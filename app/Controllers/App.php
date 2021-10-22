<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {   
        if(is_tax('ses_subject')) {
            if(get_query_var('ses_level') && get_query_var('post_type')) {
                $level = get_term_by('slug', get_query_var('ses_level'), 'ses_level');
                $level = $level->name;

                $post_object = get_post_type_object( get_query_var('post_type') );

                return $level . ' - ' . $post_object->labels->name;
            } else {
                return single_term_title( '', false ) . ' resources';
            }
            
        }
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if(function_exists('is_shop')) {
            if (is_shop()) {
                return 'Shop Online';
            }
        }
        if (is_archive()) {
            $post_type = get_post_type();
            if ( $post_type )
            {
                $post_type_data = get_post_type_object( $post_type );
                $post_type_slug = $post_type_data->rewrite['slug'];
                $slug = $post_type_slug;
                $page = get_page_by_path( $slug  );
                if($page) {
                    return get_the_title($page);
                }
            }

            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }
}
