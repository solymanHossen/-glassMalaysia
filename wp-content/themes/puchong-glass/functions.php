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
    
    // Enqueue custom admin CSS
    wp_enqueue_style( 'pg-admin-style', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0' );
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

/**
 * ============================================
 * CUSTOM DASHBOARD & CONTACT FORM SYSTEM
 * ============================================
 */

/**
 * Create Contact Form Database Table on Theme Activation
 */
function pg_create_contact_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'pg_contacts';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        phone varchar(50) NOT NULL,
        email varchar(255) NOT NULL,
        message text NOT NULL,
        submitted_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        status varchar(20) DEFAULT 'unread' NOT NULL,
        notes text,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
add_action( 'after_switch_theme', 'pg_create_contact_table' );

/**
 * AJAX Handler for Contact Form Submission
 */
function pg_handle_contact_form() {
    global $wpdb;
    
    // Check nonce
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'pg_contact_form' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed' ) );
    }
    
    // Sanitize inputs
    $name = sanitize_text_field( $_POST['name'] );
    $phone = sanitize_text_field( $_POST['phone'] );
    $email = sanitize_email( $_POST['email'] );
    $message = sanitize_textarea_field( $_POST['message'] );
    
    // Validate
    if ( empty( $name ) || empty( $phone ) || empty( $email ) || empty( $message ) ) {
        wp_send_json_error( array( 'message' => 'All fields are required' ) );
    }
    
    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Invalid email address' ) );
    }
    
    // Insert into database
    $table_name = $wpdb->prefix . 'pg_contacts';
    $result = $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'message' => $message,
        ),
        array( '%s', '%s', '%s', '%s' )
    );
    
    if ( $result ) {
        // Send email notification to admin
        $admin_email = get_option( 'admin_email' );
        $subject = 'New Contact Form Submission - ' . get_bloginfo( 'name' );
        $body = "New contact form submission:\n\n";
        $body .= "Name: $name\n";
        $body .= "Phone: $phone\n";
        $body .= "Email: $email\n";
        $body .= "Message: $message\n\n";
        $body .= "View in dashboard: " . admin_url( 'index.php' );
        
        wp_mail( $admin_email, $subject, $body );
        
        wp_send_json_success( array( 'message' => 'Thank you! Your message has been sent successfully.' ) );
    } else {
        wp_send_json_error( array( 'message' => 'Failed to submit form. Please try again.' ) );
    }
}
add_action( 'wp_ajax_pg_contact_form', 'pg_handle_contact_form' );
add_action( 'wp_ajax_nopriv_pg_contact_form', 'pg_handle_contact_form' );

/**
 * Update Contact Status via AJAX
 */
function pg_update_contact_status() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( array( 'message' => 'Unauthorized' ) );
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'pg_contacts';
    $contact_id = intval( $_POST['contact_id'] );
    $status = sanitize_text_field( $_POST['status'] );
    
    $result = $wpdb->update(
        $table_name,
        array( 'status' => $status ),
        array( 'id' => $contact_id ),
        array( '%s' ),
        array( '%d' )
    );
    
    if ( $result !== false ) {
        wp_send_json_success( array( 'message' => 'Status updated' ) );
    } else {
        wp_send_json_error( array( 'message' => 'Failed to update' ) );
    }
}
add_action( 'wp_ajax_pg_update_contact_status', 'pg_update_contact_status' );

/**
 * Delete Contact via AJAX
 */
function pg_delete_contact() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( array( 'message' => 'Unauthorized' ) );
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'pg_contacts';
    $contact_id = intval( $_POST['contact_id'] );
    
    $result = $wpdb->delete(
        $table_name,
        array( 'id' => $contact_id ),
        array( '%d' )
    );
    
    if ( $result ) {
        wp_send_json_success( array( 'message' => 'Contact deleted' ) );
    } else {
        wp_send_json_error( array( 'message' => 'Failed to delete' ) );
    }
}
add_action( 'wp_ajax_pg_delete_contact', 'pg_delete_contact' );

/**
 * Register Custom Dashboard Widgets
 */
