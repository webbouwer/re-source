<?php
/**
 * theme main functions file
 */
 
// require get_template_directory() . '/customizer.php'; // customizer functions
// require get_template_directory() . '/data.php'; // data functions

// register options
function theme_post_thumbnails() {
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'theme_post_thumbnails' );

// insert style sheet function to head
function wp_main_theme_stylesheet(){
    $stylesheet = dirname( __file__ ).'/style.css';
    echo '<link rel="stylesheet" id="wp-theme-main-style"  href="'.$stylesheet.'" type="text/css" media="all" />';
}
add_action( 'wp_head', 'wp_main_theme_stylesheet', 9999 );
?>
