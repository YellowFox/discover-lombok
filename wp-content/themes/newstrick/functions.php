<?php

/*-----------------------------------------------------------------------------------*/
/* Slightly Modified Options Framework
/*-----------------------------------------------------------------------------------*/
require_once ('admin/index.php');

function the_excerpt_max_charlength($charlength) {
    $excerpt = get_the_excerpt();
    $charlength++;

    if ( mb_strlen( $excerpt ) > $charlength ) {
        $subex = mb_substr( $excerpt, 0, $charlength - 5 );
        $exwords = explode( ' ', $subex );
        $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
        if ( $excut < 0 ) {
            echo mb_substr( $subex, 0, $excut );
        } else {
            echo $subex;
        }
        echo '...';
    } else {
        echo $excerpt;
    }
}

function the_title_max_charlength($charlength) {
    $title = get_the_title();
    $charlength++;

    if ( mb_strlen( $title ) > $charlength ) {
        $subex = mb_substr( $title, 0, $charlength - 5 );
        $exwords = explode( ' ', $subex );
        $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
        if ( $excut < 0 ) {
            echo mb_substr( $subex, 0, $excut );
        } else {
            echo $subex;
        }
        echo '...';
    } else {
        echo $title;
    }
}

/*-----------------------------------------------------------------------------------*/
/* Sets up theme defaults and registers the various WordPress features that
 * Theme supports.
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_theme_setup' ) ) {	
    function ct_theme_setup(){

        // Makes theme available for translation.
        load_theme_textdomain( 'color-theme-framework', get_template_directory() . '/languages' );

        // This theme supports a variety of post formats.
        add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio' ) );

        // This theme uses a custom image size for featured images, displayed on "standard" posts.
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 150, 150 ); // default Post Thumbnail dimensions

        // This automatically adds the relevant feed links everywhere on the whole site.
        add_theme_support( 'automatic-feed-links' );

        // Registers a new image sizes.
        add_image_size( 'small-thumb', 75, 75, true );
        add_image_size( 'carousel-thumb', 267, 188, true ); // carousel thumbnail	
        add_image_size( 'slider-thumb', 728, 387, true );   // slider thumbnail
        add_image_size( 'post-thumb', 728, 513, true );     // post thumbnail
        add_image_size( 'post-thumbnails-square', 220, 124, true );     // post thumbnail square
    }
}
add_action('after_setup_theme', 'ct_theme_setup');



/*-----------------------------------------------------------------------------------*/
/* Add WP Menu Support
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_register_menus' ) ) {
    function ct_register_menus() { 
        register_nav_menus(
        array(
            'main_menu' => __( 'main navigation' , 'color-theme-framework' ),
            'bottom_menu' => __( 'bottom navigation' , 'color-theme-framework' )
            )
        );
    }
}
add_action( 'init', 'ct_register_menus' ); 


/*-----------------------------------------------------------------------------------*/
/* Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_wp_title' ) ) {
    function ct_wp_title( $title, $sep ) {
        global $paged, $page;

        if ( is_feed() )
            return $title;

        // Add the site name.
        $title .= get_bloginfo( 'name' );

        // Add the site description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) )
            $title = "$title $sep $site_description";

        // Add a page number if necessary.
        if ( $paged >= 2 || $page >= 2 )
            $title = "$title $sep " . sprintf( __( 'Page %s', 'color-theme-framework' ), max( $paged, $page ) );

        return $title;
    }
    add_filter( 'wp_title', 'ct_wp_title', 10, 2 );
}


/*-----------------------------------------------------------------------------------*/
/* Registers our theme widget areas and sidebars
/*-----------------------------------------------------------------------------------*/
$num_widget_areas = stripslashes( $data['ct_num_widget_areas'] );
$widget_title_color = stripslashes( $data['ct_widget_title_color'] );


