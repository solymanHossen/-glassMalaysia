<?php
/**
 * Plugin Name: Puchong Glass Core
 * Description: Core functionality for Puchong Glass website (CPTs, Meta Boxes).
 * Version: 1.0
 * Author: GitHub Copilot
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register Custom Post Types
function pg_register_cpts() {
    // Services
    register_post_type( 'service', array(
        'labels' => array(
            'name' => 'Services',
            'singular_name' => 'Service',
            'add_new' => 'Add New Service',
            'add_new_item' => 'Add New Service',
            'edit_item' => 'Edit Service',
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-shield',
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'rewrite' => array( 'slug' => 'services' ),
        'show_in_rest' => true,
    ));

    // Portfolio
    register_post_type( 'portfolio', array(
        'labels' => array(
            'name' => 'Portfolio',
            'singular_name' => 'Project',
            'add_new' => 'Add New Project',
            'add_new_item' => 'Add New Project',
            'edit_item' => 'Edit Project',
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'rewrite' => array( 'slug' => 'portfolio' ),
        'show_in_rest' => true,
    ));

    // Testimonials
    register_post_type( 'testimonial', array(
        'labels' => array(
            'name' => 'Testimonials',
            'singular_name' => 'Testimonial',
            'add_new' => 'Add New Testimonial',
            'add_new_item' => 'Add New Testimonial',
            'edit_item' => 'Edit Testimonial',
        ),
        'public' => false, // Not public on frontend as single pages
        'show_ui' => true,
        'menu_icon' => 'dashicons-format-quote',
        'supports' => array( 'title', 'editor', 'thumbnail' ), // Title = Name, Editor = Quote
        'show_in_rest' => true,
    ));
}
add_action( 'init', 'pg_register_cpts' );

// Register Taxonomies
function pg_register_taxonomies() {
    register_taxonomy( 'portfolio_category', 'portfolio', array(
        'labels' => array(
            'name' => 'Portfolio Categories',
            'singular_name' => 'Category',
        ),
        'hierarchical' => true,
        'show_in_rest' => true,
    ));
}
add_action( 'init', 'pg_register_taxonomies' );

// Meta Boxes
function pg_add_meta_boxes() {
    // Service Meta
    add_meta_box( 'pg_service_meta', 'Service Details', 'pg_render_service_meta', 'service', 'normal', 'high' );
    // Portfolio Meta
    add_meta_box( 'pg_portfolio_meta', 'Project Details', 'pg_render_portfolio_meta', 'portfolio', 'normal', 'high' );
    // Testimonial Meta
    add_meta_box( 'pg_testimonial_meta', 'Testimonial Details', 'pg_render_testimonial_meta', 'testimonial', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'pg_add_meta_boxes' );

function pg_render_service_meta( $post ) {
    $specs = get_post_meta( $post->ID, '_pg_specs', true ); // Array of strings
    $benefits = get_post_meta( $post->ID, '_pg_benefits', true ); // Array of strings
    $icon = get_post_meta( $post->ID, '_pg_icon', true );
    
    // Convert arrays to newline separated strings for textarea
    $specs_str = is_array($specs) ? implode("\n", $specs) : $specs;
    $benefits_str = is_array($benefits) ? implode("\n", $benefits) : $benefits;

    wp_nonce_field( 'pg_save_meta', 'pg_meta_nonce' );
    ?>
    <p>
        <label><strong>Icon Name (Lucide):</strong></label><br>
        <input type="text" name="pg_icon" value="<?php echo esc_attr( $icon ); ?>" class="widefat" placeholder="e.g. Shield, Grid, ArrowRight">
    </p>
    <p>
        <label><strong>Specs (One per line, format "Key: Value"):</strong></label><br>
        <textarea name="pg_specs" class="widefat" rows="5"><?php echo esc_textarea( $specs_str ); ?></textarea>
    </p>
    <p>
        <label><strong>Benefits (One per line):</strong></label><br>
        <textarea name="pg_benefits" class="widefat" rows="5"><?php echo esc_textarea( $benefits_str ); ?></textarea>
    </p>
    <?php
}

function pg_render_portfolio_meta( $post ) {
    $location = get_post_meta( $post->ID, '_pg_location', true );
    $year = get_post_meta( $post->ID, '_pg_year', true );
    $challenge = get_post_meta( $post->ID, '_pg_challenge', true );
    $solution = get_post_meta( $post->ID, '_pg_solution', true );

    wp_nonce_field( 'pg_save_meta', 'pg_meta_nonce' );
    ?>
    <p>
        <label><strong>Location:</strong></label><br>
        <input type="text" name="pg_location" value="<?php echo esc_attr( $location ); ?>" class="widefat">
    </p>
    <p>
        <label><strong>Year:</strong></label><br>
        <input type="text" name="pg_year" value="<?php echo esc_attr( $year ); ?>" class="widefat">
    </p>
    <p>
        <label><strong>The Challenge:</strong></label><br>
        <textarea name="pg_challenge" class="widefat" rows="3"><?php echo esc_textarea( $challenge ); ?></textarea>
    </p>
    <p>
        <label><strong>The Solution:</strong></label><br>
        <textarea name="pg_solution" class="widefat" rows="3"><?php echo esc_textarea( $solution ); ?></textarea>
    </p>
    <?php
}

function pg_render_testimonial_meta( $post ) {
    $role = get_post_meta( $post->ID, '_pg_role', true );
    $rating = get_post_meta( $post->ID, '_pg_rating', true ) ?: 5;

    wp_nonce_field( 'pg_save_meta', 'pg_meta_nonce' );
    ?>
    <p>
        <label><strong>Role / Location:</strong></label><br>
        <input type="text" name="pg_role" value="<?php echo esc_attr( $role ); ?>" class="widefat" placeholder="e.g. Homeowner, Puchong">
    </p>
    <p>
        <label><strong>Rating (1-5):</strong></label><br>
        <input type="number" name="pg_rating" value="<?php echo esc_attr( $rating ); ?>" class="widefat" min="1" max="5">
    </p>
    <?php
}

function pg_save_meta( $post_id ) {
    if ( ! isset( $_POST['pg_meta_nonce'] ) || ! wp_verify_nonce( $_POST['pg_meta_nonce'], 'pg_save_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Save Service Meta
    if ( isset( $_POST['pg_icon'] ) ) update_post_meta( $post_id, '_pg_icon', sanitize_text_field( $_POST['pg_icon'] ) );
    if ( isset( $_POST['pg_specs'] ) ) {
        $specs = array_filter( array_map( 'trim', explode( "\n", $_POST['pg_specs'] ) ) );
        update_post_meta( $post_id, '_pg_specs', $specs );
    }
    if ( isset( $_POST['pg_benefits'] ) ) {
        $benefits = array_filter( array_map( 'trim', explode( "\n", $_POST['pg_benefits'] ) ) );
        update_post_meta( $post_id, '_pg_benefits', $benefits );
    }

    // Save Portfolio Meta
    if ( isset( $_POST['pg_location'] ) ) update_post_meta( $post_id, '_pg_location', sanitize_text_field( $_POST['pg_location'] ) );
    if ( isset( $_POST['pg_year'] ) ) update_post_meta( $post_id, '_pg_year', sanitize_text_field( $_POST['pg_year'] ) );
    if ( isset( $_POST['pg_challenge'] ) ) update_post_meta( $post_id, '_pg_challenge', sanitize_textarea_field( $_POST['pg_challenge'] ) );
    if ( isset( $_POST['pg_solution'] ) ) update_post_meta( $post_id, '_pg_solution', sanitize_textarea_field( $_POST['pg_solution'] ) );

    // Save Testimonial Meta
    if ( isset( $_POST['pg_role'] ) ) update_post_meta( $post_id, '_pg_role', sanitize_text_field( $_POST['pg_role'] ) );
    if ( isset( $_POST['pg_rating'] ) ) update_post_meta( $post_id, '_pg_rating', intval( $_POST['pg_rating'] ) );
}
add_action( 'save_post', 'pg_save_meta' );
