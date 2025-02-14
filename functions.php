<?php
// Theme setup
function my_wordpress_theme_setup() {
    // Add support for featured images
    add_theme_support('post-thumbnails');

    // Register navigation menus
    register_nav_menus([
        'primary' => __('Primary Menu', 'my-wordpress-theme'),
    ]);
}
add_action('after_setup_theme', 'my_wordpress_theme_setup');

// Enqueue styles and scripts
function my_wordpress_theme_enqueue_assets() {
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/script.js', ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', 'my_wordpress_theme_enqueue_assets');

// Include custom functions
require get_template_directory() . '/inc/custom-functions.php';

// Include search results logic
require get_template_directory() . '/inc/search-results.php';
?>