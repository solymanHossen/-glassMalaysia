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

function pg_admin_scripts() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'pg_admin_scripts' );

function pg_admin_footer_scripts() {
    global $post_type;
    if ( 'service' === $post_type || 'portfolio' === $post_type ) {
        ?>
        <script>
        jQuery(document).ready(function($){
            // Image Upload Button
            $(document).on('click', '.pg-upload-image-btn', function(e) {
                e.preventDefault();
                var button = $(this);
                var inputField = button.siblings('input[name="pg_custom_image"]');
                var imagePreview = button.siblings('.pg-image-preview');
                var removeButton = button.siblings('.pg-remove-image-btn');
                
                var mediaUploader = wp.media({
                    title: 'Select or Upload Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });
                
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    inputField.val(attachment.url);
                    imagePreview.attr('src', attachment.url).show();
                    removeButton.show();
                });
                
                mediaUploader.open();
            });
            
            // Remove Image Button
            $(document).on('click', '.pg-remove-image-btn', function(e) {
                e.preventDefault();
                var button = $(this);
                button.siblings('input[name="pg_custom_image"]').val('');
                button.siblings('.pg-image-preview').hide();
                button.hide();
            });
        });
        </script>
        <style>
        .pg-image-preview {
            max-width: 300px;
            height: auto;
            margin-top: 10px;
            border: 1px solid #ddd;
            padding: 5px;
            background: #f9f9f9;
        }
        .pg-image-field-wrapper {
            margin-bottom: 15px;
        }
        .pg-remove-image-btn {
            margin-left: 10px;
            color: #a00;
        }
        </style>
        <?php
    }
}
add_action( 'admin_footer', 'pg_admin_footer_scripts' );

function pg_theme_support() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'menus' );
    
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'puchong-glass' ),
    ) );
}
add_action( 'after_setup_theme', 'pg_theme_support' );

/**
 * Register Custom Post Types and Taxonomies
 */