/* Create Magazine Widgets areas */
for ($i = 1; $i <= $num_widget_areas; $i++) {
	if ( function_exists('register_sidebar') )
	    register_sidebar(array(
        'id' => 'ct_magazine_row_'.$i,
        'name' => __( 'Magazine Widgets - Row #', 'color-theme-framework' ).$i,
        'description' => __( 'Appears on Home page if selected the appropriate layout', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
	    ));
}

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => __( 'Magazine Top Widgets', 'color-theme-framework' ),
        'id' => 'ct_magazine_top',
        'description' => __( 'Appears on Home page', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => __( 'Magazine Center Widgets', 'color-theme-framework' ),
        'description' => __( 'Appears on Home page', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Magazine Left Sidebar',
        'description' => __( 'Appears on Home page', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Magazine Right Sidebar',
        'description' => __( 'Appears on Home page', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

// ##########  SINGLE POST WIDGETS   #############
if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Single Top Widgets',
        'id' => 'ct_single_top',
        'description' => __( 'Appears on posts', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Single Before Widgets',
        'id' => 'ct_single_before',
        'description' => __( 'Appears on posts', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Single After Widgets',
        'id' => 'ct_single_after',
        'description' => __( 'Appears on posts', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));    

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Single Left Sidebar',
        'description' => __( 'Appears on posts', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Single Right Sidebar',
        'description' => __( 'Appears on posts', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));
    
if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Sidebar Widgets',
        'description' => __( 'Appears on pages', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

// ##########  CATEGORY WIDGETS   #############
if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Category Top Widgets',
        'id' => 'ct_category_top',
        'description' => __( 'Appears on category page', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Category Before Widgets',
        'id' => 'ct_category_before',
        'description' => __( 'Appears on category page, before content', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Category After Widgets',
        'id' => 'ct_category_after',
        'description' => __( 'Appears on category page, after content', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));   

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Category Left Sidebar',
        'description' => __( 'Appears on category page', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Category Right Sidebar',
        'description' => __( 'Appears on category page', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

// ##########  BLOG WIDGETS   #############
if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Blog Top Widgets',
        'id' => 'ct_blog_top',
        'description' => __( 'Appears when using the Blog template', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Blog Before Widgets',
        'id' => 'ct_blog_before',
        'description' => __( 'Appears when using the Blog template', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Blog After Widgets',
        'id' => 'ct_blog_after',
        'description' => __( 'Appears when using the Blog template', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));   

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Blog Left Sidebar',
        'description' => __( 'Appears when using the Blog template', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Blog Right Sidebar',
        'description' => __( 'Appears when using the Blog template', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

// ##########  ONLY FOR DEMO   #############
if ( function_exists('register_sidebar') )
        register_sidebar(array(
        'id' => 'ct_magazine_row_demo',
        'name' => __( 'Demo Magazine Center Widgets', 'color-theme-framework' ),
        'description' => __( 'Appears on Home page if selected the appropriate layout (demo)', 'color-theme-framework' ),
        'before_widget' => '<div class="ct-block"><div class="widget margin-30t box border-1px bottom-shadow clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .ct-block -->',
        'before_title' => '<div class="widget-title bottom-shadow" style="background:' . $widget_title_color .';"><h2>',
        'after_title' => '</h2><div class="arrow-down" style="border-top-color:' . $widget_title_color . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->',
    ));

/* -------  FOOTER WIDGETS  ------- */
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Footer',
        'description' => __( 'Appears on footer area', 'color-theme-framework' ),
        'before_widget' => '<div class="span4"><div class="widget box clearfix">',
        'after_widget' => '</div><!-- .widget --></div><!-- .span4 -->',
        'before_title' => '<div class="widget-title bottom-shadow"><h2>',
        'after_title' => '</h2><div class="arrow-down"></div><!-- .arrow-down --></div><!-- widget-title -->',
));



if ( !isset( $content_width ) ) 
    $content_width = 980;


/*-----------------------------------------------------------------------------------*/
/*  Adding the Farbtastic Color Picker
/*  register message box widget
/*-----------------------------------------------------------------------------------*/
if ( is_admin() ) {
    if ( !function_exists( 'ct_load_color_picker_script' ) ) {
        function ct_load_color_picker_script() {
    	   wp_enqueue_script('farbtastic');
        }

        add_action('admin_print_scripts-widgets.php', 'ct_load_color_picker_script');
    }

    if ( !function_exists( 'ct_load_color_picker_style' ) ) {
        function ct_load_color_picker_style() {
    	   wp_enqueue_style('farbtastic');	
        }

        add_action('admin_print_styles-widgets.php', 'ct_load_color_picker_style');
    }
}


/*-----------------------------------------------------------------------------------*/
/*  Add Thumbnails in Manage Posts/Pages List
/*-----------------------------------------------------------------------------------*/
// Add the posts and pages columns filter. They can both use the same function.
add_filter('manage_posts_columns', 'ct_add_post_thumbnail_column', 5);
add_filter('manage_pages_columns', 'ct_add_post_thumbnail_column', 5);

// Add the column
function ct_add_post_thumbnail_column($cols){
  $cols['tcb_post_thumb'] = __('Featured', 'color-theme-framework');
  return $cols;
}

// Hook into the posts an pages column managing. Sharing function callback again.
add_action('manage_posts_custom_column', 'ct_display_post_thumbnail_column', 5, 2);
add_action('manage_pages_custom_column', 'ct_display_post_thumbnail_column', 5, 2);

// Grab featured-thumbnail size post thumbnail and display it.
function ct_display_post_thumbnail_column($col, $id){
  switch($col){
    case 'tcb_post_thumb':
      if( function_exists('the_post_thumbnail') )
        echo the_post_thumbnail( 'small-thumb' );
      else
        echo 'Not supported in theme';
      break;
  }
}



/*-----------------------------------------------------------------------------------*/
/*  Cleanup WordPress Header
/*-----------------------------------------------------------------------------------*/
remove_action( 'wp_head', 'feed_links_extra', 3 ); 
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); 
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );


/*-----------------------------------------------------------------------------------*/
/*  Change excerpt length
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_new_excerpt_length' ) ) {
    function ct_new_excerpt_length($length) {
    	return 30;
    }
}
add_filter('excerpt_length', 'ct_new_excerpt_length');


/*-----------------------------------------------------------------------------------*/
/*  Change excerpt more string
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_new_excerpt_more' ) ) {
    function ct_new_excerpt_more($more) {
    	return '...';
    }
}
add_filter('excerpt_more', 'ct_new_excerpt_more');



/*-----------------------------------------------------------------------------------*/
/*  Add Admin Bar only for Editors
/*-----------------------------------------------------------------------------------*/
if (!current_user_can('manage_options')) {
	add_filter('show_admin_bar', '__return_false');
}



/*-----------------------------------------------------------------------------------*/
/*  Show Featured Images in RSS Feed
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_featuredtorss' ) ) {
    function ct_featuredtorss($content) {
        global $post;
        if ( has_post_thumbnail( $post->ID ) ){
            $content = '<div>' . get_the_post_thumbnail( $post->ID, 'thumbnail', array( 'style' => 'margin-bottom: 15px;' ) ) . '</div>' . $content;
        }
        return $content;
    }
}
add_filter('the_excerpt_rss', 'ct_featuredtorss');
add_filter('the_content_feed', 'ct_featuredtorss');



/*-----------------------------------------------------------------------------------*/
/*  Enable Shortcodes In Sidebar Widgets
/*-----------------------------------------------------------------------------------*/
add_filter('widget_text', 'do_shortcode');



/*-----------------------------------------------------------------------------------*/
/*  Enqueues scripts for front-end
/*-----------------------------------------------------------------------------------*/
add_action('wp_enqueue_scripts', 'ct_scripts_method');

if ( !function_exists( 'ct_scripts_method' ) ) {
function ct_scripts_method() {

	//enqueue jquery
	wp_enqueue_script('jquery');

	if( !is_admin() ) {
	
		global $data;

		/* Super Fish JS */
		wp_register_script('super-fish',get_template_directory_uri().'/js/superfish.js',false, null , true);
		wp_enqueue_script('super-fish',array('jquery'));	

		/* Jquery-Easing */
		wp_register_script('jquery-easing',get_template_directory_uri().'/js/jquery.easing.1.3.js',false, null , true);
		wp_enqueue_script('jquery-easing',array('jquery'));	

		/* Google Prettify */
		wp_register_script('google-prettify',get_template_directory_uri().'/js/prettify.js',false, null , true);
		wp_enqueue_script('google-prettify',array('jquery'));

		/* Flex Slider */
		wp_register_script('flex-min-jquery',get_template_directory_uri().'/js/jquery.flexslider-min.js',false, null , true);
		wp_enqueue_script('flex-min-jquery',array('jquery'));	

        /* FitVids */
        wp_register_script('fitvids',get_template_directory_uri().'/js/jquery.fitvids.js',false, null , true);
        wp_enqueue_script('fitvids',array('jquery'));

		/* Prettyphoto */
		wp_register_script('prettyphoto-js',get_template_directory_uri().'/js/jquery.prettyphoto.js',false, null , true);
		wp_enqueue_script('prettyphoto-js',array('jquery'));

		if ( stripslashes( $data['ct_img_preload'] ) == 'Yes' ) {
			/* Image Preloader */
			wp_register_script('preloader-js',get_template_directory_uri().'/js/jquery.preloader.js',false, null , true);
			wp_enqueue_script('preloader-js',array('jquery'));
		}

		/* Bootstrap */
		wp_register_script('jquery-bootstrap',get_template_directory_uri().'/js/bootstrap.js',false, null , true);
		wp_enqueue_script('jquery-bootstrap',array('jquery'));

		/* Custom JS */
		wp_register_script('custom-js',get_template_directory_uri().'/js/custom.js',false, null , true);
		wp_enqueue_script('custom-js',array('jquery'));

        /* To Top */
        wp_register_script('scrolltopcontrol-js',get_template_directory_uri().'/js/scrolltopcontrol.js',false, null , true);
        wp_enqueue_script('scrolltopcontrol-js',array('jquery'));

        /*
        * Adds JavaScript to pages with the comment form to support
        * sites with threaded comments (when in use).
        */
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
            wp_enqueue_script( 'comment-reply' );

	} /* End Include jQuery Libraries */
  }
}


/*-----------------------------------------------------------------------------------*/
/*  Enqueues styles for front-end
/*-----------------------------------------------------------------------------------*/
if ( !function_exists ('ct_header_styles' ) ) {
	function ct_header_styles() {

	global $wp_styles;

	wp_enqueue_style( 'bootstrap-main-style',get_template_directory_uri().'/css/bootstrap.css','','','all');
	wp_enqueue_style( 'bootstrap-responsive',get_template_directory_uri().'/css/bootstrap-responsive.css','','','all');
	wp_enqueue_style( 'ct-style',get_stylesheet_directory_uri().'/style.css','','','all');		
	wp_enqueue_style( 'prettyphoto-style',get_template_directory_uri().'/css/prettyphoto.css','','','all');
	wp_enqueue_style( 'options-css-style',get_template_directory_uri().'/css/options.css','','','all');

    ############## ADD ON BY ROMAIN ########
    //Test if blog is the main one
    $blogid = get_current_blog_id() ;

    if ( $blogid == 1 ) { 

        //Then load specific assets to the header
        wp_enqueue_style('homepage-template', get_stylesheet_directory_uri().'/homepage-template/assets/css/style.css', array('bootstrap-main-style', 'bootstrap-responsive'), $ver = '1.0', $media = 'all');

    }

	/* Loads the Internet Explorer specific stylesheet. */
//	wp_enqueue_style( 'ie-fix', get_template_directory_uri() . '/css/ie-fix.css', array( 'ct-style' ), '1.0' );
//	$wp_styles->add_data( 'ie-fix', 'conditional', 'lte IE 9' );
	
	}
}

add_action('wp_print_styles', 'ct_header_styles'); 


/*-----------------------------------------------------------------------------------*/
/*  Fav and touch icons
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'ct_fav_icons' ) ) {
    function ct_fav_icons() {
        global $data;
            
        echo "<!-- Fav and touch icons -->\n";
        echo "<link rel=\"shortcut icon\" href=\"" . stripslashes( $data['ct_custom_favicon'] ) . "\">\n";
        echo "<link rel=\"apple-touch-icon-precomposed\" sizes=\"144x144\" href=\"" . get_template_directory_uri() . "/img/icons/apple-touch-icon-144-precomposed.png\">\n";
        echo "<link rel=\"apple-touch-icon-precomposed\" sizes=\"114x114\" href=\"" . get_template_directory_uri() ."/img/icons/apple-touch-icon-114-precomposed.png\">\n";
        echo "<link rel=\"apple-touch-icon-precomposed\" sizes=\"72x72\" href=\"" . get_template_directory_uri() ."/img/icons/apple-touch-icon-72-precomposed.png\">\n";
        echo "<link rel=\"apple-touch-icon-precomposed\" href=\"" . get_template_directory_uri() . "/img/icons/apple-touch-icon-57-precomposed.png\">\n";
    }
}
add_action('wp_head','ct_fav_icons');


/*-----------------------------------------------------------------------------------*/
/* Google Fonts 
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_google_fonts' ) ) {
	function ct_google_fonts() {
		global $data;

        $google_enable ='';
		if ( isset( $data['ct_google_enable'] ) ) $google_enable = stripslashes( $data['ct_google_enable'] );
		
		if ( $google_enable == 'Yes' )	{
			if ( stripslashes( $data['ct_google_stylesheet'] ) != ''  ) {
				echo stripslashes( $data['ct_google_stylesheet'] );
					
				echo '<style type="text/css">h1,h2,h3,h4,h5,h6 { ';
				echo stripslashes( $data['ct_google_fontfamily'] );
				echo '}</style>';
			}			
		}
    }
}

add_action('wp_head','ct_google_fonts');


/*-----------------------------------------------------------------------------------*/
/* Add IE conditional fix to header 
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_ie_fix' ) ) {
    function ct_ie_fix () {
        echo "<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->\n";
        echo "<!--[if lt IE 9]>\n";
        echo "<script src=\"http://html5shim.googlecode.com/svn/trunk/html5.js\"></script>\n";
        echo "<script src=\"" . get_template_directory_uri() . "/js/respond.min.js\"></script>\n";
        echo "<![endif]-->\n";

        echo "<script>if(Function('/*@cc_on return 10===document.documentMode@*/')()){document.documentElement.className='ie10';}</script>";

        $IE10 = (ereg('MSIE 10',$_SERVER['HTTP_USER_AGENT'])) ? true : false;
        if ( $IE10 == 1 ) {
            echo "<style type=\"text/css\">\n .video-post-widget, .single-video-post, .single-media-thumb, .embed-youtube, .embed-vimeo, .video-frame {position: relative;padding-bottom: 56.25%; height: 0;} .video-post-widget iframe, .single-video-post iframe, .single-media-thumb iframe, .embed-youtube iframe, .embed-vimeo iframe, .video-frame iframe { position: absolute;top: 0;left: 0;width: 100%;height: 100%;}</style>\n";
        }        
    }
}
add_action('wp_head', 'ct_ie_fix');



/*-----------------------------------------------------------------------------------*/
/* Get Related Post function 
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_get_related_posts' ) ) {
    function ct_get_related_posts($post_id, $tags = array(), $posts_number_display, $order_by) {
    	$query = new WP_Query();

    	$post_types = get_post_types();
    	unset($post_types['page'], $post_types['attachment'], $post_types['revision'], $post_types['nav_menu_item']);
	
    	if($tags) {
            foreach($tags as $tag) {
                $tagsA[] = $tag->term_id;
            }
        }
	   $query = new WP_Query( array('orderby' => $order_by, 'showposts' => $posts_number_display,'post_type' => $post_types,'post__not_in' => array($post_id),'tag__in' => $tagsA,'ignore_sticky_posts' => 1 ));
    	return $query;
    }
}


/*-----------------------------------------------------------------------------------*/
/* Pagination function 
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_pagination' ) ) {
    function ct_pagination($pages = '', $range = 4)
    {  
        $showitems = ($range * 2)+1;  
 
        global $paged;
        if(empty($paged)) $paged = 1;
 
        if($pages == '')
        {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if(!$pages)
            {
                $pages = 1;
            }
        }   
 
        if(1 != $pages)
        {
            echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
            if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
            if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
 
            for ($i=1; $i <= $pages; $i++)
            {
                if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
                {
                    echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
                }
            }
 
            if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";  
            if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
            echo "</div>\n";
        }
    }
}



/*-----------------------------------------------------------------------------------*/
/* Custom Styles for Backend Options
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'ct_upload_styles_post' ) ) {
    function ct_upload_styles_post() {
    	wp_enqueue_style( 'style-metabox-admin',get_template_directory_uri().'/admin/assets/css/metabox-options.css','','','all');
    }

    add_action('admin_print_styles', 'ct_upload_styles_post'); 
}



/*-----------------------------------------------------------------------------------*/
/* Get DailyMotion Thumbnail
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'getDailyMotionThumb' ) ) {
    function getDailyMotionThumb( $id ) {
        if ( ! function_exists( 'curl_init' ) ) {
            return null;
	    }
        else {
		  $ch = curl_init();
		  $videoinfo_url = "https://api.dailymotion.com/video/$id?fields=thumbnail_url";
		  curl_setopt( $ch, CURLOPT_URL, $videoinfo_url );
		  curl_setopt( $ch, CURLOPT_HEADER, 0 );
		  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		  curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		  curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );
		  curl_setopt( $ch, CURLOPT_FAILONERROR, true ); // Return an error for curl_error() processing if HTTP response code >= 400
		  $output = curl_exec( $ch );
		  $output = json_decode( $output );
		  $output = $output->thumbnail_url;
		  if ( curl_error( $ch ) != null ) {
			$output = new WP_Error( 'dailymotion_info_retrieval', __( 'Error retrieving video information from the URL','color-theme-framework') . '<a href="' . $videoinfo_url . '">' . $videoinfo_url . '</a>.<br /><a href="http://curl.haxx.se/libcurl/c/libcurl-errors.html">Libcurl error</a> ' . curl_errno( $ch ) . ': <code>' . curl_error( $ch ) . '</code>. If opening that URL in your web browser returns anything else than an error page, the problem may be related to your web server and might be something your host administrator can solve.' );
		  }
		  curl_close( $ch ); // Moved here to allow curl_error() operation above. Was previously below curl_exec() call.
		  return $output;
        }
    }
}


/*-----------------------------------------------------------------------------------*/
/* Get Post Count
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_get_post_count' ) ) {
    function ct_get_post_count() {
	   $res_search = &new WP_Query("showposts=-1");
	   $count = $res_search->post_count;

	   return $count; 
	     
	   wp_reset_query();
	   unset($res_search, $count);
    }
}



/*-----------------------------------------------------------------------------------*/
/* Set an option for a cURL transfer
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_curl_subscribers_text_counter' ) ) {
	function ct_curl_subscribers_text_counter( $xml_url ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $xml_url);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}


/*-----------------------------------------------------------------------------------*/
/* Youtube counter
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_yt_count' ) ) {
	function ct_yt_count( $username ) { 
		try {
			@$xmlData = @ct_curl_subscribers_text_counter('http://gdata.youtube.com/feeds/api/users/' . strtolower($username)); 
			@$xmlData = str_replace('yt:', 'yt', $xmlData); 
			@$xml = new SimpleXMLElement($xmlData); 
			@$ytCount['yt_count'] = ( string ) $xml->ytstatistics['subscriberCount'];
			@$ytCount['page_url'] = "http://www.youtube.com/user/".$username;
		} catch (Exception $e) {
			$ytCount['yt_count'] = 0;
			$ytCount['page_url'] = "http://www.youtube.com";
		}
		return($ytCount); 
	} 
}


/*-----------------------------------------------------------------------------------*/
/* Twitter counter
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_twitter_count' ) ) {
	function ct_twitter_count( $twitter_id ) {
		try {
			@$url = "https://api.twitter.com/1/users/show.json?screen_name=".$twitter_id;
			@$reply = json_decode(@ct_curl_subscribers_text_counter($url));
			@$twitter['followers_count'] = $reply->followers_count;
		} catch (Exception $e) {
			$twitter['followers_count'] = '0';
		}
		return $twitter;
	}
}


/*-----------------------------------------------------------------------------------*/
/* This is function gets the post views and display it in admin panel.
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'getPostViews' ) ) {
    function getPostViews( $postID ){
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0";
        }
        return $count. __('','color-theme-framework');
    }
}

if ( !function_exists( 'setPostViews' ) ) {
    function setPostViews($postID) {
    if (!current_user_can('administrator') ) :
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    endif;
    }
}

if ( !function_exists( 'posts_column_views' ) ) {
    function posts_column_views($defaults){
        $defaults['post_views'] = __( 'Views' , 'color-theme-framework' );
        return $defaults;
    }
}

if ( !function_exists( 'posts_custom_column_views' ) ) {
    function posts_custom_column_views($column_name, $id){
        if( $column_name === 'post_views' ) {
            echo getPostViews( get_the_ID() );
        }
    }
}

add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);



/*-----------------------------------------------------------------------------------*/
/* Remove rel attribute from the category list
/*-----------------------------------------------------------------------------------*/
function ct_remove_category_list_rel($output)
{
  $output = str_replace(' rel="category"', '', $output);
  return $output;
}

add_filter('wp_list_categories', 'ct_remove_category_list_rel');
add_filter('the_category', 'ct_remove_category_list_rel');

add_filter( 'the_category', 'ct_replace_cat_tag' );

function ct_replace_cat_tag ( $text ) {
    $text = str_replace('rel="category tag"', "", $text); return $text;
}




/*-----------------------------------------------------------------------------------*/
/* Add Theme Widgets
/*-----------------------------------------------------------------------------------*/
include("functions/newstrick-news-ticker-horizontal-widget.php");
include("functions/newstrick-categories-widget.php");
include("functions/newstrick-search-widget.php");
include("functions/newstrick-blog-widget.php");
include("functions/newstrick-fblikebox-widget.php");
include("functions/newstrick-fbsubscribe-widget.php");
include("functions/newstrick-social-widget.php");
include("functions/newstrick-recent-posts-widget.php");
include("functions/newstrick-tabbed-widget.php");
include("functions/newstrick-popular-posts-widget.php");
include("functions/newstrick-related-posts-thumbs-widget.php");
include("functions/newstrick-twitter-widget.php");
include("functions/newstrick-carousel-widget.php");
include("functions/newstrick-slider-widget.php");
include("functions/newstrick-small-slider-widget.php");
include("functions/newstrick-social-counter-widget.php");
include("functions/newstrick-two-columns-thumbs-widget.php");
include("functions/newstrick-three-columns-thumbs-widget.php");
include("functions/newstrick-flickr-widget.php");
include("functions/newstrick-instagram-widget.php");
include("functions/newstrick-one-column-thumbs-widget.php");
include("functions/newstrick-news-ticker-vertical-widget.php");
include("functions/newstrick-one-column-category-widget.php");
include("functions/newstrick-recent-posts-thumbs-widget.php");
include("functions/newstrick-text-widget.php");

/* Add Color Picker field for Categories */
require_once("includes/categories-color.php");

/* Post Like */
require_once("post-like.php");


/* Metabox components */
require_once("meta-box/meta-box.php");

/* Theme Metaboxes */
require_once("includes/theme-metaboxes.php");

/* AJAX Thumbnail Rebuild */
require_once ('includes/ajax-thumbnail-rebuild.php');

/* Sidebar Generator */
require_once ('includes/sidebar-generator.php');

/* Update notifier */
require_once ("includes/update-notifier.php");

/* Get Shortcodes */
require_once ("includes/shortcodes.php");


/*-----------------------------------------------------------------------------------*/
/* Get Post Meta
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_get_post_meta' ) ) {
    function ct_get_post_meta($ct_postid, $ct_likes, $ct_comments, $ct_views, $ct_date, $ct_category) { ?>

        <?php if ( $ct_likes == 'true' ) { ?>
        <span class="meta-likes" title="<?php _e('Likes','color-theme-framework'); ?>">
            <?php $votes = get_post_meta( $ct_postid, "votes_count", true); 
            if ( $votes == '' ) : echo '0';
            else : echo $votes; endif;  ?>
        </span><!-- .meta-likes -->
        <?php } ?>

        <?php if ( $ct_comments == 'true' ) { ?>
        <span class="meta-comments">
            <?php comments_popup_link(__('0','color-theme-framework'),__('1','color-theme-framework'),__('%','color-theme-framework')); ?>
        </span><!-- .meta-comments -->
        <?php } ?>

        <?php if ( $ct_views == 'true' ) { ?>
        <span class="meta-views" title="<?php _e('Views','color-theme-framework'); ?>">
            <?php echo getPostViews($ct_postid); ?>
        </span><!-- .meta-views-->
        <?php } ?>

        <?php if ( $ct_date == 'true' ) { ?>
        <span class="meta-date updated" title="<?php _e('Date','color-theme-framework'); ?>">
            <?php echo esc_attr( get_the_date( 'd F, Y' ) ); ?>
        </span><!-- .meta-date-->
        <?php } ?>

        <?php if ( $ct_category == 'true' ) { ?>
        <span class="meta-category" title="<?php _e('Category','color-theme-framework'); ?>">
            <?php echo get_the_category_list(', '); ?>
        </span><!-- .meta-category-->
        <?php } ?>

<?php
    }
}


/*-----------------------------------------------------------------------------------*/
/* Get author for comment
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'ct_get_author' ) ) :
function ct_get_author($comment) {
    $author = "";
    if ( empty($comment->comment_author) )
        $author = __('Anonymous', 'color-theme-framework');
    else
        $author = $comment->comment_author;
    return $author;
}
endif;



/*-----------------------------------------------------------------------------------*/
/*  This will add rel=lightbox[postid] to the href of the image link
/*-----------------------------------------------------------------------------------*/
$add_prettyphoto = stripslashes( $data['ct_add_prettyphoto'] );

if ( $add_prettyphoto == 'Yes') :
    if ( !function_exists( 'ct_add_prettyphoto_rel' ) ) {
        function ct_add_prettyphoto_rel ($content)
        {   
            global $post;
            $pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
            $replacement = '<a$1href=$2$3.$4$5 rel="prettyphoto['.$post->ID.']"$6>$7</a>';
            $content = preg_replace($pattern, $replacement, $content);
            return $content;
        }
        add_filter('the_content', 'ct_add_prettyphoto_rel', 12);
    }
endif;


/*-----------------------------------------------------------------------------------*/
/*  Custom Background and Custom CSS
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_custom_head_css' ) ) {
    function ct_custom_head_css() {

        $output = '';

        global $wp_query, $data;
        if( is_home() ) {
            $postid = get_option('page_for_posts');
        } elseif( is_search() || is_404() ) {
            $postid = 0;
        } else {
            $postid = $wp_query->post->ID;
        }

        /* -- Get the unique custom background image for page --------------------*/
        $bg_img = get_post_meta($postid, 'ct_mb_background_image', true);
        $src = wp_get_attachment_image_src( $bg_img, 'full' );
        $bg_img = $src[0];

        if( empty($bg_img) ) {
            /* -- Background image not defined, fallback to default background -- */
            $bg_pos = strtolower ( stripslashes ( $data['ct_default_bg_position'] ) );
            if ( $bg_pos == 'full screen' ) {
                $bg_pos = 'full';
            }
            $bg_type = stripslashes ( $data['ct_default_bg_type'] );

            if( $bg_pos != 'full' ) {
                /* -- Setup body backgroung image, if not fullscreen -- */
                if ( $bg_type == 'Uploaded' ) {
                    $bg_img = stripslashes ( $data['ct_default_bg_image'] );
                } else if ( $bg_type == 'Predefined' ) {
                    $bg_img = stripslashes ( $data['ct_default_predefined_bg'] );
                }

                if( !empty($bg_img) ) {
                    $bg_img = " url($bg_img)";
                } else {
                    $bg_img = " none";
                }

                $bg_repeat = strtolower ( stripslashes ( $data['ct_default_bg_repeat'] ) );
                $bg_attachment = strtolower ( stripslashes ( $data['ct_default_bg_attachment'] ) );
                $bg_color = get_post_meta($postid, 'ct_mb_background_color', true);

                if( empty($bg_color) ) { 
                    $bg_color = stripslashes ( $data['ct_body_background'] );
                }

                $output .= "body { \n\tbackground-color: $bg_color;\n\tbackground-image: $bg_img;\n\tbackground-attachment: $bg_attachment;\n\tbackground-repeat: $bg_repeat;\n\tbackground-position: top $bg_pos; \n}\n";
            }    
        } else {
            /* -- Custom image defined, check default position -------------------- */
            $bg_pos = get_post_meta($postid, 'ct_mb_background_position', true);

            if( $bg_pos != 'full' ) {
                /* -- Setup body backgroung image, if not fullscreen -- */
                $bg_img = " url($bg_img)";

                /* -- Get the repeat and backgroung color options -- */
                $bg_repeat = get_post_meta($postid, 'ct_mb_background_repeat', true);
                $bg_attachment = get_post_meta($postid, 'ct_mb_background_attachment', true);
                $bg_color = get_post_meta($postid, 'ct_mb_background_color', true);

                if( empty($bg_color) ) {
                    $bg_color = stripslashes ( $data['ct_body_background'] );
                }

                $output .= "body { \n\tbackground-color: $bg_color;\n\tbackground-image: $bg_img;\n\tbackground-attachment: $bg_attachment;\n\tbackground-repeat: $bg_repeat;\n\tbackground-position: top $bg_pos; \n}\n";
            }
        }
        
        /* -- Custom CSS from Theme Options --------------------*/
        $custom_css = stripslashes ( $data['ct_custom_css'] );
    
        if ( !empty($custom_css) ) {
            $output .= $custom_css . "\n";
        }
        
        /* -- Output our custom styles --------------------------*/
        if ($output <> '') {
            $output = "<!-- Custom Styles -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
            echo stripslashes($output);
        }
    
    }

    add_action('wp_head', 'ct_custom_head_css');
}


/*-------------------------------------------------*/
/*  EQUAL BLOCK HEIGHT IN THE FOOTER
/*-------------------------------------------------*/
function ct_equal_height() { ?>
    <script type="text/javascript">
    // Equal Height Columns
    jQuery.noConflict();
        function equalHeight(group) {
            tallest = 0;
            group.each(function() {
                thisHeight = jQuery(this).height();
                if(thisHeight > tallest) {
                    tallest = thisHeight;
                }
            });
            group.height(tallest);
        }
    jQuery(document).ready(function() {
        equalHeight(jQuery(".sf-menu-flat > li"));
    });
    </script>

<?php }
add_action('wp_head','ct_equal_height');


/*-----------------------------------------------------------------------------------*/
/* Displays page links for paginated posts/pages
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_wp_link_pages' ) ) {
    function ct_wp_link_pages( $args = '' ) {
        $defaults = array(
            'before' => '<p class="pagination clearfix"><span>' . __( 'Pages:', 'color-theme-framework' ) . '</span>', 
            'after' => '</p>',
            'text_before' => '',
            'text_after' => '',
            'next_or_number' => 'number', 
            'nextpagelink' => __( 'Next page', 'color-theme-framework' ),
            'previouspagelink' => __( 'Previous page', 'color-theme-framework' ),
            'pagelink' => '%',
            'echo' => 1
        );

        $r = wp_parse_args( $args, $defaults );
        $r = apply_filters( 'wp_link_pages_args', $r );
        extract( $r, EXTR_SKIP );

        global $page, $numpages, $multipage, $more, $pagenow;

        $output = '';
        if ( $multipage ) {
            if ( 'number' == $next_or_number ) {
                $output .= $before;
                for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
                    $j = str_replace( '%', $i, $pagelink );
                    $output .= ' ';
                    if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
                        $output .= _wp_link_page( $i );
                    else
                        $output .= '<span class="current">';

                    $output .= $text_before . $j . $text_after;
                    if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
                        $output .= '</a>';
                    else
                        $output .= '</span>';
                }
                $output .= $after;
            } else {
                if ( $more ) {
                    $output .= $before;
                    $i = $page - 1;
                    if ( $i && $more ) {
                        $output .= _wp_link_page( $i );
                        $output .= $text_before . $previouspagelink . $text_after . '</a>';
                    }
                    $i = $page + 1;
                    if ( $i <= $numpages && $more ) {
                        $output .= _wp_link_page( $i );
                        $output .= $text_before . $nextpagelink . $text_after . '</a>';
                    }
                    $output .= $after;
                }
            }
        }

        if ( $echo )
            echo $output;

        return $output;
    }
}



/*-----------------------------------------------------------------------------------*/
/* Get rating stars (big)
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_get_rating_stars' ) ) {
    function ct_get_rating_stars() {
        
        global $post, $ct_video_height;
       
        $stars_color = get_post_meta( $post->ID, 'ct_mb_stars_color', true);         
        if ( $stars_color == '' ) $stars_color = '#DD0C0C';
                                        
        $overall_score = get_post_meta($post->ID, 'ct_mb_over_score', true);            

        if ( $overall_score == '' ) $score = 'zero';
            
        switch( $overall_score ) {
            case 0:
                $score = 'zero';
                break;
            case 0.5:
                $score = 'zero_half';
                break;
            case 1:
                $score = 'one';
                break;
            case 1.5:
                $score = 'one_half';
                break;
            case 2:
                $score = 'two';
                break;
            case 2.5:
                $score = 'two_half';
                break;
            case 3:
                $score = 'three';
                break;
            case 3.5:
                $score = 'three_half';
                break;
            case 4:
                $score = 'four';
                break;
            case 4.5:
                $score = 'four_half';
                break;
            case 5:
                $score = 'five';
                break;
        }       
        echo '<div class="ct-rating ' . $score . '" title="'.__('Review Score: ','color-theme-framework'). $overall_score . '" style="background-color:'. $stars_color . '"></div>';
    }
}


/*-----------------------------------------------------------------------------------*/
/* Get rating stars (big)
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_get_rating_stars_s' ) ) {
    function ct_get_rating_stars_s() {
        
        global $post, $ct_video_height;
       
        $stars_color = get_post_meta( $post->ID, 'ct_mb_stars_color', true);         
        if ( $stars_color == '' ) $stars_color = '#DD0C0C';
                                        
        $overall_score = get_post_meta($post->ID, 'ct_mb_over_score', true);            

        if ( $overall_score == '' ) $score = 'zero';
            
        switch( $overall_score ) {
            case 0:
                $score = 'zero';
                break;
            case 0.5:
                $score = 'zero_half';
                break;
            case 1:
                $score = 'one';
                break;
            case 1.5:
                $score = 'one_half';
                break;
            case 2:
                $score = 'two';
                break;
            case 2.5:
                $score = 'two_half';
                break;
            case 3:
                $score = 'three';
                break;
            case 3.5:
                $score = 'three_half';
                break;
            case 4:
                $score = 'four';
                break;
            case 4.5:
                $score = 'four_half';
                break;
            case 5:
                $score = 'five';
                break;
        }       
        echo '<div class="ct-rating-s ' . $score . '" title="'.__('Review Score: ','color-theme-framework'). $overall_score . '" style="background-color:'. $stars_color . '"></div>';
    }
}



/*-----------------------------------------------------------------------------------*/
/* Get Single Star Rating (for criteria)
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_get_single_rating' ) ) {
    function ct_get_single_rating( $score_value, $local_ID ) {

        $stars_color = get_post_meta( $local_ID , 'ct_mb_stars_color', true);          
        if ( $stars_color == '' ) $stars_color = '#DD0C0C';

        switch( $score_value ) {
            case 0:
                $score = 'zero';
                break;
            case 0.5:
                $score = 'zero_half';
                break;
            case 1:
                $score = 'one';
                break;
            case 1.5:
                $score = 'one_half';
                break;
            case 2:
                $score = 'two';
                break;
            case 2.5:
                $score = 'two_half';
                break;
            case 3:
                $score = 'three';
                break;
            case 3.5:
                $score = 'three_half';
                break;
            case 4:
                $score = 'four';
                break;
            case 4.5:
                $score = 'four_half';
                break;
            case 5:
                $score = 'five';
                break;
                
                }       
        return '<div class="ct-rating ' . $score . '" title="'.__('Criteria Score: ','color-theme-framework'). $score_value . '" style="background-color:'. $stars_color . '"></div>';          
    }
}

/*-----------------------------------------------------------------------------------*/
/* Displays Read more link
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'ct_get_readmore' ) ) {
    function ct_get_readmore() {
        echo "<a class=\"read-more\" href=\"" . get_permalink() . "\" title=\"" . __('Permalink to ','color-theme-framework') . the_title('','',false) . "\">" . __('more','color-theme-framework') ."</a>";
    }
}


/*-----------------------------------------------------------------------------------*/
/* Set up posts per page for Blog widget
/* Only for Home page and Blog page
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'ct_posts_per_page' ) ) {
    function ct_posts_per_page( $query ) {
        global $data;
        $blog_num_posts = stripslashes( $data['ct_blog_num_posts'] );

        if ( is_home() || is_page_template('template-blog.php') ) { 
            $query->query_vars['posts_per_page'] = $blog_num_posts;
        }
        return $query;  
    }  

    if ( !is_admin() ) add_filter( 'pre_get_posts', 'ct_posts_per_page' );  
}



/*-----------------------------------------------------------------------------------*/
/* Template for comments and pingbacks.
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'ct_comment' ) ) :
function ct_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
        // Display trackbacks differently than normal comments.
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <p><?php _e( 'Pingback:', 'color-theme-framework' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'color-theme-framework' ), '<span class="edit-link">', '</span>' ); ?></p>
    <?php
            break;
        default :
        // Proceed with normal comments.
        global $post;
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment">
            <header class="comment-meta comment-author vcard">
                <?php
                    echo '<div class="comment-avatar">' . get_avatar( $comment, 75 );
                    // If current post author is also comment author, make it known visually.
                    if ( $comment->user_id == $post->post_author ) {
                        echo '<br/><span class="muted-small"> ' . __( 'Post author', 'color-theme-framework' ) . '</span>';
                    } else echo '';
                    echo '</div>';

                    printf( '<cite class="fn">%1$s</cite>',
                        get_comment_author_link()
                    );
                    printf( '<a class="muted-small" href="%1$s"><time datetime="%2$s">%3$s</time></a>',
                        esc_url( get_comment_link( $comment->comment_ID ) ),
                        get_comment_time( 'c' ),
                        /* translators: 1: date, 2: time */
                        sprintf( __( '%1$s at %2$s', 'color-theme-framework' ), get_comment_date(), get_comment_time() )
                    );
                ?>
            </header><!-- .comment-meta -->

            <?php if ( '0' == $comment->comment_approved ) : ?>
                <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'color-theme-framework' ); ?></p>
            <?php endif; ?>

            <section class="comment-content comment">
                <?php comment_text(); ?>
                <?php edit_comment_link( __( 'Edit', 'color-theme-framework' ), '<p class="edit-link">', '</p>' ); ?>
            </section><!-- .comment-content -->

            <div class="reply clearfix">
                <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'color-theme-framework' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div><!-- .reply -->
        </article><!-- #comment-## -->
    <?php
        break;
    endswitch; // end comment_type check
}
endif;