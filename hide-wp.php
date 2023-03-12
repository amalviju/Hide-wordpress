/*
Plugin Name: Hide WP
Description: plugin that can hide the WordPress admin URL, theme name, and plugin name
Author: Amal Viju
*/

function custom_login_url() {
    return home_url( '/custom-login-url' );
}
add_filter( 'login_url', 'custom_login_url' );

function remove_theme_and_plugin_info() {
    global $wp_widget_factory;
    
    // Remove theme info
    remove_action( 'wp_head', '_wp_render_title_tag', 1 );
    remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
    remove_action( 'wp_head', 'wp_print_styles', 8 );
    remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'rsd_link' );

    // Remove plugin info
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
    remove_action( 'wp_head', 'wp_resource_hints', 2 );
    
    // Remove widget info
    if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
        remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
    }
}
add_action( 'init', 'remove_theme_and_plugin_info' );

function rename_plugin() {
    global $menu;
    $menu[99] = array( 'Hide WP', 'manage_options', 'custom-login-url', '', 'menu-top', '', 'none' );
}
add_action( 'admin_menu', 'rename_plugin' );