function pg_add_dashboard_widgets() {
    wp_add_dashboard_widget(
        'pg_contacts_widget',
        '📬 Contact Form Submissions',
        'pg_contacts_widget_display'
    );
    
    wp_add_dashboard_widget(
        'pg_stats_widget',
        '📊 Website Statistics',
        'pg_stats_widget_display'
    );
    
    wp_add_dashboard_widget(
        'pg_recent_services_widget',
        '🛡️ Recent Services',
        'pg_recent_services_widget_display'
    );
    
    wp_add_dashboard_widget(
        'pg_recent_portfolio_widget',
        '🖼️ Recent Portfolio Projects',
        'pg_recent_portfolio_widget_display'
    );
    
    wp_add_dashboard_widget(
        'pg_quick_actions_widget',
        '⚡ Quick Actions',
        'pg_quick_actions_widget_display'
    );
}
add_action( 'wp_dashboard_setup', 'pg_add_dashboard_widgets' );

/**
 * Remove Default WordPress Dashboard Widgets (Optional - uncomment to use)
 */
function pg_remove_default_dashboard_widgets() {
    // Uncomment lines below to remove default WordPress widgets
    // remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    // remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    // remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    // remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
    // remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    // remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    // remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    // remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    // remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', 'pg_remove_default_dashboard_widgets', 0 );

/**
 * Customize Admin Dashboard - Add Welcome Message
 */
function pg_custom_dashboard_welcome() {
    $current_user = wp_get_current_user();
    ?>
    <style>
        .pg-welcome-panel {
            background: linear-gradient(135deg, #0A2342 0%, #1E5A8E 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .pg-welcome-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .pg-welcome-subtitle {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 20px;
        }
        .pg-welcome-actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .pg-welcome-btn {
            padding: 12px 24px;
            background: rgba(255,255,255,0.2);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s;
            backdrop-filter: blur(10px);
        }
        .pg-welcome-btn:hover {
            background: rgba(255,255,255,0.3);
            color: white;
            transform: translateY(-2px);
        }
    </style>
    <div class="pg-welcome-panel">
        <div class="pg-welcome-title">👋 Welcome back, <?php echo esc_html( $current_user->display_name ); ?>!</div>
        <div class="pg-welcome-subtitle">Manage your Puchong Glass website from this dashboard</div>
        <div class="pg-welcome-actions">
            <a href="<?php echo admin_url( 'post-new.php?post_type=service' ); ?>" class="pg-welcome-btn">➕ Add Service</a>
            <a href="<?php echo admin_url( 'post-new.php?post_type=portfolio' ); ?>" class="pg-welcome-btn">➕ Add Project</a>
            <a href="<?php echo admin_url( 'admin.php?page=pg-all-contacts' ); ?>" class="pg-welcome-btn">📬 View Contacts</a>
            <a href="<?php echo home_url(); ?>" target="_blank" class="pg-welcome-btn">🌐 View Website</a>
        </div>
    </div>
    <?php
}
add_action( 'admin_notices', 'pg_custom_dashboard_welcome' );

/**
 * Only show welcome panel on dashboard page
 */
function pg_show_welcome_only_on_dashboard() {
    $screen = get_current_screen();
    if ( $screen->id !== 'dashboard' ) {
        remove_action( 'admin_notices', 'pg_custom_dashboard_welcome' );
    }
}
add_action( 'current_screen', 'pg_show_welcome_only_on_dashboard' );

/**
 * Contact Form Submissions Widget
 */
function pg_contacts_widget_display() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'pg_contacts';
    
    // Get statistics
    $total_contacts = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
    $unread_contacts = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'unread'" );
    $today_contacts = $wpdb->get_var( $wpdb->prepare( 
        "SELECT COUNT(*) FROM $table_name WHERE DATE(submitted_at) = %s", 
        date( 'Y-m-d' ) 
    ));
    
    // Get recent contacts
    $contacts = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY submitted_at DESC LIMIT 10" );
    
    ?>
    <style>
        .pg-dashboard-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .pg-stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px;
            border-radius: 8px;
            color: white;
            text-align: center;
        }
        .pg-stat-card.unread {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .pg-stat-card.today {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .pg-stat-number {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .pg-stat-label {
            font-size: 12px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .pg-contact-item {
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 10px;
            background: #f9f9f9;
            transition: all 0.3s;
        }
        .pg-contact-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        .pg-contact-item.unread {
            background: #fff3cd;
            border-color: #ffc107;
        }
        .pg-contact-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .pg-contact-name {
            font-weight: bold;
            color: #0A2342;
            font-size: 16px;
        }
        .pg-contact-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .pg-contact-badge.unread {
            background: #ffc107;
            color: #000;
        }
        .pg-contact-badge.read {
            background: #28a745;
            color: #fff;
        }
        .pg-contact-badge.archived {
            background: #6c757d;
            color: #fff;
        }
        .pg-contact-info {
            font-size: 13px;
            color: #666;
            margin-bottom: 8px;
        }
        .pg-contact-message {
            font-size: 14px;
            color: #333;
            margin-bottom: 10px;
            padding: 10px;
            background: white;
            border-left: 3px solid #0A2342;
            border-radius: 4px;
        }
        .pg-contact-actions {
            display: flex;
            gap: 8px;
        }
        .pg-btn {
            padding: 6px 12px;
            font-size: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .pg-btn-success {
            background: #28a745;
            color: white;
        }
        .pg-btn-success:hover {
            background: #218838;
        }
        .pg-btn-danger {
            background: #dc3545;
            color: white;
        }
        .pg-btn-danger:hover {
            background: #c82333;
        }
        .pg-btn-secondary {
            background: #6c757d;
            color: white;
        }
        .pg-btn-secondary:hover {
            background: #5a6268;
        }
        .pg-no-contacts {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        .pg-view-all {
            text-align: center;
            margin-top: 15px;
        }
    </style>
    
    <div class="pg-dashboard-stats">
        <div class="pg-stat-card">
            <div class="pg-stat-number"><?php echo $total_contacts; ?></div>
            <div class="pg-stat-label">Total Contacts</div>
        </div>
        <div class="pg-stat-card unread">
            <div class="pg-stat-number"><?php echo $unread_contacts; ?></div>
            <div class="pg-stat-label">Unread</div>
        </div>
        <div class="pg-stat-card today">
            <div class="pg-stat-number"><?php echo $today_contacts; ?></div>
            <div class="pg-stat-label">Today</div>
        </div>
    </div>
    
    <?php if ( empty( $contacts ) ): ?>
        <div class="pg-no-contacts">
            <p><strong>No contact submissions yet</strong></p>
            <p>Contact form submissions will appear here.</p>
        </div>
    <?php else: ?>
        <div class="pg-contacts-list">
            <?php foreach ( $contacts as $contact ): ?>
                <div class="pg-contact-item <?php echo esc_attr( $contact->status ); ?>" data-contact-id="<?php echo $contact->id; ?>">
                    <div class="pg-contact-header">
                        <span class="pg-contact-name"><?php echo esc_html( $contact->name ); ?></span>
                        <span class="pg-contact-badge <?php echo esc_attr( $contact->status ); ?>">
                            <?php echo esc_html( $contact->status ); ?>
                        </span>
                    </div>
                    <div class="pg-contact-info">
                        📞 <?php echo esc_html( $contact->phone ); ?> | 
                        📧 <a href="mailto:<?php echo esc_attr( $contact->email ); ?>"><?php echo esc_html( $contact->email ); ?></a> | 
                        🕒 <?php echo date( 'M j, Y g:i A', strtotime( $contact->submitted_at ) ); ?>
                    </div>
                    <div class="pg-contact-message">
                        <?php echo esc_html( $contact->message ); ?>
                    </div>
                    <div class="pg-contact-actions">
                        <?php if ( $contact->status !== 'read' ): ?>
                            <button class="pg-btn pg-btn-success pg-mark-read" data-id="<?php echo $contact->id; ?>">
                                ✓ Mark as Read
                            </button>
                        <?php endif; ?>
                        <?php if ( $contact->status !== 'archived' ): ?>
                            <button class="pg-btn pg-btn-secondary pg-mark-archived" data-id="<?php echo $contact->id; ?>">
                                📦 Archive
                            </button>
                        <?php endif; ?>
                        <button class="pg-btn pg-btn-danger pg-delete-contact" data-id="<?php echo $contact->id; ?>">
                            🗑️ Delete
                        </button>
                        <a href="mailto:<?php echo esc_attr( $contact->email ); ?>" class="pg-btn pg-btn-success">
                            ✉️ Reply via Email
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="pg-view-all">
            <a href="<?php echo admin_url( 'admin.php?page=pg-all-contacts' ); ?>" class="button button-primary">
                View All Contacts →
            </a>
        </div>
    <?php endif; ?>
    
    <script>
    jQuery(document).ready(function($) {
        $('.pg-mark-read').on('click', function() {
            var btn = $(this);
            var contactId = btn.data('id');
            updateContactStatus(contactId, 'read', btn);
        });
        
        $('.pg-mark-archived').on('click', function() {
            var btn = $(this);
            var contactId = btn.data('id');
            updateContactStatus(contactId, 'archived', btn);
        });
        
        $('.pg-delete-contact').on('click', function() {
            if (!confirm('Are you sure you want to delete this contact?')) return;
            
            var btn = $(this);
            var contactId = btn.data('id');
            
            $.post(ajaxurl, {
                action: 'pg_delete_contact',
                contact_id: contactId
            }, function(response) {
                if (response.success) {
                    btn.closest('.pg-contact-item').fadeOut(300, function() {
                        $(this).remove();
                    });
                } else {
                    alert('Failed to delete contact');
                }
            });
        });
        
        function updateContactStatus(contactId, status, btn) {
            $.post(ajaxurl, {
                action: 'pg_update_contact_status',
                contact_id: contactId,
                status: status
            }, function(response) {
                if (response.success) {
                    var item = btn.closest('.pg-contact-item');
                    item.removeClass('unread read archived').addClass(status);
                    item.find('.pg-contact-badge')
                        .removeClass('unread read archived')
                        .addClass(status)
                        .text(status);
                    btn.remove();
                } else {
                    alert('Failed to update status');
                }
            });
        }
    });
    </script>
    <?php
}

/**
 * Website Statistics Widget
 */
function pg_stats_widget_display() {
    $services_count = wp_count_posts( 'service' )->publish;
    $portfolio_count = wp_count_posts( 'portfolio' )->publish;
    $pages_count = wp_count_posts( 'page' )->publish;
    $users_count = count_users();
    
    ?>
    <style>
        .pg-stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .pg-stats-item {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            color: white;
        }
        .pg-stats-item:nth-child(2) {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .pg-stats-item:nth-child(3) {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .pg-stats-item:nth-child(4) {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        .pg-stats-item-number {
            font-size: 42px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .pg-stats-item-label {
            font-size: 14px;
            opacity: 0.95;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .pg-stats-item-link {
            color: white;
            text-decoration: none;
            display: block;
            margin-top: 10px;
            font-size: 12px;
            opacity: 0.9;
        }
        .pg-stats-item-link:hover {
            opacity: 1;
            text-decoration: underline;
        }
    </style>
    
    <div class="pg-stats-grid">
        <div class="pg-stats-item">
            <div class="pg-stats-item-number"><?php echo $services_count; ?></div>
            <div class="pg-stats-item-label">Services</div>
            <a href="<?php echo admin_url( 'edit.php?post_type=service' ); ?>" class="pg-stats-item-link">View All →</a>
        </div>
        <div class="pg-stats-item">
            <div class="pg-stats-item-number"><?php echo $portfolio_count; ?></div>
            <div class="pg-stats-item-label">Portfolio</div>
            <a href="<?php echo admin_url( 'edit.php?post_type=portfolio' ); ?>" class="pg-stats-item-link">View All →</a>
        </div>
        <div class="pg-stats-item">
            <div class="pg-stats-item-number"><?php echo $pages_count; ?></div>
            <div class="pg-stats-item-label">Pages</div>
            <a href="<?php echo admin_url( 'edit.php?post_type=page' ); ?>" class="pg-stats-item-link">View All →</a>
        </div>
        <div class="pg-stats-item">
            <div class="pg-stats-item-number"><?php echo $users_count['total_users']; ?></div>
            <div class="pg-stats-item-label">Users</div>
            <a href="<?php echo admin_url( 'users.php' ); ?>" class="pg-stats-item-link">View All →</a>
        </div>
    </div>
    <?php
}

/**
 * Recent Services Widget
 */
function pg_recent_services_widget_display() {
    $services = get_posts( array(
        'post_type' => 'service',
        'posts_per_page' => 5,
        'orderby' => 'date',
        'order' => 'DESC'
    ) );
    
    ?>
    <style>
        .pg-recent-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .pg-recent-item {
            padding: 12px;
            border-left: 3px solid #0A2342;
            background: #f9f9f9;
            margin-bottom: 10px;
            border-radius: 4px;
            transition: all 0.3s;
        }
        .pg-recent-item:hover {
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .pg-recent-item-title {
            font-weight: bold;
            color: #0A2342;
            text-decoration: none;
            display: block;
            margin-bottom: 5px;
        }
        .pg-recent-item-title:hover {
            color: #1E5A8E;
        }
        .pg-recent-item-date {
            font-size: 12px;
            color: #999;
        }
    </style>
    
    <?php if ( empty( $services ) ): ?>
        <p>No services found. <a href="<?php echo admin_url( 'post-new.php?post_type=service' ); ?>">Create one</a></p>
    <?php else: ?>
        <ul class="pg-recent-list">
            <?php foreach ( $services as $service ): ?>
                <li class="pg-recent-item">
                    <a href="<?php echo get_edit_post_link( $service->ID ); ?>" class="pg-recent-item-title">
                        <?php echo esc_html( $service->post_title ); ?>
                    </a>
                    <span class="pg-recent-item-date">
                        <?php echo date( 'M j, Y', strtotime( $service->post_date ) ); ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
        <p style="text-align: center; margin-top: 15px;">
            <a href="<?php echo admin_url( 'edit.php?post_type=service' ); ?>" class="button">View All Services</a>
        </p>
    <?php endif; ?>
    <?php
}

/**
 * Recent Portfolio Widget
 */
function pg_recent_portfolio_widget_display() {
    $projects = get_posts( array(
        'post_type' => 'portfolio',
        'posts_per_page' => 5,
        'orderby' => 'date',
        'order' => 'DESC'
    ) );
    
    ?>
    <?php if ( empty( $projects ) ): ?>
        <p>No portfolio projects found. <a href="<?php echo admin_url( 'post-new.php?post_type=portfolio' ); ?>">Create one</a></p>
    <?php else: ?>
        <ul class="pg-recent-list">
            <?php foreach ( $projects as $project ): ?>
                <li class="pg-recent-item">
                    <a href="<?php echo get_edit_post_link( $project->ID ); ?>" class="pg-recent-item-title">
                        <?php echo esc_html( $project->post_title ); ?>
                    </a>
                    <span class="pg-recent-item-date">
                        <?php echo date( 'M j, Y', strtotime( $project->post_date ) ); ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
        <p style="text-align: center; margin-top: 15px;">
            <a href="<?php echo admin_url( 'edit.php?post_type=portfolio' ); ?>" class="button">View All Projects</a>
        </p>
    <?php endif; ?>
    <?php
}

/**
 * Quick Actions Widget
 */
function pg_quick_actions_widget_display() {
    ?>
    <style>
        .pg-quick-actions {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .pg-quick-action {
            padding: 20px;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s;
            display: block;
        }
        .pg-quick-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: white;
        }
        .pg-quick-action:nth-child(2) {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .pg-quick-action:nth-child(3) {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .pg-quick-action:nth-child(4) {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        .pg-quick-action-icon {
            font-size: 32px;
            margin-bottom: 8px;
        }
        .pg-quick-action-label {
            font-weight: bold;
            font-size: 14px;
        }
    </style>
    
    <div class="pg-quick-actions">
        <a href="<?php echo admin_url( 'post-new.php?post_type=service' ); ?>" class="pg-quick-action">
            <div class="pg-quick-action-icon">🛡️</div>
            <div class="pg-quick-action-label">Add Service</div>
        </a>
        <a href="<?php echo admin_url( 'post-new.php?post_type=portfolio' ); ?>" class="pg-quick-action">
            <div class="pg-quick-action-icon">🖼️</div>
            <div class="pg-quick-action-label">Add Project</div>
        </a>
        <a href="<?php echo admin_url( 'post-new.php?post_type=page' ); ?>" class="pg-quick-action">
            <div class="pg-quick-action-icon">📄</div>
            <div class="pg-quick-action-label">Add Page</div>
        </a>
        <a href="<?php echo home_url(); ?>" target="_blank" class="pg-quick-action">
            <div class="pg-quick-action-icon">🌐</div>
            <div class="pg-quick-action-label">View Website</div>
        </a>
    </div>
    <?php
}

/**
 * Export Contacts to CSV
 */
function pg_export_contacts_csv() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Unauthorized' );
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'pg_contacts';
    $contacts = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY submitted_at DESC" );
    
    if ( empty( $contacts ) ) {
        wp_die( 'No contacts to export' );
    }
    
    // Set headers for CSV download
    header( 'Content-Type: text/csv; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename=contacts-export-' . date( 'Y-m-d' ) . '.csv' );
    
    $output = fopen( 'php://output', 'w' );
    
    // Add BOM for Excel UTF-8 compatibility
    fprintf( $output, chr(0xEF).chr(0xBB).chr(0xBF) );
    
    // Add column headers
    fputcsv( $output, array( 'ID', 'Name', 'Phone', 'Email', 'Message', 'Status', 'Submitted At' ) );
    
    // Add data rows
    foreach ( $contacts as $contact ) {
        fputcsv( $output, array(
            $contact->id,
            $contact->name,
            $contact->phone,
            $contact->email,
            $contact->message,
            $contact->status,
            $contact->submitted_at
        ) );
    }
    
    fclose( $output );
    exit;
}
add_action( 'admin_init', function() {
    if ( isset( $_GET['pg_export_contacts'] ) && $_GET['pg_export_contacts'] === 'csv' ) {
        pg_export_contacts_csv();
    }
});

/**
 * Add Admin Menu for All Contacts Page
 */
function pg_add_admin_menu() {
    add_menu_page(
        'All Contacts',
        'Contact Forms',
        'manage_options',
        'pg-all-contacts',
        'pg_all_contacts_page',
        'dashicons-email',
        25
    );
    
    add_submenu_page(
        'pg-all-contacts',
        'Export Contacts',
        'Export to CSV',
        'manage_options',
        'pg-export-contacts',
        'pg_export_contacts_page'
    );
}
add_action( 'admin_menu', 'pg_add_admin_menu' );

/**
 * Export Contacts Page
 */
function pg_export_contacts_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'pg_contacts';
    $total_contacts = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
    ?>
    <div class="wrap">
        <h1>📤 Export Contacts</h1>
        <div class="card" style="max-width: 600px;">
            <h2>Export Options</h2>
            <p>Export all contact form submissions to a CSV file that can be opened in Excel, Google Sheets, or any spreadsheet application.</p>
            
            <div style="background: #f0f0f1; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3 style="margin-top: 0;">📊 Export Statistics</h3>
                <p><strong>Total Contacts:</strong> <?php echo $total_contacts; ?></p>
                <p><strong>Export Format:</strong> CSV (Comma Separated Values)</p>
                <p><strong>File Encoding:</strong> UTF-8</p>
            </div>
            
            <p>
                <a href="<?php echo admin_url( 'admin.php?pg_export_contacts=csv' ); ?>" class="button button-primary button-hero">
                    📥 Download CSV File
                </a>
            </p>
            
            <hr>
            
            <h3>What's included in the export?</h3>
            <ul>
                <li>✓ Contact ID</li>
                <li>✓ Name</li>
                <li>✓ Phone Number</li>
                <li>✓ Email Address</li>
                <li>✓ Message</li>
                <li>✓ Status (Read/Unread/Archived)</li>
                <li>✓ Submission Date & Time</li>
            </ul>
        </div>
    </div>
    <?php
}

/**
 * All Contacts Admin Page
 */
function pg_all_contacts_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'pg_contacts';
    
    // Handle bulk actions
    if ( isset( $_POST['bulk_action'] ) && isset( $_POST['contact_ids'] ) ) {
        $action = sanitize_text_field( $_POST['bulk_action'] );
        $contact_ids = array_map( 'intval', $_POST['contact_ids'] );
        
        if ( $action === 'delete' ) {
            $ids_placeholder = implode( ',', array_fill( 0, count( $contact_ids ), '%d' ) );
            $wpdb->query( $wpdb->prepare( "DELETE FROM $table_name WHERE id IN ($ids_placeholder)", $contact_ids ) );
            echo '<div class="notice notice-success"><p>Selected contacts deleted.</p></div>';
        } elseif ( in_array( $action, array( 'read', 'unread', 'archived' ) ) ) {
            $ids_placeholder = implode( ',', array_fill( 0, count( $contact_ids ), '%d' ) );
            $wpdb->query( $wpdb->prepare( "UPDATE $table_name SET status = %s WHERE id IN ($ids_placeholder)", array_merge( array( $action ), $contact_ids ) ) );
            echo '<div class="notice notice-success"><p>Status updated for selected contacts.</p></div>';
        }
    }
    
    // Pagination
    $per_page = 20;
    $page = isset( $_GET['paged'] ) ? max( 1, intval( $_GET['paged'] ) ) : 1;
    $offset = ( $page - 1 ) * $per_page;
    
    $total_contacts = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
    $total_pages = ceil( $total_contacts / $per_page );
    
    $contacts = $wpdb->get_results( $wpdb->prepare( 
        "SELECT * FROM $table_name ORDER BY submitted_at DESC LIMIT %d OFFSET %d",
        $per_page,
        $offset
    ) );
    
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">📬 Contact Form Submissions</h1>
        <a href="<?php echo admin_url( 'admin.php?pg_export_contacts=csv' ); ?>" class="page-title-action">📥 Export to CSV</a>
        <a href="<?php echo admin_url( 'index.php' ); ?>" class="page-title-action">← Back to Dashboard</a>
        <hr class="wp-header-end">
        
        <?php if ( empty( $contacts ) ): ?>
            <div class="notice notice-info">
                <p>No contact submissions yet.</p>
            </div>
        <?php else: ?>
            <form method="post">
                <div class="tablenav top">
                    <div class="alignleft actions bulkactions">
                        <select name="bulk_action">
                            <option value="">Bulk Actions</option>
                            <option value="read">Mark as Read</option>
                            <option value="unread">Mark as Unread</option>
                            <option value="archived">Archive</option>
                            <option value="delete">Delete</option>
                        </select>
                        <input type="submit" class="button action" value="Apply">
                    </div>
                    <div class="tablenav-pages">
                        <span class="displaying-num"><?php echo $total_contacts; ?> items</span>
                        <?php if ( $total_pages > 1 ): ?>
                            <span class="pagination-links">
                                <?php if ( $page > 1 ): ?>
                                    <a class="prev-page button" href="?page=pg-all-contacts&paged=<?php echo $page - 1; ?>">‹</a>
                                <?php endif; ?>
                                <span class="paging-input">
                                    <span class="tablenav-paging-text"><?php echo $page; ?> of <?php echo $total_pages; ?></span>
                                </span>
                                <?php if ( $page < $total_pages ): ?>
                                    <a class="next-page button" href="?page=pg-all-contacts&paged=<?php echo $page + 1; ?>">›</a>
                                <?php endif; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <td class="check-column"><input type="checkbox" id="cb-select-all"></td>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $contacts as $contact ): ?>
                            <tr>
                                <th class="check-column">
                                    <input type="checkbox" name="contact_ids[]" value="<?php echo $contact->id; ?>">
                                </th>
                                <td><strong><?php echo esc_html( $contact->name ); ?></strong></td>
                                <td><a href="mailto:<?php echo esc_attr( $contact->email ); ?>"><?php echo esc_html( $contact->email ); ?></a></td>
                                <td><?php echo esc_html( $contact->phone ); ?></td>
                                <td><?php echo esc_html( wp_trim_words( $contact->message, 15 ) ); ?></td>
                                <td><?php echo date( 'M j, Y g:i A', strtotime( $contact->submitted_at ) ); ?></td>
                                <td>
                                    <span class="pg-contact-badge <?php echo esc_attr( $contact->status ); ?>">
                                        <?php echo esc_html( ucfirst( $contact->status ) ); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
        <?php endif; ?>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('#cb-select-all').on('click', function() {
            $('input[name="contact_ids[]"]').prop('checked', this.checked);
        });
    });
    </script>
    <?php
}

