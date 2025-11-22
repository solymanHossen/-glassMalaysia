<?php

function pg_enqueue_scripts() {
    // Tailwind CSS (CDN for development/demo purposes)
    wp_enqueue_script( 'tailwind', 'https://cdn.tailwindcss.com', array(), null, false );
    
    // Lucide Icons
    wp_enqueue_script( 'lucide', 'https://unpkg.com/lucide@latest', array(), null, false );

    // Theme Styles
    wp_enqueue_style( 'pg-style', get_stylesheet_uri() );

    // Main JS
    wp_enqueue_script( 'pg-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true );

    // Pass AJAX URL to script
    wp_localize_script( 'pg-main', 'pg_data', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'whatsapp_number' => '60123456789'
    ));
}
add_action( 'wp_enqueue_scripts', 'pg_enqueue_scripts' );

function pg_theme_support() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'menus' );
    
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'puchong-glass' ),
    ) );
}
add_action( 'after_setup_theme', 'pg_theme_support' );

// Helper to get icon SVG (since we are using Lucide JS, we will use data attributes or classes)
function pg_get_icon( $name ) {
    // In the frontend, we will use <i data-lucide="name"></i> and let lucide.createIcons() handle it.
    return '<i data-lucide="' . esc_attr( strtolower( $name ) ) . '"></i>';
}
