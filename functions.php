<?php
/**
 * Veloce Prestige Mobility Functions and Definitions
 *
 * @package Veloce_Prestige_Mobility
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Theme Setup and Supports
 */
function dev_nahian_car_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

    // Switch default core markup to output valid HTML5.
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Add support for responsive embeds.
    add_theme_support( 'responsive-embeds' );

    // Register Navigation Menus.
    register_nav_menus(
        array(
            'primary'  => esc_html__( 'Primary Menu', 'dev-nahian-car' ),
            'footer-1' => esc_html__( 'Footer 1 Menu', 'dev-nahian-car' ),
            'footer-2' => esc_html__( 'Footer 2 Menu', 'dev-nahian-car' ),
            'footer-3' => esc_html__( 'Footer 3 Menu', 'dev-nahian-car' ),
        )
    );
}
add_action( 'after_setup_theme', 'dev_nahian_car_setup' );

/**
 * Enqueue Styles and Scripts
 */
function dev_nahian_car_scripts() {
    // 1. Enqueue Root style.css (Required by WordPress for theme headers & metadata recognition)
    wp_enqueue_style( 'dev-nahian-car-root-style', get_stylesheet_uri(), array(), '1.0.0' );

    // 2. Enqueue Main Stylesheet from assets/css/style.css
    wp_enqueue_style( 
        'dev-nahian-car-main-style', 
        get_template_directory_uri() . '/assets/css/style.css', 
        array( 'dev-nahian-car-root-style' ), 
        '1.0.0' 
    );

    // 3. Enqueue WordPress Core jQuery
    wp_enqueue_script( 'jquery' );

    // 4. Locate core JavaScript bundle asset safely
    $js_path = file_exists( get_template_directory() . '/assets/js/main.js' ) ? '/assets/js/main.js' : '/main.js';
    
    // Enqueue Custom Core JavaScript bundle
    wp_enqueue_script(
        'dev-nahian-car-core-script',
        get_template_directory_uri() . $js_path,
        array( 'jquery' ),
        '1.0.0',
        true
    );

    // 5. Localize script for AJAX endpoints and nonces
    wp_localize_script(
        'dev-nahian-car-core-script',
        'devNahianCarAjax',
        array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'dev_nahian_car_nonce' ),
        )
    );
}
add_action( 'wp_enqueue_scripts', 'dev_nahian_car_scripts' );

/**
 * Register Widget Areas / Sidebars
 */
function dev_nahian_car_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__( 'Blog Sidebar', 'dev-nahian-car' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here to appear in your blog and single article sidebars.', 'dev-nahian-car' ),
            'before_widget' => '<div id="%1$s" class="dev-nahian-car-sidebar-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="dev-nahian-car-widget-title">',
            'after_title'   => '</h4>',
        )
    );
}
add_action( 'widgets_init', 'dev_nahian_car_widgets_init' );

/**
 * Include Separate Admin Menu Files from inc/
 */
$dev_nahian_admin_files = array(
    '/inc/website-settings.php',
);

foreach ( $dev_nahian_admin_files as $file ) {
    $filepath = get_template_directory() . $file;
    if ( file_exists( $filepath ) ) {
        require_once $filepath;
    }
}

class Dev_Nahian_Car_Nav_Walker extends Walker_Nav_Menu {
    
    // Start Level (Dropdown / Submenu wrappers)
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $class_name = ($depth === 0) ? 'dev-nahian-car-dropdown-menu' : 'dev-nahian-car-mobile-submenu';
        $output .= "\n$indent<ul class=\"$class_name\">\n";
    }

    // Start Element (Menu Items)
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        
        if ($depth === 0) {
            $classes[] = 'dev-nahian-car-nav-item';
        } else {
            $classes[] = 'dev-nahian-car-dropdown-item';
        }

        $args = (object) $args;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $output .= $indent . '<li' . $class_names . '>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        if ( in_array('menu-item-has-children', $item->classes) && $depth === 0 ) {
            $atts['class'] = 'dev-nahian-car-nav-link';
        } else if ($depth === 0) {
            $atts['class'] = 'dev-nahian-car-nav-link';
        } else {
            $atts['class'] = ''; // Handled by dropdown item styles
        }

        // Highlight active page check
        if ( in_array('current-menu-item', $item->classes) ) {
            $atts['class'] .= ' dev-nahian-car-active';
        }

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        
        // Add icons based on menu text or slug for desktop view if desired
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

        // Append dropdown chevron icon if item has children at root level
        if ( in_array('menu-item-has-children', $item->classes) && $depth === 0 ) {
            $item_output .= ' <svg class="dev-nahian-car-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>';
        }

        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}