function pg_register_post_types() {
    // Service CPT
    register_post_type( 'service', array(
        'labels' => array(
            'name' => __( 'Services', 'puchong-glass' ),
            'singular_name' => __( 'Service', 'puchong-glass' ),
            'add_new_item' => __( 'Add New Service', 'puchong-glass' ),
            'edit_item' => __( 'Edit Service', 'puchong-glass' ),
            'new_item' => __( 'New Service', 'puchong-glass' ),
            'view_item' => __( 'View Service', 'puchong-glass' ),
            'search_items' => __( 'Search Services', 'puchong-glass' ),
            'not_found' => __( 'No services found', 'puchong-glass' ),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-shield',
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'rewrite' => array( 'slug' => 'services' ),
        'show_in_rest' => true,
    ) );

    // Portfolio CPT
    register_post_type( 'portfolio', array(
        'labels' => array(
            'name' => __( 'Portfolio', 'puchong-glass' ),
            'singular_name' => __( 'Project', 'puchong-glass' ),
            'add_new_item' => __( 'Add New Project', 'puchong-glass' ),
            'edit_item' => __( 'Edit Project', 'puchong-glass' ),
            'new_item' => __( 'New Project', 'puchong-glass' ),
            'view_item' => __( 'View Project', 'puchong-glass' ),
            'search_items' => __( 'Search Projects', 'puchong-glass' ),
            'not_found' => __( 'No projects found', 'puchong-glass' ),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'rewrite' => array( 'slug' => 'portfolio' ),
        'show_in_rest' => true,
    ) );

    // Portfolio Category Taxonomy
    register_taxonomy( 'portfolio_category', 'portfolio', array(
        'labels' => array(
            'name' => __( 'Project Categories', 'puchong-glass' ),
            'singular_name' => __( 'Category', 'puchong-glass' ),
        ),
        'hierarchical' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'rewrite' => array( 'slug' => 'portfolio-category' ),
    ) );
}
add_action( 'init', 'pg_register_post_types' );

/**
 * Register Meta Boxes for Custom Fields
 */
function pg_add_meta_boxes() {
    add_meta_box( 'pg_service_meta', 'Service Details', 'pg_service_meta_callback', 'service', 'normal', 'high' );
    add_meta_box( 'pg_portfolio_meta', 'Project Details', 'pg_portfolio_meta_callback', 'portfolio', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'pg_add_meta_boxes' );

function pg_service_meta_callback( $post ) {
    wp_nonce_field( 'pg_save_meta', 'pg_meta_nonce' );
    $icon = get_post_meta( $post->ID, '_pg_icon', true );
    $benefits = get_post_meta( $post->ID, '_pg_benefits', true );
    $specs = get_post_meta( $post->ID, '_pg_specs', true );
    $custom_image = get_post_meta( $post->ID, '_pg_custom_image', true );
    ?>
    <div class="pg-image-field-wrapper">
        <label><strong>Service Image (Optional - overrides Featured Image):</strong></label><br>
        <small>Leave empty to use the Featured Image instead.</small><br><br>
        <input type="text" name="pg_custom_image" value="<?php echo esc_attr( $custom_image ); ?>" class="widefat" placeholder="Image URL" readonly style="margin-bottom: 10px;">
        <button type="button" class="button button-secondary pg-upload-image-btn">Upload/Select Image</button>
        <button type="button" class="button button-link-delete pg-remove-image-btn" style="<?php echo $custom_image ? '' : 'display:none;'; ?>">Remove Image</button>
        <br>
        <img src="<?php echo esc_url( $custom_image ); ?>" class="pg-image-preview" style="<?php echo $custom_image ? '' : 'display:none;'; ?>">
    </div>
    <p>
        <label for="pg_icon"><strong>Icon Name (Lucide):</strong></label><br>
        <input type="text" id="pg_icon" name="pg_icon" value="<?php echo esc_attr( $icon ); ?>" class="widefat" placeholder="e.g. Shield, Zap, Home">
    </p>
    <p>
        <label><strong>Key Benefits (One per line):</strong></label><br>
        <textarea name="pg_benefits" class="widefat" rows="4"><?php echo esc_textarea( is_array($benefits) ? implode("\n", $benefits) : $benefits ); ?></textarea>
    </p>
    <p>
        <label><strong>Technical Specs (Format: Label:Value, one per line):</strong></label><br>
        <textarea name="pg_specs" class="widefat" rows="4"><?php echo esc_textarea( is_array($specs) ? implode("\n", $specs) : $specs ); ?></textarea>
    </p>
    <?php
}

function pg_portfolio_meta_callback( $post ) {
    wp_nonce_field( 'pg_save_meta', 'pg_meta_nonce' );
    $location = get_post_meta( $post->ID, '_pg_location', true );
    $year = get_post_meta( $post->ID, '_pg_year', true );
    $challenge = get_post_meta( $post->ID, '_pg_challenge', true );
    $solution = get_post_meta( $post->ID, '_pg_solution', true );
    $custom_image = get_post_meta( $post->ID, '_pg_custom_image', true );
    ?>
    <div class="pg-image-field-wrapper">
        <label><strong>Project Image (Optional - overrides Featured Image):</strong></label><br>
        <small>Leave empty to use the Featured Image instead.</small><br><br>
        <input type="text" name="pg_custom_image" value="<?php echo esc_attr( $custom_image ); ?>" class="widefat" placeholder="Image URL" readonly style="margin-bottom: 10px;">
        <button type="button" class="button button-secondary pg-upload-image-btn">Upload/Select Image</button>
        <button type="button" class="button button-link-delete pg-remove-image-btn" style="<?php echo $custom_image ? '' : 'display:none;'; ?>">Remove Image</button>
        <br>
        <img src="<?php echo esc_url( $custom_image ); ?>" class="pg-image-preview" style="<?php echo $custom_image ? '' : 'display:none;'; ?>">
    </div>
    <p>
        <label for="pg_location"><strong>Location:</strong></label><br>
        <input type="text" id="pg_location" name="pg_location" value="<?php echo esc_attr( $location ); ?>" class="widefat">
    </p>
    <p>
        <label for="pg_year"><strong>Year:</strong></label><br>
        <input type="text" id="pg_year" name="pg_year" value="<?php echo esc_attr( $year ); ?>" class="widefat">
    </p>
    <p>
        <label for="pg_challenge"><strong>The Challenge:</strong></label><br>
        <textarea id="pg_challenge" name="pg_challenge" class="widefat" rows="3"><?php echo esc_textarea( $challenge ); ?></textarea>
    </p>
    <p>
        <label for="pg_solution"><strong>The Solution:</strong></label><br>
        <textarea id="pg_solution" name="pg_solution" class="widefat" rows="3"><?php echo esc_textarea( $solution ); ?></textarea>
    </p>
    <?php
}

function pg_save_meta( $post_id ) {
    if ( ! isset( $_POST['pg_meta_nonce'] ) || ! wp_verify_nonce( $_POST['pg_meta_nonce'], 'pg_save_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    // Save Custom Image
    if ( isset( $_POST['pg_custom_image'] ) ) update_post_meta( $post_id, '_pg_custom_image', sanitize_text_field( $_POST['pg_custom_image'] ) );

    // Service Meta
    if ( isset( $_POST['pg_icon'] ) ) update_post_meta( $post_id, '_pg_icon', sanitize_text_field( $_POST['pg_icon'] ) );
    
    if ( isset( $_POST['pg_benefits'] ) ) {
        $benefits = array_filter( array_map( 'trim', explode( "\n", $_POST['pg_benefits'] ) ) );
        update_post_meta( $post_id, '_pg_benefits', $benefits );
    }

    if ( isset( $_POST['pg_specs'] ) ) {
        $specs = array_filter( array_map( 'trim', explode( "\n", $_POST['pg_specs'] ) ) );
        update_post_meta( $post_id, '_pg_specs', $specs );
    }

    // Portfolio Meta
    if ( isset( $_POST['pg_location'] ) ) update_post_meta( $post_id, '_pg_location', sanitize_text_field( $_POST['pg_location'] ) );
    if ( isset( $_POST['pg_year'] ) ) update_post_meta( $post_id, '_pg_year', sanitize_text_field( $_POST['pg_year'] ) );
    if ( isset( $_POST['pg_challenge'] ) ) update_post_meta( $post_id, '_pg_challenge', sanitize_textarea_field( $_POST['pg_challenge'] ) );
    if ( isset( $_POST['pg_solution'] ) ) update_post_meta( $post_id, '_pg_solution', sanitize_textarea_field( $_POST['pg_solution'] ) );
}
add_action( 'save_post', 'pg_save_meta' );

// Helper to get icon SVG (since we are using Lucide JS, we will use data attributes or classes)
function pg_get_icon( $name ) {
    // In the frontend, we will use <i data-lucide="name"></i> and let lucide.createIcons() handle it.
    return '<i data-lucide="' . esc_attr( strtolower( $name ) ) . '"></i>';
}

// Include Seeder
require_once get_template_directory() . '/includes/seeder.php';

