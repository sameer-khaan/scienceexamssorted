<?php

// Register Custom Post Type
function free_resources_cpt() {

    $labels = array(
        'name'                  => _x( 'Free Resources', 'Post Type General Name', 'sage' ),
        'singular_name'         => _x( 'Resource', 'Post Type Singular Name', 'sage' ),
        'menu_name'             => __( 'Free Resources', 'sage' ),
        'name_admin_bar'        => __( 'Free Resources', 'sage' ),
        'archives'              => __( 'Resources Archives', 'sage' ),
        'attributes'            => __( 'Resource Attributes', 'sage' ),
        'parent_item_colon'     => __( 'Parent Resource:', 'sage' ),
        'all_items'             => __( 'All Resources', 'sage' ),
        'add_new_item'          => __( 'Add New Resource', 'sage' ),
        'add_new'               => __( 'Add New', 'sage' ),
        'new_item'              => __( 'New Resource', 'sage' ),
        'edit_item'             => __( 'Edit Resource', 'sage' ),
        'update_item'           => __( 'Update Resource', 'sage' ),
        'view_item'             => __( 'View Resource', 'sage' ),
        'view_items'            => __( 'View Resources', 'sage' ),
        'search_items'          => __( 'Search Resource', 'sage' ),
        'not_found'             => __( 'Not found', 'sage' ),
        'not_found_in_trash'    => __( 'Not found in Bin', 'sage' ),
        'featured_image'        => __( 'Featured Image', 'sage' ),
        'set_featured_image'    => __( 'Set featured image', 'sage' ),
        'remove_featured_image' => __( 'Remove featured image', 'sage' ),
        'use_featured_image'    => __( 'Use as featured image', 'sage' ),
        'insert_into_item'      => __( 'Insert into Resource', 'sage' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Resource', 'sage' ),
        'items_list'            => __( 'Resources list', 'sage' ),
        'items_list_navigation' => __( 'Resources list navigation', 'sage' ),
        'filter_items_list'     => __( 'Filter Resources list', 'sage' ),
    );

    $rewrite = array(
        'slug'                  => 'free-resources',
        'with_front'            => false,
        'pages'                 => true,
        'feeds'                 => true,
    );

    $args = array(
        'label'                 => __( 'Free Resources', 'sage' ),
        'description'           => __( '', 'sage' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'revisions' ),
        'taxonomies'            => array( ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-unlock',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'rewrite'               => $rewrite,
        'capability_type'       => 'page',
        'show_in_rest'          => false,
    );
    register_post_type( 'ses_free_resources', $args );

}
add_action( 'init', __NAMESPACE__.'\\free_resources_cpt', 0 );

// Register Custom Post Type
function exam_paper_cpt() {

    $labels = array(
        'name'                  => _x( 'Notes and Exam Questions', 'Post Type General Name', 'sage' ),
        'singular_name'         => _x( 'Paper', 'Post Type Singular Name', 'sage' ),
        'menu_name'             => __( 'Papers', 'sage' ),
        'name_admin_bar'        => __( 'Papers', 'sage' ),
        'archives'              => __( 'Paper Archives', 'sage' ),
        'attributes'            => __( 'Paper Attributes', 'sage' ),
        'parent_item_colon'     => __( 'Parent Paper:', 'sage' ),
        'all_items'             => __( 'All Papers', 'sage' ),
        'add_new_item'          => __( 'Add New Paper', 'sage' ),
        'add_new'               => __( 'Add New', 'sage' ),
        'new_item'              => __( 'New Paper', 'sage' ),
        'edit_item'             => __( 'Edit Paper', 'sage' ),
        'update_item'           => __( 'Update Paper', 'sage' ),
        'view_item'             => __( 'View Paper', 'sage' ),
        'view_items'            => __( 'View Papers', 'sage' ),
        'search_items'          => __( 'Search Paper', 'sage' ),
        'not_found'             => __( 'Not found', 'sage' ),
        'not_found_in_trash'    => __( 'Not found in Bin', 'sage' ),
        'featured_image'        => __( 'Featured Image', 'sage' ),
        'set_featured_image'    => __( 'Set featured image', 'sage' ),
        'remove_featured_image' => __( 'Remove featured image', 'sage' ),
        'use_featured_image'    => __( 'Use as featured image', 'sage' ),
        'insert_into_item'      => __( 'Insert into Paper', 'sage' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Paper', 'sage' ),
        'items_list'            => __( 'Papers list', 'sage' ),
        'items_list_navigation' => __( 'Papers list navigation', 'sage' ),
        'filter_items_list'     => __( 'Filter Papers list', 'sage' ),
    );

    $rewrite = array(
        'slug'                  => 'subject/%ses_subject%/notes-and-exam-questions/level/%ses_level%',
        'with_front'            => false,
        'pages'                 => true,
        'feeds'                 => true,
    );

    $args = array(
        'label'                 => __( 'Paper', 'sage' ),
        'description'           => __( 'Individually made topic revision booklets including all essential learning in easy to follow chunks. 
Hone your understanding and exam technique with our past exam questions booklets.', 'sage' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'revisions' ),
        'taxonomies'            => array( 'ses_subject', 'ses_level' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-media-spreadsheet',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'rewrite'               => $rewrite,
        'capability_type'       => 'page',
        'show_in_rest'          => false,
    );
    register_post_type( 'ses_exam_paper', $args );

}
add_action( 'init', __NAMESPACE__.'\\exam_paper_cpt', 0 );


function activities_archive_rewrite_rules() {

    add_rewrite_rule(
        '^subject/(.*)/activities/level/(.*)/(.*)/?$',
        'index.php?post_type=ses_activities&ses_subject=$matches[1]&ses_level=$matches[2]&name=$matches[3]&page_levels=content',
        'top'
    );

    add_rewrite_rule(
        '^subject/(.*)/six-mark-questions/level/(.*)/board/(.*)/(.*)/?$',
        'index.php?post_type=ses_six_marks&ses_subject=$matches[1]&ses_level=$matches[2]&ses_exam_board=$matches[3]&name=$matches[4]&page_levels=content',
        'top'
    );

    add_rewrite_rule(
        '^subject/(.*)/notes-and-exam-questions/level/(.*)/(.*)/?$',
        'index.php?post_type=ses_exam_paper&ses_subject=$matches[1]&ses_level=$matches[2]&name=$matches[3]&page_levels=content',
        'top'
    );

    add_rewrite_rule(
        '^subject/(.*)/six-mark-questions/level/(.*)/board/(.*)/?',
        'index.php?post_type=ses_six_marks&ses_subject=$matches[1]&ses_level=$matches[2]&ses_exam_board=$matches[3]&page_levels=board',
        'top'
    );

    add_rewrite_rule(
        '^subject/(.*)/activities/level/(.*)/?',
        'index.php?page_levels=level&post_type=ses_activities&ses_subject=$matches[1]&ses_level=$matches[2]',
        'top'
    );

    add_rewrite_rule(
        '^subject/(.*)/six-mark-questions/level/(.*)/?',
        'index.php?page_levels=level&post_type=ses_six_marks&ses_subject=$matches[1]&ses_level=$matches[2]',
        'top'
    );

    add_rewrite_rule(
        '^subject/(.*)/notes-and-exam-questions/level/(.*)/?',
        'index.php?page_levels=level&post_type=ses_exam_paper&ses_subject=$matches[1]&ses_level=$matches[2]',
        'top'
    );

    add_rewrite_rule(
        '^subject/(.*)/?$',
        'index.php?page_levels=subject&ses_subject=$matches[1]',
        'top'
    );

    // flush_rewrite_rules(); // use only once
}

add_action( 'init', __NAMESPACE__.'\\activities_archive_rewrite_rules' );


add_filter('query_vars', __NAMESPACE__.'\\add_my_var');
function add_my_var($public_query_vars) {
    $public_query_vars[] = 'page_levels';
    return $public_query_vars;
}


// Register Custom Post Type
function activities_cpt() {

    $labels = array(
        'name'                  => _x( '1 a Week Activities', 'Post Type General Name', 'sage' ),
        'singular_name'         => _x( 'Activity', 'Post Type Singular Name', 'sage' ),
        'menu_name'             => __( '1 a week activities', 'sage' ),
        'name_admin_bar'        => __( 'Activities', 'sage' ),
        'archives'              => __( 'Activities Archives', 'sage' ),
        'attributes'            => __( 'Activities Attributes', 'sage' ),
        'parent_item_colon'     => __( 'Parent Activitiy:', 'sage' ),
        'all_items'             => __( 'All Activities', 'sage' ),
        'add_new_item'          => __( 'Add New Activities', 'sage' ),
        'add_new'               => __( 'Add New', 'sage' ),
        'new_item'              => __( 'New Activities', 'sage' ),
        'edit_item'             => __( 'Edit Activities', 'sage' ),
        'update_item'           => __( 'Update Activities', 'sage' ),
        'view_item'             => __( 'View Activities', 'sage' ),
        'view_items'            => __( 'View Activities', 'sage' ),
        'search_items'          => __( 'Search Activities', 'sage' ),
        'not_found'             => __( 'Not found', 'sage' ),
        'not_found_in_trash'    => __( 'Not found in Bin', 'sage' ),
        'featured_image'        => __( 'Featured Image', 'sage' ),
        'set_featured_image'    => __( 'Set featured image', 'sage' ),
        'remove_featured_image' => __( 'Remove featured image', 'sage' ),
        'use_featured_image'    => __( 'Use as featured image', 'sage' ),
        'insert_into_item'      => __( 'Insert into item', 'sage' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
        'items_list'            => __( 'Activities list', 'sage' ),
        'items_list_navigation' => __( 'Activities list navigation', 'sage' ),
        'filter_items_list'     => __( 'Filter activities list', 'sage' ),
    );
    $rewrite = array(
        'slug'                  => 'subject/%ses_subject%/activities/level/%ses_level%',
        'with_front'            => false,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Activity', 'sage' ),
        'description'           => __( 'Print and complete 1 worksheet per week to keep your learning going.  Made for students to use or teachers to set as a lesson starter or homework.', 'sage' ),
        'labels'                => $labels,
        'supports'              => array( 'editor', 'revisions' ),
        'taxonomies'            => array( 'ses_subject', 'ses_level' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-calendar',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'rewrite'               => $rewrite,
        'capability_type'       => 'page',
        'show_in_rest'          => false,
    );
    register_post_type( 'ses_activities', $args );

}
add_action( 'init', __NAMESPACE__.'\\activities_cpt', 0 );

// Register Custom Taxonomy
function ses_subject_tax() {

    $labels = array(
        'name'                       => _x( 'Subjects', 'Taxonomy General Name', 'sage' ),
        'singular_name'              => _x( 'Subject', 'Taxonomy Singular Name', 'sage' ),
        'menu_name'                  => __( 'Subjects', 'sage' ),
        'all_items'                  => __( 'All Subjects', 'sage' ),
        'parent_item'                => __( 'Parent Subject', 'sage' ),
        'parent_item_colon'          => __( 'Parent Subject:', 'sage' ),
        'new_item_name'              => __( 'New Subject Name', 'sage' ),
        'add_new_item'               => __( 'Add New Subject', 'sage' ),
        'edit_item'                  => __( 'Edit Subject', 'sage' ),
        'update_item'                => __( 'Update Subject', 'sage' ),
        'view_item'                  => __( 'View Subject', 'sage' ),
        'separate_items_with_commas' => __( 'Separate subjects with commas', 'sage' ),
        'add_or_remove_items'        => __( 'Add or remove subjects', 'sage' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'sage' ),
        'popular_items'              => __( 'Popular Subjects', 'sage' ),
        'search_items'               => __( 'Search Subjects', 'sage' ),
        'not_found'                  => __( 'Not Found', 'sage' ),
        'no_terms'                   => __( 'No subjects', 'sage' ),
        'items_list'                 => __( 'Subjects list', 'sage' ),
        'items_list_navigation'      => __( 'Subjects list navigation', 'sage' ),
    );
    $rewrite = array(
        'slug'                       => 'subject',
        'with_front'                 => false,
        'hierarchical'               => false,
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'meta_box_cb'                => 'post_categories_meta_box',
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => false,
        'show_tagcloud'              => false,
        'rewrite'                    => $rewrite,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'ses_subject', array( 'ses_activities', 'ses_exam_paper', 'ses_six_marks' ), $args );

}
add_action( 'init', __NAMESPACE__.'\\ses_subject_tax', 0 );

function wpa_show_permalinks( $post_link, $post ){
    if ( is_object( $post ) && ($post->post_type == 'ses_activities' ||  $post->post_type == 'ses_exam_paper' ||  $post->post_type == 'ses_six_marks')){

        
        $terms = wp_get_object_terms( $post->ID, 'ses_level' );
        if( $terms ){
            $post_link = str_replace( '%ses_level%' , $terms[0]->slug , $post_link );
        }

        $terms = wp_get_object_terms( $post->ID, 'ses_subject' );
        if( $terms ){
            $post_link = str_replace( '%ses_subject%' , $terms[0]->slug , $post_link );
        }

        if($post->post_type == 'ses_six_marks') {
            $terms = wp_get_object_terms( $post->ID, 'ses_exam_board' );
            if( $terms ){
                $post_link = str_replace( '%ses_exam_board%' , $terms[0]->slug , $post_link );
            }
        }
    }
    return $post_link;
}
add_filter( 'post_type_link', __NAMESPACE__.'\\wpa_show_permalinks', 1, 2 );

add_filter( 'post_edit_category_parent_dropdown_args', 'hide_parent_dropdown_select' );

function hide_parent_dropdown_select( $args ) {
    if ( 'ses_subject' == $args['taxonomy'] || 'ses_level' == $args['taxonomy'] || 'ses_tier' == $args['taxonomy'] ) {
        $args['echo'] = false;
    }
    return $args;
}

add_action( 'admin_init', 'convert_taxonomy_terms_to_integers' );

function convert_taxonomy_terms_to_integers() {
    $taxonomies = ['ses_subject', 'ses_tier', 'ses_level'];
    foreach ($taxonomies as $taxonomy) {
        if ( isset( $_POST['tax_input'][ $taxonomy ] ) && is_array( $_POST['tax_input'][ $taxonomy ] ) ) {
            $terms = $_POST['tax_input'][ $taxonomy ];
            $new_terms = array_map( 'intval', $terms );
            $_POST['tax_input'][ $taxonomy ] = $new_terms;
        }
    }   
}

// Register Custom Taxonomy
function ses_tier_tax() {

    $labels = array(
        'name'                       => _x( 'Tiers', 'Taxonomy General Name', 'sage' ),
        'singular_name'              => _x( 'Tier', 'Taxonomy Singular Name', 'sage' ),
        'menu_name'                  => __( 'Tiers', 'sage' ),
        'all_items'                  => __( 'All Tiers', 'sage' ),
        'parent_item'                => __( 'Parent Tier', 'sage' ),
        'parent_item_colon'          => __( 'Parent Tier:', 'sage' ),
        'new_item_name'              => __( 'New Tier Name', 'sage' ),
        'add_new_item'               => __( 'Add New Tier', 'sage' ),
        'edit_item'                  => __( 'Edit Tier', 'sage' ),
        'update_item'                => __( 'Update Tier', 'sage' ),
        'view_item'                  => __( 'View Tier', 'sage' ),
        'separate_items_with_commas' => __( 'Separate tiers with commas', 'sage' ),
        'add_or_remove_items'        => __( 'Add or remove tiers', 'sage' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'sage' ),
        'popular_items'              => __( 'Popular Tiers', 'sage' ),
        'search_items'               => __( 'Search Tiers', 'sage' ),
        'not_found'                  => __( 'Not Found', 'sage' ),
        'no_terms'                   => __( 'No tiers', 'sage' ),
        'items_list'                 => __( 'Tiers list', 'sage' ),
        'items_list_navigation'      => __( 'Tiers list navigation', 'sage' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => false,
        'show_tagcloud'              => false,
        'rewrite'                    => false,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'ses_tier', array( 'ses_activities' ), $args );

}
add_action( 'init', __NAMESPACE__.'\\ses_tier_tax', 0 );

// Register Custom Taxonomy
function ses_level_tax() {

    $labels = array(
        'name'                       => _x( 'Levels', 'Taxonomy General Name', 'sage' ),
        'singular_name'              => _x( 'Level', 'Taxonomy Singular Name', 'sage' ),
        'menu_name'                  => __( 'Levels', 'sage' ),
        'all_items'                  => __( 'All Levels', 'sage' ),
        'parent_item'                => __( 'Parent Level', 'sage' ),
        'parent_item_colon'          => __( 'Parent Level:', 'sage' ),
        'new_item_name'              => __( 'New Level Name', 'sage' ),
        'add_new_item'               => __( 'Add New Level', 'sage' ),
        'edit_item'                  => __( 'Edit Level', 'sage' ),
        'update_item'                => __( 'Update Level', 'sage' ),
        'view_item'                  => __( 'View Level', 'sage' ),
        'separate_items_with_commas' => __( 'Separate levels with commas', 'sage' ),
        'add_or_remove_items'        => __( 'Add or remove levels', 'sage' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'sage' ),
        'popular_items'              => __( 'Popular Levels', 'sage' ),
        'search_items'               => __( 'Search Levels', 'sage' ),
        'not_found'                  => __( 'Not Found', 'sage' ),
        'no_terms'                   => __( 'No levels', 'sage' ),
        'items_list'                 => __( 'Levels list', 'sage' ),
        'items_list_navigation'      => __( 'Levels list navigation', 'sage' ),
    );
    $rewrite = array(
        'slug'                       => 'level',
        'with_front'                 => false,
        'hierarchical'               => false,
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'meta_box_cb'                => 'post_categories_meta_box',
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => false,
        'show_tagcloud'              => false,
        'rewrite'                    => $rewrite,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'ses_level', array( 'ses_activities', 'ses_exam_paper', 'ses_six_marks' ), $args );

}
add_action( 'init', __NAMESPACE__.'\\ses_level_tax', 0 );


// Register Custom Taxonomy
function ses_exam_board_tax() {

    $labels = array(
        'name'                       => _x( 'Exam Boards', 'Taxonomy General Name', 'sage' ),
        'singular_name'              => _x( 'Exam Board', 'Taxonomy Singular Name', 'sage' ),
        'menu_name'                  => __( 'Exam Boards', 'sage' ),
        'all_items'                  => __( 'All Exam Boards', 'sage' ),
        'parent_item'                => __( 'Parent Exam Board', 'sage' ),
        'parent_item_colon'          => __( 'Parent Exam Board:', 'sage' ),
        'new_item_name'              => __( 'New Exam Board Name', 'sage' ),
        'add_new_item'               => __( 'Add New Exam Board', 'sage' ),
        'edit_item'                  => __( 'Edit Exam Board', 'sage' ),
        'update_item'                => __( 'Update Exam Board', 'sage' ),
        'view_item'                  => __( 'View Exam Board', 'sage' ),
        'separate_items_with_commas' => __( 'Separate Exam Boards with commas', 'sage' ),
        'add_or_remove_items'        => __( 'Add or remove Exam Boards', 'sage' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'sage' ),
        'popular_items'              => __( 'Popular Exam Boards', 'sage' ),
        'search_items'               => __( 'Search Exam Boards', 'sage' ),
        'not_found'                  => __( 'Not Found', 'sage' ),
        'no_terms'                   => __( 'No Exam Boards', 'sage' ),
        'items_list'                 => __( 'Exam Boards list', 'sage' ),
        'items_list_navigation'      => __( 'Exam Boards list navigation', 'sage' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'meta_box_cb'                => 'post_categories_meta_box',
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => false,
        'show_tagcloud'              => false,
        'rewrite'                    => false,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'ses_exam_board', array(), $args );

}
add_action( 'init', __NAMESPACE__.'\\ses_exam_board_tax', 0 );


// Register Custom Post Type
function six_marks_cpt() {

    $labels = array(
        'name'                  => _x( '6 Mark Questions', 'Post Type General Name', 'sage' ),
        'singular_name'         => _x( 'Question Set', 'Post Type Singular Name', 'sage' ),
        'menu_name'             => __( '6 Mark Questions', 'sage' ),
        'name_admin_bar'        => __( 'Question Sets', 'sage' ),
        'archives'              => __( 'Question Set Archives', 'sage' ),
        'attributes'            => __( 'Question Set Attributes', 'sage' ),
        'parent_item_colon'     => __( 'Parent Question Set:', 'sage' ),
        'all_items'             => __( 'All Question Sets', 'sage' ),
        'add_new_item'          => __( 'Add New Question Set', 'sage' ),
        'add_new'               => __( 'Add New', 'sage' ),
        'new_item'              => __( 'New Question Set', 'sage' ),
        'edit_item'             => __( 'Edit Question Set', 'sage' ),
        'update_item'           => __( 'Update Question Set', 'sage' ),
        'view_item'             => __( 'View Question Set', 'sage' ),
        'view_items'            => __( 'View Question Sets', 'sage' ),
        'search_items'          => __( 'Search Question Set', 'sage' ),
        'not_found'             => __( 'Not found', 'sage' ),
        'not_found_in_trash'    => __( 'Not found in Bin', 'sage' ),
        'featured_image'        => __( 'Featured Image', 'sage' ),
        'set_featured_image'    => __( 'Set featured image', 'sage' ),
        'remove_featured_image' => __( 'Remove featured image', 'sage' ),
        'use_featured_image'    => __( 'Use as featured image', 'sage' ),
        'insert_into_item'      => __( 'Insert into Question Set', 'sage' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Question Set', 'sage' ),
        'items_list'            => __( 'Question Sets list', 'sage' ),
        'items_list_navigation' => __( 'Question Sets list navigation', 'sage' ),
        'filter_items_list'     => __( 'Filter Question Sets list', 'sage' ),
    );
    $rewrite = array(
        'slug'                  => 'subject/%ses_subject%/six-mark-questions/level/%ses_level%/board/%ses_exam_board%',
        'with_front'            => false,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Question Set', 'sage' ),
        'description'           => __( 'Practice exam long answer questions and consolidate your learning by topic.', 'sage' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'revisions' ),
        'taxonomies'            => array( 'ses_subject', 'ses_level', 'ses_exam_board' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-saved',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'rewrite'               => $rewrite,
        'capability_type'       => 'page',
        'show_in_rest'          => false,
    );
    register_post_type( 'ses_six_marks', $args );

}
add_action( 'init', __NAMESPACE__.'\\six_marks_cpt', 0 );


